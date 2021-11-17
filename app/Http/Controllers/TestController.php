<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\customer;
use App\Country;
use URL;
use Illuminate\Support\Facades\Config;
use App\Traits\SalesForceApiTrait;
use App\Traits\CustomerTrait;
use App\Traits\StripeSubscriptionTrait;

class TestController extends Controller
{
    use StripeSubscriptionTrait;
    use SalesForceApiTrait;
    use CustomerTrait;

    public $appEnvironment;
    public $salesForceUsername;
    public $salesForcePassword;
    public $salesForceClientId;
    public $salesForceClientSecret;
    public $salesForceBaseUrl;
    public $salesForceToken;
    public $salesForceTokenUrl;

    public function __construct()
    {
        $this->appEnvironment = getAppEnvironment() == 'production' ? 'production' : 'sandbox';
        $this->salesForceUsername = getSalesForceUsername($this->appEnvironment);
        $this->salesForcePassword = getSalesForcePassword($this->appEnvironment);
        $this->salesForceClientId = getSalesForceClientId($this->appEnvironment);
        $this->salesForceClientSecret = getSalesForceClientSecret($this->appEnvironment);
        $this->salesForceBaseUrl = getSalesForceBaseUrl($this->appEnvironment);
        $this->salesForceToken = getSalesForceToken($this->appEnvironment);
        $this->salesForceTokenUrl = getSalesForceTokenUrl($this->appEnvironment);
    }

    public function index()
    {
        $USDKey = Config::get('services.stripe.secret');
        $EURGBPKey = Config::get('services.stripe.EUR_GBP_secret');

        $USDPlans = getThePlans($USDKey);
        $EURGBPPlans = getThePlans($EURGBPKey);

        $plans = array_merge($USDPlans, $EURGBPPlans);

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();
        $data['country'] = $country;
        $data['frequently'] = $frequently;

        return view('test3', compact('plans', 'data'));
    }

    public function individual(Request $request)
    {
        $productDetails = $this->getProductDetails($request->currency, $request->all());

        $rule = [
            'email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'shipping_country_id' => 'required'
        ];

        $customMessages = [
            'email.required' => 'The email field is required.',
            'email.email'   => 'The email must be a valid email address.',
            'first_name.required' => 'The first name field is required.',
            'last_name.required'  => 'The last name field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'shipping_country_id.required' => 'Please select the shipping country.',
            'email.regex' => 'This email id is invalid.',
        ];

        $validator = Validator::make($request->all(), $rule, $customMessages);
        if ($validator->fails()) {
            Session()->flash('activeTab', 'individual');
            return redirect(url()->previous() . '#individual')->withErrors($validator);
        }

        $customer = new customer();

        $customerData = $customer->where('email', $request->email)->get()->first();

        if (isset($customerData) && $customerData != NULL) {

            $customer->where('email', $request->email)->update([
                'firstname' => $request->first_name,
                'lastname'  => $request->last_name,
                'phone_number' => $request->phone_number,
                'product_id'   => $productDetails['product_id'],
                'product_name' => $productDetails['product_name'],
                'product_handle' => $request->product_handle,
                'product_price' => $productDetails['product_price'],
                'country_val' => $request->shipping_country_code
            ]);
            $customerId = $customerData->id;
        } else {

            $customer->email = $request->email;
            $customer->firstname = $request->first_name;
            $customer->lastname  = $request->last_name;
            $customer->phone_number = $request->phone_number;
            $customer->product_id   = $productDetails['product_id'];
            $customer->product_name = $productDetails['product_name'];
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $productDetails['product_price'];
            $customer->country_val = $request->shipping_country_code;
            $customer->save();
            $customerId = $customer->id;
        }

        updateCountryCounts($request->shipping_country_id); // update the country counts

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();
        $data['customer_id']  = $customerId;
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $productDetails['product_id'];
        $data['product_price'] = $productDetails['product_price'];
        $data['url'] = Url::asset('individual_checkout');
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $productDetails['product_name'];
        $data['price_id'] = $productDetails['price_id'];
        $data['exist'] = "no";
        $data['currency'] = $request->currency;
        $data['country'] = $country;
        $data['frequently'] = $frequently;
        $data['shipping_country_id'] = $request->shipping_country_id;
        $data['final_price'] = Config::get('constants.currency_symbols.'.$request->currency).$productDetails['product_price'];

        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        $l_data = array(
            'phone' => $request->phone_number,
            'lastname' => $request->last_name,
            'firstname' => $request->first_name,
            'email' => $request->email,
            'billingstreet' => "",
            'billingcity' => "",
            'billingstate' => "",
            'billingzip' => "",
            'billingcountry' => "",
            'memberfirstname' => '',
            'memberlastname' => '',
            'memberphone' => '',
            'memberemail' => '',
            'stripeproductid' => $productDetails['product_id'],
            'giftrecipientfirstname' => '',
            'giftrecipientlastname' => '',
            'giftrecipientphone' => '',
            'giftrecipientemail' => '',
        );

        $lead_data = json_encode($l_data);


        $leadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $lead_data);
        $l_id = $leadResponse['lead_data'];
        $http_status = $leadResponse['http_status'];

