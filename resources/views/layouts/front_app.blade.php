<!doctype html>
<html lang="en">
<style type="text/css">
    .exp_error_msg{
    display: block;
    color: red;
}
.loader{ position: fixed; left: 0; top: 0; right: 0; bottom: 0; z-index: 9; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.7);}
</style>
<style type="text/css">
  #apple-pay-button {
    display: none;
    background-color: black;
    background-image: -webkit-named-image(apple-pay-logo-white);
    background-size: 100% 100%;
    background-origin: content-box;
    background-repeat: no-repeat;
    width: 100%;
    height: 44px;
    padding: 10px 0;
    border-radius: 10px;
  }
</style>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Cultivist</title>

    <link rel="stylesheet" href="{{ asset('/') }}css/jquery-ui.css">
    <script src="{{ asset('/') }}js/futura-pt.js"></script>
    <script src="{{ asset('/') }}js/futura-pt-bold.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}js/HvGL0enBCARnu58YIXYOQ_iyoLHUDOO5dCyItrHhg7tfeCSIfFHN4UJLFRbh5.js"></script>
    <style type="text/css">@font-face{font-family:futura-pt-bold;src:url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt-bold;src:url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/l?subset_id=2&fvd=n5&v=3) format("woff2"),url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/d?subset_id=2&fvd=n5&v=3) format("woff"),url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/a?subset_id=2&fvd=n5&v=3) format("opentype");font-weight:500;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/l?subset_id=2&fvd=n6&v=3) format("woff2"),url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/d?subset_id=2&fvd=n6&v=3) format("woff"),url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/a?subset_id=2&fvd=n6&v=3) format("opentype");font-weight:600;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/849347/000000000000000000010093/27/l?subset_id=2&fvd=i3&v=3) format("woff2"),url(https://use.typekit.net/af/849347/000000000000000000010093/27/d?subset_id=2&fvd=i3&v=3) format("woff"),url(https://use.typekit.net/af/849347/000000000000000000010093/27/a?subset_id=2&fvd=i3&v=3) format("opentype");font-weight:300;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}</style><script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <script type="text/javascript" src="{{ asset('/') }}js/uA6bzwO1_HAQbuVv3YB_KFd_CdC7i2s3RExXVUfS1uJfeTCIf4e6pUJ6wRMU5.js"></script>
    <style type="text/css">@font-face{font-family:futura-pt-bold;src:url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/l?subset_id=2&fvd=n3&v=3) format("woff2"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/d?subset_id=2&fvd=n3&v=3) format("woff"),url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/a?subset_id=2&fvd=n3&v=3) format("opentype");font-weight:300;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/l?subset_id=2&fvd=n4&v=3) format("woff2"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/d?subset_id=2&fvd=n4&v=3) format("woff"),url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/a?subset_id=2&fvd=n4&v=3) format("opentype");font-weight:400;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/l?subset_id=2&fvd=n7&v=3) format("woff2"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/d?subset_id=2&fvd=n7&v=3) format("woff"),url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/a?subset_id=2&fvd=n7&v=3) format("opentype");font-weight:700;font-style:normal;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/l?subset_id=2&fvd=i4&v=3) format("woff2"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/d?subset_id=2&fvd=i4&v=3) format("woff"),url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/a?subset_id=2&fvd=i4&v=3) format("opentype");font-weight:400;font-style:italic;font-display:auto;}@font-face{font-family:futura-pt;src:url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/l?subset_id=2&fvd=i7&v=3) format("woff2"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/d?subset_id=2&fvd=i7&v=3) format("woff"),url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/a?subset_id=2&fvd=i7&v=3) format("opentype");font-weight:700;font-style:italic;font-display:auto;}</style><script type="text/javascript">try{Typekit.load();}catch(e){}</script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/style.css">
  </head>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-71079941-22"></script>
  <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-71079941-22');
</script>

 <body>
    <nav class="navbar navbar-expand-md navbar-light bg-white">
      <div class="container-fluid">
        <a class="navbar-brand" href="https://ww2.thecultivist.com/"><img src="{{ asset('/') }}images/logo.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="https://ww2.thecultivist.com/memberships-options">Join Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://members.thecultivist.com/login">Sign In</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    @yield('content')

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('/') }}js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <style type="text/css">
    .error{
        color: red;
    }
    </style>
