<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use App\customer;
use App\Country;
use URL;

class IndividialController extends Controller
{
    public function individual(Request $request)
    {
      //dd($request->all());
         $rule =
            [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number'=> 'required'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->fails())
        {
            return redirect(url()->previous())->withErrors($validator);
        }


        $country = Country::orderBy('name','ASC')->get();
        $frequently = Country::orderBy('counts','DESC')->limit(4)->get();
           
           $customer = new customer();
           $customer->email = $request->email;
           $customer->firstname = $request->first_name;
           $customer->lastname  = $request->last_name;
           $customer->phone_number = $request->phone_number;
           $customer->product_id   = $request->product_id;
           $customer->product_name = $request->product_name;
           $customer->product_handle = $request->product_handle;
           $customer->product_price = $request->product_price;
           $customer->save();

           $data['customer_id']  = "";
           $data['customer_first_name'] = $customer->firstname;
           $data['customer_last_name']  = $customer->lastname;
           $data['customer_email']  = $customer->email;
           $data['phone_number']   = $request->phone_number;
           $data['product_handle'] = $request->product_handle;
           $data['product_id']  = $request->product_id;
           $data['product_price'] = $request->product_price;
           $data['url'] = Url::asset('individual_checkout');
           $data['payment_name'] = $request->payment_name;
           $data['product_name'] = $request->product_name;
           $data['exist'] = "no";
           $data['snap_day']  = $request->snap_day;
           $data['product_price_point_id'] = $request->product_price_point_id;
           $data['uk_product_id'] = $request->uk_product_id;
           $data['uk_product_price'] = $request->uk_product_price;
           $data['uk_price_point_id'] = $request->uk_price_point_id;
           $data['gbp_product_id']  = $request->gbp_product_id;
           $data['gbp_product_price'] = $request->gbp_product_price;
           $data['gbp_price_point_id'] = $request->gbp_price_point_id;
           $data['country'] = $country;
           $data['frequently'] = $frequently;
   

            $l_data = array (
                'phone' => $customer->phone_number ,
                'lastname' => $customer->lastname,
                'firstname' => $customer->firstname,
                'email' => $customer->email,
                'billingstreet'=>"",
                'billingcity' => "",
                'billingstate' => "",
                'billingzip' => "",
                'billingcountry' => "",
                'memberfirstname' => '',
                'memberlastname' => '',
                'memberphone' => '',
                'memberemail' => '',
                'chargifyproductid'=> $request->product_id,
                'giftrecipientfirstname' => '',
                'giftrecipientlastname' => '',
                'giftrecipientphone' => '',
                'giftrecipientemail' => '',
            );
         
            $lead_data = json_encode($l_data);

            //dd($lead_data);

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

      /* token generate code over */  
    /*--- lead create code---- */    

          
            //dd($lead_data);  

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
        CURLOPT_POSTFIELDS =>$lead_data,
        CURLOPT_HTTPHEADER => array(
          $token,
          'Content-Type: application/json',
          'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
        ),
      ));

      $lead_response = curl_exec($curl);

      curl_close($curl);
       $lead_response;
       $l_id = json_decode($lead_response,true);
       $lead_id = $l_id['id'];
      
  		/* --- lead code over ----*/     

