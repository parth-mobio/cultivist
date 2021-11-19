<!doctype html>
<html lang="en">
<style type="text/css">
    .exp_error_msg {
        display: block;
        color: red;
    }

    .loader {
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 9;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .7);
    }

    .error {
        color: red;
    }
</style>
<style>
    .StripeElement {
        background-color: white;
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
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
    <style type="text/css">
        @font-face {
            font-family: futura-pt-bold;
            src: url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/l?subset_id=2&fvd=n7&v=3) format("woff2"), url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/d?subset_id=2&fvd=n7&v=3) format("woff"), url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/a?subset_id=2&fvd=n7&v=3) format("opentype");
            font-weight: 700;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt-bold;
            src: url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/l?subset_id=2&fvd=i7&v=3) format("woff2"), url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/d?subset_id=2&fvd=i7&v=3) format("woff"), url(https://use.typekit.net/af/72575c/00000000000000003b9af1e5/27/a?subset_id=2&fvd=i7&v=3) format("opentype");
            font-weight: 700;
            font-style: italic;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/l?subset_id=2&fvd=n3&v=3) format("woff2"), url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/d?subset_id=2&fvd=n3&v=3) format("woff"), url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/a?subset_id=2&fvd=n3&v=3) format("opentype");
            font-weight: 300;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/l?subset_id=2&fvd=n4&v=3) format("woff2"), url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/d?subset_id=2&fvd=n4&v=3) format("woff"), url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/a?subset_id=2&fvd=n4&v=3) format("opentype");
            font-weight: 400;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/l?subset_id=2&fvd=n5&v=3) format("woff2"), url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/d?subset_id=2&fvd=n5&v=3) format("woff"), url(https://use.typekit.net/af/2cd6bf/00000000000000000001008f/27/a?subset_id=2&fvd=n5&v=3) format("opentype");
            font-weight: 500;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/l?subset_id=2&fvd=n6&v=3) format("woff2"), url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/d?subset_id=2&fvd=n6&v=3) format("woff"), url(https://use.typekit.net/af/c4c302/000000000000000000012192/27/a?subset_id=2&fvd=n6&v=3) format("opentype");
            font-weight: 600;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/l?subset_id=2&fvd=n7&v=3) format("woff2"), url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/d?subset_id=2&fvd=n7&v=3) format("woff"), url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/a?subset_id=2&fvd=n7&v=3) format("opentype");
            font-weight: 700;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/849347/000000000000000000010093/27/l?subset_id=2&fvd=i3&v=3) format("woff2"), url(https://use.typekit.net/af/849347/000000000000000000010093/27/d?subset_id=2&fvd=i3&v=3) format("woff"), url(https://use.typekit.net/af/849347/000000000000000000010093/27/a?subset_id=2&fvd=i3&v=3) format("opentype");
            font-weight: 300;
            font-style: italic;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/l?subset_id=2&fvd=i4&v=3) format("woff2"), url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/d?subset_id=2&fvd=i4&v=3) format("woff"), url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/a?subset_id=2&fvd=i4&v=3) format("opentype");
            font-weight: 400;
            font-style: italic;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/l?subset_id=2&fvd=i7&v=3) format("woff2"), url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/d?subset_id=2&fvd=i7&v=3) format("woff"), url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/a?subset_id=2&fvd=i7&v=3) format("opentype");
            font-weight: 700;
            font-style: italic;
            font-display: auto;
        }
    </style>
    <script type="text/javascript">
        try {
            Typekit.load();
        } catch (e) {}
    </script>
    <script type="text/javascript" src="{{ asset('/') }}js/uA6bzwO1_HAQbuVv3YB_KFd_CdC7i2s3RExXVUfS1uJfeTCIf4e6pUJ6wRMU5.js"></script>
    <style type="text/css">
        @font-face {
            font-family: futura-pt-bold;
            src: url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/l?subset_id=2&fvd=n7&v=3) format("woff2"), url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/d?subset_id=2&fvd=n7&v=3) format("woff"), url(https://use.typekit.net/af/053fc9/00000000000000003b9af1e4/27/a?subset_id=2&fvd=n7&v=3) format("opentype");
            font-weight: 700;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/l?subset_id=2&fvd=n3&v=3) format("woff2"), url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/d?subset_id=2&fvd=n3&v=3) format("woff"), url(https://use.typekit.net/af/ae4f6c/000000000000000000010096/27/a?subset_id=2&fvd=n3&v=3) format("opentype");
            font-weight: 300;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/l?subset_id=2&fvd=n4&v=3) format("woff2"), url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/d?subset_id=2&fvd=n4&v=3) format("woff"), url(https://use.typekit.net/af/9b05f3/000000000000000000013365/27/a?subset_id=2&fvd=n4&v=3) format("opentype");
            font-weight: 400;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/l?subset_id=2&fvd=n7&v=3) format("woff2"), url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/d?subset_id=2&fvd=n7&v=3) format("woff"), url(https://use.typekit.net/af/309dfe/000000000000000000010091/27/a?subset_id=2&fvd=n7&v=3) format("opentype");
            font-weight: 700;
            font-style: normal;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/l?subset_id=2&fvd=i4&v=3) format("woff2"), url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/d?subset_id=2&fvd=i4&v=3) format("woff"), url(https://use.typekit.net/af/cf3e4e/000000000000000000010095/27/a?subset_id=2&fvd=i4&v=3) format("opentype");
            font-weight: 400;
            font-style: italic;
            font-display: auto;
        }

        @font-face {
            font-family: futura-pt;
            src: url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/l?subset_id=2&fvd=i7&v=3) format("woff2"), url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/d?subset_id=2&fvd=i7&v=3) format("woff"), url(https://use.typekit.net/af/eb729a/000000000000000000010092/27/a?subset_id=2&fvd=i7&v=3) format("opentype");
            font-weight: 700;
            font-style: italic;
            font-display: auto;
        }
    </style>
    <script type="text/javascript">
        try {
            Typekit.load();
        } catch (e) {}
    </script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/style.css">
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-71079941-22"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
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
        .error.dual-error {
            color: red;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {

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
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 13
                    },
                    shipping_country: {
                        required: true
                    }
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
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 13
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
                    detail_02_phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 13
                    },
                    shipping_country_dual: {
                        required: true
                    }
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
                    shipping_country: {
                        required: false
                    },
                    phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 13
                    },
                    customer_email: {
                        required: true,
                        email: true
                    },
                    customer_first_name: {
                        required: true
                    },
                    customer_last_name: {
                        required: true,

                    },
                    customer_phone_number: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 13
                    },
                    shipping_country_gift: {
                        required: true
                    }
                }
            });

            //Close the alert messages in 15 seconds
            $(".close-alert-message").on("click", function() {
                $('.alert-message').hide();
            });
            setTimeout(function() {
                $('.alert-message').fadeOut('fast');
            }, 15000);
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
        $(document).ready(function() {

            $("input[name='payment']").click(function() {

                var test = $(this).val();
                if (test == 'no') {
                    $(".billing_address").hide();
                    //$("#"+test).show();
                } else {
                    $(".billing_address").show();
                }

            });

            $("input[name='payment_method']").click(function() {

                var test1 = $(this).val();
                if (test1 == 'apple_pay') {
                    $(".credit_card").hide();
                    //$("#"+test).show();
                } else {
                    $(".credit_card").show();
                }

            });

            var country = ['AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IS', 'IE', 'IT', 'LV', 'LI', 'LT', 'LU', 'MT', 'MC', 'NL', 'NO', 'PL', 'PT', 'RO', 'SK', 'ES', 'SE', 'CH'];

            $('.ship_country').change(function() {
                var shipping_country = $('.ship_country option:selected').attr('code');
                $('#contact_form').find('#shipping_country_code').val(shipping_country);

                var shipping_country_id = $(this).val();
                $('#contact_form').find('#shipping_country_id').val(shipping_country_id);

                setIndividualShipping(shipping_country, country);

            });

            $('.ship_country_d').change(function() {
                var shipping_country = $('.ship_country_d option:selected').attr('code');
                $('#dual_form').find('#shipping_country_code').val(shipping_country);

                var shipping_country_id = $(this).val();
                $('#dual_form').find('#shipping_country_id').val(shipping_country_id);

                setDualShipping(shipping_country, country);
            });

            $('.ship_country_g').change(function() {
                var shipping_country = $('.ship_country_g option:selected').attr('code');
                $('#gift_form').find('#shipping_country_code').val(shipping_country);

                var shipping_country_id = $(this).val();
                $('#gift_form').find('#shipping_country_id').val(shipping_country_id);

                setGiftShipping(shipping_country, country);
            });

            function setIndividualShipping(shipping_country, country) {
                if (shipping_country === 'GB') {
                    var product_id = $('#gbp_product_id').val();
                    var product_price = $('#gbp_product_price').val();
                    $('#contact_form').find('#checkout_product_id').val(product_id);
                    $('#contact_form').find('#product_price').val(product_price);
                    $('.price').text('£' + product_price);
                    $('.total_price').text('£' + product_price);
                    $('#contact_form').find('#currency').val('GBP');

                } else if (jQuery.inArray(shipping_country, country) !== -1) {
                    var product_id = $('#uk_product_id').val();
                    var product_price = $('#uk_product_price').val();
                    $('#contact_form').find('#checkout_product_id').val(product_id);
                    $('#contact_form').find('#product_price').val(product_price);
                    $('.price').text('€' + product_price);
                    $('.total_price').text('€' + product_price);
                    $('#contact_form').find('#currency').val('EUR');
                } else {
                    var def_product_id = $('#product_id').val();
                    var def_product_price = $('#pro_price').val();
                    $('#contact_form').find('#checkout_product_id').val(def_product_id);
                    $('#contact_form').find('#product_price').val(def_product_price);
                    $('.price').text('$' + def_product_price);
                    $('.total_price').text('$' + def_product_price);
                    $('#contact_form').find('#currency').val('USD');
                }
            }

            function setDualShipping(shipping_country, country) {
                if (shipping_country === 'GB') {
                    var product_id = $('#gbp_product_id_d').val();
                    var product_price = $('#gbp_product_price_d').val();
                    $('#dual_form').find('#checkout_product_id').val(product_id);
                    $('#dual_form').find('#product_price').val(product_price);
                    $('.price_d').text('£' + product_price);
                    $('.total_price_d').text('£' + product_price);
                    $('#dual_form').find('#currency').val('GBP');

                } else if (jQuery.inArray(shipping_country, country) !== -1) {
                    var product_id = $('#uk_product_id_d').val();
                    var product_price = $('#uk_product_price_d').val();
                    $('#dual_form').find('#checkout_product_id').val(product_id);
                    $('#dual_form').find('#product_price').val(product_price);
                    $('.price_d').text('€' + product_price);
                    $('.total_price_d').text('€' + product_price);
                    $('#dual_form').find('#currency').val('EUR');
                } else {
                    var def_product_id = $('#product_id_d').val();
                    var def_product_price = $('#pro_price_d').val();
                    $('#dual_form').find('#checkout_product_id').val(def_product_id);
                    $('#dual_form').find('#product_price').val(def_product_price);
                    $('.price_d').text('$' + def_product_price);
                    $('.total_price_d').text('$' + def_product_price);
                    $('#dual_form').find('#currency').val('USD');
                }
            }

            function setGiftShipping(shipping_country, country) {
                if (shipping_country === 'GB') {
                    var product_id = $('#gbp_product_id_g').val();
                    var product_price = $('#gbp_product_price_g').val();
                    $('#gift_form').find('#checkout_product_id').val(product_id);
                    $('#gift_form').find('#product_price').val(product_price);
                    $('.price_g').text('£' + product_price);
                    $('.total_price_g').text('£' + product_price);
                    $('#gift_form').find('#currency').val('GBP');

                } else if (jQuery.inArray(shipping_country, country) !== -1) {
                    var product_id = $('#uk_product_id_g').val();
                    var product_price = $('#uk_product_price_g').val();
                    $('#gift_form').find('#checkout_product_id').val(product_id);
                    $('#gift_form').find('#product_price').val(product_price);
                    $('.price_g').text('€' + product_price);
                    $('.total_price_g').text('€' + product_price);
                    $('#gift_form').find('#currency').val('EUR');
                } else {
                    var def_product_id = $('#product_id_g').val();
                    var def_product_price = $('#pro_price_g').val();
                    $('#gift_form').find('#checkout_product_id').val(def_product_id);
                    $('#gift_form').find('#product_price').val(def_product_price);
                    $('.price_g').text('$' + def_product_price);
                    $('.total_price_g').text('$' + def_product_price);
                    $('#gift_form').find('#currency').val('USD');
                }
            }
        });

        $(document).ready(function() {

            // Individual Membership Form Yearly and Monthly data
            $('.year').click(function() {
                var price = $(this).attr('data-value');
                var pay_name = $(this).attr('data-name');
                var uk_price_y = $(this).attr('data-uk');
                var gbp_price_y = $(this).attr('data-gbp');
                $('#pro_price').val('');
                $('#pro_price').val(price);
                $('#payment_name').val('');
                $('#payment_name').val(pay_name);
                $('#uk_product_price').val(uk_price_y);
                $('#gbp_product_price').val(gbp_price_y);
                <?php if (isset($plans)) { ?>
                    var planDetails = <?php echo json_encode($plans) ?>;
                    $('#product_name').val(planDetails.yearlyProductNameUSD);
                    $('#product_id').val(planDetails.yearlyProductIDUSD);
                    $('#price_id').val(planDetails.yearlyPlanIDUSD);
                    $('#uk_product_name').val(planDetails.yearlyProductNameEUR);
                    $('#uk_product_id').val(planDetails.yearlyProductIDEUR);
                    $('#uk_price_id').val(planDetails.yearlyPlanIDEUR);
                    $('#gbp_product_name').val(planDetails.yearlyProductName);
                    $('#gbp_product_id').val(planDetails.yearlyProductID);
                    $('#gbp_price_id').val(planDetails.yearlyPlanID);
                <?php }; ?>
                $('.ship_country').trigger('change');
            });

            $('.month').click(function() {
                var price1 = $(this).attr('data-value');
                var pay_name1 = $(this).attr('data-name');
                $('#pro_price').val();
                $('#pro_price').val(price1);
                $('#payment_name').val('');
                $('#payment_name').val(pay_name1);
                <?php if (isset($plans)) { ?>
                    var planDetails = <?php echo json_encode($plans) ?>;
                    $('#product_name').val(planDetails.monthlyProductNameUSD);
                    $('#product_id').val(planDetails.monthlyProductIDUSD);
                    $('#price_id').val(planDetails.monthlyPlanIDUSD);
                    $('#uk_product_name').val(planDetails.monthlyProductNameEUR);
                    $('#uk_product_id').val(planDetails.monthlyProductIDEUR);
                    $('#uk_product_price').val(planDetails.monthlyProductAmountEUR);
                    $('#uk_price_id').val(planDetails.monthlyPlanIDEUR);
                    $('#gbp_product_name').val(planDetails.monthlyProductName);
                    $('#gbp_product_id').val(planDetails.monthlyProductID);
                    $('#gbp_product_price').val(planDetails.monthlyProductAmount);
                    $('#gbp_price_id').val(planDetails.monthlyPlanID);
                <?php }; ?>
                $('.ship_country').trigger('change');
            });

            // Dual Membership Form Yearly and Monthly data
            $('.year_d').click(function() {
                var price = $(this).attr('data-value');
                var pay_name4 = $(this).attr('data-name');
                var uk_price_d = $(this).attr('data-uk');
                var gbp_price_d = $(this).attr('data-gbp');
                $('#pro_price_d').val('');
                $('#pro_price_d').val(price);
                $('#payment_name_d').val('');
                $('#payment_name_d').val(pay_name4);
                $('#uk_product_price_d').val(uk_price_d);
                $('#gbp_product_price_d').val(gbp_price_d);

                <?php if (isset($plans)) { ?>
                    var planDetails = <?php echo json_encode($plans) ?>;

                    $('#product_name_d').val(planDetails.yearlyProductNameDualUSD);
                    $('#product_id_d').val(planDetails.yearlyProductIDDualUSD);
                    $('#price_id_d').val(planDetails.yearlyPlanIDDualUSD);

                    $('#uk_product_name_d').val(planDetails.yearlyProductNameDualEUR);
                    $('#uk_product_id_d').val(planDetails.yearlyProductIDDualEUR);
                    $('#uk_price_id_d').val(planDetails.yearlyPlanIDDualEUR);

                    $('#gbp_product_name_d').val(planDetails.yearlyProductNameDualGBP);
                    $('#gbp_product_id_d').val(planDetails.yearlyProductIDDualGBP);
                    $('#gbp_price_id_d').val(planDetails.yearlyPlanIDDualGBP);
                <?php }; ?>
                $('.ship_country_d').trigger('change');
            });

            $('.month_d').click(function() {
                var price3 = $(this).attr('data-value');
                var pay_name5 = $(this).attr('data-name');
                $('#pro_price_d').val();
                $('#pro_price_d').val(price3);
                $('#payment_name_d').val('');
                $('#payment_name_d').val(pay_name5);
                <?php if (isset($plans)) { ?>
                    var planDetails = <?php echo json_encode($plans) ?>;
                    $('#product_name_d').val(planDetails.monthlyProductNameDualUSD);
                    $('#product_id_d').val(planDetails.monthlyProductIDDualUSD);
                    $('#price_id_d').val(planDetails.monthlyPlanIDDualUSD);
                    $('#uk_product_name_d').val(planDetails.monthlyProductNameDualEUR);
                    $('#uk_product_id_d').val(planDetails.monthlyProductIDDualEUR);
                    $('#uk_product_price_d').val(planDetails.monthlyProductAmountDualEUR);
                    $('#uk_price_id_d').val(planDetails.monthlyPlanIDDualEUR);
                    $('#gbp_product_name_d').val(planDetails.monthlyProductNameDualGBP);
                    $('#gbp_product_id_d').val(planDetails.monthlyProductIDDualGBP);
                    $('#gbp_product_price_d').val(planDetails.monthlyProductAmountDualGBP);
                    $('#gbp_price_id_d').val(planDetails.monthlyPlanIDDualGBP);
                <?php }; ?>
                $('.ship_country_d').trigger('change');
            });

            // Gift Membership Form Yearly and Monthly data

            $('.year_g').click(function() {
                var price = $(this).attr('data-value');
                var pay_name4 = $(this).attr('data-name');
                var uk_price_d = $(this).attr('data-uk');
                var gbp_price_d = $(this).attr('data-gbp');

                $('#pro_price_d').val('');
                $('#pro_price_d').val(price);
                $('#payment_name_d').val('');
                $('#payment_name_d').val(pay_name4);
                $('#uk_product_price_g').val(uk_price_d);
                $('#gbp_product_price_g').val(gbp_price_d);

                <?php if (isset($plans)) { ?>
                    var planDetails = <?php echo json_encode($plans) ?>;

                    $('#product_name_g').val(planDetails.yearlyProductNameGiftUSD);
                    $('#product_id_g').val(planDetails.yearlyProductIDGiftUSD);
                    $('#price_id_g').val(planDetails.yearlyPlanIDGiftUSD);

                    $('#uk_product_name_g').val(planDetails.yearlyProductNameGiftEUR);
                    $('#uk_product_id_g').val(planDetails.yearlyProductIDGiftEUR);
                    $('#uk_price_id_g').val(planDetails.yearlyPlanIDGiftEUR);

                    $('#gbp_product_name_g').val(planDetails.yearlyProductNameGiftGBP);
                    $('#gbp_product_id_g').val(planDetails.yearlyProductIDGiftGBP);
                    $('#gbp_price_id_g').val(planDetails.yearlyPlanIDGiftGBP);
                <?php }; ?>
                $('.ship_country_g').trigger('change');
            });
        });
    </script>
    <?php $check_coupen = URL::asset('coupen_check'); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click', "#apply", function() {

                var coupen_code = $('#promosGifts').val();
                var currency = $('#currency').val();



                $.ajax({
                    type: 'POST',
                    url: "<?php echo $check_coupen ?>",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'coupen_code': coupen_code,
                        'currency': currency
                    },
                    success: function(data) {
                        if (data.status == true) {
                            if (data.percentage != null || data.percentage != "") {

                                $('#error_msg').css('display', 'none');
                                $("#success_msg").css('display', 'block');
                                $("#success_msg").text(data.message);
                                var total = $('#product_price').val();
                                var percentage = data.percentage;
                                var discount = ((total * percentage) / 100);
                                var total_price = (total - discount);
                                if (data.type == "GBP") {
                                    $('#discount_name').css('display', 'block');
                                    $('#disc_amount').text("£" + discount);
                                    $('#disc_amount').css('display', 'inline-block');
                                    $('.total_price').text("£" + total_price);
                                } else if (data.type == "EUR") {
                                    $('#discount_name').css('display', 'block');
                                    $('#disc_amount').text("€" + discount);
                                    $('#disc_amount').css('display', 'inline-block');
                                    $('.total_price').text("€" + total_price);
                                } else {
                                    $('#discount_name').css('display', 'block');
                                    $('#disc_amount').text("$" + discount);
                                    $('#disc_amount').css('display', 'inline-block');
                                    $('.total_price').text("$" + total_price);
                                }
                            } else {
                                $('#error_msg').css('display', 'none');
                                $("#success_msg").css('display', 'block');
                                $("#success_msg").text(data.message);
                                var total = $('#product_price').val();
                                var percentage = data.percentage;
                                var discount_amt = (data.amount / 100);
                                var total_price = ((total - $discount_amt));
                                //   var total_price = (total - discount);
                                if (data.type == "GBP") {
                                    $('#discount_name').css('display', 'block');
                                    $('#disc_amount').text("£" + discount_amt);
                                    $('#disc_amount').css('display', 'inline-block');

                                    $('.total_price').text("£" + total_price);
                                } else if (data.type == "EUR") {
                                    $('#discount_name').css('display', 'block');
                                    $('#disc_amount').text("€" + discount_amt);
                                    $('#disc_amount').css('display', 'inline-block');

                                    $('.total_price').text("€" + total_price);
                                } else {
                                    $('#discount_name').css('display', 'block');
                                    $('#disc_amount').text("$" + discount_amt);
                                    $('#disc_amount').css('display', 'inline-block');

                                    $('.total_price').text("$" + total_price);
                                }
                            }

                            //alert(total_price);
                            //alert(data.message['coupon']['percentage']);
                            // $('#error_msg').css('display','block');
                            // $('#error_msg').html(data.message);



                        } else {
                            // alert(data.message);
                            $("#success_msg").css('display', 'none');
                            $('#error_msg').css('display', 'block');
                            $('#error_msg').html(data.message);
                        }


                    }
                });
            });
        });
    </script>
    </script>


    <script type="text/javascript">
        $('#contact_form').one('submit', function() {
            $(this).find('input[type="submit"]').attr('disabled', 'disabled');
        });

        $('#dual_form').one('submit', function() {
            $(this).find('input[type="submit"]').attr('disabled', 'disabled');
        });

        $('#gift_form').one('submit', function() {
            $(this).find('input[type="submit"]').attr('disabled', 'disabled');
        });

        $('#checkout_form').one('submit', function() {
            $(this).find('input[type="submit"]').attr('disabled', 'disabled');
        });
    </script>


    <script type="text/javascript">
        $(function() {
            $("#expiry").on("blur", function() {
                if (isMMSlashYYYY(this.value) == false) {
                    $('.exp_error_msg').show();
                } else {
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
    @stack('front-scripts')
</body>

</html>
