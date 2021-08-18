<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\customer;
use App\Country;
use URL;

class GiftController extends Controller
{
    public function gifting(Request $request)
    {
        //dd($request->all());
      
        $validatedData = [
            'Emailgift' => 'required|email',
            'Firstnamegift' => 'required',
            'Lastnamegift' => 'required',
          
        ];

        $validator = Validator::make($request->all(),$validatedData);
        if($validator->fails())
        {
            Session()->flash('activeTab','gifting');    
            return redirect(url()->previous() .'#gifting')->withErrors($validator);
        }
         
         $country = Country::orderBy('name','ASC')->get();
         $frequently = Country::orderBy('counts','DESC')->limit(4)->get();



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

        if ($err){
          $error = "cURL Error #:" . $err;
        } else {
           $response;
        }

        //dd($response);
        if($response == "[]")
        {
          
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
          //dd($customer->email);
        


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


          // dd($data);
    			/* token gererate code start -- */

	        $curl = curl_init();
	        curl_setopt_array($curl, array(
	          CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/oauth2/token',
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => '',
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 0,
	          CURLOPT_FOLLOWLOCATION => true,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => 'POST',
	          CURLOPT_POSTFIELDS => 'grant_type=password&client_id=3MVG9d3kx8wbPieGlphtF5U_r5vE5n6xzmYszuNbcgO_Fl7rWpUfWIUWgbO76BWpB7AbTngUbVJNc8T_IU0yk&client_secret=223354502D7CD5E90324AA7A777A7104BB034CECF71A0548D30E8D472009EBF5&username=rahul%40kandisatech.com&password=Cultivist%4012',
	          CURLOPT_HTTPHEADER => array(
	            'Content-Type: application/x-www-form-urlencoded',
	            'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
	          ),
	        ));

	        $response = curl_exec($curl);

	        curl_close($curl);
	        $response = json_decode($response, true);
	        $token = 'Authorization: Bearer '.$response['access_token']; 

    		/*--- lead create code---- */    
        	$gift_l_data = array (
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
	            //dd($g_lead_data);
	        /* lead create gift */      
	            $curl = curl_init();

	        curl_setopt_array($curl, array(
	          CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/apexrest/createlead',
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
	       // dd($gift_lead_response);
	        $lead_datas = json_decode($gift_lead_response,true);
	        $data['lead_id'] = $lead_datas['id'];
	        
        /* lead create over */

            
        return view('checkout1',compact('data'));           
    }

    public function gift_checkout(Request $request)
    {
      // dd($request->all());

	      $country = Country::orderBy('name','ASC')->get();
	         $frequently = Country::orderBy('counts','DESC')->limit(4)->get();

	      if($request->currency == "GBP")
	      {
	        $post_url1 = "https://the-cultivist-uk-clone-clone.chargify.com/customers.json?q=$request->customer_email";
	        $header1 = array("authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw=="
	        );
	        $domain = "GBP";
	      }
	      else if($request->currency == "EUR")
	      {
	        $post_url1 = "https://the-cultivist-uk-clone.chargify.com/customers.json?q=$request->customer_email";
	        $header1 = array(
	              "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc="
	            );
	        $domain = "UK"; 
	      }  
	      else 
	      {
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

        if ($err){
          $error = "cURL Error #:" . $err;
        } else {
           $response;
        }

        //dd($response);
        if($response == "[]")
        {
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

           //dd($customer->email);
            $datas['domain'] = $domain;
            $datas['product_id'] = $request->product_id;
            $datas['product_price'] = $request->product_price;
            $datas['product_name'] = $request->product_name;
            $customer = customer::where('email',$request->email)->orderBy('id','desc')->update($datas);
        }
        
        else
        {
          // $data = json_decode($response,true);  
           $request->customer_id  = $data['0']['customer']['id'];

            $data_json = json_decode($response,true);  
            $datas['domain'] = $domain;
            $datas['product_id'] = $request->product_id;
            $datas['product_price'] = $request->product_price;
            $datas['product_name'] = $request->product_name;
            $datas['customer_id'] = $data_json['0']['customer']['id'];
            $customer = customer::where('email',$request->customer_email)->orderBy('id','desc')->update($datas);

            $request->customer_exist = "yes";
        } 

        $expiry = explode("/",$request->expiry);
        $ye = str_replace(' ', '',$expiry[1]);
        $month = str_replace(' ', '',$expiry[0]);
      //  $date = str_replace(' ', '',$expiry[1]);
        $year = '20'.$ye;
        
	     if($request->Startdategift != null)
	     {
	        $date=date_create($request->Startdategift);
	        $dates = date_format($date,"Y-m-d");
	     }
	     else
	     {
	        $dates = null;
	     } 

	     Country::where('code',$request->shipping_country)->increment('counts' ,1);

	    if($request->customer_exist == "no")
	    {  
	     // dd("no_exit");
	      $post_data=  array (
	          'subscription' =>array (
	                      "snap_day" => $request->snap_day==null ? '' :$request->snap_day,
	                      'product_id' =>$request->product_id,
	                      'product_price_point_id' => $request->product_price_point_id,
	                      'customer_attributes' =>array (
	                                'first_name' => $request->customer_first_name,
	                                'last_name' => $request->customer_last_name,
	                                'email' => $request->customer_email,
	                                'zip' => $request->shipping_zipcode,
	                                'state' => $request->shipping_state,
	                              //  'reference' => 'XYZ',
	                                'phone' => $request->customer_phone_number,
	                              //  'organization' => ,
	                                'country' => $request->shipping_country,
	                                'city' => $request->shipping_city,
	                                'address_2' => NULL,
	                                'address' =>$request->shipping_address,

	                      ),
	                      'credit_card_attributes' => array(
	                              'full_number'=> $request->ccnumber,
	                              'expiration_month' => $month,
	                              'expiration_year' => $year,
	                              'cvv'=> $request->cvv,
	                              'first_name' => $request->card_name,
	                              'billing_zip'=>$request->billing_zip,  
	                              'billing_address' => $request->billing_address==null ? $request->shipping_address:$request->billing_address,
	                              'billing_city' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
	                              'billing_state'=> $request->billing_state==null ? $request->shipping_state : $request->billing_state,
	                              'billing_zip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
	                              'billing_country'=> $request->billing_country==null ? $request->shipping_country : $request->billing_country,
	                      ),
	                      "metafields"=> array (
	                               "Emailgift"=> $request->Emailgift,
	                               "Firstnamegift"=> $request->Firstnamegift,
	                               "Lastnamegift" =>$request->Lastnamegift,
	                               "Phonegift" =>$request->shipping_phonenumber,
	                               "Startdategift"=>$dates==null ? '' :$dates, 
	                               "additional_information" => $request->additional_information
	                      ),
	                      'coupon_code' =>$request->promo_gift==null ? ' ' :$request->promo_gift,
	                      'currency' => $request->currency,
	                ),
	        );
	    }
	    else
	    {
	      $post_data=  array (
	        'subscription' =>array (
	                      "snap_day" => $request->snap_day==null ? '' :$request->snap_day,
	                      'product_id' =>$request->product_id,
	                      'product_price_point_id' => $request->product_price_point_id,
	                    //  "customer_id" => $request->customer_id,
	                      "customer_id" => '',
	                      'customer_attributes' =>array (
	                                'first_name' => $request->customer_first_name,
	                                'last_name' => $request->customer_last_name,
	                                'email' => $request->customer_email,
	                                'zip' => $request->shipping_zipcode,
	                                'state' => $request->shipping_state,
	                              //  'reference' => 'XYZ',
	                                'phone' => $request->customer_phone_number,
	                              //  'organization' => ,
	                                'country' => $request->shipping_country,
	                                'city' => $request->shipping_city,
	                                'address_2' => NULL,
	                                'address' =>$request->shipping_address,

	                      ),
	                      'credit_card_attributes' => array(
	                              'full_number'=> $request->ccnumber,
	                              'expiration_month' => $month,
	                              'expiration_year' => $year,
	                              'cvv'=> $request->cvv,
	                              'first_name' => $request->card_name,
	                              'billing_zip'=>$request->billing_zip,  
	                              'billing_address' => $request->billing_address==null ? $request->shipping_address:$request->billing_address,
	                              'billing_city' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
	                              'billing_state'=> $request->billing_state==null ? $request->shipping_state : $request->billing_state,
	                              'billing_zip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
	                              'billing_country'=> $request->billing_country==null ? $request->shipping_country : $request->billing_country,
	                      ),
	                      "metafields"=> array (
	                               "Emailgift"=> $request->Emailgift,
	                               "Firstnamegift"=> $request->Firstnamegift,
	                               "Lastnamegift" =>$request->Lastnamegift,
	                               "Phonegift" =>$request->shipping_phonenumber,
	                               "Startdategift"=>$dates==null ? '' :$dates, 
	                               "additional_information" => $request->additional_information
	                      ),
	                    'coupon_code' =>$request->promo_gift==null ? ' ' :$request->promo_gift,
	                    'currency' => $request->currency,
	                ),
	        );       
	    }

         // dd($post_data);
           $data['customer_id']  = $request->customer_id;
         //  $data['customer_id']  = "";
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
      //     $data['uk_price_point_id'] = $request->uk_price_point_id;
           $data['uk_price_point_id'] = $request->uk_product_price_point_id;
           $data['gbp_product_id'] = $request->gbp_product_id;
           $data['gbp_product_price'] = $request->gbp_product_price;
           $data['gbp_price_point_id'] = $request->gbp_product_price_point_id;
           $data['country'] = $country;
           $data['frequently'] = $frequently;
           $data['lead_id']  = $request->lead_id;
 
	    $json = json_encode($post_data);

	    if($request->currency == "GBP")
	    {
	      $post_url = "https://the-cultivist-uk-clone-clone.chargify.com/subscriptions.json";
	      $header = array("authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw==",
	      "content-type: application/json");
	    }
	    else if($request->currency == "EUR")
	    {
	        $post_url = "https://the-cultivist-uk-clone.chargify.com/subscriptions.json";
	        $header = array(
	              "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc=",
	               "content-type: application/json"
	            );    
	    } 
	    else
	    {
	      $post_url = "https://the-cultivist-usa.chargify.com/subscriptions.json";
	      $header = array(
	        "authorization: Basic aUlpVmJoYXZMbFRzMk80eE5KTDFtMFJ4NU9aWEhmVTRkNVBNZmZiNWI4azo=",
	        "content-type: application/json"
	      );
	    }  

    	/* token gererate code start -- */

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/oauth2/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'grant_type=password&client_id=3MVG9d3kx8wbPieGlphtF5U_r5vE5n6xzmYszuNbcgO_Fl7rWpUfWIUWgbO76BWpB7AbTngUbVJNc8T_IU0yk&client_secret=223354502D7CD5E90324AA7A777A7104BB034CECF71A0548D30E8D472009EBF5&username=rahul%40kandisatech.com&password=Cultivist%4012',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        $token = 'Authorization: Bearer '.$response['access_token']; 

    	/*--- lead create code---- */    

        $gift_l_data = array (
                'firstname' => $request->customer_first_name,
                'lastname' => $request->customer_last_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone_number,
                'billingstreet'=>$request->billing_address==null ? $request->shipping_address:$request->billing_address,
                'billingcity' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
                'billingstate' => $request->billing_state==null ? $request->shipping_state : $request->billing_state,
                'billingzip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
                'billingcountry' => $request->billing_country==null ? $request->shipping_country : $request->billing_country,
                'memberfirstname' => '',
                'memberlastname' => '',
                'memberphone' => '',
                'memberemail' => '',
                'mailingstreet'=>$request->shipping_address,
                'mailingcity' => $request->shipping_city,
                'mailingstate'=> $request->shipping_state,
                'mailingzip'  => $request->shipping_zipcode,
                'mailingcountry' => $request->shipping_country,
                'chargifyproductid'=> $request->product_id,
                'giftrecipientfirstname' => $request->Firstnamegift,
                'giftrecipientlastname' => $request->Lastnamegift,
                'giftrecipientphone' => $request->phone_number,
                'giftrecipientemail' => $request->Emailgift,
                'promoapplied' =>$request->promo_gift,
                'additionalinformation' =>$request->additional_information,
              //  'id'=> $request->lead_id,

            );
         
            $g_lead_data = json_encode($gift_l_data);
           // dd($g_lead_data);
        /* lead create gift */      
            $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/apexrest/createlead',
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
       // dd($gift_lead_response);
        $lead_datas = json_decode($gift_lead_response,true);
        $gd_datas['leadId'] = $lead_datas['id'];
        $gd_datas['lead_response'] = $gift_lead_response;
        //dd($gd_datas);
        customer::where('email',$request->customer_email)->orderBy('id','desc')->update($gd_datas);
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
	        // echo $response;
	          $error = json_decode($response,true);
	    
	          if(isset($error['errors']))
	          {
	              return view('checkout',compact('data','error'));
	          } 
	          else
	          { 
	            customer::where('email',$request->email)->orderBy('id','desc')->update(['chargify_response'=>$response]);
	            $response = json_decode($response,true);
	            if(isset($response['subscription']))
	            {  
	              $lead_datas['obj']['chargifysubscriptionid'] = $response['subscription']['id'];
	              $lead_datas['obj']['subscriptionstartdate'] = date('Y-m-d',strtotime($response['subscription']['activated_at']));
	              $lead_datas['obj']['membershipfee'] =$response['subscription']['product_price_in_cents'];
	              $lead_datas['obj']['paymentfrequency'] = '';
	              $lead_datas['obj']['accountcurrency'] = $request->currency; 
	              $lead_responses = json_encode($lead_datas);
	            }  
	            else
	            { 
	              
	              $lead_datas['obj']['chargifysubscriptionid'] = '';
	              $lead_datas['obj']['subscriptionstartdate'] = '';
	              $lead_datas['obj']['membershipfee'] ='';
	              $lead_datas['obj']['paymentfrequency'] = '';
	              $lead_datas['obj']['accountcurrency'] = ''; 
	              $lead_responses = json_encode($lead_datas);
	            }  

	                        /* gift member */

	              $curl = curl_init();

	              curl_setopt_array($curl, array(
	              CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/apexrest/createmember',
	              CURLOPT_RETURNTRANSFER => true,
	              CURLOPT_ENCODING => '',
	              CURLOPT_MAXREDIRS => 10,
	              CURLOPT_TIMEOUT => 0,
	              CURLOPT_FOLLOWLOCATION => true,
	              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	              CURLOPT_CUSTOMREQUEST => 'POST',
	              CURLOPT_POSTFIELDS =>$lead_responses,
	              CURLOPT_HTTPHEADER => array(
	                $token,
	                'Content-Type: application/json',
	                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
	              ),
	            ));

	            $gift_member_response = curl_exec($curl);

	            curl_close($curl);
	             $gift_member_response;
	                // dd($gift_member_response);   
	                    /* END */
	              return redirect('/success');
	          } 
	      } 

	}

	public function check_coupen(Request $request)
    { 
     // dd($request->all());
	    if($request->currency == "GBP")
	    {
	      $coupen_url = "https://the-cultivist-uk-clone-clone.chargify.com/coupons/validate.json?code=$request->coupen_code";
	      $header_coupon = array("authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw==",
	      "content-type: application/json");
	    }
	    else if($request->currency == "EUR")
	    {
	        $coupen_url = "https://the-cultivist-uk-clone.chargify.com/coupons/validate.json?code=$request->coupen_code";
	        $header_coupon = array(
	              "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc=",
	               "content-type: application/json"
	            );    
	    } 
	    else
	    {
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
	      //  echo "cURL Error #:" . $err;
		        $error = json_decode($err,true);
		        if(isset($error['errors']))
		        {
		            $resp = array("status"=>false,"message"=> $error['errors']);
		            echo json_encode($resp);
		            exit;
		        }
		        else
		        {
		            $resp = array("status"=>false,"message"=> $error);
		            echo json_encode($resp);
		            exit; 
		        }
	         
	      	} else {
	      //  echo $response;
	          	$error = json_decode($response,true);
		        if(isset($error['errors']))
		        {
		            $resp = array("status"=>false,"message"=> $error['errors']);
		            echo json_encode($resp);
		            exit;
		        }
		        else
		        {
		            $type = $request->currency;
		            $percentage = $error['coupon']['percentage'];  
		            $amount = $error['coupon']['amount_in_cents'];
		           $resp = array("status"=>true,"percentage"=> $percentage,"amount"=>$amount,"message"=>"coupon applied successfully",'type'=>$type);
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
        //dd($request->all());

        /* token gererate code start -- */

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/oauth2/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'grant_type=password&client_id=3MVG9d3kx8wbPieGlphtF5U_r5vE5n6xzmYszuNbcgO_Fl7rWpUfWIUWgbO76BWpB7AbTngUbVJNc8T_IU0yk&client_secret=223354502D7CD5E90324AA7A777A7104BB034CECF71A0548D30E8D472009EBF5&username=rahul%40kandisatech.com&password=Cultivist%4012',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        $token = 'Authorization: Bearer '.$response['access_token']; 
        //dd($request->product_name);
    	/*--- lead create code---- */    
	      if($request->product_name == "The Enthusiast")
	      {  
	        $l_data = array (
	                'phone' => $request->phone_number ,
	                'lastname' => $request->last_name,
	                'firstname' => $request->first_name,
	                'email' => $request->email,
	                'billingstreet'=>$request->billing_address==null ? $request->shipping_address:$request->billing_address,
	                'billingcity' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
	                'billingstate' => $request->billing_state==null ? $request->shipping_state : $request->billing_state,
	                'billingzip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
	                'billingcountry' => $request->billing_country==null ? $request->shipping_country : $request->billing_country,
	                'mailingstreet'=>$request->shipping_address,
	                'mailingcity' => $request->shipping_city,
	                'mailingstate'=> $request->shipping_state,
	                'mailingzip'  => $request->shipping_zipcode,
	                'mailingcountry' => $request->shipping_country,
	                'memberfirstname' => '',
	                'memberlastname' => '',
	                'memberphone' => '',
	                'memberemail' => '',
	                'chargifyproductid'=> $request->product_id,
	                'giftrecipientfirstname' => '',
	                'giftrecipientlastname' => '',
	                'giftrecipientphone' => '',
	                'giftrecipientemail' => '',
	                'promoapplied' =>$request->promo_gift,
	                'additionalinformation' =>$request->additional_information,
	              //  'id'=> $request->lead_id,
	            );
	      }  
	      else if($request->product_name =="The Enthusiast - Dual")
	      {
	        $l_data = array (
	          'firstname' => $request->first_name,
	          'lastname' => $request->last_name,
	          'email' => $request->email,
	          'phone' => $request->phone_number,
	          'billingstreet'=>$request->billing_address==null ? $request->shipping_address:$request->billing_address,
	          'billingcity' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
	          'billingstate' => $request->billing_state==null ? $request->shipping_state : $request->billing_state,
	          'billingzip' => $request->billing_zipcode==null ? $request->shipping_zipcode :$request->billing_zipcode,
	          'billingcountry' => $request->billing_country==null ? $request->shipping_country :$request->billing_country,
	          'mailingstreet'=>$request->shipping_address,
	          'mailingcity' => $request->shipping_city,
	          'mailingstate'=> $request->shipping_state,
	          'mailingzip'  => $request->shipping_zipcode,
	          'mailingcountry' => $request->shipping_country,
	          'memberfirstname' => $request->first_name_dual_member,
	          'memberlastname' => $request->last_name_dual_member,
	          'memberphone' => $request->phone_dual_member,
	          'memberemail' => $request->email_dual_member,
	          'chargifyproductid'=> $request->product_id,
	          'giftrecipientfirstname' => '',
	          'giftrecipientlastname' => '',
	          'giftrecipientphone' => '',
	          'giftrecipientemail' => '',
	          'promoapplied' =>$request->promo_gift,
	          'additionalinformation' =>$request->additional_information,
	        //  'id'=>$request->lead_id,
	        );
	      }
	      else
	      {
	           $l_data = array (
	                'firstname' => $request->customer_first_name,
	                'lastname' => $request->customer_last_name,
	                'email' => $request->customer_email,
	                'phone' => $request->customer_phone_number,
	                'billingstreet'=>$request->billing_address==null ? $request->shipping_address:$request->billing_address,
	                'billingcity' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
	                'billingstate' => $request->billing_state==null ? $request->shipping_state : $request->billing_state,
	                'billingzip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
	                'billingcountry' => $request->billing_country==null ? $request->shipping_country : $request->billing_country,
	                'memberfirstname' => '',
	                'memberlastname' => '',
	                'memberphone' => '',
	                'memberemail' => '',
	                'mailingstreet'=>$request->shipping_address,
	                'mailingcity' => $request->shipping_city,
	                'mailingstate'=> $request->shipping_state,
	                'mailingzip'  => $request->shipping_zipcode,
	                'mailingcountry' => $request->shipping_country,
	                'chargifyproductid'=> $request->product_id,
	                'giftrecipientfirstname' => $request->Firstnamegift,
	                'giftrecipientlastname' => $request->Lastnamegift,
	                'giftrecipientphone' => $request->phone_number,
	                'giftrecipientemail' => $request->Emailgift,
	                'promoapplied' =>$request->promo_gift,
	                'additionalinformation' =>$request->additional_information,
	              //  'id'=> $request->lead_id,

	            );
	      }   
            $g_lead_data = json_encode($l_data);
           // dd($g_lead_data);
        /* lead create gift */      
            $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://thecultivist--kandisa21.my.salesforce.com/services/apexrest/createlead',
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
       // dd($gift_lead_response);
        $lead_datas = json_decode($gift_lead_response,true);
        $gd_datas['leadId'] = $lead_datas['id'];
        $gd_datas['lead_response'] = $gift_lead_response;
      //dd($gd_datas);
	      if($request->product_name == "The Enthusiast")
	      {
	          customer::where('email',$request->email)->orderBy('id','desc')->update($gd_datas);
	      }
	      else if($request->product_name == "The Enthusiast - Dual")
	      {
	          customer::where('email',$request->email)->orderBy('id','desc')->update($gd_datas);
	      }
	      else
	      {  
	        customer::where('email',$request->customer_email)->orderBy('id','desc')->update($gd_datas);
	      }  

      	$resp = array("status"=>true,"message"=>"Detail saved successfully...!");
            echo json_encode($resp);
            exit; 
        
    }
}
