<?php

use Illuminate\Support\Facades\Config;

/**
 * Get the curl response for the create campaign member API.
 *
 * @param string $data
 * @param string $token
 * @param string $url
 * @return object
 */
function curlResponse($data, $token, $url, $curlHttpHeader)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $data,
		CURLOPT_HTTPHEADER => array(
			$token,
			'Content-Type: application/json',
			'Cookie: BrowserId=' . $curlHttpHeader
		),
	));

	return $curl;
}

/**
 * Get the curl response to generate the autorized token.
 *
 * @param string $data
 * @param string $token
 * @param string $url
 * @return object
 */
function curlResponseForAuthorizedToken($url)
{

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
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

	return $curl;
}

/**
 * Get the USD, GBP & EUR Stripe plans as per the price id using stripe secret key.
 *
 * @param string $key
 * @return array
 */
function getThePlans($key)
{
	$stripe = new \Stripe\StripeClient($key);

	$plansArrayUSD = [];
	$plansArrayEUR = [];
	$plansArrayGBP = [];
	$plansArrayLocalUSD = [];

	// USD Plans
	if ($key == Config::get('services.stripe.secret')) {
		$annualPlansLocalUSD = $stripe->plans->retrieve(
			Config::get('constants.local_usd_annual_price_id'),
		);

		$monthlyPlansLocalUSD = $stripe->plans->retrieve(
			Config::get('constants.local_usd_monthly_price_id'),
		);

		$plansArrayLocalUSD['yearlyProductNameLocalUSD'] = 'Enthusiast - Annual';
		$plansArrayLocalUSD['yearlyProductIDLocalUSD'] = $annualPlansLocalUSD->product;
		$plansArrayLocalUSD['yearlyPlanIDLocalUSD'] = $annualPlansLocalUSD->id;
		$plansArrayLocalUSD['yearlyProductAmountLocalUSD'] = ($annualPlansLocalUSD->amount / 100);
		$plansArrayLocalUSD['yearlycProductCurrencyLocalUSD'] = $annualPlansLocalUSD->currency;
		$plansArrayLocalUSD['yearlyProductIntervalLocalUSD'] = $annualPlansLocalUSD->interval;
		$plansArrayLocalUSD['monthlyProductNameLocalUSD'] = 'Enthusiast - Monthly';
		$plansArrayLocalUSD['monthlyProductIDLocalUSD'] = $monthlyPlansLocalUSD->product;
		$plansArrayLocalUSD['monthlyPlanIDLocalUSD'] = $monthlyPlansLocalUSD->id;
		$plansArrayLocalUSD['monthlyProductAmountLocalUSD'] = ($monthlyPlansLocalUSD->amount / 100);
		$plansArrayLocalUSD['monthlyProductCurrencyLocalUSD'] = $monthlyPlansLocalUSD->currency;
		$plansArrayLocalUSD['monthlyProductIntervalLocalUSD'] = $monthlyPlansLocalUSD->interval;
	} else if ($key == Config::get('services.stripe.USD_secret')) {
		$annualPlansUSD = $stripe->plans->retrieve(
			Config::get('constants.usd_annual_price_id'),
		);

		$monthlyPlansUSD = $stripe->plans->retrieve(
			Config::get('constants.usd_monthly_price_id'),
		);

		$plansArrayUSD['yearlyProductNameUSD'] = $annualPlansUSD->name;
		$plansArrayUSD['yearlyProductIDUSD'] = $annualPlansUSD->product;
		$plansArrayUSD['yearlyPlanIDUSD'] = $annualPlansUSD->id;
		$plansArrayUSD['yearlyProductAmountUSD'] = ($annualPlansUSD->amount / 100);
		$plansArrayUSD['yearlycProductCurrencyUSD'] = $annualPlansUSD->currency;
		$plansArrayUSD['yearlyProductIntervalUSD'] = $annualPlansUSD->interval;
		$plansArrayUSD['monthlyProductNameUSD'] = $monthlyPlansUSD->name;
		$plansArrayUSD['monthlyProductIDUSD'] = $monthlyPlansUSD->product;
		$plansArrayUSD['monthlyPlanIDUSD'] = $monthlyPlansUSD->id;
		$plansArrayUSD['monthlyProductAmountUSD'] = ($monthlyPlansUSD->amount / 100);
		$plansArrayUSD['monthlyProductCurrencyUSD'] = $monthlyPlansUSD->currency;
		$plansArrayUSD['monthlyProductIntervalUSD'] = $monthlyPlansUSD->interval;
	} else {
		$annualPlansEUR = $stripe->plans->retrieve(
			Config::get('constants.eur_annual_price_id'),
		);
		$monthlyPlansEUR = $stripe->plans->retrieve(
			Config::get('constants.eur_monthly_price_id'),
		);

		$annualPlansGBP = $stripe->plans->retrieve(
			Config::get('constants.gbp_annual_price_id'),
		);
		$monthlyPlansGBP = $stripe->plans->retrieve(
			Config::get('constants.gbp_monthly_price_id'),
		);

		$plansArrayEUR['yearlyProductNameEUR'] = $annualPlansEUR->name;
		$plansArrayEUR['yearlyProductIDEUR'] = $annualPlansEUR->product;
		$plansArrayEUR['yearlyPlanIDEUR'] = $annualPlansEUR->id;
		$plansArrayEUR['yearlyProductAmountEUR'] = ($annualPlansEUR->amount / 100);
		//$plansArrayEUR['yearlyProductAmountEUR'] = ($annualPlansEUR->amount);
		$plansArrayEUR['yearlycProductCurrencyEUR'] = $annualPlansEUR->currency;
		$plansArrayEUR['yearlyProductIntervalEUR'] = $annualPlansEUR->interval;
		$plansArrayEUR['monthlyProductNameEUR'] = $monthlyPlansEUR->name;
		$plansArrayEUR['monthlyProductIDEUR'] = $monthlyPlansEUR->product;
		$plansArrayEUR['monthlyPlanIDEUR'] = $monthlyPlansEUR->id;
		$plansArrayEUR['monthlyProductAmountEUR'] = ($monthlyPlansEUR->amount / 100);
		//$plansArrayEUR['monthlyProductAmountEUR'] = ($monthlyPlansEUR->amount);
		$plansArrayEUR['monthlyProductCurrencyEUR'] = $monthlyPlansEUR->currency;
		$plansArrayEUR['monthlyProductIntervalEUR'] = $monthlyPlansEUR->interval;

		$plansArrayGBP['yearlyProductName'] = $annualPlansGBP->name;
		$plansArrayGBP['yearlyProductID'] = $annualPlansGBP->product;
		$plansArrayGBP['yearlyPlanID'] = $annualPlansGBP->id;
		$plansArrayGBP['yearlyProductAmount'] = ($annualPlansGBP->amount / 100);
		//$plansArrayGBP['yearlyProductAmount'] = ($annualPlansGBP->amount);
		$plansArrayGBP['yearlycProductCurrency'] = $annualPlansGBP->currency;
		$plansArrayGBP['yearlyProductInterval'] = $annualPlansGBP->interval;
		$plansArrayGBP['monthlyProductName'] = $monthlyPlansGBP->name;
		$plansArrayGBP['monthlyProductID'] = $monthlyPlansGBP->product;
		$plansArrayGBP['monthlyPlanID'] = $monthlyPlansGBP->id;
		$plansArrayGBP['monthlyProductAmount'] = ($monthlyPlansGBP->amount / 100);
		//$plansArrayGBP['monthlyProductAmount'] = ($monthlyPlansGBP->amount);
		$plansArrayGBP['monthlyProductCurrency'] = $monthlyPlansGBP->currency;
		$plansArrayGBP['monthlyProductInterval'] = $monthlyPlansGBP->interval;
	}


	$plans = array_merge($plansArrayLocalUSD, $plansArrayUSD, $plansArrayEUR, $plansArrayGBP);

	return $plans;
}