<script type="text/javascript">
$(document).ready(function () {
    //var check_radio  = $("input:radio[name='no']:checked").val();

    
    $('#contact_form').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            first_name: {
                required: true
            },
            last_name: {
                required: true,
                
            },
            phone_number:{
                required: true,
                digits: true
            },
        }
    });
    
    $('#dual_form').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true
            },
            first_name: {
                required: true
            },
            last_name: {
                required: true,
                
            },
            phone_number:{
                required: true,
                digits: true
            },
            detail_02_email: {
                required: true,
                email: true
            },
            detail_02_first_name: {
                required: true
            },
            detail_02_last_name: {
                required: true,
                
            },
            detail_02_phone_number:{
                required: true,
                digits: true
            },
        }
    });

    $('#gift_form').validate({ // initialize the plugin
             ignore: [],
        rules: {
            Emailgift: {
                required: true,
                email: true
            },
            Firstnamegift: {
                required: true
            },
            Lastnamegift: {
                required: true,
                
            },
            Startdategift: {
                required: '#no[value="no"]:checked',
                date:true,
                
            },
        },
        messages: {
            Startdategift: 'Please select a date',   
        },
    });   

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
            shipping_country:{
                required: true,
                
            },
            shipping_state:{
                required:true,
            },
            shipping_phonenumber:{
                required:true,
            },
            customer_email:{
                required:true,
                email: true
            },
            customer_first_name:{
                required:true,
            },
            customer_last_name:{
                required:true,
            },
            customer_phone_number:{
                required:true,
            },
            ccnumber:{
                required:true,
                digits: true,
            },
            expiry:{
                required:true,
             //   date: true
            },
            cvv:{
                required:true,
            },
            billing_zip:{
                required:true,
            },
            card_name:{
                required:true,
            },
            tnc:{
                required:true,
            },
            tnc_p:{
                required:true,
            },
            billing_address:{
                //required:true
                required: '#yes[value="yes"]:checked',
            },
            billing_city:{
                required: '#yes[value="yes"]:checked',
            },
            billing_zipcode:{
                required: '#yes[value="yes"]:checked',
            },
            billing_state:{
                required: '#yes[value="yes"]:checked',
            },
            billing_country:{
                required: '#yes[value="yes"]:checked',
            },
            billing_phonenumber:{
                required: '#yes[value="yes"]:checked',
            },
        },
         errorPlacement: function(error, element) {
        if (element.attr("name") == "tnc" )
            error.insertAfter("#tnc_msg");
        else if  (element.attr("name") == "tnc_p" )    
            error.insertAfter("#tnc_p_msg");
        else  // This is the default behavior of the script for all fields
            error.insertAfter( element );
        
    }
    });
});
</script>
    <script type="text/javascript">
        $("#datepicker").datepicker({
            minDate: new Date(),
            maxDate: new Date(new Date().setMonth(new Date().getMonth() + 3)),
        onSelect: function(dateText, inst) {
            $('#start_date').val(dateText);    
            //alert( $('#start_date').val()); 
        } 
      });   
    </script>

    <script type="text/javascript">
  
  $(document).ready(function(){ 
    
    $("input[name='payment']").click(function() {
       
        var test = $(this).val();
        if(test == 'no')
        {
          $(".billing_address").hide();
          //$("#"+test).show();  
        }
        else
        {
          $(".billing_address").show();
        }  
       
    });

    $("input[name='payment_method']").click(function() {
       
        var test1 = $(this).val();
        if(test1 == 'apple_pay')
        {
          $(".credit_card").hide();
          //$("#"+test).show();  
        }
        else
        {
          $(".credit_card").show();
        }  
       
    });
  });  
    
    $(document).ready(function () {
        $('.year').click(function () { 
            var price = $(this).attr('data-value');
            var pay_name = $(this).attr('data-name');
            var snap_day = $(this).attr('data-interval');
            var uk_price_y = $(this).attr('data-uk'); 
            var gbp_price_y = $(this).attr('data-gbp');
            
            $('#pro_price').val('');
            $('#pro_price').val(price);
            $('#payment_name').val('');
            $('#payment_name').val(pay_name);
            $('#snap_day').val(snap_day);
            $('#price_point_id').val('955621');
            $('#uk_product_price').val(uk_price_y);
            $('#gbp_product_price').val(gbp_price_y);
            $('#uk_price_point_id').val('957322');
            $('#gbp_price_point_id').val('1197863');
            
        }); 

        $('.month').click(function () { 
            var price1 = $(this).attr('data-value');
            var pay_name1 = $(this).attr('data-name'); 
            var snap_day = $(this).attr('data-interval'); 
            var uk_price_m = $(this).attr('data-uk');
            var gbp_price_m = $(this).attr('data-gbp');

            $('#price_point_id').val('962219');
         //   alert($('#price_point_id').val());
            $('#pro_price').val();
            $('#pro_price').val(price1);
            $('#payment_name').val('');
            $('#payment_name').val(pay_name1);
            $('#snap_day').val(snap_day);
            $('#uk_product_price').val(uk_price_m);
            $('#gbp_product_price').val(gbp_price_m);
            $('#uk_price_point_id').val('1196436');
            $('#gbp_price_point_id').val('1197864');
          //  alert($('#gbp_product_price').val());
        });

        $('.year_g').click(function () { 
            var price = $(this).attr('data-value');
            var pay_name2 = $(this).attr('data-name');
            var snap_day_g = $(this).attr('data-interval');
            var uk_price_g = $(this).attr('data-uk');
            var gbp_price_g = $(this).attr('data-gbp');

            $('#pro_price_g').val('');
            $('#pro_price_g').val(price);
            $('#payment_name_g').val('');
            $('#payment_name_g').val(pay_name2);
            $('#price_point_id_g').val('996066');
            $('#snap_day_g').val(snap_day_g);
            $('#uk_product_price_g').val(uk_price_g);
            $('#gbp_product_price_g').val(gbp_price_g);
            $('#uk_price_point_id_g').val('996068');
            $('#gbp_price_point_id_g').val('1197866');
           // alert($('#uk_price_point_id').val());
           // alert($('#price_point_id_g').val());
        }); 

        $('.month_g').click(function () { 
            var price1 = $(this).attr('data-value');
            var pay_name3 = $(this).attr('data-name');
            var snap_day_g = $(this).attr('data-interval'); 


            $('#price_point_id_g').val('1188338');
            $('#pro_price_g').val();
            $('#pro_price_g').val(price1);
            $('#payment_name_g').val('');
            $('#payment_name_g').val(pay_name3);
        //    $('#price_point_id_g').val('1188338');
            $('#snap_day_g').val(snap_day_g);
           // alert($('#payment_name_g').val());
        });    

         $('.year_d').click(function () { 
            var price = $(this).attr('data-value');
            var pay_name4 = $(this).attr('data-name'); 
            var snap_day_d = $(this).attr('data-interval');
            var uk_price_d = $(this).attr('data-uk'); 
            var gbp_price_d = $(this).attr('data-gbp');

            $('#price_point_id_d').val('1188336');
            $('#pro_price_d').val(price);
            $('#payment_name_d').val('');
            $('#payment_name_d').val(pay_name4);
            $('#snap_day_d').val(snap_day_d);
            $('#uk_product_price_d').val(uk_price_d);
            $('#gbp_product_price_d').val(gbp_price_d);
            $('#uk_price_point_id_d').val('1196439');
            $('#gbp_price_point_id_d').val('1197868');
            
           // alert($('#gbp_product_price_d').val());
          //  alert($('#price_point_id_d').val());
        }); 

        $('.month_d').click(function () { 
            var price3 = $(this).attr('data-value');
            var pay_name5 = $(this).attr('data-name');
            var snap_day_d = $(this).attr('data-interval');  
            var uk_price_d_m = $(this).attr('data-uk'); 
            var gbp_price_d_m = $(this).attr('data-gbp');
           // alert(price2);
            $('#price_point_id_d').val('1188337');
            $('#pro_price_d').val();
            $('#pro_price_d').val(price3);
            $('#payment_name_d').val('');
            $('#payment_name_d').val(pay_name5);
            $('#snap_day_d').val(snap_day_d);
            $('#uk_product_price_d').val(uk_price_d_m);
            $('#gbp_product_price_d').val(gbp_price_d_m);
            $('#uk_price_point_id_d').val('1196441');
            $('#gbp_price_point_id_d').val('1197867');
           //alert($('#uk_price_point_id_d').val());
        });    
        
      
    var   country = ['AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','GR','HU','IS','IE','IT','LV','LI','LT','LU','MT','MC','NL','NO','PL','PT','RO','SK','ES','SE','CH'];
        $('.ship_country').change(function() {
            var val = $(this).val();
           // alert(val);
            if(val ==='GB')
            {
               // alert('GB');
               var product_id = $('#gbp_product_id').val();
               var price_point_id   = $('#gbp_product_price_point_id').val();
               var product_price = $('#gbp_product_price').val();
                $('#checkout_product_id').val(product_id);
                $('#product_price_point_id').val(price_point_id);
                $('#product_price').val(product_price);
                $('.price').text('£'+product_price);
                $('.total_price').text('£'+product_price);
                $('#currency').val('GBP');
               //alert($('#checkout_product_id').val());
            }
            else if(jQuery.inArray(val,country) !== -1)
            {
                var product_id = $('#uk_product_id').val();
                var price_point_id   = $('#uk_product_price_point_id').val();
                var product_price = $('#uk_product_price').val();
                $('#checkout_product_id').val(product_id);
                $('#product_price_point_id').val(price_point_id);
                $('#product_price').val(product_price);
                $('.price').text('€'+product_price);
                $('.total_price').text('€'+product_price);
                $('#currency').val('EUR');
              // alert($('#checkout_product_id').val());
            }    
            else{
                var def_product_id = $('#default_product_id').val();
                var def_point_id   = $('#default_product_price_point_id').val();
                var def_product_price = $('#default_product_price').val();
                                 $('#checkout_product_id').val(def_product_id);
                                 $('#product_price_point_id').val(def_point_id); 
                                 $('#product_price').val(def_product_price);  
                                 $('.price').text('$'+def_product_price);
                                 $('.total_price').text('$'+def_product_price);
                                 $('#currency').val('USD');   
                //                 alert($('#checkout_product_id').val());
            } 
        });    
    }); 

