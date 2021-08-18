@extends('layouts.app')
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
                    <a class="nav-link active" id="individual-tab" data-bs-toggle="tab" href="#individual" role="tab" aria-controls="individual" aria-selected="true">Individual</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link {{session('activeTab') == 'dual' ? 'active' : ''}}" id="dual-tab" data-bs-toggle="tab" href="#dual" role="tab" aria-controls="dual" aria-selected="false">Dual <span class="d-none d-sm-inline">Membership</span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link {{session('activeTab') == 'gifting' ? 'active' : ''}}" id="gifting-tab" data-bs-toggle="tab" href="#gifting" role="tab" aria-controls="gifting" aria-selected="false">Gift a Membership</a>
                  </li>
                </ul>
                <div class="tab-content">
                  	<div class="tab-pane fade {{session('activeTab') == '' ? 'show active' : ''}}" id="individual" role="tabpanel" aria-labelledby="individual-tab">
	                    <div class="form-wrap">
	                      	<div class="mb-5">Great choice! Tell us a bit more about yourself.</div>
		                    <form method="post" action="{{URL::asset('individual-post')}}" id="contact_form">
		                    	@csrf
		                    	
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
		                        </div>
	                      	
	                    </div>
	                    <div class="tabs-style-1 mt-4">
			                <h6 class="fw-bold mb-3">Select Your Payment Preference</h6>
			                <ul class="nav nav-pills" role="tablist">
			                  <li class="nav-item" role="presentation">
			                    <a class="nav-link active" id="yearPrepaid-tab" data-bs-toggle="tab" href="#yearPrepaid" role="tab" aria-controls="yearPrepaid" aria-selected="true">1 Year Prepaid</a>
			                  </li>
			                  <li class="nav-item" role="presentation">
			                    <a class="nav-link" id="paidMonthly-tab" data-bs-toggle="tab" href="#paidMonthly" role="tab" aria-controls="paidMonthly" aria-selected="false">Pay Monthly</a>
			                  </li>
			                </ul>
			                <div class="tab-content">
			                  <div class="tab-pane fade show active" id="yearPrepaid" role="tabpanel" aria-labelledby="yearPrepaid-tab">
			                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
			                      <div class="col-9">
			                        <div class="fw-bold">The Enthusiast</div>
			                        <div class="pt-3">1 Year Prepaid (Receive Metal Membership Card)</div>
			                      </div>
			                      <div class="col-3 text-end">$440</div>
			                    </div>
			                    <div class="row gx-1 mt-3">
			                      <div class="col-9 fw-bold">Total</div>
			                      <div class="col-3 text-end fw-bold">$440</div>
			                    </div>
			                  </div>
			                  <div class="tab-pane fade" id="paidMonthly" role="tabpanel" aria-labelledby="paidMonthly-tab">
			                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
			                      <div class="col-9">
			                        <div class="fw-bold">The Enthusiast - Dual Memberships</div>
			                        <div class="pt-3">Paid Monthly</div>
			                      </div>
			                      <div class="col-3 text-end">$40</div>
			                    </div>
			                    <div class="row gx-1 mt-3">
			                      <div class="col-9 fw-bold">Total</div>
			                      <div class="col-3 text-end fw-bold">$40</div>
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
                  	<div class="tab-pane fade {{session('activeTab') == 'dual' ? 'show active' : ''}}" id="dual" role="tabpanel" aria-labelledby="dual-tab">
	                    <div class="form-wrap">
	                      	<div class="mb-4">Available to anyone living at the same address.</div>
                      		<div class="mb-5 text-aaa">*Interested in more than 2 memberships? Email us <a class="text-aaa" href="mailto:contact@thecultivist.com">here</a>.</div>
	                      	<form method="post" action="{{URL::asset('dual-post')}}" id="dual_form">
	                      		@csrf
	                      		
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
	                    	<div class="tabs-style-1 mt-4">
				                <h6 class="fw-bold mb-3">Select Your Payment Preference</h6>
				                <ul class="nav nav-pills" role="tablist">
				                  <li class="nav-item" role="presentation">
				                    <a class="nav-link active" id="yearPrepaid-tab" data-bs-toggle="tab" href="#yearPrepaid1" role="tab" aria-controls="yearPrepaid" aria-selected="true">1 Year Prepaid</a>
				                  </li>
				                  <li class="nav-item" role="presentation">
				                    <a class="nav-link" id="paidMonthly-tab" data-bs-toggle="tab" href="#paidMonthly1" role="tab" aria-controls="paidMonthly" aria-selected="false">Pay Monthly</a>
				                  </li>
				                </ul>
				                <div class="tab-content">
				                  <div class="tab-pane fade show active" id="yearPrepaid1" role="tabpanel" aria-labelledby="yearPrepaid-tab">
				                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
				                      <div class="col-9">
				                        <div class="fw-bold">The Enthusiast - Dual Membership</div>
				                        <div class="pt-3">1 Year Prepaid (Receive Metal Membership Card)</div>
				                      </div>
				                      <div class="col-3 text-end">$880</div>
				                    </div>
				                    <div class="row gx-1 mt-3">
				                      <div class="col-9 fw-bold">Total</div>
				                      <div class="col-3 text-end fw-bold">$880</div>
				                    </div>
				                  </div>
				                  <div class="tab-pane fade" id="paidMonthly1" role="tabpanel" aria-labelledby="paidMonthly-tab">
				                    <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
				                      <div class="col-9">
				                        <div class="fw-bold">The Enthusiast - Dual Membership</div>
				                        <div class="pt-3">Paid Monthly</div>
				                      </div>
				                      <div class="col-3 text-end">$80</div>
				                    </div>
				                    <div class="row gx-1 mt-3">
				                      <div class="col-9 fw-bold">Total</div>
				                      <div class="col-3 text-end fw-bold">$80</div>
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
                      		<div class="mb-5">Tell us  who will be receiving the gift.</div>
                      		<form method="post" action="{{url('gifting')}}" id="gift_form">
                      			@csrf
                      			
	                        <div class="row gx-2 pb-3">
	                          <div class="col-12 h6 fw-bold mb-3">Recipient's Details</div>
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
	                             <span class="text-danger">{{ $errors->first('phone_number')  }}</span>
	                          </div>
	                        </div>
	                        <div class="pt-4 pb-3">
		                        <div class="col-12 h6 fw-bold mb-1">Would you like the recipient to know?</div>
		                        <div class="mb-3"><!--We understand it’s really hard to keep the gift as a surprice! Let us help you with that.--></div>
	                            <div class="form-check" data-bs-toggle="modal" data-bs-target="#radioNoModal">
		                            <input class="form-check-input" type="radio" name="yn" id="no" checked>
		                            <label class="form-check-label" for="no">
		                              No, I want to keep it as a surprise!
		                            </label>
	                          	</div>
	                          	<div class="form-check" data-bs-toggle="modal" data-bs-target="#radioYesModal">
		                            <input class="form-check-input" type="radio" name="yn" id="yes">
		                            <label class="form-check-label" for="yes">
		                              Yes, please let the reciepient know.
		                            </label>
	                          	</div>
		                    </div>           	
                    	</div>
                    	<div class="tabs-style-1 mt-4">
			                <h6 class="fw-bold mb-3">Select Your Payment Preference</h6>
			                <ul class="nav nav-pills" role="tablist">
				                <li class="nav-item" role="presentation">
				                    <a class="nav-link active" id="yearPrepaid-tab" data-bs-toggle="tab" href="#yearPrepaid2" role="tab" aria-controls="yearPrepaid" aria-selected="true">1 Year Prepaid</a>
				                </li>
			                  	<li class="nav-item" role="presentation">
			                    	<a class="nav-link" id="paidMonthly-tab" data-bs-toggle="tab" href="#paidMonthly2" role="tab" aria-controls="paidMonthly" aria-selected="false">Pay Monthly</a>
			                  	</li>
			                </ul>
			                <div class="tab-content">
						        <div class="tab-pane fade show active" id="yearPrepaid2" role="tabpanel" aria-labelledby="yearPrepaid-tab">
						            <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
							            <div class="col-9">
							                <div class="fw-bold">The Enthusiast</div>
							                <div class="pt-3">1 Year Prepaid (Receive Metal Membership Card)</div>
							            </div>
						              	<div class="col-3 text-end">$440</div>
						            </div>
						            <div class="row gx-1 mt-3">
						              	<div class="col-9 fw-bold">Total</div>
						              	<div class="col-3 text-end fw-bold">$440</div>
						            </div>
						          </div>
							        <div class="tab-pane fade" id="paidMonthly2" role="tabpanel" aria-labelledby="paidMonthly-tab">
							            <div class="row gx-1 mt-4 pt-3 border-bottom border-dark pb-4">
							              	<div class="col-9">
							                	<div class="fw-bold">The Enthusiast - Dual Memberships</div>
							                	<div class="pt-3">Paid Monthly</div>
							              	</div>
							              	<div class="col-3 text-end">$40</div>
							            </div>
							            <div class="row gx-1 mt-3">
							              	<div class="col-9 fw-bold">Total</div>
							              	<div class="col-3 text-end fw-bold">$40</div>
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
                <div class="mb-3 lh-1-7">They will receive their welcome email <br>once your payment is processed.</div>
              </div>
              <div class="pb-2 pb-sm-4 text-center">
                <button type="button" class="btn btn-link text-dark" data-bs-dismiss="modal">GOT IT!</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="radioNoModal" tabindex="-1" aria-labelledby="radioNoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="p-2 px-sm-4 pt-sm-4 pb-sm-2 mt-4 text-center">
                <div class="mb-4 lh-1-7">Select the date you'd like their membership to begin. <br>This will also be the date they will receive their welcome email.</div>
               	<div class="mb-4 mx-auto datepicker-240" id="datepicker"></div>
              </div>
              <div class="pb-2 pb-sm-4 text-center">
                <button type="button" class="btn btn-link text-dark" data-bs-dismiss="modal">SUBMIT</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection
