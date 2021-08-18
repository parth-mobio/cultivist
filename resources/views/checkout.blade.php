@extends('layouts.front_app')
@section('content')
	<main>
        <div class="loader" style="display: none;">
            <img src="{{ asset('/') }}images/loader.svg" alt="" >

        </div>
      <section class="section-40">
        <div class="container">
          <div class="row">
                @if(isset($error['errors']))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($error['errors'] as $err)
                            <li>{{ $err }}</li><br>
                            @endforeach
                        </ul>
                    </div>
                @endif 
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 mx-auto">
              <div class="form-wrap">
                <form action="{{$data['url']}}" id="checkout_form" method="post">
                  @csrf
                  <div class="row gx-2 pb-3">
                    <div class="col-12 h6 fw-bold mb-3">@if($data['product_name']== "The Enthusiast - Gift")Recipient Address
                    @else Shipping Information  @endif</div>
                    <div class="col-12 mb-2">
                      <label class="form-label" for="streetAddress">Street Address</label>
                      <input type="text" class="form-control" id="streetAddress" name="shipping_address">
                      <span class="text-danger">{{ $errors->first('last_name') }}</span>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                      <label class="form-label" for="city">City</label>
                      <input type="text" class="form-control" id="city" name="shipping_city">
                    </div>
                    
                    <div class="col-12 col-sm-6 mb-2">
                      <label class="form-label" for="zipcode">Zipcode</label>
                      <input type="text" class="form-control" id="zipcode" name="shipping_zipcode">
                    </div>

                    <div class="col-12 col-sm-6 mb-2">
                      <label class="form-label" for="state">State / Province</label>
                      <input type="text" class="form-control" id="shipping_state" name="shipping_state">
                    </div>

                    <div class="col-12 mb-2">
                      <label class="form-label" for="country">Country</label>
                      <select class="form-select ship_country" id="country" name="shipping_country">
                        <option selected disabled>Select Country</option>
                        <optgroup label="Frequently Used">
                           @foreach($data['frequently'] as $key=> $val)
                             <option value="{{$val->code}}">{{$val->name}}</option>   
                           @endforeach 
                        </optgroup>
                        <optgroup label="All Country">    
                            @foreach($data['country'] as $key => $value)
                               <option value="{{$value->code}}">{{$value->name}} </option> 
                            @endforeach
                        </optgroup>
                            
                      </select>
                    </div>
                    @if($data['product_name']== "The Enthusiast - Gift")
              <!--      <div class="col-12 mb-2">
                      <label class="form-label" for="phoneNumber">Phone Number</label>
                      <input type="text" class="form-control" id="phoneNumber" name="shipping_phonenumber">
                      <p style="font-size:10px;">We strongly recommand including the receipient phone number in case of any delivery issues.</p>
                    </div>-->
                    <input type="hidden" name="shipping_phonenumber" value="{{$data['customer_phone_number']}}">
                    @endif

                    <input type="hidden" name="uk_product_id" id="uk_product_id" value="{{$data['uk_product_id']}}">
                    <input type="hidden" name="uk_product_price" id="uk_product_price" value="{{$data['uk_product_price']}}">
                    <input type="hidden" name="uk_product_price_point_id" id="uk_product_price_point_id" value="{{$data['uk_price_point_id']}}">

                    <input type="hidden" name="gbp_product_id" id="gbp_product_id" value="{{$data['gbp_product_id']}}">
                    <input type="hidden" name="gbp_product_price" id="gbp_product_price" value="{{$data['gbp_product_price']}}">
                    <input type="hidden" name="gbp_product_price_point_id" id="gbp_product_price_point_id" value="{{$data['gbp_price_point_id']}}">

                    <input type="hidden" id="currency" name="currency" value="USD">
                    <input type="hidden" id="lead_id" name="lead_id" value="{{$data['lead_id']}}">
                    <input type="hidden" name="customer_id" value="{{$data['customer_id']}}">
                    <input type="hidden" name="product_handle" value="{{$data['product_handle']}}">
                    <input type="hidden" name="first_name" value="{{$data['customer_first_name']}}">
                    <input type="hidden" name="last_name" value="{{$data['customer_last_name']}}">
                    <input type="hidden" name="email" value="{{$data['customer_email']}}">
                    <input type="hidden" name="phone_number" value="{{$data['phone_number']}}">
                    <input type="hidden" name="product_price" id="product_price" value="{{$data['product_price']}}">
                    <input type="hidden" name="url" value="{{$data['url']}}">
                    <input type="hidden" name="customer_exist" value="{{$data['exist']}}">
                    <input type="hidden" name="default_product_id" id="default_product_id" value="{{$data['product_id']}}">
                    <input type="hidden"   name="product_id" id="checkout_product_id" value="{{$data['product_id']}}">
                    <input type="hidden" name="payment_name" value="{{$data['payment_name']}}">
                    <input type="hidden" name="product_name" value="{{$data['product_name']}}">
                    <input type="hidden" name="snap_day" value="{{$data['snap_day']}}">
                    <input type="hidden" name="product_price_point_id" id="product_price_point_id" value="{{$data['product_price_point_id']}}">
                    <input type="hidden" name="default_product_price_point_id" id="default_product_price_point_id" value="{{$data['product_price_point_id']}}">
                <input type="hidden" name="default_product_price" id="default_product_price" value="{{$data['product_price']}}">

                    @if(isset($data['email_dual_member']) && $data['email_dual_member'] != null)
                      <input type="hidden" name="email_dual_member" value="{{$data['email_dual_member']}}">
                      <input type="hidden" name="first_name_dual_member" value="{{$data['first_name_dual_member']}}">
                      <input type="hidden" name="last_name_dual_member" value="{{$data['last_name_dual_member']}}">
                      <input type="hidden" name="phone_dual_member" value="{{$data['phone_dual_member']}}">

                    @endif

                    @if($data['product_name']== "The Enthusiast - Gift")
                        <input type="hidden" name="Emailgift" value="{{$data['Emailgift']}}">
                        <input type="hidden" name="Firstnamegift" value="{{$data['Firstnamegift']}}">
                        <input type="hidden" name="Lastnamegift" value="{{$data['Lastnamegift']}}">
                        <input type="hidden" name="customer_email" value="{{$data['customer_email']}}">
                        <input type="hidden" name="customer_first_name" value="{{$data['customer_first_name']}}">
                        <input type="hidden" name="customer_last_name" value="{{$data['customer_last_name']}}">
                        <input type="hidden" name="customer_phone_number" value="{{$data['customer_phone_number']}}">
                        

                    @endif

                    @if(isset($data['Startdategift']) && $data['Startdategift'] != null)
                        <input type="hidden" name="Startdategift" value="{{$data['Startdategift']}}">
                    @else
                        <input type="hidden" name="Startdategift" value="">
                    @endif
                  </div>

                @if($data['product_name']== "The Enthusiast - Gift")  
                <!--   <div class="row gx-2 pb-3">
                        <div class="col-12 h6 fw-bold mb-3">Your Information</div>
                            <div class="col-12 mb-2">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control" id="customer_email" name="customer_email" value="{{old('email')}}">
                                 <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            <div class="col-12 col-sm-6 mb-2">
                                <label class="form-label" for="firstname">First Name</label>
                                <input type="text" class="form-control" id="customer_first_name" name="customer_first_name" value="{{old('first_name')}}">
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            </div>
                            <div class="col-12 col-sm-6 mb-2">
                                <label class="form-label" for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="customer_last_name" name="customer_last_name" value="{{old('last_name')}}">
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-label" for="phonenumber">Phone Number</label>
                                <input type="text" class="form-control" id="customer_phone_number" name="customer_phone_number" value="{{old('phone_number')}}">
                                 <span class="text-danger">{{ $errors->first('phone_number')  }}</span>
                            </div> 
                    </div>-->   
                @endif    