</script>
<?php $check_coupen = URL::asset('coupen_check'); ?>
<script type="text/javascript">
$(document).ready(function () {

    $(document).on('click', "#apply", function () {
        
        var coupen_code  = $('#promosGifts').val();
        var currency  = $('#currency').val();
        
    

                $.ajax({
                type: 'POST',
                url: "<?php echo $check_coupen ?>",
                dataType:'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'coupen_code':coupen_code,'currency':currency},
                success: function (data) {
                    if(data.status == true)
                    {
                        if(data.percentage != null || data.percentage !="")
                        {
                            $('#error_msg').css('display','none');
                            $("#success_msg").css('display','block');
                            $("#success_msg").text(data.message);    
                            var total = $('#product_price').val();
                            var percentage = data.percentage;
                            var discount = ((total * percentage)/100);
                            var total_price = (total - discount);   
                            if(data.type == "GBP")
                            {
                                $('#discount_name').css('display','block');
                                $('#disc_amount').text("£"+discount);
                                $('#disc_amount').css('display','inline-block');
                                $('.total_price').text("£"+total_price);        
                            }
                            else if(data.type == "EUR")
                            {
                                $('#discount_name').css('display','block');
                                $('#disc_amount').text("€"+discount);
                                $('#disc_amount').css('display','inline-block');
                                $('.total_price').text("€"+total_price);    
                            }
                            else
                            {    
                                $('#discount_name').css('display','block');
                                $('#disc_amount').text("$"+discount);
                                $('#disc_amount').css('display','inline-block');
                                $('.total_price').text("$"+total_price);    
                            }    
                        }
                        else
                        {
                            $('#error_msg').css('display','none');    
                            $("#success_msg").css('display','block');
                            $("#success_msg").text(data.message);    
                            var total = $('#product_price').val();
                            var percentage = data.percentage;
                            var discount_amt = (data.amount /100);
                            var total_price = ((total - $discount_amt));
                         //   var total_price = (total - discount);
                         if(data.type == "GBP")
                         {
                            $('#discount_name').css('display','block');
                            $('#disc_amount').text("£"+discount_amt);
                            $('#disc_amount').css('display','inline-block');
                            
                            $('.total_price').text("£"+total_price);
                         }
                         else if(data.type == "EUR")
                         {
                            $('#discount_name').css('display','block');
                            $('#disc_amount').text("€"+discount_amt);
                            $('#disc_amount').css('display','inline-block');
                            
                            $('.total_price').text("€"+total_price);
                         }   
                         else
                         {   
                            $('#discount_name').css('display','block');
                            $('#disc_amount').text("$"+discount_amt);
                            $('#disc_amount').css('display','inline-block');
                            
                            $('.total_price').text("$"+total_price);
                         }          
                        }    
                        
                        //alert(total_price);
                        //alert(data.message['coupon']['percentage']);
                       // $('#error_msg').css('display','block');
                       // $('#error_msg').html(data.message);

                    
                        
                    }
                    else{
                       // alert(data.message);
                        $("#success_msg").css('display','none');
                        $('#error_msg').css('display','block');
                        $('#error_msg').html(data.message);
                    }


                }
            });
    });
});
</script> 

    <script type="text/javascript">
     $('#placed').click(function() {
       var check =  $('input[name="tnc_p"]:checked').val();
        if(check == "yes")
        {
            $('.loader').show(); 
            return true;
        }    
            
       
     });
 </script>
