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
        // dd($this->salesForceTokenUrl, $this->salesForceToken, $this->salesForceBaseUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword);

    }

    public function index()
    {
        $USDKey = Config::get('services.stripe.secret');
        $EURGBPKey = Config::get('services.stripe.EUR_GBP_secret');

        $USDPlans = getThePlans($USDKey);
        $EURGBPPlans = getThePlans($EURGBPKey);

        $plans = array_merge($USDPlans, $EURGBPPlans);

        return view('test3', compact('plans'));
    }

    public function individual(Request $request)
    {
        $rule =
            [
                'email' => 'required|email',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_number' => 'required'
            ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect(url()->previous())->withErrors($validator);
        }

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();

        $customer = new customer();

        $customerData = $customer->where('email', $request->email)->get()->first();

        if (isset($customerData) && $customerData != NULL) {

            $customer->where('email', $request->email)->update([
                'firstname' => $request->first_name,
                'lastname'  => $request->last_name,
                'phone_number' => $request->phone_number,
                'product_id'   => $request->product_id,
                'product_name' => $request->product_name,
                'product_handle' => $request->product_handle,
                'product_price' => $request->product_price,
            ]);
        } else {

            $customer->email = $request->email;
            $customer->firstname = $request->first_name;
            $customer->lastname  = $request->last_name;
            $customer->phone_number = $request->phone_number;
            $customer->product_id   = $request->product_id;
            $customer->product_name = $request->product_name;
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $request->product_price;
            $customer->save();
        }

        $data['customer_id']  = "";
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $request->product_id;
        $data['product_price'] = $request->product_price;
        $data['url'] = Url::asset('individual_checkout');
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['price_id'] = $request->price_id;
        $data['exist'] = "no";
        $data['uk_product_name'] = $request->uk_product_name;
        $data['uk_product_id'] = $request->uk_product_id;
        $data['uk_product_price'] = $request->uk_product_price;
        $data['uk_price_id'] = $request->uk_price_id;
        $data['gbp_product_name'] = $request->gbp_product_name;
        $data['gbp_product_id']  = $request->gbp_product_id;
        $data['gbp_product_price'] = $request->gbp_product_price;
        $data['gbp_price_id'] = $request->gbp_price_id;
        $data['country'] = $country;
        $data['frequently'] = $frequently;

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
            'stripeproductid' => $request->product_id,
            'giftrecipientfirstname' => '',
            'giftrecipientlastname' => '',
            'giftrecipientphone' => '',
            'giftrecipientemail' => '',
        );

        $lead_data = json_encode($l_data);

        $token = $this->getSalesForceAuthToken($this->salesForceTokenUrl, $this->salesForceClientId, $this->salesForceClientSecret, $this->salesForceUsername, $this->salesForcePassword, $this->salesForceToken);

        $leadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $lead_data);
        $l_id = $leadResponse['lead_data'];
        $http_status = $leadResponse['http_status'];

        if (isset($l_id['id'])) {
            $lead_id = $l_id['id'];

            /* --- lead code over ----*/

            $data['lead_id'] = $lead_id;
        }

        $data['intent'] = $customer->createSetupIntent();
        if ($http_status == Config::get('constants.status_error_code')) {
            return redirect('/')->with('error', $l_id['message']);
        }
        return view('checkout1', compact('data'));
    }


    public function individual_checkout(Request $request)
    {

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
        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();
        $datas['product_id'] = $request->product_id;
        $datas['product_price'] = $request->product_price;
        $datas['product_name'] = $request->product_name;
        $datas['customer_id'] = $customerId;
        $datas['stripe_response'] = $stripeResponseEncoded;

        $this->updateCustomerData($customerId, $datas);
        // $customer = customer::where('email', $request->email)->orderBy('id', 'desc')->update($datas);

        Country::where('code', $request->shipping_country)->increment('counts', 1);
        $data['customer_id']  = $request->customer_id;
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $request->product_id;
        $data['product_price'] = $request->product_price;
        $data['url'] =   $request->url;
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['price_id'] = $request->price_id;
        $data['exist'] = $request->customer_exist;
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['uk_product_name'] = $request->uk_product_name;
        $data['uk_product_id'] = $request->uk_product_id;
        $data['uk_product_price'] = $request->uk_product_price;
        $data['uk_price_id'] = $request->uk_price_id;
        $data['gbp_product_name'] = $request->gbp_product_name;
        $data['gbp_product_id'] = $request->gbp_product_id;
        $data['gbp_product_price'] = $request->gbp_product_price;
        $data['gbp_price_id'] = $request->gbp_price_id;
        $data['country'] = $country;
        $data['frequently'] = $frequently;
        $data['lead_id'] = $request->lead_id;

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
            'billingcountry' => $request->billing_country == null ? $request->shipping_country : $request->billing_country,
            'mailingstreet' => $request->shipping_address,
            'mailingcity' => $request->shipping_city,
            'mailingstate' => $request->shipping_state,
            'mailingzip'  => $request->shipping_zipcode,
            'mailingcountry' => $request->shipping_country,
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
        // $customer = customer::where('email', $request->email)->orderBy('id', 'desc')->update($u_datas);

        /* --- lead code over ----*/


        /* code for create member  */

        if (isset($stripeResponseDecoded)) {
            $lead_data['obj']['stripesubscriptionid'] = $stripeResponseDecoded['id'];
            $lead_data['obj']['subscriptionstartdate'] = date('Y-m-d', strtotime($stripeResponseDecoded['start_date']));
            $lead_data['obj']['membershipfee'] = $stripeResponseDecoded['plan']['amount'];
            $lead_data['obj']['paymentfrequency'] = '';
            $lead_data['obj']['accountcurrency'] = $request->currency;
            $lead_responses = json_encode($lead_data);
        } else {
            $lead_data['obj']['stripesubscriptionid'] = '';
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
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'detail_02_email' => 'required|email',
            'detail_02_first_name' => 'required',
            'detail_02_last_name' => 'required',
            'detail_02_phone_number' => 'required'
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
            'detail_02_phone_number.required' => 'The phone number is required.'
        ];

        $validator = Validator::make($request->all(), $validatedData, $customMessages);
        if ($validator->fails()) {
            Session()->flash('activeTab', 'dual');
            return redirect(url()->previous() . '#dual')->withErrors($validator);
        }

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();

        $cardHolderTwoData = [
            "detail_02_email" => $request['detail_02_email'],
            "detail_02_first_name" => $request['detail_02_first_name'],
            "detail_02_last_name" => $request['detail_02_last_name'],
            "detail_02_phone_number" => $request['detail_02_phone_number'],
        ];
        $cardHolderTwoEncodedData = json_encode($cardHolderTwoData);
        $customer = new customer();
        $customerData = $customer->where('email', $request->email)->get()->first();

        if (isset($customerData) && $customerData != NULL) {

            $customer->where('email', $request->email)->update([
                'firstname' => $request->first_name,
                'lastname'  => $request->last_name,
                'phone_number' => $request->phone_number,
                'product_id'   => $request->product_id,
                'product_name' => $request->product_name,
                'product_handle' => $request->product_handle,
                'product_price' => $request->product_price,
                'membership_type' => "dual",
                'secondary_customer_data' => $cardHolderTwoEncodedData,
            ]);
        } else {

            $customer->email = $request->email;
            $customer->firstname = $request->first_name;
            $customer->lastname  = $request->last_name;
            $customer->phone_number = $request->phone_number;
            $customer->product_id   = $request->product_id;
            $customer->product_name = $request->product_name;
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $request->product_price;
            $customer->membership_type = "dual";
            $customer->secondary_customer_data = $cardHolderTwoEncodedData;
            $customer->save();
        }

        $data['customer_id']  = "";
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $request->product_id;
        $data['product_price'] = $request->product_price;
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['url'] = Url::asset('dual_checkout');
        $data['price_id'] = $request->price_id;
        $data['exist'] = "no";
        $data['email_dual_member'] = $request->detail_02_email;
        $data['first_name_dual_member'] = $request->detail_02_first_name;
        $data['last_name_dual_member'] = $request->detail_02_last_name;
        $data['phone_dual_member'] = $request->detail_02_phone_number;
        $data['snap_day'] = $request->snap_day;
        $data['uk_product_name'] = $request->uk_product_name;
        $data['uk_product_id'] = $request->uk_product_id;
        $data['uk_product_price'] = $request->uk_product_price;
        $data['uk_price_id'] = $request->uk_price_id;
        $data['gbp_product_name'] = $request->gbp_product_name;
        $data['gbp_product_id']  = $request->gbp_product_id;
        $data['gbp_product_price'] = $request->gbp_product_price;
        $data['gbp_price_id'] = $request->gbp_price_id;
        $data['country'] = $country;
        $data['frequently'] = $frequently;

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
            'stripeproductid' => $request->product_id,
            'giftrecipientfirstname' => '',
            'giftrecipientlastname' => '',
            'giftrecipientphone' => '',
            'giftrecipientemail' => '',
        );

        $dual_lead_data = json_encode($duallead_data);

        /*--- lead create code---- */
        $leadResponse = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $dual_lead_data);
        $d_response = $leadResponse['lead_data'];
        $http_status = $leadResponse['http_status'];
        if (isset($d_response)) {
            $data['lead_id'] = $d_response['id'];
        }

        /* --- lead code over ----*/

        $data['intent'] = $customer->createSetupIntent();
        if ($http_status == Config::get('constants.status_error_code')) {
            return redirect('/')->with('dual-error', $d_response['message']);
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

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();
        $datas['product_id'] = $request->product_id;
        $datas['product_price'] = $request->product_price;
        $datas['product_name'] = $request->product_name;
        $datas['customer_id'] = $customerId;
        $datas['stripe_response'] = $stripeResponseEncoded;

        $this->updateCustomerData($customerId, $datas);
        // $customer = customer::where('email', $request->email)->orderBy('id', 'desc')->update($datas);

        Country::where('code', $request->shipping_country)->increment('counts', 1);

        $data['customer_id']  = $request->customer_id;
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $request->product_id;
        $data['product_price'] = $request->product_price;
        $data['url'] =   $request->url;
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['price_id'] = $request->price_id;
        $data['exist'] = $request->customer_exist;
        $data['email_dual_member'] = $request->email_dual_member;
        $data['first_name_dual_member'] = $request->first_name_dual_member;
        $data['last_name_dual_member']  = $request->last_name_dual_member;
        $data['phone_dual_member']      = $request->detail_02_phone_number;
        $data['uk_product_name'] = $request->uk_product_name;
        $data['uk_product_id'] = $request->uk_product_id;
        $data['uk_product_price'] = $request->uk_product_price;
        $data['uk_price_id'] = $request->uk_price_id;
        $data['gbp_product_name'] = $request->gbp_product_name;
        $data['gbp_product_id'] = $request->gbp_product_id;
        $data['gbp_product_price'] = $request->gbp_product_price;
        $data['gbp_price_id'] = $request->gbp_price_id;
        $data['country'] = $country;
        $data['frequently'] = $frequently;
        $data['lead_id'] = $request->lead_id;

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
        $ud_datas['leadId'] = $lead_datas['lead_data']['id'];
        $ud_datas['lead_response'] = $lead_datas;

        $this->updateCustomerData($customerId, $ud_datas);
        // $customer = customer::where('email', $request->email)->orderBy('id', 'desc')->update($ud_datas);

        /* --- lead code over ----*/


        /* code for create member in dual */

        if (isset($stripeResponseDecoded)) {
            $lead_data['obj']['stripesubscriptionid'] = $stripeResponseDecoded['id'];
            $lead_data['obj']['subscriptionstartdate'] = date('Y-m-d', strtotime($stripeResponseDecoded['start_date']));
            $lead_data['obj']['membershipfee'] = $stripeResponseDecoded['plan']['amount'];
            $lead_data['obj']['paymentfrequency'] = '';
            $lead_data['obj']['accountcurrency'] = $request->currency;
            $lead_responses = json_encode($lead_data);
        } else {
            $lead_data['obj']['stripesubscriptionid'] = '';
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
            'secondary_customer_data' => $dual_lead_data
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
            'Emailgift' => 'required|email',
            'Firstnamegift' => 'required',
            'Lastnamegift' => 'required',

        ];

        $validator = Validator::make($request->all(), $validatedData);
        if ($validator->fails()) {
            Session()->flash('activeTab', 'gifting');
            return redirect(url()->previous() . '#gifting')->withErrors($validator);
        }

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();



        $post_url1 = "https://the-cultivist-usa.chargify.com/customers.json?q=$request->customer_email";
        $header1 = array(
            "authorization: Basic aUlpVmJoYXZMbFRzMk80eE5KTDFtMFJ4NU9aWEhmVTRkNVBNZmZiNWI4azo="
        );
        $domain = "USA";



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $post_url1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => $header1,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $error = "cURL Error #:" . $err;
        } else {
            $response;
        }

        if ($response == "[]") {

            $customer = new customer();
            $customer->email = $request->customer_email;
            $customer->firstname = $request->customer_first_name;
            $customer->lastname  = $request->customer_last_name;
            $customer->phone_number = $request->customer_phone_number;
            $customer->product_id   = $request->product_id;
            $customer->product_name = $request->product_name;
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $request->product_price;
            $customer->save();
        }



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
        $data['product_id']  = $request->product_id;
        $data['product_price'] = $request->product_price;
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['product_handle'] = $request->product_handle;
        $data['url'] = Url::asset('gift_checkout');
        $data['exist'] = "no";
        $data['snap_day']  = $request->snap_day;
        $data['product_price_point_id'] = $request->product_price_point_id;
        $data['Startdategift'] = $request->Startdategift;
        $data['uk_product_id'] = $request->uk_product_id;
        $data['uk_product_price'] = $request->uk_product_price;
        $data['uk_price_point_id'] = $request->uk_price_point_id;
        $data['gbp_product_id']  = $request->gbp_product_id;
        $data['gbp_product_price'] = $request->gbp_product_price;
        $data['gbp_price_point_id'] = $request->gbp_price_point_id;
        $data['country'] = $country;
        $data['frequently'] = $frequently;


        /* token gererate code start -- */

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&client_id=3MVG9szVa2RxsqBaGQzSS2thf6iKy9gGluD2979jniKFXHrc6nc1vZ4OTw_PwoXVQNtWlUf3NE.2H0R08yQKO&client_secret=20983D576824023C7D59591642B9D98A2104787E157E0E3FA3B5167286835C88&username=marlies.verhoeven%40thecultivist.com&password=Dogdays2018J3vmtrm6pwcCIAlQttIXuFIS1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw; CookieConsentPolicy=0:0'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        $token = 'Authorization: Bearer ' . $response['access_token'];

        /*--- lead create code---- */



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
            'giftrecipientfirstname' => $request->Firstnamegift,
            'giftrecipientlastname' => $request->Lastnamegift,
            'giftrecipientphone' => $request->phone_number,
            'giftrecipientemail' => $request->Emailgift,

        );

        $g_lead_data = json_encode($gift_l_data);
        /* lead create gift */
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/apexrest/createlead',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $g_lead_data,
            CURLOPT_HTTPHEADER => array(
                $token,
                'Content-Type: application/json',
                'Cookie: BrowserId=tdG2nKgDEeu56Q1Yr4wGvQ'
            ),
        ));

        $gift_lead_response = curl_exec($curl);

        curl_close($curl);
        $gift_lead_response;
        $lead_datas = json_decode($gift_lead_response, true);
        $data['lead_id'] = $lead_datas['id'];

        /* lead create over */
        $data['intent'] = $customer->createSetupIntent(); // intent setup for stripe

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

        $subscriptionResponse = $this->createStripeSubscription($request->payment_method, $request->email, $request->price_id);
        $subscription = $subscriptionResponse['subscription_response'];
        $customerId = $subscriptionResponse['customer_id'];

        $country = Country::orderBy('name', 'ASC')->get();
        $frequently = Country::orderBy('counts', 'DESC')->limit(4)->get();

        if ($request->currency == "GBP") {
            $post_url1 = "https://the-cultivist-uk-clone-clone.chargify.com/customers.json?q=$request->customer_email";
            $header1 = array(
                "authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw=="
            );
            $domain = "GBP";
        } else if ($request->currency == "EUR") {
            $post_url1 = "https://the-cultivist-uk-clone.chargify.com/customers.json?q=$request->customer_email";
            $header1 = array(
                "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc="
            );
            $domain = "UK";
        } else {
            $post_url1 = "https://the-cultivist-usa.chargify.com/customers.json?q=$request->customer_email";
            $header1 = array(
                "authorization: Basic aUlpVmJoYXZMbFRzMk80eE5KTDFtMFJ4NU9aWEhmVTRkNVBNZmZiNWI4azo="
            );
            $domain = "USA";
        }



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $post_url1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => $header1,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $error = "cURL Error #:" . $err;
        } else {
            $response;
        }

        if ($response == "[]") {
            $customer = new customer();
            $customer->email = $request->customer_email;
            $customer->firstname = $request->customer_first_name;
            $customer->lastname  = $request->customer_last_name;
            $customer->phone_number = $request->customer_phone_number;
            $customer->product_id   = $request->product_id;
            $customer->product_name = $request->product_name;
            $customer->product_handle = $request->product_handle;
            $customer->product_price = $request->product_price;
            $customer->save();

            $datas['domain'] = $domain;
            $datas['product_id'] = $request->product_id;
            $datas['product_price'] = $request->product_price;
            $datas['product_name'] = $request->product_name;
            $customer = customer::where('email', $request->email)->orderBy('id', 'desc')->update($datas);
        } else {
            $request->customer_id  = $data['0']['customer']['id'];

            $data_json = json_decode($response, true);
            $datas['domain'] = $domain;
            $datas['product_id'] = $request->product_id;
            $datas['product_price'] = $request->product_price;
            $datas['product_name'] = $request->product_name;
            $datas['customer_id'] = $data_json['0']['customer']['id'];
            $customer = customer::where('email', $request->customer_email)->orderBy('id', 'desc')->update($datas);

            $request->customer_exist = "yes";
        }

        $expiry = explode("/", $request->expiry);
        $ye = str_replace(' ', '', $expiry[1]);
        $month = str_replace(' ', '', $expiry[0]);
        $year = '20' . $ye;

        if ($request->Startdategift != null) {
            $date = date_create($request->Startdategift);
            $dates = date_format($date, "Y-m-d");
        } else {
            $dates = null;
        }

        Country::where('code', $request->shipping_country)->increment('counts', 1);

        if ($request->customer_exist == "no") {
            $post_data =  array(
                'subscription' => array(
                    "snap_day" => $request->snap_day == null ? '' : $request->snap_day,
                    'product_id' => $request->product_id,
                    'product_price_point_id' => $request->product_price_point_id,
                    'customer_attributes' => array(
                        'first_name' => $request->customer_first_name,
                        'last_name' => $request->customer_last_name,
                        'email' => $request->customer_email,
                        'zip' => $request->shipping_zipcode,
                        'state' => $request->shipping_state,
                        'phone' => $request->customer_phone_number,
                        'country' => $request->shipping_country,
                        'city' => $request->shipping_city,
                        'address_2' => NULL,
                        'address' => $request->shipping_address,

                    ),
                    'credit_card_attributes' => array(
                        'full_number' => $request->ccnumber,
                        'expiration_month' => $month,
                        'expiration_year' => $year,
                        'cvv' => $request->cvv,
                        'first_name' => $request->card_name,
                        'billing_zip' => $request->billing_zip,
                        'billing_address' => $request->billing_address == null ? $request->shipping_address : $request->billing_address,
                        'billing_city' => $request->billing_city == null ? $request->shipping_city : $request->billing_address,
                        'billing_state' => $request->billing_state == null ? $request->shipping_state : $request->billing_state,
                        'billing_zip' => $request->billing_zipcode == null ? $request->shipping_zipcode : $request->billing_zipcode,
                        'billing_country' => $request->billing_country == null ? $request->shipping_country : $request->billing_country,
                    ),
                    "metafields" => array(
                        "Emailgift" => $request->Emailgift,
                        "Firstnamegift" => $request->Firstnamegift,
                        "Lastnamegift" => $request->Lastnamegift,
                        "Phonegift" => $request->shipping_phonenumber,
                        "Startdategift" => $dates == null ? '' : $dates,
                        "additional_information" => $request->additional_information
                    ),
                    'coupon_code' => $request->promo_gift == null ? ' ' : $request->promo_gift,
                    'currency' => $request->currency,
                ),
            );
        } else {
            $post_data =  array(
                'subscription' => array(
                    "snap_day" => $request->snap_day == null ? '' : $request->snap_day,
                    'product_id' => $request->product_id,
                    'product_price_point_id' => $request->product_price_point_id,
                    "customer_id" => '',
                    'customer_attributes' => array(
                        'first_name' => $request->customer_first_name,
                        'last_name' => $request->customer_last_name,
                        'email' => $request->customer_email,
                        'zip' => $request->shipping_zipcode,
                        'state' => $request->shipping_state,
                        'phone' => $request->customer_phone_number,
                        'country' => $request->shipping_country,
                        'city' => $request->shipping_city,
                        'address_2' => NULL,
                        'address' => $request->shipping_address,

                    ),
                    'credit_card_attributes' => array(
                        'full_number' => $request->ccnumber,
                        'expiration_month' => $month,
                        'expiration_year' => $year,
                        'cvv' => $request->cvv,
                        'first_name' => $request->card_name,
                        'billing_zip' => $request->billing_zip,
                        'billing_address' => $request->billing_address == null ? $request->shipping_address : $request->billing_address,
                        'billing_city' => $request->billing_city == null ? $request->shipping_city : $request->billing_address,
                        'billing_state' => $request->billing_state == null ? $request->shipping_state : $request->billing_state,
                        'billing_zip' => $request->billing_zipcode == null ? $request->shipping_zipcode : $request->billing_zipcode,
                        'billing_country' => $request->billing_country == null ? $request->shipping_country : $request->billing_country,
                    ),
                    "metafields" => array(
                        "Emailgift" => $request->Emailgift,
                        "Firstnamegift" => $request->Firstnamegift,
                        "Lastnamegift" => $request->Lastnamegift,
                        "Phonegift" => $request->shipping_phonenumber,
                        "Startdategift" => $dates == null ? '' : $dates,
                        "additional_information" => $request->additional_information
                    ),
                    'coupon_code' => $request->promo_gift == null ? ' ' : $request->promo_gift,
                    'currency' => $request->currency,
                ),
            );
        }

        $data['customer_id']  = $request->customer_id;
        $data['customer_first_name'] = $request->first_name;
        $data['customer_last_name']  = $request->last_name;
        $data['customer_email']  = $request->email;
        $data['customer_phone_number'] = $request->phone_number;
        $data['phone_number']   = $request->phone_number;
        $data['product_handle'] = $request->product_handle;
        $data['product_id']  = $request->product_id;
        $data['product_price'] = $request->product_price;
        $data['url'] =   $request->url;
        $data['payment_name'] = $request->payment_name;
        $data['product_name'] = $request->product_name;
        $data['exist'] = $request->customer_exist;
        $data['snap_day']  = $request->snap_day;
        $data['product_price_point_id'] = $request->product_price_point_id;
        $data['Startdategift'] = $request->Startdategift;
        $data['Emailgift'] = $request->Emailgift;
        $data['Firstnamegift'] = $request->Firstnamegift;
        $data['Lastnamegift']  = $request->Lastnamegift;
        $data['uk_product_id'] = $request->uk_product_id;
        $data['uk_product_price'] = $request->uk_product_price;
        $data['uk_price_point_id'] = $request->uk_product_price_point_id;
        $data['gbp_product_id'] = $request->gbp_product_id;
        $data['gbp_product_price'] = $request->gbp_product_price;
        $data['gbp_price_point_id'] = $request->gbp_product_price_point_id;
        $data['country'] = $country;
        $data['frequently'] = $frequently;
        $data['lead_id']  = $request->lead_id;

        $json = json_encode($post_data);

        if ($request->currency == "GBP") {
            $post_url = "https://the-cultivist-uk-clone-clone.chargify.com/subscriptions.json";
            $header = array(
                "authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw==",
                "content-type: application/json"
            );
        } else if ($request->currency == "EUR") {
            $post_url = "https://the-cultivist-uk-clone.chargify.com/subscriptions.json";
            $header = array(
                "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc=",
                "content-type: application/json"
            );
        } else {
            $post_url = "https://the-cultivist-usa.chargify.com/subscriptions.json";
            $header = array(
                "authorization: Basic aUlpVmJoYXZMbFRzMk80eE5KTDFtMFJ4NU9aWEhmVTRkNVBNZmZiNWI4azo=",
                "content-type: application/json"
            );
        }

        /* token gererate code start -- */

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&client_id=3MVG9szVa2RxsqBaGQzSS2thf6iKy9gGluD2979jniKFXHrc6nc1vZ4OTw_PwoXVQNtWlUf3NE.2H0R08yQKO&client_secret=20983D576824023C7D59591642B9D98A2104787E157E0E3FA3B5167286835C88&username=marlies.verhoeven%40thecultivist.com&password=Dogdays2018J3vmtrm6pwcCIAlQttIXuFIS1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw; CookieConsentPolicy=0:0'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        $token = 'Authorization: Bearer ' . $response['access_token'];

        /*--- lead create code---- */

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
            'chargifyuserid' => $request->customer_id,

        );

        $g_lead_data = json_encode($gift_l_data);
        /* lead create gift */
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/apexrest/createlead',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $g_lead_data,
            CURLOPT_HTTPHEADER => array(
                $token,
                'Content-Type: application/json',
                'Cookie: BrowserId=tdG2nKgDEeu56Q1Yr4wGvQ'
            ),
        ));

        $gift_lead_response = curl_exec($curl);

        curl_close($curl);
        $gift_lead_response;
        $lead_datas = json_decode($gift_lead_response, true);
        $gd_datas['leadId'] = $lead_datas['id'];
        $gd_datas['lead_response'] = $gift_lead_response;
        customer::where('email', $request->customer_email)->orderBy('id', 'desc')->update($gd_datas);
        /* lead create over */


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $post_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $error = json_decode($response, true);

            if (isset($error['errors'])) {
                return view('checkout', compact('data', 'error'));
            } else {
                customer::where('email', $request->email)->orderBy('id', 'desc')->update(['chargify_response' => $response]);
                $response = json_decode($response, true);
                if (isset($response['subscription'])) {
                    $lead_datas['obj']['chargifysubscriptionid'] = $response['subscription']['id'];
                    $lead_datas['obj']['subscriptionstartdate'] = date('Y-m-d', strtotime($response['subscription']['activated_at']));
                    $lead_datas['obj']['membershipfee'] = $response['subscription']['product_price_in_cents'];
                    $lead_datas['obj']['paymentfrequency'] = '';
                    $lead_datas['obj']['accountcurrency'] = $request->currency;
                    $lead_responses = json_encode($lead_datas);
                } else {

                    $lead_datas['obj']['chargifysubscriptionid'] = '';
                    $lead_datas['obj']['subscriptionstartdate'] = '';
                    $lead_datas['obj']['membershipfee'] = '';
                    $lead_datas['obj']['paymentfrequency'] = '';
                    $lead_datas['obj']['accountcurrency'] = '';
                    $lead_responses = json_encode($lead_datas);
                }
                /* gift member */

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/apexrest/createmember',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $lead_responses,
                    CURLOPT_HTTPHEADER => array(
                        $token,
                        'Content-Type: application/json',
                        'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
                    ),
                ));

                $gift_member_response = curl_exec($curl);

                curl_close($curl);
                $gift_member_response;
                /* END */
                return redirect('/success');
            }
        }
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

    public function formsubmit(Request $request)
    {

        /* token gererate code start -- */

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&client_id=3MVG9szVa2RxsqBaGQzSS2thf6iKy9gGluD2979jniKFXHrc6nc1vZ4OTw_PwoXVQNtWlUf3NE.2H0R08yQKO&client_secret=20983D576824023C7D59591642B9D98A2104787E157E0E3FA3B5167286835C88&username=marlies.verhoeven%40thecultivist.com&password=Dogdays2018J3vmtrm6pwcCIAlQttIXuFIS1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw; CookieConsentPolicy=0:0'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        $token = 'Authorization: Bearer ' . $response['access_token'];
        /*--- lead create code---- */
        if ($request->product_name == "The Enthusiast") {
            $l_data = array(
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
                'memberfirstname' => '',
                'memberlastname' => '',
                'memberphone' => '',
                'memberemail' => '',
                'chargifyproductid' => $request->product_id,
                'giftrecipientfirstname' => '',
                'giftrecipientlastname' => '',
                'giftrecipientphone' => '',
                'giftrecipientemail' => '',
                'promoapplied' => $request->promo_gift,
                'additionalinformation' => $request->additional_information,
                'chargifyuserid' => $request->customer_id,
            );
        } else if ($request->product_name == "The Enthusiast - Dual") {
            $l_data = array(
                'firstname' => $request->first_name,
                'lastname' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
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
                'chargifyproductid' => $request->product_id,
                'giftrecipientfirstname' => '',
                'giftrecipientlastname' => '',
                'giftrecipientphone' => '',
                'giftrecipientemail' => '',
                'promoapplied' => $request->promo_gift,
                'additionalinformation' => $request->additional_information,
                'chargifyuserid' => $request->customer_id,
            );
        } else {
            $l_data = array(
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
                'chargifyuserid' => $request->customer_id,

            );
        }
        $g_lead_data = json_encode($l_data);
        /* lead create gift */
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://thecultivist.my.salesforce.com/services/apexrest/createlead',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $g_lead_data,
            CURLOPT_HTTPHEADER => array(
                $token,
                'Content-Type: application/json',
                'Cookie: BrowserId=tdG2nKgDEeu56Q1Yr4wGvQ'
            ),
        ));

        $gift_lead_response = curl_exec($curl);

        curl_close($curl);
        $gift_lead_response;
        $lead_datas = json_decode($gift_lead_response, true);
        $gd_datas['leadId'] = $lead_datas['id'];
        $gd_datas['lead_response'] = $gift_lead_response;
        if ($request->product_name == "The Enthusiast") {
            customer::where('email', $request->email)->orderBy('id', 'desc')->update($gd_datas);
        } else if ($request->product_name == "The Enthusiast - Dual") {
            customer::where('email', $request->email)->orderBy('id', 'desc')->update($gd_datas);
        } else {
            customer::where('email', $request->customer_email)->orderBy('id', 'desc')->update($gd_datas);
        }

        $resp = array("status" => true, "message" => "Detail saved successfully...!");
        echo json_encode($resp);
        exit;
        /* lead create over */
    }
}
