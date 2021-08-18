Stripe.setPublishableKey('pk_test_RPrUGJLNCHVrZYDVLKp5TVJe');

Stripe.applePay.checkAvailability(function(available) {
  if (available) {
    document.getElementById('apple-pay-button').style.display = 'block';
    console.log(‘hi, I can do ApplePay’);
  }
});

document.getElementById('apple-pay-button').addEventListener('click', beginApplePay);

var price =”{{$data['product_price']}}”;
 var id =”{{($product->id) }}”;
 var url = "{{$data['url']}}";

function beginApplePay() {
  var paymentRequest = {
    countryCode: 'US',
    currencyCode: 'USD',
    total: {
      label: 'Rocketship Inc',
      amount: '19.99'
    }
  };
  var session = Stripe.applePay.buildSession(paymentRequest,
    function(result, completion) {

    $.post(url, { token: result.token.id }).done(function() {
      completion(ApplePaySession.STATUS_SUCCESS);
      // You can now redirect the user to a receipt page, etc.
      window.location.href = '/success';
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