</script>


<script type="text/javascript">
    $('#contact_form').one('submit', function() {
    $(this).find('input[type="submit"]').attr('disabled','disabled');
});

$('#dual_form').one('submit', function() {
    $(this).find('input[type="submit"]').attr('disabled','disabled');
});

$('#gift_form').one('submit', function() {
    $(this).find('input[type="submit"]').attr('disabled','disabled');
});

$('#checkout_form').one('submit', function() {
    $(this).find('input[type="submit"]').attr('disabled','disabled');
});
</script>


<script type="text/javascript">
    $(function() {
    $("#expiry").on("blur", function() {
        if(isMMSlashYYYY(this.value)==false)
        {
            $('.exp_error_msg').show();
        }
        else{
            $('.exp_error_msg').hide();   
        }    
        //$(this).closest("div").toggleClass("exp_error_msg",!isMMSlashYYYY(this.value))  
    })
})


function isMMSlashYYYY(value) {
    if (!value) return true;
    var split = value.split("/")
    var mm = +split[0]
    var yyyy = +split[1]

    if (isNaN(mm) || isNaN(yyyy)) return false;

    if (mm < 1 || mm > 13) return false;

    if (yyyy < 99);

    if (yyyy < 21 || yyyy > 40) return false;

    return true;
}

</script>
<?php $form_submit = URL::asset('form-submit'); ?>
<script type="text/javascript">
 $(document).ready(function () {

    $(document).on('change', "#country", function () {

                $.ajax({
                type: 'POST',
                url: "<?php echo $form_submit; ?>",
                dataType:'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#checkout_form").serialize(),
                success: function (data) {
                    if(data.status == true)
                    {
                          //alert('success');        
                    }
                }
            });
    });

    $(document).on('focusout', ".call", function () {

                $.ajax({
                type: 'POST',
                url: "<?php echo $form_submit; ?>",
                dataType:'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#checkout_form").serialize(),
                success: function (data) {
                    if(data.status == true)
                    {
                          //alert('success');        
                    }
                }
            });
    });

    $(document).on('change', "#billing_country", function () {

                $.ajax({
                type: 'POST',
                url: "<?php echo $form_submit; ?>",
                dataType:'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $("#checkout_form").serialize(),
                success: function (data) {
                    if(data.status == true)
                    {
                          //alert('success');        
                    }
                }
            });
    });

});   

</script>

  </body>
</html>