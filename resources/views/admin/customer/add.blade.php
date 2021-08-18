

@extends('layouts.app')
@section('content')


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Patient</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Patient List </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    

                    @if( Session::has("message") )
                          <div class="alert alert-success alert-block" id="success1" role="alert">
                          <button class="close" data-dismiss="alert"></button>
                          {{ Session::get("message") }}
                         </div>
                    @endif

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>

                <div class="alert alert-success" id='success' style="display:none">
                    <button type="button" class="close" data-dismiss="alert">X</button>
                    <p id="success_msg"></p>
                    
                </div> 

                    <div class="card ">

<!--                        <div class="card-header">
                            <h3 class="card-title">Add</h3>
                        </div>-->
                       
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="card-header">
                            <h3 class="card-title">Add</h3>
                        </div>
                            <div class="card card-primary card-outline card-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">General Information:</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Contact Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Medical History</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-document-tab" data-toggle="pill" href="#custom-tabs-two-document" role="tab" aria-controls="custom-tabs-two-document" aria-selected="false">Document</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-two-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                                            <form method="POST" action="" id="form1" enctype="multipart/form-data">
                                                {{csrf_field()}}


                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">&nbsp;</label>
                                                    <div class="col-lg-5">
                                                        @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li><br>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>



                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">First Name *</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('first_name') }}" id="first_name" class="form-control" name="first_name" placeholder="e.g Enter full name" >
                                                        <p id="p1" style="display: none;color: red;">First Name required.</p>
                                                        <div class="invalid-feedback">
                                                            Please enter first_name
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> Last Name *</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('last_name') }}" id="last_name" class="form-control" name="last_name" placeholder="e.g lastname" >
                                                        <p id="p2" style="display: none;color: red;">Last Name required.</p>
                                                        <div class="invalid-feedback">
                                                            Please enter last_name
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> Date Of Birth *</label>
                                                    <div class="col-lg-5">
                                                        <input type="date" value="{{ old('dob') }}" id="dob" class="form-control" name="dob" placeholder="Enter Date" >
                                                        <p id="p3" style="display: none;color: red;">Date Of Birth required.</p>
                                                        <div class="invalid-feedback">
                                                            Please enter Date of Birth
                                                        </div>
                                                        <p id="p3" style="display: none;color: red;">Date of Birth required.</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Gender *</label>
                                                    <div class="col-lg-5">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary1" name="gender" value="male" checked>
                                                            <label for="radioPrimary1">Male
                                                            </label>
                                                        </div>

                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary1" name="gender" value="female" >
                                                            <label for="radioPrimary1">FeMale
                                                            </label>
                                                        </div> 
                                                        <div class="invalid-feedback">
                                                            Please enter Date of Birth
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Adhar Card </label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('adhar_card') }}" id="email" class="form-control" name="adhar_card" placeholder="1234456789102" >
                                                        <div class="invalid-feedback">
                                                            Please enter Adhar card
                                                        </div>
                                                    </div>
                                                </div>                                 

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Pan Card </label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('pan_card') }}" id="email" class="form-control" name="pan_card" placeholder="Enter pancard" >
                                                        <div class="invalid-feedback">
                                                            Please enter Adhar card
                                                        </div>
                                                    </div>
                                                </div> 

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Anniversary </label>
                                                    <div class="col-lg-5">
                                                        <input type="date" value="{{ old('anniversary_date') }}" id="email" class="form-control" name="anniversary_date" placeholder="Enter anniversary date" >
                                                        <div class="invalid-feedback">
                                                            Please enter Aniversary
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Referred By </label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('referred_by') }}" id="referred_by" class="form-control" name="referred_by" placeholder="e.g M.K.patel" >
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Blood Group </label>
                                                    <div class="col-lg-5">
                                                        <div class="select">
                                                            <select name="blood_group" class="custom-select form-control">
                                                                <option value="">Select</option>
                                                                <option value="A+">A+</option>
                                                                <option value="A-">A-</option>
                                                                <option value="B+">B+</option>
                                                                <option value="B-">B-</option>
                                                                <option value="AB+">AB+</option>
                                                                <option value="AB-">AB-</option>
                                                                <option value="o-">O-</option>
                                                                <option value="o+">O+</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Please select an option
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> Image </label>
                                                     <div class="col-lg-5">
                                                        <input type="file" name="avatar_image" id="avatar_image" class="form-control" placeholder="Please select image to upload">
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Cover Image </label>
                                                     <div class="col-lg-5">
                                                        <input type="file" name="cover_image" id="cover_image" class="form-control" placeholder="Please select image to upload">
                                                    </div>
                                                </div>

                                                <!--<a  >Next</a>-->                                                                    
                                                <button type="button" id="first" class="btn btn-success btnNext">Next</button>
                                            </form>
                                        </div><!-- tab over-->    

                                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                                            <form method="POST" action="" id="form2" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Primary Mobile *</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('mobile') }}" id="mobile" class="form-control" name="mobile" placeholder="e.g 1234567890" >
                                                        <div class="invalid-feedback">
                                                            Please enter mobile
                                                        </div>
                                                        <div id="mobile_error_message">
                                                        </div>
                                                        <input type="hidden" id="mobile_unique" name="mobile_unique">
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Secondary Mobile No. </label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('secondary_mobile') }}" id="mobile" class="form-control" name="secondary_mobile" placeholder="e.g 1234567890" >
                                                        <div class="invalid-feedback" >
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Email *</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('email') }}" id="email" class="form-control" name="email" placeholder="e.g abc@DairyBoy.com" >
                                                        <div class="invalid-feedback">
                                                            Please enter email
                                                        </div>
                                                        <div id="email_error_message">
                                                        </div>
                                                        <input type="hidden" id="email_unique" name="email_unique">
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Address</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('address') }}" id="address" class="form-control" name="address" placeholder="e.g address" >
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">City</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('city') }}" id="city" class="form-control" name="city" placeholder="e.g Jaipur" >
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">State</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('state') }}" id="state" class="form-control" name="state" placeholder="e.g state" >
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Zipcode</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" value="{{ old('zipcode') }}" id="zipcode" class="form-control" name="zipcode" placeholder="e.g zipcode" >
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-danger btnPrevious">Previous</button>
                                                <button type="button" id="second" class="btn btn-success btnNext">Next</button>

                                            </form>
                                        </div><!-- tab over-->
                                        <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                                            <form method="POST" action="" id="form3" enctype="multipart/form-data">
                                                {{csrf_field()}}
                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Disease</label>
                                                    <div class="col-lg-5">
                                                        <div class="select2-purple">
                                                            <select class="select2" multiple="multiple" data-placeholder="Select a disease" data-dropdown-css-class="select2-purple" id="disease" name="disease[]" style="width: 100%;">
                                                                @foreach($disease as $value)

                                                                   <option value="{{$value->id}}">{{$value->title}}</option>     

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>          



                                                <div class="form-group row d-flex align-items-center mb-5">
                                                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Other History</label>
                                                    <div class="col-lg-5">
                                                        <textarea class="form-control" name="other_history" id="other_history"></textarea>
                                                    </div>
                                                </div>  

                                                <input type="hidden" id="form1_data" name="form1_data">
                                                <input type="hidden" id="form2_data" name="form2_data">
                                                <input type="hidden" name="avatar_image" id="form_data">

                                                <button type="button" class="btn btn-danger btnPrevious">Previous</button>
                                                <button type="button" id="third" class="btn btn-success btnNext">Create</button>
                                            </form>
                                        </div><!-- tab over-->



                                        <div class="tab-pane fade" id="custom-tabs-two-document" role="tabpanel" aria-labelledby="custom-tabs-two-document-tab">
                                           <form method="POST" id="form4" enctype="multipart/form-data">
                                                {{csrf_field()}}     
                                            

                                            <input type="hidden" name="user_id" value="" id="user_id">


                                            

                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> Document *</label>
                                                <div class="col-lg-5">
                                                    <select name="document" class="form-control" id="document"> 
                                                        <option value="0"> -- select Document -- </option>
                                                        <option value="voter_id">Voter ID</option>
                                                        <option value="adhar_card">Adhar Card</option>
                                                        <option value="pan_no">Pan Card</option>
                                                        <option value="passport">Passport</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> Image </label>
                                                <div class="col-lg-5">
                                                    <input type="file" name="image" id="image" class="form-control" placeholder="Please select image to upload">
                                                </div>
                                            </div>

                            
                                            <div class="col-8 ">
                                            <div class="card card-primary">
                                              
                                              <div class="card-body">
                                                <div class="row document_image">

                                                  
                                                  
                                                  
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                
                                            </form>

                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">&nbsp;</label>
                                                <div class="col-lg-5">
                                                    <div class="select">
                                                        <button type="button" class="btn  btn-success" id="add">Upload</button>
                                                        <a href="{{ URL::asset('customer') }}">
                                                            <button type="button" class="btn btn-danger">Back</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                                
                                        </div><!-- tab over-->




                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>

                     </div>
                </div>
            </div>        
        </div>
    </section>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        $('.btnNext').click(function () {
//            $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
        });

        $('.btnPrevious').click(function () {
            
            $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
        });
    });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    

  })