<!--
                  coupen info-->
                  <div class="row gx-2 py-3">
                    <div class="col-12 h6 fw-bold mb-2">Payment Information</div>
                    <div class="col-12 col-sm-6 col-xl-5 pb-4">Is your billing address different?</div>
                    <div class="col-12 col-sm-6 col-xl-5">
                      <div class="form-check d-block d-sm-inline-block me-sm-4">
                        <input class="form-check-input" type="radio" name="payment" id="yes" value="yes">
                        <label class="form-check-label" for="yes">Yes</label>
                      </div>
                      <div class="form-check d-block d-sm-inline-block">
                        <input class="form-check-input" type="radio" name="payment" id="no" value="no" checked>
                        <label class="form-check-label" for="no">No</label>
                      </div>
                    </div>
                    <div class="col-12 col-sm-2 d-none d-md-block">
                      <img src="{{ asset('/') }}images/card-img.png" alt="">
                    </div>
                  </div>
                    <div class="row gx-2 pb-3 billing_address" id="yes" style="display: none;">
                        <div class="col-12 h6 fw-bold mb-3">Billing Information</div>
                        <div class="col-12 mb-2">
                          <label class="form-label" for="streetAddress">Billing Address</label>
                          <input type="text" class="form-control" id="billing_address" name="billing_address">
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                          <label class="form-label" for="city">City</label>
                          <input type="text" class="form-control" id="billing_city" name="billing_city">
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                          <label class="form-label" for="zipcode">Zipcode</label>
                          <input type="text" class="form-control" id="billing_zipcode" name="billing_zipcode">
                        </div>
                      <div class="col-12 col-sm-6 mb-2">
                        <label class="form-label" for="state">State / Province</label>
                        <input type="text" class="form-control" id="state" name="billing_state">
                        </div>
                        <div class="col-12 mb-2">
                          <label class="form-label" for="country">Country</label>
                          <select class="form-select" id="billing_country" name="billing_country">
                            <option selected disabled>Select Country</option>
                            <optgroup label="Frequently Used">
                               @foreach($data['frequently'] as $key=> $val)
                                 <option value="{{$val->code}}">{{$val->name}}</option>   
                               @endforeach 
                            </optgroup>
                            <optgroup label="All Country">    
                                @foreach($data['country'] as $key => $value)
                                    <option value="{{$value->code}}">{{$value->name}} </option> 
                                @endforeach
                            </optgroup>    
                          </select>
                        </div>
                        
                    </div>

                  <div class="row gx-2 pb-3">
                    <div class="col-12 mb-2">
                      <label class="form-label" for="ccNumber">Credit Card Number</label>
                      <input type="text" class="form-control" id="ccNumber" name="ccnumber">
                    </div>
                    <div class="col-12 col-sm mb-2">
                      <label class="form-label" for="expiration">Expiration</label>
                      <input type="text" class="form-control" id="expiry" name="expiry" placeholder="MM/YY">
                      <span  class="exp_error_msg" style="display: none">Invalid expiration</span>
                    </div>
                    <div class="col-12 col-sm-3 mb-2">
                      <label class="form-label" for="cvv">CVV</label>
                      <input type="text" class="form-control" id="cvv" name="cvv">
                    </div>
                    <div class="col-12 col-sm mb-2">
                      <label class="form-label" for="billingZip">Billing Zip</label>
                      <input type="text" class="form-control" id="billing_zip" name="billing_zip">
                    </div>
                @if($data['product_name']== "The Enthusiast - Gift")      
                    <div class="col-12 mb-2">
                      <label class="form-label" for="ccNumber">Name on the card</label>
                      <input type="text" class="form-control" id="card_name" name="card_name">
                    </div>
                @endif    
                  </div>

                  <div class="row gx-2 py-3">
                    <div class="col-12 col-sm-6 mb-3">
                      <label class="form-label" for="promosGifts">Promos & Gifts</label>
                      <input type="text" class="form-control" id="promosGifts" name="promo_gift">
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                      <label class="form-label d-none d-sm-block">&nbsp;</label>
                      <button type="button" class="btn btn-dark w-140" id="apply">Apply</button>
                    </div>
                    <p id="error_msg" style="display: none;color:red"></p>
                    <p id="success_msg" style="display: none;color: green;"></p>
                  </div>
                    
                  <div class="row gx-2 py-4">
                @if($data['product_name']== "The Enthusiast - Gift")
                    <div class="col-12 h6 fw-bold mb-2">Gift Message</div>
                    <div class="col-12 pb-3"></div>
                @else
                    <div class="col-12 h6 fw-bold mb-2">Additional Information</div>
                    <div class="col-12 pb-3">Anything you would like to share with us about you?</div>
                @endif    
                        
                    <div class="col-12">
                      <textarea class="form-control" rows="6" name="additional_information"></textarea>
                    </div>
                  </div>

                <!--  <div class="py-4">
                    <div class="row gx-1 border-bottom border-dark pb-4">
                      <div class="col-9">
                        <div class="fw-bold">{{$data['product_name']}}</div>
                        <div class="pt-3">{{$data['payment_name']}}</div>
                    <    <div class="pt-3" id="discount_name" style="display:none;">Discount</div>
                      </div>
                      <div class="col-3 text-end">${{$data['product_price']}}</div>
                      <div class="col-9">
                        <div class="fw-bold"></div>
                        <div class="pt-3" id="discount_name" style="display:none;">Discount</div>
                      </div>
                      
                      <div class="col-3 text-end" id="disc_amount"></div>
                    </div>
                    <div class="row gx-1 mt-3">

                      <div class="col-9 fw-bold">Total</div>
                      <div class="col-3 text-end fw-bold total_price">${{$data['product_price']}}</div>
                    </div>
                  </div>-->
                    <div class="pb-4 pt-2">
                        <div class="border-bottom border-dark pb-4">
                            <div class="row gx-1 pt-3">
                                <div class="col-9">
                                    <div class="fw-bold">{{$data['product_name']}}</div>
                                    <div class="pt-3">{{$data['payment_name']}}</div>
                                </div>
                                <div class="col-3 text-end price">${{$data['product_price']}}</div>
                            </div>
                            <div class="row gx-1 pt-3">
                                <div class="col-9">
                                    <div class="fw-bold" id="discount_name" style="display:none;">Discount</div>
                                </div>
                                <div class="col-3 text-end" id="disc_amount"></div>
                            </div>
                        </div>
                            <div class="row gx-1 mt-3">
                                <div class="col-9 fw-bold">Total</div>
                                <div class="col-3 text-end fw-bold total_price">${{$data['product_price']}}</div>
                            </div>
                    </div>
                  <div class="row gx-2 py-4">
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="tnc" id="tnc">
                        <label class="form-check-label" for="terms">Accept our <a class="link-blue" href="https://www.thecultivist.com/legals/terms-of-use">Terms & Conditions</a></label><br>
                        <span id="tnc_msg"></span>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="tnc_p" id="tnc_p" value="yes">
                        <label class="form-check-label" for="privacy">Accept our <a class="link-blue" href="https://www.thecultivist.com/legals/member-agreement">Member Agreement & Privacy/ Notice Policy</a></label><br>
                        <span id="tnc_p_msg"></span>
                      </div>
                      <span class="text-danger">{{ $errors->first('tnc') }}</span>
                    </div>
                  </div>
                  <div class="pt-4">
                    <button type="submit" id="placed" class="btn btn-dark w-210">Place Secure Order</button>
                    <button id="apple-pay-button">Apple pay</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