        $data['lead_id'] = $lead_id;
        return view('checkout1',compact('data'));    
    }


    public function individual_checkout(Request $request)
    {
      //dd($request->lead_id);
           
        $expiry = explode("/",$request->expiry);
        $ye = str_replace(' ', '',$expiry[1]);
        $month = str_replace(' ', '',$expiry[0]);
      //  $date = str_replace(' ', '',$expiry[1]);
        $year = '20'.$ye;

        $country = Country::orderBy('name','ASC')->get();
        $frequently = Country::orderBy('counts','DESC')->limit(4)->get();

	    if($request->currency == "GBP")
	    {  

	        $post_url1 = "https://the-cultivist-uk-clone-clone.chargify.com/customers.json?q=$request->email";
	        $header1 = array("authorization: Basic Z3gwb21rb1ZCclhhY3piWWswSENJYzhBaWNOa00yVXg1UkFvVXh0Nlk6MDAwVGhlQ3VsdGl2aXN0X1VwbGVycyM0Nw=="
	        );
	        $domain = "GBP";
	    }
	    else if($request->currency == "EUR")
	    {
	        $post_url1 = "https://the-cultivist-uk-clone.chargify.com/customers.json?q=$request->email";
	        $header1 = array(
	              "authorization: Basic TzV2bUNBam5QbmtBY3AzaXVBVHZmS3NkeEpGYTlIMXVTSzV2ZVgzOW9BOjAwMFRoZUN1bHRpdmlzdF9VcGxlcnMjNDc="
	            );
	        $domain = "UK"; 
	    }  
	    else 
	    {
	        $post_url1 = "https://the-cultivist-usa.chargify.com/customers.json?q=$request->email";
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

        if($response == "[]")
        {
            $datas['domain'] = $domain;
            $datas['product_id'] = $request->product_id;
            $datas['product_price'] = $request->product_price;
            $datas['product_name'] = $request->product_name;
            $customer = customer::where('email',$request->email)->orderBy('id','desc')->update($datas);
        }
        else
        {

            $data_json = json_decode($response,true);  
           // dd($data_json);
            $datas['domain'] = $domain;
            $datas['product_id'] = $request->product_id;
            $datas['product_price'] = $request->product_price;
            $datas['product_name'] = $request->product_name;
            $datas['customer_id'] = $data_json['0']['customer']['id'];
            
            $customer = customer::where('email',$request->email)->orderBy('id','desc')->update($datas);

            $request->customer_exist = "yes";
            
            $request->customer_id = $datas['customer_id'];
        }  

        Country::where('code',$request->shipping_country)->increment('counts' ,1);

    // dd($request->all());   

		    if($request->customer_exist == "no")
		    {  
		      $post_data=  array (
		          'subscription' =>array (         
		                      "snap_day" => $request->snap_day==null ? '' :$request->snap_day,
		                      'product_id' =>$request->product_id,
		                      'product_price_point_id' => $request->product_price_point_id,
		                      'customer_attributes' =>array (
		                                'first_name' => $request->first_name,
		                                'last_name' => $request->last_name,
		                                'email' => $request->email,
		                                'zip' => $request->shipping_zipcode,
		                                'state' => $request->shipping_state,
		                              //  'reference' => 'XYZ',
		                              //  'phone' => $request->shipping_phonenumber,
		                                  'phone' => $request->phone_number, 
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
		                              'billing_zip'=>$request->billing_zip,
		                              'billing_address' => $request->billing_address==null ? $request->shipping_address:$request->billing_address,
		                              'billing_city' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
		                              'billing_state'=> $request->billing_state==null ? $request->shipping_state : $request->billing_state,
		                              'billing_zip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
		                              'billing_country'=> $request->billing_country==null ? $request->shipping_country : $request->billing_country,
		                      ),
		                      "metafields"=> array (
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
		                      "customer_id" => $request->customer_id,
		                      'customer_attributes' =>array (
		                                'first_name' => $request->first_name,
		                                'last_name' => $request->last_name,
		                                'email' => $request->email,
		                                'zip' => $request->shipping_zipcode,
		                                'state' => $request->shipping_state,
		                              //  'reference' => 'XYZ',
		                              //  'phone' => $request->shipping_phonenumber,
		                                 'phone' => $request->phone_number,  
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
		                              'billing_zip'=>$request->billing_zip,
		                              'billing_address' => $request->billing_address==null ? $request->shipping_address:$request->billing_address,
		                              'billing_city' => $request->billing_city==null ? $request->shipping_city : $request->billing_address,
		                              'billing_state'=> $request->billing_state==null ? $request->shipping_state : $request->billing_state,
		                              'billing_zip' => $request->billing_zipcode==null ? $request->shipping_zipcode : $request->billing_zipcode,
		                              'billing_country'=> $request->billing_country==null ? $request->shipping_country : $request->billing_country,
		                      ),
		                      "metafields"=> array (
		                               "additional_information" => $request->additional_information
		                      ),
		                      'coupon_code' =>$request->promo_gift==null ? ' ' :$request->promo_gift,
		                      'currency' => $request->currency,
		                ),
		        );       
		    } 
      //dd($post_data);
           $data['customer_id']  = $request->customer_id;
           $data['customer_first_name'] = $request->first_name;
           $data['customer_last_name']  = $request->last_name;
           $data['customer_email']  = $request->email;
           $data['phone_number']   = $request->phone_number;
           $data['product_handle'] = $request->product_handle;
           $data['product_id']  = $request->product_id;
           $data['product_price'] = $request->product_price;
           $data['url'] =   $request->url;
           $data['exist'] = $request->customer_exist;
           $data['payment_name'] = $request->payment_name;
           $data['product_name'] = $request->product_name;
           $data['snap_day']  = $request->snap_day;
           $data['product_price_point_id'] = $request->product_price_point_id;
           $data['uk_product_id'] = $request->uk_product_id;
           $data['uk_product_price'] = $request->uk_product_price;
           $data['uk_price_point_id'] = $request->uk_product_price_point_id;
           $data['gbp_product_id'] = $request->gbp_product_id;
           $data['gbp_product_price'] = $request->gbp_product_price;
           $data['gbp_price_point_id'] = $request->gbp_product_price_point_id;
           $data['country'] = $country;
           $data['frequently'] = $frequently;
           $data['lead_id'] = $request->lead_id;

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

	      	/* token generate code over */  
	    	/*--- lead create code---- */    

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
                'chargifyuserid'=>$request->customer_id,
              //  'id'=> $request->lead_id,
            );
         
            $lead_data = json_encode($l_data);
            //dd($lead_data);  

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
		        CURLOPT_POSTFIELDS =>$lead_data,
		        CURLOPT_HTTPHEADER => array(
		          $token,
		          'Content-Type: application/json',
		          'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
		        ),
		      ));

		      $lead_response = curl_exec($curl);

		      curl_close($curl);
		       $lead_response;
		       $lead_data = json_decode($lead_response,true);
		      // dd($lead_response);
		       $u_datas['leadId'] = $lead_data['id'];
		       $u_datas['lead_response'] = $lead_data;
		       //dd($u_datas['leadId']);
		      $customer = customer::where('email',$request->email)->orderBy('id','desc')->update($u_datas);
		      // dd($lead_response);
		  /* --- lead code over ----*/     


		  /* code for create member  */

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
		    //$error = json_decode($err);
		    //print_r($error);
		  } else {
		    $error = json_decode($response,true);
		  // echo $response;
		    
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
		            $lead_data['obj']['chargifysubscriptionid'] = $response['subscription']['id'];
		            $lead_data['obj']['subscriptionstartdate'] = date('Y-m-d',strtotime($response['subscription']['activated_at']));
		            $lead_data['obj']['membershipfee'] =$response['subscription']['product_price_in_cents'];
		            $lead_data['obj']['paymentfrequency'] = '';
		            $lead_data['obj']['accountcurrency'] = $request->currency; 
		            $lead_responses = json_encode($lead_data);
		        }    
		        else{
		          $lead_data['obj']['chargifysubscriptionid'] = '';
		          $lead_data['obj']['subscriptionstartdate'] = '';
		          $lead_data['obj']['membershipfee'] ='';
		          $lead_data['obj']['paymentfrequency'] = '';
		          $lead_data['obj']['accountcurrency'] = ''; 
		          $lead_responses = json_encode($lead_data);
		        } 
		       //dd($lead_data);

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

		      $response = curl_exec($curl);

		      curl_close($curl);
		       $response;
		        return redirect('/success');
		    }  
  		}
	}
}