</script>
<?php $Update_Url1 = URL::asset('document_update'); ?>
<?php $remove_image = URL::asset('remove_document'); ?>
<?php $customer_add = URL::asset('customer-add'); ?>

<script type="text/javascript">
$(document).ready(function () {

    $(document).on('click', ".album_data_remove", function () {
        var document_id = $(this).attr('data-value');
        var p_id  = $('#user_id').val();
    

                $.ajax({
                type: 'POST',
                url: "<?php echo $remove_image; ?>",
                dataType:'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'document_id': document_id,'p_id':p_id},
                beforeSend:function(){
                     return confirm("Are you sure?");
                },
                success: function (data) {

               
                    if(data.status == true)
                    {
                        
                        $('.document_image').html(data.data_return);
                        $('#success').show();
                        $('#success_msg').html(data.message);
                        $('#document').val();
                        setTimeout(function() {
                            $('#success').fadeOut('fast');
                        }, 5000);
                        
                    }
                }
    });
});


    $("#third").click(function () {
        var form = document.forms.namedItem("form1"); 
        var formdata = new FormData(form);
        var form2 = $('#form2_data').val();
        var disease = $('#disease').val();
        var other_history = $('#other_history').val();
        formdata.append('form2_data', form2);
        formdata.append('disease',disease);
        formdata.append('other_history',other_history);

        
        $.ajax({
            type: "post",
            async: true,
            url: "<?php echo $customer_add; ?>",
            dataType:'json',
            contentType: false,
            data: formdata,
            processData: false,
            success: function (data)
            {
                if($.isEmptyObject(data.error))
                {
                    if(data.status == true)
                    {
                        $('#user_id').val(data.data_id);    
                        $('#custom-tabs-two-document-tab').trigger('click');
                        $('#success').show();
                        $('#success_msg').html(data.message);
                        $("#form1")[0].reset();
                        $("#form2")[0].reset();                 
                        $("#form3")[0].reset();
                        
                    }   
                    
                        
                }else{

                        printErrorMsg(data.error);

                }      
            }

        });
    });

    function printErrorMsg (msg)
    {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
    }


    $("#add").click(function () {
        var form = document.forms.namedItem("form4"); 
        var formdata = new FormData(form);
        
        $.ajax({
            type: "post",
            async: true,
            url: "<?php echo $Update_Url1; ?>",
            dataType:'json',
            contentType: false,
            data: formdata,
            processData: false,
            success: function (data)
            {
                if($.isEmptyObject(data.error))
                {
                    if(data.status == true)
                    {
                        $('.document_image').html(data.data_return);    
                        $('#success').show();
                        $('#success_msg').html(data.message);
                        $('#document').val();
                        setTimeout(function() {
                            $('#success').fadeOut('fast');
                        }, 5000);
                        
                    }   
                    
                        
                }else{

                        printErrorMsg(data.error);

                }      
            }

        });
    });

    function printErrorMsg (msg)
    {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
    }

    
});



    

