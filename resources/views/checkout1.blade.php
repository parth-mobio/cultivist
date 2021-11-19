@extends('layouts.front_app')
@section('content')
<main>
    <div class="loader" style="display: none;">
        <img src="{{ asset('/') }}images/loader.svg" alt="">

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
                                    @else Shipping Information @endif</div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="streetAddress">Street Address</label>
                                    <input type="text" class="form-control call" id="streetAddress" name="shipping_address">
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control call" id="city" name="shipping_city">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label" for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control call" id="zipcode" name="shipping_zipcode">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label" for="state">State / Province</label>
                                    <input type="text" class="form-control call" id="shipping_state" name="shipping_state">
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="shipping_country">Shipping Country</label>
                                    <select class="form-select ship_country call" id="country" name="shipping_country" disabled>
                                        @foreach($data['country'] as $key => $value)
                                            @if($data['shipping_country_id'] == $value->id)
                                                <option code="{{$value->code}}" value="{{$value->id}}" selected>{{$value->name}} </option>
                                            @else
                                                <option code="{{$value->code}}" value="{{$value->id}}">{{$value->name}} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @if(isset($data['Emailgift']) && $data['Emailgift'] != null)

                                <input type="hidden" name="shipping_phonenumber" value="{{$data['customer_phone_number']}}">
                                @endif

                                <input type="hidden" id="currency" name="currency" value="{{$data['currency']}}">
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
                                <input type="hidden" name="product_id" id="checkout_product_id" value="{{$data['product_id']}}">
                                <input type="hidden" name="payment_name" value="{{$data['payment_name']}}">
                                <input type="hidden" name="product_name" id="product_name" value="{{$data['product_name']}}">
                                <input type="hidden" name="price_id" id="price_id" value="{{$data['price_id']}}">
                                <input type="hidden" name="default_product_price" id="default_product_price" value="{{$data['product_price']}}">
                                <input type="hidden" name="shipping_country_id" id="shipping_country_id" value="{{$data['shipping_country_id']}}">
                                @if(isset($data['email_dual_member']) && $data['email_dual_member'] != null)
                                <input type="hidden" name="email_dual_member" value="{{$data['email_dual_member']}}">
                                <input type="hidden" name="first_name_dual_member" value="{{$data['first_name_dual_member']}}">
                                <input type="hidden" name="last_name_dual_member" value="{{$data['last_name_dual_member']}}">
                                <input type="hidden" name="phone_dual_member" value="{{$data['phone_dual_member']}}">

                                @endif

                                @if(isset($data['Emailgift']) && $data['Emailgift'] != null)
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

                            <!--coupen info-->
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
                                    <label class="form-label " for="streetAddress">Billing Address</label>
                                    <input type="text" class="form-control call" id="billing_address" name="billing_address">
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control call" id="billing_city" name="billing_city">
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label" for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control call" id="billing_zipcode" name="billing_zipcode">
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <label class="form-label" for="state">State / Province</label>
                                    <input type="text" class="form-control call" id="billing_state" name="billing_state">
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="form-select call billing_country" id="billing_country" name="billing_country">
                                        <option selected disabled>Select Country</option>
                                        <optgroup label="Frequently Used">
                                            @foreach($data['frequently'] as $key=> $val)
                                            <option code="{{$val->code}}" value="" country_id="{{$val->id}}">{{$val->name}} </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="All Country">
                                            @foreach($data['country'] as $key => $value)
                                            <option code="{{$value->code}}" value="" country_id="{{$value->id}}">{{$value->name}} </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                                <input type="hidden" name="billing_country_id" id="billing_country_id" value="" />
                            </div>

                            <div class="row gx-2 pb-3 credit_card">

                                <div class="col-12 mb-2">
                                    <div class="col-12 col-sm mb-2">
                                        <label class="form-label" for="ccNumber">Name on the card</label>
                                        <input type="text" class="form-control" id="card-holder-name" name="card_name">
                                    </div>
                                    <!-- Stripe Elements Placeholder -->
                                    <div class="col-12 col-sm mb-2">
                                        <label class="form-label" for="ccNumber">Credit Card Number</label>
                                        <div id="card-element" class="form-control">

                                        </div>
                                        <div id="card-errors" class="error" role="alert"></div>

                                    </div>
                                    <div class="stripe-errors"></div>
                                </div>
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
                            <div class="pb-4 pt-2">
                                <div class="border-bottom border-dark pb-4">
                                    <div class="row gx-1 pt-3">
                                        <div class="col-9">

                                            <div class="fw-bold" id="product-name">{{$data['product_name']}}</div>
                                            <div class="pt-3" id="payment-name">{{$data['payment_name']}}</div>

                                        </div>
                                        <div class="col-3 text-end price">{{$data['final_price']}}</div>
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
                                    <div class="col-3 text-end fw-bold total_price">{{$data['final_price']}}</div>
                                </div>
                            </div>
                            <div class="row gx-2 py-4">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input check_uncheck_radio" type="radio" name="tnc" id="tnc">
                                        <label class="form-check-label" for="terms">Accept our <a class="link-blue" href="https://www.thecultivist.com/legals/terms-of-use">Terms & Conditions</a></label><br>
                                        <span id="tnc_msg"></span>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check_uncheck_radio" type="radio" name="tnc_p" id="tnc_p" value="yes">
                                        <label class="form-check-label" for="privacy">Accept our <a class="link-blue" href="https://www.thecultivist.com/legals/member-agreement">Member Agreement & Privacy/ Notice Policy</a></label><br>
                                        <span id="tnc_p_msg"></span>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('tnc') }}</span>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" id="placed" class="btn btn-dark w-210 card-button" data-secret="{{ $data['intent']->client_secret }}">Place Secure Order</button>
                            </div>
                            <input type="hidden" id="has-credit-card" value="true" />
                            <input type="hidden" id="stripe_key" value="{{$data['stripe_key']}}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@push('front-scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
    var stripeKey = $('#stripe_key').val();
    const stripe = Stripe(stripeKey);

    var billing_country_id = $('.billing_country option:selected').attr('country_id');
    $('#billing_country_id').val(billing_country_id);

    var billing_country = $('.billing_country option:selected').attr('code');
    $('.billing_country option:selected').val(billing_country);

    $(document).ready(function() {

        $('.billing_country').change(function() {
            var billing_country_id = $('.billing_country option:selected').attr('country_id');
            $('#billing_country_id').val(billing_country_id);

            var billing_country = $('.billing_country option:selected').attr('code');
            $('.billing_country option:selected').val(billing_country);
        });

        $('input[type=radio][name=payment]').change(function() {
            if (this.value == 'no') {
                $('#billing_address').val('');
                $('#billing_city').val('');
                $('#billing_state').val('');
                $('#billing_zipcode').val('');
                $('#billing_country option:selected').removeAttr('selected');
                $('.billing_country option:selected').attr("value", "");
                $('#billing_country_id').attr("value", "");
                $('#billing_country').val('');
            }

        });

        if ($('#has-credit-card').val() === 'true') {
            var elements = stripe.elements();
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            var card = elements.create('card', {
                hidePostalCode: true,
                style: style
            });
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementsByClassName('card-button');
            const clientSecret = $('.card-button').attr('data-secret');

            $('.card-button').on('click', async (e) => {
                e.preventDefault();
                var isFormValid = validateCheckoutForm();
                if (isFormValid) {
                    $('.loader').show();
                    const {
                        setupIntent,
                        error
                    } = await stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card: card,
                                billing_details: {
                                    name: cardHolderName.value
                                }
                            }
                        }
                    );
                    if (error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = error.message;
                        $('.loader').hide();
                    } else {
                        paymentMethodHandler(setupIntent.payment_method);
                    }
                }
            });

            function paymentMethodHandler(payment_method) {
                var form = document.getElementById('checkout_form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
                form.appendChild(hiddenInput);
                form.submit();
            }

            function validateCheckoutForm() {
                $('#checkout_form').validate({ // initialize the plugin
                    rules: {
                        shipping_address: {
                            required: true,

                        },
                        shipping_city: {
                            required: true,
                        },
                        shipping_zipcode: {
                            required: true,

                        },
                        shipping_country: {
                            required: true,

                        },
                        shipping_state: {
                            required: true,
                        },
                        shipping_phonenumber: {
                            required: true,
                        },
                        customer_email: {
                            required: true,
                            email: true
                        },
                        customer_first_name: {
                            required: true,
                        },
                        customer_last_name: {
                            required: true,
                        },
                        customer_phone_number: {
                            required: true,
                        },
                        ccnumber: {
                            required: true,
                            digits: true,
                        },
                        expiry: {
                            required: true,
                            //   date: true
                        },
                        cvv: {
                            required: true,
                        },
                        billing_zip: {
                            required: true,
                        },
                        card_name: {
                            required: true,
                        },
                        tnc: {
                            required: true,
                        },
                        tnc_p: {
                            required: true,
                        },
                        billing_address: {
                            //required:true
                            required: '#yes[value="yes"]:checked',
                        },
                        billing_city: {
                            required: '#yes[value="yes"]:checked',
                        },
                        billing_zipcode: {
                            required: '#yes[value="yes"]:checked',
                        },
                        billing_state: {
                            required: '#yes[value="yes"]:checked',
                        },
                        billing_country: {
                            required: '#yes[value="yes"]:checked',
                        },
                        billing_phonenumber: {
                            required: '#yes[value="yes"]:checked',
                        },
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "tnc")
                            error.insertAfter("#tnc_msg");
                        else if (element.attr("name") == "tnc_p")
                            error.insertAfter("#tnc_p_msg");
                        else // This is the default behavior of the script for all fields
                            error.insertAfter(element);

                    }
                });

                return $('#checkout_form').valid();
            }
        }

        $('.check_uncheck_radio').click(function() {

            var attr = $(this).attr('checked');

            if (typeof attr !== 'undefined' && attr !== false) {
                $(this).removeAttr("checked");
            } else {
                $(this).attr("checked", 'true');
            }
        });
    })
</script>
@endpush