<script src="https://js.stripe.com/v3/"></script>   
<script type="text/javascript">
  Stripe.setPublishableKey('pk_test_RPrUGJLNCHVrZYDVLKp5TVJe');

Stripe.applePay.checkAvailability(function(available) {
  if (available) {
    document.getElementById('apple-pay-button').style.display = 'block';
    console.log('hi, I can do ApplePay');
  }
});

document.getElementById('apple-pay-button').addEventListener('click', beginApplePay);

var price ="{{$data['product_price']}}";
 var id ="{{$data['product_id']}}";
 var url = "{{$data['url']}}";

function beginApplePay() {
  var paymentRequest = {
    countryCode: 'US',
    currencyCode: 'USD',
    total: {
      label: 'Rocketship Inc',
      amount: price
    }
  };
  var session = Stripe.applePay.buildSession(paymentRequest,
    function(result, completion) {

    $.post(url, { token: result.token.id }).done(function() {
      completion(ApplePaySession.STATUS_SUCCESS);
      // You can now redirect the user to a receipt page, etc.
      window.location.href = "{{URL::asset('success')}}";
    }).fail(function() {
      completion(ApplePaySession.STATUS_FAILURE);
    });

  }, function(error) {
    console.log(error.message);
  });

  session.oncancel = function() {
    console.log("User hit the cancel button in the payment window");
  };

  session.begin();
}

</script>    
@endsection