</script>
<script type="text/javascript">
    $(document).ready(function(){
         setTimeout(function(){
           $("#success1").remove();
         }, 5000 ); // 5 secs

    }); 
    
</script>>
@endsection
@push('custom-scripts')
<?php $mobile_url = URL::asset('unique-mobile'); ?>
<?php $email_url = URL::asset('unique-email'); ?>
<script>




    document.getElementById("first").addEventListener("click", FirstTab);

    function FirstTab() {

        $('#form1').validate({// initialize the plugin
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                dob: {
                    required:true
                }
            }
        });

        var valid_first_step = $("#form1").valid();

        if (valid_first_step == true) {


            $('.nav-tabs .active').parent().next('li').find('a').trigger('click');

        }
    }

    document.getElementById("second").addEventListener("click", SecondTab);
    function SecondTab() {
        
        $('#form2').validate({// initialize the plugin
            rules:
            {
                mobile:
                {
                    required: true,
                    remote:
                    {
                        'url': '{{$mobile_url}}',
                        'type': "post",
                        'data': {
                            _token: function ()
                            {
                                return "{{ csrf_token() }}";
                            }
                        },success: function(response) {
                            
                            if (response == 1) {
                                $('#mobile_error_message').html('');
                                $('#mobile_error_message').append('<p>mobile is already exits</p>');
                            
                                 $('#mobile_unique').val('false');
                            } else { 
                                $('#mobile_error_message').html('');
                                $('#mobile_unique').val('true');
                            
                                return true;                                 
                            }
                        }
                    }
                },
                email:
                {
                    required: true,
                    remote:
                    {
                        'url': '{{$email_url}}',
                        'type': "post",
                        'data': {
                            _token: function ()
                            {
                                return "{{ csrf_token() }}";
                            }
                        },success: function(response) {
                            
                            if (response == 1) {
                                $('#email_error_message').html('');
                                $('#email_error_message').append('<p>Email is already exits</p>');
                            
                                 $('#email_unique').val('false');
                            } else { 
                                $('#email_error_message').html('');
                                $('#email_unique').val('true');
                            
                                return true;                                 
                            }
                        }
                    }
                },
            }    
        });
        var valid_second_step = $('#form2').valid();
        if (valid_second_step == true) {
        if($('#mobile_unique').val() == 'true' && $('#email_unique').val() == 'true'){
         $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
        }
           
        }
    }

    document.getElementById("third").addEventListener("click", ThirdTab);
    function ThirdTab() {
        $('#form3').validate({// initialize the plugin
            rules: {
                disease: {
                    required: true
                }
            }
        });
        var valid_third_step = $('#form3').valid();
        
        
        if (valid_third_step == true) {

             
             
            $('#form1_data').val($('#form1').serialize());
             $('#form2_data').val($('#form2').serialize());

             

            



        }
    }




</script>




@endpush