        if (isset($l_id['id'])) {
            $lead_id = $l_id['id'];

            /* --- lead code over ----*/

            $data['lead_id'] = $lead_id;
        }

        $customer = customer::find($customerId);
        $data['intent'] = $customer->createSetupIntent();

        $eurGbpCountries = array_merge(Config::get('constants.eur_countries'),Config::get('constants.gbp_countries'));
        $data['stripe_key'] = in_array($request->shipping_country_code, $eurGbpCountries) ? Config::get('services.stripe.EUR_GBP_key') : Config::get('services.stripe.key');
        if ($http_status == Config::get('constants.status_error_code')) {
            Session()->flash('activeTab', 'individual');
            return redirect(url()->previous() . '#individual')->with('error', $l_id['message']);
            // return redirect('/')->withInput(['tabOpen' => 'individual'])->with('error', $l_id['message']);
        }
        return view('checkout1', compact('data'));
    }

    public function individual_checkout(Request $request)
    {
        $request->shipping_country_name = $this->getCountryName($request->shipping_country_id);
        $request->billing_country_name = $this->getCountryName($request->billing_country_id);

        $customerDataForStripe = $this->prepareDataToUpdate($request);
        $subscriptionResponse = $this->createStripeSubscription($request->payment_method, $request->email, $request->price_id, $customerDataForStripe);
        $subscription = $subscriptionResponse['subscription_response'];
        $customerId = $subscriptionResponse['customer_id'];

        if ($request->currency == "USD") {
            $key = Config::get('services.stripe.secret');
            $stripe = new \Stripe\StripeClient($key);
            $stripeResponse = $stripe->subscriptions->retrieve(
                $subscription->stripe_id,
                []
            );
        } else {
            $key = Config::get('services.stripe.EUR_GBP_secret');
            $stripe = new \Stripe\StripeClient($key);
            $stripeResponse = $stripe->subscriptions->retrieve(
                $subscription->stripe_id,
                []
            );
        }
        $stripeResponseEncoded = json_encode($stripeResponse);
        $stripeResponseDecoded = json_decode($stripeResponseEncoded, true);
        $datas['product_id'] = $request->product_id;
        $datas['product_price'] = $request->product_price;
        $datas['product_name'] = $request->product_name;
        $datas['customer_id'] = $customerId;
        $datas['stripe_response'] = $stripeResponseEncoded;

        $this->updateCustomerData($customerId, $datas);

        if(isset($request->billing_country_id) && !empty($request->billing_country_id)) {
            updateCountryCounts($request->billing_country_id); // update the country counts
        }


        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        /*--- lead create code---- */

        $l_data = array(
            'phone' => $request->phone_number,
            'lastname' => $request->last_name,
            'firstname' => $request->first_name,
            'email' => $request->email,
            'billingstreet' => $request->billing_address == null ? $request->shipping_address : $request->billing_address,
            'billingcity' => $request->billing_city == null ? $request->shipping_city : $request->billing_city,
            'billingstate' => $request->billing_state == null ? $request->shipping_state : $request->billing_state,
            'billingzip' => $request->billing_zipcode == null ? $request->shipping_zipcode : $request->billing_zipcode,
            'billingcountry' => $request->billing_country_name == null ? $request->shipping_country_name : $request->billing_country_name,
            'mailingstreet' => $request->shipping_address,
            'mailingcity' => $request->shipping_city,
            'mailingstate' => $request->shipping_state,
            'mailingzip'  => $request->shipping_zipcode,
            'mailingcountry' => $request->shipping_country_name,
            'memberfirstname' => '',
            'memberlastname' => '',
            'memberphone' => '',
            'memberemail' => '',
            'stripeproductid' => $request->product_id,
            'giftrecipientfirstname' => '',
            'giftrecipientlastname' => '',
            'giftrecipientphone' => '',
            'giftrecipientemail' => '',
            'promoapplied' => $request->promo_gift,
            'additionalinformation' => $request->additional_information,
            'customerid' => $request->customer_id,
        );

        $lead_data = json_encode($l_data);

        $leadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $lead_data);
        $lead_data = $leadResponse['lead_data'];

        $u_datas['leadId'] = $lead_data['id'];
        $u_datas['lead_response'] = $lead_data;
        $this->updateCustomerData($customerId, $u_datas);

        /* code for create member  */

        if (isset($stripeResponseDecoded)) {
            $lead_data['obj']['stripeuserid'] = $stripeResponseDecoded['id'];
            $lead_data['obj']['subscriptionstartdate'] = date('Y-m-d', $stripeResponseDecoded['start_date']);
            $lead_data['obj']['membershipfee'] = $stripeResponseDecoded['plan']['amount'];
            $lead_data['obj']['paymentfrequency'] = '';
            $lead_data['obj']['accountcurrency'] = $request->currency;
            $lead_responses = json_encode($lead_data);
        } else {
            $lead_data['obj']['stripeuserid'] = '';
            $lead_data['obj']['subscriptionstartdate'] = '';
            $lead_data['obj']['membershipfee'] = '';
            $lead_data['obj']['paymentfrequency'] = '';
            $lead_data['obj']['accountcurrency'] = '';
            $lead_responses = json_encode($lead_data);
        }

        // convert the lead into member for salesforce
        $createMemberResponse = $this->createMember($token, $this->salesForceBaseUrl, $lead_responses);

        // update the customer in local database
        $this->updateCustomerData($customerId, ['create_member_response' => json_encode($createMemberResponse), 'membership_type' => 'individual']);

        return redirect('/success');
    }


    public function dual(Request $request)
    {
        $validatedData = [
            'email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'detail_02_email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'detail_02_first_name' => 'required',
            'detail_02_last_name' => 'required',
            'detail_02_phone_number' => 'required',
            'shipping_country_id' => 'required'
        ];
        $customMessages = [
            'email.required' => 'The email field is required.',
            'email.email'   => 'The email must be a valid email address.',
            'first_name.required' => 'The first name field is required.',
            'last_name.required'  => 'The last name field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'detail_02_email.required'   => 'The email field is required.',
            'detail_02_email.email' => 'The email must be a valid email address.',
            'detail_02_first_name.required'  => 'The first name is required',
            'detail_02_last_name.required'  => 'The last name is required.',
            'detail_02_phone_number.required' => 'The phone number is required.',
            'shipping_country_id.required' => 'Please select the shipping country.',
            'email.regex' => 'This email id is invalid.',
            'detail_02_email.regex' => 'This email id is invalid.',
        ];

        $validator = Validator::make($request->all(), $validatedData, $customMessages);
        if ($validator->fails()) {
            Session()->flash('activeTab', 'dual');
            return redirect(url()->previous() . '#dual')->withErrors($validator);
        }

        $cardHolderTwoData = [
            "detail_02_email" => $request['detail_02_email'],
            "detail_02_first_name" => $request['detail_02_first_name'],
            "detail_02_last_name" => $request['detail_02_last_name'],
            "detail_02_phone_number" => $request['detail_02_phone_number'],
        ];
        $cardHolderTwoEncodedData = json_encode($cardHolderTwoData);

        $productDetails = $this->getProductDetails($request->currency, $request->all());

        $customer = new customer();
        $customerData = $customer->where('email', $request->email)->get()->first();

        if (isset($customerData) && $customerData != NULL) {

            $customer->where('email', $request->email)->update([
                'firstname' => $request->first_name,
                'lastname'  => $request->last_name,
                'phone_number' => $request->phone_number,
                'product_id'   => $productDetails['product_id'],
                'product_name' => $productDetails['product_name'],
                'product_handle' => $request->product_handle,
                'product_price' => $productDetails['product_price'],
                'membership_type' => "dual",
                'secondary_customer_data' => $cardHolderTwoEncodedData,
                'country_val' => $request->shipping_country_code
            ]);
            $customerId = $customerData->id;
        } else {

            $customer->email = $request->email;
            $customer->firstname = $request->first_name;
            $customer->lastname  = $request->last_name;
            $customer->phone_number = $request->phone_number;
            $customer->product_id   = $productDetails['product_id'];
            $customer->product_name = $productDetails['product_name'];
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $productDetails['product_price'];
            $customer->membership_type = "dual";
            $customer->secondary_customer_data = $cardHolderTwoEncodedData;
            $customer->country_val = $request->shipping_country_code;
            $customer->save();
            $customerId = $customer->id;
        }

        updateCountryCounts($request->shipping_country_id); // update the country counts

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();

        $data['customer_id']  = "";
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $productDetails['product_id'];
        $data['product_price'] = $productDetails['product_price'];
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $productDetails['product_name'];
        $data['price_id'] = $productDetails['price_id'];
        $data['url'] = Url::asset('dual_checkout');
        $data['exist'] = "no";
        $data['email_dual_member'] = $request->detail_02_email;
        $data['first_name_dual_member'] = $request->detail_02_first_name;
        $data['last_name_dual_member'] = $request->detail_02_last_name;
        $data['phone_dual_member'] = $request->detail_02_phone_number;
        $data['snap_day'] = $request->snap_day;
        $data['country'] = $country;
        $data['frequently'] = $frequently;
        $data['shipping_country_id'] = $request->shipping_country_id;
        $data['currency'] = $request->currency;
        $data['final_price'] = Config::get('constants.currency_symbols.'.$request->currency).$productDetails['product_price'];

        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        /* create lead */

        $duallead_data = array(
            'firstname' => $request->first_name,
            'lastname' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'billingcity' => "",
            'billingstate' => "",
            'billingzip' => "",
            'billingcountry' => "",
            'memberfirstname' => $request->detail_02_first_name,
            'memberlastname' => $request->detail_02_last_name,
            'memberphone' => $request->detail_02_phone_number,
            'memberemail' => $request->detail_02_email,
            'stripeproductid' => $productDetails['product_id'],
            'giftrecipientfirstname' => '',
            'giftrecipientlastname' => '',
            'giftrecipientphone' => '',
            'giftrecipientemail' => '',
        );

        $dual_lead_data = json_encode($duallead_data);

        $leadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $dual_lead_data);
        $d_response = $leadResponse['lead_data'];
        $http_status = $leadResponse['http_status'];
        if (isset($d_response)) {
            $data['lead_id'] = $d_response['id'];
        }

        $customer = customer::find($customerId);
        $eurGbpCountries = array_merge(Config::get('constants.eur_countries'),Config::get('constants.gbp_countries'));

        $data['stripe_key'] = in_array($request->shipping_country_code, $eurGbpCountries) ? Config::get('services.stripe.EUR_GBP_key') : Config::get('services.stripe.key');
        $data['intent'] = $customer->createSetupIntent();

        if ($http_status == Config::get('constants.status_error_code')) {
            Session()->flash('activeTab', 'dual');
            return redirect(url()->previous() . '#dual')->with('dual-error', $d_response['message']);
            // return redirect('/')->with('dual-error', $d_response['message']);
        }

        return view('checkout1', compact('data'));
    }

    /**
     * This will create the dual subscription
     *
     * @param Request $request
     * @return void
     */
    public function dual_checkout(Request $request)
    {
        $request->shipping_country_name = $this->getCountryName($request->shipping_country_id);
        $request->billing_country_name = $this->getCountryName($request->billing_country_id);
        $customerDataForStripe = $this->prepareDataToUpdate($request);

        $subscriptionResponse = $this->createStripeSubscription($request->payment_method, $request->email, $request->price_id, $customerDataForStripe);
        $subscription = $subscriptionResponse['subscription_response'];
        $customerId = $subscriptionResponse['customer_id'];

        if ($request->currency == "USD") {
            $key = Config::get('services.stripe.secret');
            $stripe = new \Stripe\StripeClient($key);
            $stripeResponse = $stripe->subscriptions->retrieve(
                $subscription->stripe_id,
                []
            );
        } else {
            $key = Config::get('services.stripe.EUR_GBP_secret');
            $stripe = new \Stripe\StripeClient($key);
            $stripeResponse = $stripe->subscriptions->retrieve(
                $subscription->stripe_id,
                []
            );
        }
        $stripeResponseEncoded = json_encode($stripeResponse);
        $stripeResponseDecoded = json_decode($stripeResponseEncoded, true);

        $datas['product_id'] = $request->product_id;
        $datas['product_price'] = $request->product_price;
        $datas['product_name'] = $request->product_name;
        $datas['customer_id'] = $customerId;
        $datas['stripe_response'] = $stripeResponseEncoded;

        $this->updateCustomerData($customerId, $datas);

        if(isset($request->billing_country_id) && !empty($request->billing_country_id)) {
            updateCountryCounts($request->billing_country_id); // update the country counts
        }


        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        /*--- lead create code---- */

        $duallead_data = array(
            'phone' => $request->phone_number,
            'lastname' => $request->last_name,
            'firstname' => $request->first_name,
            'email' => $request->email,
            'billingstreet' => $request->billing_address == null ? $request->shipping_address : $request->billing_address,
            'billingcity' => $request->billing_city == null ? $request->shipping_city : $request->billing_city,
            'billingstate' => $request->billing_state == null ? $request->shipping_state : $request->billing_state,
            'billingzip' => $request->billing_zipcode == null ? $request->shipping_zipcode : $request->billing_zipcode,
            'billingcountry' => $request->billing_country == null ? $request->shipping_country : $request->billing_country,
            'mailingstreet' => $request->shipping_address,
            'mailingcity' => $request->shipping_city,
            'mailingstate' => $request->shipping_state,
            'mailingzip'  => $request->shipping_zipcode,
            'mailingcountry' => $request->shipping_country,
            'memberfirstname' => $request->first_name_dual_member,
            'memberlastname' => $request->last_name_dual_member,
            'memberphone' => $request->phone_dual_member,
            'memberemail' => $request->email_dual_member,
            'stripeproductid' => $request->product_id,
            'giftrecipientfirstname' => '',
            'giftrecipientlastname' => '',
            'giftrecipientphone' => '',
            'giftrecipientemail' => '',
            'promoapplied' => $request->promo_gift,
            'additionalinformation' => $request->additional_information,
            'customerid' => $request->customer_id,
        );

        $dual_lead_data = json_encode($duallead_data);

        $lead_datas = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $dual_lead_data);
        $lead_data = $lead_datas['lead_data'];

        $ud_datas['leadId'] = $lead_datas['lead_data']['id'];
        $ud_datas['lead_response'] = $lead_datas;

        /* --- lead code over ----*/

        $this->updateCustomerData($customerId, $ud_datas);
        // $customer = customer::where('email', $request->email)->orderBy('id', 'desc')->update($ud_datas);

        /* code for create member in dual */

        if (isset($stripeResponseDecoded)) {
            $lead_data['obj']['stripeuserid'] = $stripeResponseDecoded['id'];
            $lead_data['obj']['subscriptionstartdate'] = date('Y-m-d', $stripeResponseDecoded['start_date']);
            $lead_data['obj']['membershipfee'] = $stripeResponseDecoded['plan']['amount'];
            $lead_data['obj']['paymentfrequency'] = '';
            $lead_data['obj']['accountcurrency'] = $request->currency;
            $lead_responses = json_encode($lead_data);
        } else {
            $lead_data['obj']['stripeuserid'] = '';
            $lead_data['obj']['subscriptionstartdate'] = '';
            $lead_data['obj']['membershipfee'] = '';
            $lead_data['obj']['paymentfrequency'] = '';
            $lead_data['obj']['accountcurrency'] = '';
            $lead_responses = json_encode($lead_data);
        }

        $createMemberResponse = $this->createMember($token, $this->salesForceBaseUrl, $lead_responses);

        $this->updateCustomerData($customerId, [
            'create_member_response' => $createMemberResponse,
            'membership_type' => 'dual',
            'secondary_customer_data' => $lead_responses
        ]);

        /* End member */
        return redirect('/success');
    }

    /**
     * This will generate the salesforce lead and send to gift checkout form
     *
     * @param Request $request
     * @return view
     */
    public function gifting(Request $request)
    {
        $validatedData = [
            'Emailgift' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'Firstnamegift' => 'required',
            'Lastnamegift' => 'required',
            'phone_number' => 'required',
            'customer_email' => 'required|email',
            'customer_first_name' => 'required',
            'customer_last_name' => 'required',
            'customer_phone_number' => 'required',
            'shipping_country_id' => 'required',
        ];

        $customMessages = [
            'Emailgift.required' => 'The email field is required.',
            'Emailgift.email'   => 'The email must be a valid email address.',
            'Firstnamegift.required' => 'The first name field is required.',
            'Lastnamegift.required'  => 'The last name field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'customer_email.required'   => 'The email field is required.',
            'customer_email.email' => 'The email must be a valid email address.',
            'customer_first_name.required'  => 'The first name is required',
            'customer_last_name.required'  => 'The last name is required.',
            'customer_phone_number.required' => 'The phone number is required.',
            'shipping_country_id.required' => 'Please select the shipping country.',
            'Emailgift.regex' => 'The email id is invalid.'
        ];

        $validator = Validator::make($request->all(), $validatedData, $customMessages);

        if ($validator->fails()) {
            Session()->flash('activeTab', 'gifting');
            return redirect(url()->previous() . '#gifting')->withErrors($validator);
        }

        $giftRecipientData = [
            "gift_recipient_name" => $request['Emailgift'],
            "gift_recipient_first_name" => $request['Firstnamegift'],
            "gift_recipient_last_name" => $request['Lastnamegift'],
            "gift_recipient_phone_number" => $request['phone_number'],
        ];
        $giftRecipientData = json_encode($giftRecipientData);

        $productDetails = $this->getProductDetails($request->currency, $request->all());

        $customer = new customer();
        $customerData = $customer->where('email', $request->customer_email)->get()->first();

        if (isset($customerData) && $customerData != NULL) {

            $customer->where('email', $request->customer_email)->update([
                'firstname' => $request->customer_first_name,
                'lastname'  => $request->customer_last_name,
                'phone_number' => $request->customer_phone_number,
                'product_id'   => $request->product_id,
                'product_name' => $request->product_name,
                'product_handle' => $request->product_handle,
                'product_price' => $request->product_price,
                'membership_type' => "gift",
                'secondary_customer_data' => $giftRecipientData,
                'country_val' => $request->shipping_country_code
            ]);
            $customerId = $customerData->id;
        } else {
            $customer = new customer();
            $customer->email = $request->customer_email;
            $customer->firstname = $request->customer_first_name;
            $customer->lastname  = $request->customer_last_name;
            $customer->phone_number = $request->customer_phone_number;
            $customer->product_id   = $request->product_id;
            $customer->product_name = $request->product_name;
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $request->product_price;
            $customer->membership_type = "gift";
            $customer->secondary_customer_data = $giftRecipientData;
            $customer->country_val = $request->shipping_country_code;
            $customer->save();
            $customerId = $customer->id;
        }

        updateCountryCounts($request->shipping_country_id); // update the country counts

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();

        $data['customer_id']  = "";
        $data['customer_first_name'] = $request->customer_first_name;
        $data['customer_last_name']  = $request->customer_last_name;
        $data['customer_email']  = $request->customer_email;
        $data['customer_phone_number'] = $request->customer_phone_number;
        $data['phone_number']   = $request->customer_phone_number;
        $data['Emailgift'] = $request->Emailgift;
        $data['Firstnamegift']  = $request->Firstnamegift;
        $data['Lastnamegift']  = $request->Lastnamegift;
        $data['phone_number']   = $request->phone_number;
        $data['product_id']  = $productDetails['product_id'];
        $data['product_price'] = $productDetails['product_price'];
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $productDetails['product_name'];
        $data['price_id'] = $productDetails['price_id'];
        $data['product_handle'] = $request->product_handle;
        $data['url'] = Url::asset('gift_checkout');
        $data['exist'] = "no";
        $data['snap_day']  = $request->snap_day;
        $data['product_price_point_id'] = $request->product_price_point_id;
        $data['Startdategift'] = $request->Startdategift;
        $data['country'] = $country;
        $data['frequently'] = $frequently;
        $data['currency'] = $request->currency;
        $data['shipping_country_id'] = $request->shipping_country_id;
        $data['final_price'] = Config::get('constants.currency_symbols.'.$request->currency).$productDetails['product_price'];

        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        $gift_l_data = array(
            'firstname' => $request->customer_first_name,
            'lastname' => $request->customer_last_name,
            'email' => $request->customer_email,
            'phone' => $request->customer_phone_number,
            'billingcity' => "",
            'billingstate' => "",
            'billingzip' => "",
            'billingcountry' => "",
            'memberfirstname' => '',
            'memberlastname' => '',
            'memberphone' => '',
            'memberemail' => '',
            'stripeproductid' => $productDetails['product_id'],
            'giftrecipientfirstname' => $request->Firstnamegift,
            'giftrecipientlastname' => $request->Lastnamegift,
            'giftrecipientphone' => $request->phone_number,
            'giftrecipientemail' => $request->Emailgift,

        );

        $g_lead_data = json_encode($gift_l_data);

        $giftLeadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $g_lead_data);
        $gift_lead_response = $giftLeadResponse['lead_data'];
        $http_status = $giftLeadResponse['http_status'];
        if ($http_status == Config::get('constants.status_error_code')) {
            Session()->flash('activeTab', 'gifting');
            return redirect(url()->previous() . '#gifting')->with('gift-error', $gift_lead_response['message']);
            // return redirect('/')->with('dual-error', $gift_lead_response['message']);
        }

        if (isset($gift_lead_response['id'])) {
            $data['lead_id'] = $gift_lead_response['id'];
        }

        $customer = customer::find($customerId);
        $eurGbpCountries = array_merge(Config::get('constants.eur_countries'),Config::get('constants.gbp_countries'));

        $data['stripe_key'] = in_array($request->shipping_country_code, $eurGbpCountries) ? Config::get('services.stripe.EUR_GBP_key') : Config::get('services.stripe.key');
        $data['intent'] = $customer->createSetupIntent();

        return view('checkout1', compact('data'));
    }

    /**
     * This will create the gift subscription
     *
     * @param Request $request
     * @return redirect
     */
    public function gift_checkout(Request $request)
    {
        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        $request->shipping_country_name = $this->getCountryName($request->shipping_country_id);
        $request->billing_country_name = $this->getCountryName($request->billing_country_id);
        $customerDataForStripe = $this->prepareDataToUpdate($request);
        $subscriptionResponse = $this->createStripeSubscription($request->payment_method, $request->email, $request->price_id, $customerDataForStripe);
        $subscription = $subscriptionResponse['subscription_response'];
        $customerId = $subscriptionResponse['customer_id'];

        if ($request->currency == "USD") {
            $key = Config::get('services.stripe.secret');
            $stripe = new \Stripe\StripeClient($key);
            $stripeResponse = $stripe->subscriptions->retrieve(
                $subscription->stripe_id,
                []
            );
        } else {
            $key = Config::get('services.stripe.EUR_GBP_secret');
            $stripe = new \Stripe\StripeClient($key);
            $stripeResponse = $stripe->subscriptions->retrieve(
                $subscription->stripe_id,
                []
            );
        }
        $stripeResponseEncoded = json_encode($stripeResponse);
        $stripeResponseDecoded = json_decode($stripeResponseEncoded, true);

        if(isset($request->billing_country_id) && !empty($request->billing_country_id)) {
            updateCountryCounts($request->billing_country_id); // update the country counts
        }

        $datas['product_id'] = $request->product_id;
        $datas['product_price'] = $request->product_price;
        $datas['product_name'] = $request->product_name;
        $datas['customer_id'] = $customerId;
        $datas['stripe_response'] = $stripeResponseEncoded;

        $this->updateCustomerData($customerId, $datas);

        Country::where('code', $request->shipping_country)->increment('counts', 1);

        $gift_l_data = array(
            'firstname' => $request->customer_first_name,
            'lastname' => $request->customer_last_name,
            'email' => $request->customer_email,
            'phone' => $request->customer_phone_number,
            'billingstreet' => $request->billing_address == null ? $request->shipping_address : $request->billing_address,
            'billingcity' => $request->billing_city == null ? $request->shipping_city : $request->billing_city,
            'billingstate' => $request->billing_state == null ? $request->shipping_state : $request->billing_state,
            'billingzip' => $request->billing_zipcode == null ? $request->shipping_zipcode : $request->billing_zipcode,
            'billingcountry' => $request->billing_country == null ? $request->shipping_country : $request->billing_country,
            'memberfirstname' => '',
            'memberlastname' => '',
            'memberphone' => '',
            'memberemail' => '',
            'mailingstreet' => $request->shipping_address,
            'mailingcity' => $request->shipping_city,
            'mailingstate' => $request->shipping_state,
            'mailingzip'  => $request->shipping_zipcode,
            'mailingcountry' => $request->shipping_country,
            'chargifyproductid' => $request->product_id,
            'giftrecipientfirstname' => $request->Firstnamegift,
            'giftrecipientlastname' => $request->Lastnamegift,
            'giftrecipientphone' => $request->phone_number,
            'giftrecipientemail' => $request->Emailgift,
            'promoapplied' => $request->promo_gift,
            'additionalinformation' => $request->additional_information,
            'customerid' => $request->customer_id,
        );

        $g_lead_data = json_encode($gift_l_data);
        $giftLeadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $g_lead_data);
        $gift_lead_response = $giftLeadResponse['lead_data'];
        $http_status = $giftLeadResponse['http_status'];

        $gd_datas['leadId'] = $gift_lead_response['id'];
        $gd_datas['lead_response'] = $gift_lead_response;

        $this->updateCustomerData($customerId, $gd_datas);

        if (isset($stripeResponseDecoded)) {
            $gift_lead_response['obj']['stripeuserid'] = $stripeResponseDecoded['id'];
            $gift_lead_response['obj']['subscriptionstartdate'] = date('Y-m-d', $stripeResponseDecoded['start_date']);
            $gift_lead_response['obj']['membershipfee'] = $stripeResponseDecoded['plan']['amount'];
            $gift_lead_response['obj']['paymentfrequency'] = '';
            $gift_lead_response['obj']['accountcurrency'] = $request->currency;
            $lead_responses = json_encode($gift_lead_response);
        } else {
            $gift_lead_response['obj']['stripeuserid'] = '';
            $gift_lead_response['obj']['subscriptionstartdate'] = '';
            $gift_lead_response['obj']['membershipfee'] = '';
            $gift_lead_response['obj']['paymentfrequency'] = '';
            $gift_lead_response['obj']['accountcurrency'] = '';
            $lead_responses = json_encode($gift_lead_response);
        }

        $createMemberResponse = $this->createMember($token, $this->salesForceBaseUrl, $lead_responses);

        $this->updateCustomerData($customerId, [
            'create_member_response' => $createMemberResponse,
            'membership_type' => 'dual',
            'secondary_customer_data' => $lead_responses
        ]);

        /* END */
        return redirect('/success');
    }


    public function check_coupen(Request $request)
    {
        if ($request->currency == "GBP") {
            $coupen_url = "https://the-cultivist-uk-clone-clone.chargify.com/coupons/validate.json?code=$request->coupen_code";
            $header_coupon = array(
                "authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw==",
                "content-type: application/json"
            );
        } else if ($request->currency == "EUR") {
            $coupen_url = "https://the-cultivist-uk-clone.chargify.com/coupons/validate.json?code=$request->coupen_code";
            $header_coupon = array(
                "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc=",
                "content-type: application/json"
            );
        } else {
            $coupen_url = "https://the-cultivist-usa.chargify.com/coupons/validate.json?code=$request->coupen_code";
            $header_coupon = array(
                "authorization: Basic aUlpVmJoYXZMbFRzMk80eE5KTDFtMFJ4NU9aWEhmVTRkNVBNZmZiNWI4azo=",
                "content-type: application/json"
            );
        }



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $coupen_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => $header_coupon,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);



        if ($err) {
            $error = json_decode($err, true);
            if (isset($error['errors'])) {
                $resp = array("status" => false, "message" => $error['errors']);
                echo json_encode($resp);
                exit;
            } else {
                $resp = array("status" => false, "message" => $error);
                echo json_encode($resp);
                exit;
            }
        } else {
            $error = json_decode($response, true);
            if (isset($error['errors'])) {
                $resp = array("status" => false, "message" => $error['errors']);
                echo json_encode($resp);
                exit;
            } else {
                $type = $request->currency;
                $percentage = $error['coupon']['percentage'];
                $amount = $error['coupon']['amount_in_cents'];
                $resp = array("status" => true, "percentage" => $percentage, "amount" => $amount, "message" => "coupon applied successfully", 'type' => $type);
                echo json_encode($resp);
                exit;
            }
        }
    }

    public function success()
    {
        return view('thank_you');
    }

    /**
     * This will return the product details based on currency
     *
     * @param string $currency
     * @param array $requestData
     * @return array
     */
    public function getProductDetails($currency, $requestData)
    {
        if($currency === 'USD'){
            return [
                "product_id" => $requestData['product_id'],
                "product_name" => $requestData['product_name'],
                "product_price" => $requestData['product_price'],
                "price_id" => $requestData['price_id'],
            ];
        }

        if ($currency === 'EUR'){
            return [
                "product_id" => $requestData['uk_product_id'],
                "product_name" => $requestData['uk_product_name'],
                "product_price" => $requestData['uk_product_price'],
                "price_id" => $requestData['uk_price_id'],
            ];
        }

        if ($currency === 'GBP'){
            return [
                "product_id" => $requestData['gbp_product_id'],
                "product_name" => $requestData['gbp_product_name'],
                "product_price" => $requestData['gbp_product_price'],
                "price_id" => $requestData['gbp_price_id'],
            ];
        }
    }

    /**
     * This will return the country name
     *
     * @param int $shippingCountryId
     * @return void
     */
    public function getCountryName($shippingCountryId)
    {
        $shippingCountry = Country::where('id', $shippingCountryId)->first();
        return $shippingCountry->name ?? null;
    }
}
