@extends('layouts.front_app')
@section('content')


<main>
    <section class="section-40">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 mx-auto">
                    <div class="pb-5 text-center">
                        <h1 class="mb-3">Welcome to the Club!</h1>
                        <p>Please take a moment to set up your membership.</p>
                    </div>
                    <div class="tabs-wrap tabs-style-1 pt-3">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active product1" id="individual-tab" data-bs-toggle="tab" href="#individual" role="tab" aria-controls="individual" aria-selected="true" data-id="5246819">Individual</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link  product2{{session('activeTab') == 'dual' ? 'active' : ''}}" id="dual-tab" data-bs-toggle="tab" href="#dual" role="tab" aria-controls="dual" aria-selected="false" data-id="5453217">Dual <span class="d-none d-sm-inline">Membership</span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link product3{{session('activeTab') == 'gifting' ? 'active' : ''}}" id="gifting-tab" data-bs-toggle="tab" href="#gifting" role="tab" aria-controls="gifting" aria-selected="false" data-id="5278164">Gift a Membership</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabs">
                            <div class="tab-pane fade {{session('activeTab') == '' ? 'show active' : ''}}" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                                <div class="form-wrap">
                                    <div class="mb-5">Great choice! Tell us a bit more about yourself.</div>
                                    <form method="post" action="{{URL::asset('individual-post')}}" id="contact_form">
                                        @csrf

                                        @if ($message = Session::get('error'))
                                        <div class="alert alert-danger alert-block alert-message">
                                            <strong>{!! $message !!}</strong>
                                            <button type="button" class="close close-alert-message fa fa-window-close" data-dismiss="alert">×</button>
                                        </div>
                                        @endif

                                        <div class="row gx-2 pb-3">
                                            <div class="col-12 h6 fw-bold mb-3">Your Details</div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="first_name" value="{{old('first_name')}}">
                                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="last_name" value="{{old('last_name')}}">
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="phonenumber">Phone Number</label>
                                                <input type="text" class="form-control" id="phonenumber" name="phone_number" value="{{old('phone_number')}}">
                                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="shipping_country">Country</label>
                                                <select class="form-select ship_country call" id="country" name="shipping_country">
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
                                            <input type="hidden" name="shipping_country_id" id="shipping_country_id" value="" />
                                            <input type="hidden" name="shipping_country_code" id="shipping_country_code" value="" />
                                            <input type="hidden" name="product_id" id="checkout_product_id" value="">
                                        </div>
                                        <div class="tabs-style-1 mt-4">
                                            <h6 class="fw-bold mb-3">Select Your Payment Preference</h6>
                                            <ul class="nav nav-pills pay" role="tablist">
                                                <li class="nav-item payment" role="presentation">
                                                    <a class="nav-link active year" id="yearPrepaid-tab" data-bs-toggle="tab" href="#yearPrepaid" role="tab" aria-controls="yearPrepaid" aria-selected="true" data-value="{{$plans['yearlyProductAmountUSD']}}" data-name="1 Year Prepaid" data-interval="" data-uk="{{$plans['yearlyProductAmountEUR']}}" data-gbp="{{$plans['yearlyProductAmount']}}">1 Year Prepaid</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link month" id="paidMonthly-tab" data-bs-toggle="tab" href="#paidMonthly" role="tab" aria-controls="paidMonthly" aria-selected="false" data-value="{{$plans['monthlyProductAmountUSD']}}" data-name="Pay Monthly" data-interval="28" data-uk="{{$plans['monthlyProductAmountEUR']}}" data-gbp="{{$plans['monthlyProductAmount']}}">Pay Monthly</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="payment_tab">

                                                <div class="tab-pane fade show active" id="yearPrepaid" role="tabpanel" aria-labelledby="yearPrepaid-tab">

                                                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
                                                        <div class="col-9">
                                                            <div class="fw-bold">{{$plans['yearlyProductNameUSD']}}</div>
                                                            <div class="pt-3">1 Year Prepaid (Receive Metal Membership Card)</div>
                                                        </div>
                                                        <div class="col-3 text-end price">${{$plans['yearlyProductAmountUSD']}}</div>
                                                    </div>
                                                    <div class="row gx-1 mt-3">
                                                        <div class="col-9 fw-bold">Total</div>
                                                        <div class="col-3 text-end fw-bold total total_price">${{$plans['yearlyProductAmountUSD']}}</div>
                                                    </div>

                                                    <input type="hidden" id="product_name" name="product_name" value="{{$plans['yearlyProductNameUSD']}}">
                                                    <input type="hidden" id="product_id" name="product_id" value="{{$plans['yearlyProductIDUSD']}}">
                                                    <input type="hidden" id="pro_price" name="product_price" value="{{$plans['yearlyProductAmountUSD']}}">
                                                    <input type="hidden" name="product_handle" value="museum-1">
                                                    <input type="hidden" id="price_id" name="price_id" value="{{$plans['yearlyPlanIDUSD']}}">


                                                    <input type="hidden" id="uk_product_name" name="uk_product_name" value="{{$plans['yearlyProductNameEUR']}}">
                                                    <input type="hidden" id="uk_product_id" name="uk_product_id" value="{{$plans['yearlyProductIDEUR']}}">
                                                    <input type="hidden" id="uk_product_price" name="uk_product_price" value="{{$plans['yearlyProductAmountEUR']}}">
                                                    <input type="hidden" id="uk_price_id" name="uk_price_id" value="{{$plans['yearlyPlanIDEUR']}}">

                                                    <input type="hidden" id="gbp_product_name" name="gbp_product_name" value="{{$plans['yearlyProductName']}}">
                                                    <input type="hidden" id="gbp_product_id" name="gbp_product_id" value="{{$plans['yearlyProductID']}}">
                                                    <input type="hidden" id="gbp_product_price" name="gbp_product_price" value="{{$plans['yearlyProductAmount']}}">
                                                    <input type="hidden" id="gbp_price_id" name="gbp_price_id" value="{{$plans['yearlyPlanID']}}">
                                                    <input type="hidden" name="product_price" id="product_price" value="">
                                                    <input type="hidden" id="currency" name="currency" value="">

                                                    <input type="hidden" id="payment_name" name="payment_name" value="1 Year Prepaid">

                                                </div>
                                                <div class="tab-pane fade" id="paidMonthly" role="tabpanel" aria-labelledby="paidMonthly-tab">
                                                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
                                                        <div class="col-9">
                                                            <div class="fw-bold">{{$plans['monthlyProductNameUSD']}}</div>
                                                            <div class="pt-3">Paid Monthly</div>
                                                        </div>
                                                        <div class="col-3 text-end price">${{$plans['monthlyProductAmountUSD']}}</div>
                                                    </div>
                                                    <div class="row gx-1 mt-3">
                                                        <div class="col-9 fw-bold">Total</div>
                                                        <div class="col-3 text-end fw-bold total total_price" id="total">${{$plans['monthlyProductAmountUSD']}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 pt-3 align-items-center">
                                            <div class="col-12 col-sm-auto">
                                                <div class="">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#renewsEveryYearModal">Automatically renews every year</a>
                                                </div>
                                                <div class="mt-1">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cancelAutoRenewalModal">How to cancel auto renewal</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm order-sm-first mt-4 pt-3 mt-sm-0 pt-sm-0">
                                                <button type="submit" class="btn btn-dark w-140">Continue</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade {{session('activeTab') == 'dual' ? 'show active' : ''}}" id="dual" role="tabpanel" aria-labelledby="dual-tab">
                                <div class="form-wrap">
                                    <div class="mb-4">Available to anyone living at the same address.</div>
                                    <div class="mb-5 text-aaa">*Interested in more than 2 memberships? Email us <a class="text-aaa" href="mailto:contact@thecultivist.com">here</a>.</div>
                                    <form method="post" action="{{URL::asset('dual-post')}}" id="dual_form">
                                        @csrf

                                        @if ($message = Session::get('dual-error'))
                                        <div class="alert alert-danger alert-block alert-message">
                                            <strong>{!! $message !!}</strong>
                                            <button type="button" class="close close-alert-message fa fa-window-close" data-dismiss="alert">×</button>
                                        </div>
                                        @endif

                                        <div class="row gx-2 pb-3">
                                            <div class="col-12 h6 fw-bold mb-3">Card Holder 1</div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="first_name" value="{{old('first_name')}}">
                                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="last_name" value="{{old('last_name')}}">
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="phonenumber">Phone Number</label>
                                                <input type="text" class="form-control" id="phonenumber" name="phone_number" value="{{old('phone_number')}}">
                                                <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="shipping_country">Country</label>
                                                <select class="form-select ship_country_d call" id="country" name="shipping_country">
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
                                            <input type="hidden" name="shipping_country_id" id="shipping_country_id" value="" />
                                            <input type="hidden" name="shipping_country_code" id="shipping_country_code" value="" />
                                            <input type="hidden" name="product_id" id="checkout_product_id" value="">

                                        </div>
                                        <div class="row gx-2 py-3">
                                            <div class="col-12 h6 fw-bold mb-3">Card Holder 2</div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" class="form-control" id="detail_02_email" name="detail_02_email" value="{{old('detail_02_email')}}">
                                                <span class="text-danger">{{ $errors->first('detail_02_email') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="detail_02_first_name" name="detail_02_first_name" value="{{old('detail_02_first_name')}}">
                                                <span class="text-danger">{{ $errors->first('detail_02_first_name') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="detail_02_last_name" name="detail_02_last_name" value="{{old('detail_02_last_name')}}">
                                                <span class="text-danger">{{ $errors->first('detail_02_last_name') }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="phonenumber">Phone Number</label>
                                                <input type="text" class="form-control" id="detail_02_phone_number" name="detail_02_phone_number" value="{{old('detail_02_phone_number')}}">
                                                <span class="text-danger">{{ $errors->first('detail_02_phone_number') }}</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="product_price" id="product_price" value="">
                                        <input type="hidden" id="currency" name="currency" value="">
                                        <input type="hidden" id="product_name_d" name="product_name" value="{{$plans['yearlyProductNameDualUSD']}}">
                                        <input type="hidden" id="product_id_d" name="product_id" value="{{$plans['yearlyProductIDDualUSD']}}">
                                        <input type="hidden" id="pro_price_d" name="product_price" value="{{$plans['yearlyProductAmountDualUSD']}}">
                                        <input type="hidden" name="product_handle" value="museum-dual">
                                        <input type="hidden" id="price_id_d" name="price_id" value="{{$plans['yearlyPlanIDDualUSD']}}">

                                        <input type="hidden" id="uk_product_name_d" name="uk_product_name" value="{{$plans['yearlyProductNameDualEUR']}}">
                                        <input type="hidden" id="uk_product_id_d" name="uk_product_id" value="{{$plans['yearlyProductIDDualEUR']}}">
                                        <input type="hidden" id="uk_product_price_d" name="uk_product_price" value="{{$plans['yearlyProductAmountDualEUR']}}">
                                        <input type="hidden" id="uk_price_id_d" name="uk_price_id" value="{{$plans['yearlyPlanIDDualEUR']}}">

                                        <input type="hidden" id="gbp_product_name_d" name="gbp_product_name" value="{{$plans['yearlyProductNameDualGBP']}}">
                                        <input type="hidden" id="gbp_product_id_d" name="gbp_product_id" value="{{$plans['yearlyProductIDDualGBP']}}">
                                        <input type="hidden" id="gbp_product_price_d" name="gbp_product_price" value="{{$plans['yearlyProductAmountDualGBP']}}">
                                        <input type="hidden" id="gbp_price_id_d" name="gbp_price_id" value="{{$plans['yearlyPlanIDDualGBP']}}">

                                        <div class="tabs-style-1 mt-4">
                                            <input type="hidden" name="payment_name" id="payment_name_d" value="1 Year Prepaid">
                                            <input type="hidden" name="snap_day" id="snap_day_d" value="28">
                                            <h6 class="fw-bold mb-3">Select Your Payment Preference</h6>
                                            <ul class="nav nav-pills pay" role="tablist">
                                                <li class="nav-item payment" role="presentation">
                                                    <a class="nav-link active year_d" id="yearPrepaid-tab" data-bs-toggle="tab" href="#yearPrepaid1" role="tab" aria-controls="yearPrepaid" aria-selected="true" data-value="{{$plans['yearlyProductAmountDualUSD']}}" data-name="1 Year Prepaid" data-uk="{{$plans['yearlyProductAmountDualEUR']}}" data-gbp="{{$plans['yearlyProductAmountDualGBP']}}">1 Year Prepaid</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link month_d" id="paidMonthly-tab" data-bs-toggle="tab" href="#paidMonthly1" role="tab" aria-controls="paidMonthly" aria-selected="false" data-value="{{$plans['monthlyProductAmountDualUSD']}}" data-name="Pay Monthly" data-interval="28" data-uk="{{$plans['monthlyProductAmountDualEUR']}}" data-gbp="{{$plans['monthlyProductAmountDualGBP']}}">Pay Monthly</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="payment_tab">

                                                <div class="tab-pane fade show active" id="yearPrepaid1" role="tabpanel" aria-labelledby="yearPrepaid-tab">

                                                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
                                                        <div class="col-9">
                                                            <div class="fw-bold">{{$plans['yearlyProductNameDualUSD']}}</div>
                                                            <div class="pt-3">1 Year Prepaid (Receive Metal Membership Card)</div>
                                                        </div>
                                                        <div class="col-3 text-end price_d">${{$plans['yearlyProductAmountDualUSD']}}</div>
                                                    </div>
                                                    <div class="row gx-1 mt-3">
                                                        <div class="col-9 fw-bold">Total</div>
                                                        <div class="col-3 text-end fw-bold total total_price_d">${{$plans['yearlyProductAmountDualUSD']}}</div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="paidMonthly1" role="tabpanel" aria-labelledby="paidMonthly-tab">
                                                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
                                                        <div class="col-9">
                                                            <div class="fw-bold">{{$plans['monthlyProductNameDualUSD']}}</div>
                                                            <div class="pt-3 price_d">Paid Monthly</div>
                                                        </div>
                                                        <div class="col-3 text-end price_d">${{$plans['monthlyProductAmountDualUSD']}}</div>
                                                    </div>
                                                    <div class="row gx-1 mt-3">
                                                        <div class="col-9 fw-bold">Total</div>
                                                        <div class="col-3 text-end fw-bold total total_price_d" id="total">${{$plans['monthlyProductAmountDualUSD']}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 pt-3 align-items-center">
                                            <div class="col-12 col-sm-auto">
                                                <div class="">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#renewsEveryYearModal">Automatically renews every year</a>
                                                </div>
                                                <div class="mt-1">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cancelAutoRenewalModal">How to cancel auto renewal</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm order-sm-first mt-4 pt-3 mt-sm-0 pt-sm-0">
                                                <button type="submit" class="btn btn-dark w-140">Continue</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="tab-pane fade {{session('activeTab') == 'gifting' ? 'show active' : ''}}" id="gifting" role="tabpanel" aria-labelledby="gifting-tab">
                                <div class="form-wrap">
                                    <div class="mb-5">Tell us who will be receiving the gift.</div>
                                    <form method="post" action="{{url('gifting')}}" id="gift_form">
                                        @csrf

                                        <div class="row gx-2 pb-3">
                                            <div class="col-12 h6 fw-bold mb-3">Recipient's Details</div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="Emailgift" value="{{old('Emailgift')}}">
                                                <span class="text-danger">{{ $errors->first('Emailgift') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="Firstnamegift" name="Firstnamegift" value="{{old('Firstnamegift')}}">
                                                <span class="text-danger">{{ $errors->first('Firstnamegift') }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <label class="form-label" for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="Lastnamegift" name="Lastnamegift" value="{{old('Lastnamegift')}}">
                                                <span class="text-danger">{{ $errors->first('Lastnamegift') }}</span>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label class="form-label" for="phonenumber">Phone Number</label>
                                                <input type="text" class="form-control" id="phonenumber" name="phone_number" value="{{old('phone_number')}}">
                                                <span class="text-danger">{{ $errors->first('phone_number')  }}</span>
                                            </div>

                                            <div class="row gx-2 pb-3">
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
                                                <div class="col-12 mb-2">
                                                    <label class="form-label" for="shipping_country">Country</label>
                                                    <select class="form-select ship_country_g call" id="country" name="shipping_country">
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
                                                <input type="hidden" name="shipping_country_id" id="shipping_country_id" value="" />
                                                <input type="hidden" name="shipping_country_code" id="shipping_country_code" value="" />
                                            </div>
                                            <input type="hidden" name="product_id" id="checkout_product_id" value="">
                                            <input type="hidden" name="product_price" id="product_price" value="">
                                            <input type="hidden" id="currency" name="currency" value="">
                                            <input type="hidden" id="product_name_g" name="product_name" value="{{$plans['yearlyProductNameGiftUSD']}}">
                                            <input type="hidden" id="product_id_g" name="product_id" value="{{$plans['yearlyProductIDGiftUSD']}}">
                                            <input type="hidden" id="pro_price_g" name="product_price" value="{{$plans['yearlyProductAmountGiftUSD']}}">
                                            <input type="hidden" name="product_handle" value="museum-dual">
                                            <input type="hidden" id="price_id_g" name="price_id" value="{{$plans['yearlyPlanIDGiftUSD']}}">


                                            <input type="hidden" id="uk_product_name_g" name="uk_product_name" value="{{$plans['yearlyProductNameGiftEUR']}}">
                                            <input type="hidden" id="uk_product_id_g" name="uk_product_id" value="{{$plans['yearlyProductIDGiftEUR']}}">
                                            <input type="hidden" id="uk_product_price_g" name="uk_product_price" value="{{$plans['yearlyProductAmountGiftEUR']}}">
                                            <input type="hidden" id="uk_price_id_g" name="uk_price_id" value="{{$plans['yearlyPlanIDGiftEUR']}}">

                                            <input type="hidden" id="gbp_product_name_g" name="gbp_product_name" value="{{$plans['yearlyProductNameGiftGBP']}}">
                                            <input type="hidden" id="gbp_product_id_g" name="gbp_product_id" value="{{$plans['yearlyProductIDGiftGBP']}}">
                                            <input type="hidden" id="gbp_product_price_g" name="gbp_product_price" value="{{$plans['yearlyProductAmountGiftGBP']}}">
                                            <input type="hidden" id="gbp_price_id_g" name="gbp_price_id" value="{{$plans['yearlyPlanIDGiftGBP']}}">

                                        </div>
                                        <div class="pt-4 pb-3">
                                            <div class="col-12 h6 fw-bold mb-1">
                                                Please note, the recipient will be notified of their gift as soon as checkout is complete.
                                            </div>
                                            <br>
                                            <div class="col-12 h6 fw-bold mb-1">
                                                Should you want a later start date, please email <a href="mailto: contact@thecultivist.com">contact@thecultivist.com</a> our team.
                                            </div>
                                        </div>
                                        <div class="tabs-style-1 mt-4">
                                            <?php
                                            //	$price_year = ($value['price_in_cents']/100);
                                            $price_month = (40);
                                            ?>
                                            <input type="hidden" name="product_price" id="pro_price_g" value="440">
                                            <input type="hidden" name="payment_name" id="payment_name_g" value="1 Year Prepaid">
                                            <input type="hidden" name="product_price_point_id" id="price_point_id_g" value="996066">
                                            <input type="hidden" name="snap_day" id="snap_day_g" value="28">
                                            <h6 class="fw-bold mb-3">Select Your Payment Preference</h6>
                                            <ul class="nav nav-pills" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active year_g" id="yearPrepaid-tab" data-bs-toggle="tab" href="#yearPrepaid2" role="tab" aria-controls="yearPrepaid" aria-selected="true" data-value="{{$plans['yearlyProductAmountGiftUSD']}}" data-name="1 Year Prepaid" data-uk="{{$plans['yearlyProductAmountGiftEUR']}}" data-gbp="{{$plans['yearlyProductAmountGiftGBP']}}">1 Year Prepaid</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">

                                                <div class="tab-pane fade show active" id="yearPrepaid2" role="tabpanel" aria-labelledby="yearPrepaid-tab">
                                                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
                                                        <div class="col-9">
                                                            <div class="fw-bold">{{$plans['yearlyProductNameGiftUSD']}}</div>
                                                            <div class="pt-3">1 Year Prepaid (Receive Metal Membership Card)</div>
                                                        </div>
                                                        <div class="col-3 text-end price_g">${{$plans['yearlyProductAmountGiftUSD']}}</div>
                                                    </div>
                                                    <div class="row gx-1 mt-3">
                                                        <div class="col-9 fw-bold">Total</div>
                                                        <div class="col-3 text-end fw-bold total_price_g">${{$plans['yearlyProductAmountGiftUSD']}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4 pt-3 align-items-center">
                                            <div class="col-12 col-sm-auto">
                                                <div class="">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#renewsEveryYearModal">Automatically renews every year</a>
                                                </div>
                                                <div class="mt-1">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cancelAutoRenewalModal">How to cancel auto renewal</a>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm order-sm-first mt-4 pt-3 mt-sm-0 pt-sm-0">
                                                <button type="submit" id="gift_submit" class="btn btn-dark w-140">Continue</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="renewsEveryYearModal" tabindex="-1" aria-labelledby="renewsEveryYearModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-2 p-sm-4 mt-4 text-center">
                        <div class="mb-3 lh-1-7">Your membership will be automatically renewed each year and we will charge your default payment method. If you selected the monthly payment option, your membership fees will be paid monthly.</div>
                        <div class="mb-4">You can cancel this auto renewal at any time.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="cancelAutoRenewalModal" tabindex="-1" aria-labelledby="cancelAutoRenewalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-2 p-sm-4 mt-4 text-center">
                        <div class="mb-4 lh-1-7">Simply send an email to our Membership Team at <strong>membership.admin@thecultivist.com</strong> <br>to cancel auto renewal.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="radioYesModal" tabindex="-1" aria-labelledby="radioYesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-2 px-sm-4 pt-sm-4 pb-sm-2 mt-4 text-center">
                        <div class="mb-3 modal-text">They will receive their welcome email <br>once your payment is processed.</div>
                    </div>
                    <div class="pb-2 pb-sm-4 text-center">
                        <button type="button" class="btn btn-link text-dark" data-bs-dismiss="modal">GOT IT!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
</main>
@endsection
