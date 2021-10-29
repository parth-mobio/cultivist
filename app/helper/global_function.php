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

    // USD Plans
    // if ($key == Config::get('services.stripe.secret')) {
    // 	$annualPlansLocalUSD = $stripe->plans->retrieve(
    // 		Config::get('constants.local_usd_annual_price_id'),
    // 	);

    // 	$monthlyPlansLocalUSD = $stripe->plans->retrieve(
    // 		Config::get('constants.local_usd_monthly_price_id'),
    // 	);

    // 	$plansArrayLocalUSD['yearlyProductNameLocalUSD'] = 'Enthusiast - Annual';
    // 	$plansArrayLocalUSD['yearlyProductIDLocalUSD'] = $annualPlansLocalUSD->product;
    // 	$plansArrayLocalUSD['yearlyPlanIDLocalUSD'] = $annualPlansLocalUSD->id;
    // 	$plansArrayLocalUSD['yearlyProductAmountLocalUSD'] = ($annualPlansLocalUSD->amount / 100);
    // 	$plansArrayLocalUSD['yearlycProductCurrencyLocalUSD'] = $annualPlansLocalUSD->currency;
    // 	$plansArrayLocalUSD['yearlyProductIntervalLocalUSD'] = $annualPlansLocalUSD->interval;
    // 	$plansArrayLocalUSD['monthlyProductNameLocalUSD'] = 'Enthusiast - Monthly';
    // 	$plansArrayLocalUSD['monthlyProductIDLocalUSD'] = $monthlyPlansLocalUSD->product;
    // 	$plansArrayLocalUSD['monthlyPlanIDLocalUSD'] = $monthlyPlansLocalUSD->id;
    // 	$plansArrayLocalUSD['monthlyProductAmountLocalUSD'] = ($monthlyPlansLocalUSD->amount / 100);
    // 	$plansArrayLocalUSD['monthlyProductCurrencyLocalUSD'] = $monthlyPlansLocalUSD->currency;
    // 	$plansArrayLocalUSD['monthlyProductIntervalLocalUSD'] = $monthlyPlansLocalUSD->interval;
    // }

    if ($key == Config::get('services.stripe.USD_secret')) {

        // individual annual plans
        $UsdIndividualAnnualPlans = $stripe->plans->retrieve(
                Config::get('constants.usd_annual_price_id'),
            );

        $plansArrayUSD['yearlyProductNameUSD'] = $UsdIndividualAnnualPlans->name;
        $plansArrayUSD['yearlyProductIDUSD'] = $UsdIndividualAnnualPlans->product;
        $plansArrayUSD['yearlyPlanIDUSD'] = $UsdIndividualAnnualPlans->id;
        $plansArrayUSD['yearlyProductAmountUSD'] = ($UsdIndividualAnnualPlans->amount / 100);
        $plansArrayUSD['yearlyProductCurrencyUSD'] = $UsdIndividualAnnualPlans->currency;
        $plansArrayUSD['yearlyProductIntervalUSD'] = $UsdIndividualAnnualPlans->interval;

        // individual monthly plans
        $UsdIndividualMonthlyPlans = $stripe->plans->retrieve(
            Config::get('constants.usd_monthly_price_id'),
        );
        $plansArrayUSD['monthlyProductNameUSD'] = $UsdIndividualMonthlyPlans->name;
        $plansArrayUSD['monthlyProductIDUSD'] = $UsdIndividualMonthlyPlans->product;
        $plansArrayUSD['monthlyPlanIDUSD'] = $UsdIndividualMonthlyPlans->id;
        $plansArrayUSD['monthlyProductAmountUSD'] = ($UsdIndividualMonthlyPlans->amount / 100);
        $plansArrayUSD['monthlyProductCurrencyUSD'] = $UsdIndividualMonthlyPlans->currency;
        $plansArrayUSD['monthlyProductIntervalUSD'] = $UsdIndividualMonthlyPlans->interval;

        // dual monthly plans
        $UsdDualMonthlyPlans = $stripe->plans->retrieve(
            Config::get('constants.usd_monthly_price_id_dual'),
        );
        $plansArrayUSD['monthlyProductNameDualUSD'] = $UsdDualMonthlyPlans->name;
        $plansArrayUSD['monthlyProductIDDualUSD'] = $UsdDualMonthlyPlans->product;
        $plansArrayUSD['monthlyPlanIDDualUSD'] = $UsdDualMonthlyPlans->id;
        $plansArrayUSD['monthlyProductAmountDualUSD'] = ($UsdDualMonthlyPlans->amount / 100);
        $plansArrayUSD['monthlyProductCurrencyDualUSD'] = $UsdDualMonthlyPlans->currency;
        $plansArrayUSD['monthlyProductIntervalDualUSD'] = $UsdDualMonthlyPlans->interval;

        // dual annual plans
        $UsdDualAnnualPlans = $stripe->plans->retrieve(
            Config::get('constants.usd_annual_price_id_dual'),
        );
        $plansArrayUSD['yearlyProductNameDualUSD'] = $UsdDualAnnualPlans->name;
        $plansArrayUSD['yearlyProductIDDualUSD'] = $UsdDualAnnualPlans->product;
        $plansArrayUSD['yearlyPlanIDDualUSD'] = $UsdDualAnnualPlans->id;
        $plansArrayUSD['yearlyProductAmountDualUSD'] = ($UsdDualAnnualPlans->amount / 100);
        $plansArrayUSD['yearlyProductCurrencyDualUSD'] = $UsdDualAnnualPlans->currency;
        $plansArrayUSD['yearlyProductIntervalDualUSD'] = $UsdDualAnnualPlans->interval;

        return $plansArrayUSD;
    } else {

        // individual annual plans for EUR
        $EurIndividualAnnualPlans = $stripe->plans->retrieve(
            Config::get('constants.eur_annual_price_id'),
        );
        $plansArrayEUR['yearlyProductNameEUR'] = $EurIndividualAnnualPlans->name;
        $plansArrayEUR['yearlyProductIDEUR'] = $EurIndividualAnnualPlans->product;
        $plansArrayEUR['yearlyPlanIDEUR'] = $EurIndividualAnnualPlans->id;
        $plansArrayEUR['yearlyProductAmountEUR'] = ($EurIndividualAnnualPlans->amount / 100);
        $plansArrayEUR['yearlycProductCurrencyEUR'] = $EurIndividualAnnualPlans->currency;
        $plansArrayEUR['yearlyProductIntervalEUR'] = $EurIndividualAnnualPlans->interval;

        // individual monthly plans of EUR
        $UsdIndividualMonthlyPlans = $stripe->plans->retrieve(
            Config::get('constants.eur_monthly_price_id'),
        );
        $plansArrayEUR['monthlyProductNameEUR'] = $UsdIndividualMonthlyPlans->name;
        $plansArrayEUR['monthlyProductIDEUR'] = $UsdIndividualMonthlyPlans->product;
        $plansArrayEUR['monthlyPlanIDEUR'] = $UsdIndividualMonthlyPlans->id;
        $plansArrayEUR['monthlyProductAmountEUR'] = ($UsdIndividualMonthlyPlans->amount / 100);
        $plansArrayEUR['monthlyProductCurrencyEUR'] = $UsdIndividualMonthlyPlans->currency;
        $plansArrayEUR['monthlyProductIntervalEUR'] = $UsdIndividualMonthlyPlans->interval;

        // dual monthly plans of EUR
        $EurDualMonthlyPlans = $stripe->plans->retrieve(
            Config::get('constants.eur_monthly_price_id_dual'),
        );
        $plansArrayEUR['monthlyProductNameDualEUR'] = $EurDualMonthlyPlans->name;
        $plansArrayEUR['monthlyProductIDDualEUR'] = $EurDualMonthlyPlans->product;
        $plansArrayEUR['monthlyPlanIDDualEUR'] = $EurDualMonthlyPlans->id;
        $plansArrayEUR['monthlyProductAmountDualEUR'] = ($EurDualMonthlyPlans->amount / 100);
        $plansArrayEUR['monthlyProductCurrencyDualEUR'] = $EurDualMonthlyPlans->currency;
        $plansArrayEUR['monthlyProductIntervalDualEUR'] = $EurDualMonthlyPlans->interval;

        // dual annual plans of EUR
        $EurDualAnnualPlans = $stripe->plans->retrieve(
            Config::get('constants.eur_annual_price_id_dual'),
        );
        $plansArrayEUR['yearlyProductNameDualEUR'] = $EurDualAnnualPlans->name;
        $plansArrayEUR['yearlyProductIDDualEUR'] = $EurDualAnnualPlans->product;
        $plansArrayEUR['yearlyPlanIDDualEUR'] = $EurDualAnnualPlans->id;
        $plansArrayEUR['yearlyProductAmountDualEUR'] = ($EurDualAnnualPlans->amount / 100);
        $plansArrayEUR['yearlyProductCurrencyDualEUR'] = $EurDualAnnualPlans->currency;
        $plansArrayEUR['yearlyProductIntervalDualEUR'] = $EurDualAnnualPlans->interval;

        // individual annual plans for GBP
        $GbpIndividualAnnualPlans = $stripe->plans->retrieve(
            Config::get('constants.gbp_annual_price_id'),
        );
        $plansArrayGBP['yearlyProductName'] = $GbpIndividualAnnualPlans->name;
        $plansArrayGBP['yearlyProductID'] = $GbpIndividualAnnualPlans->product;
        $plansArrayGBP['yearlyPlanID'] = $GbpIndividualAnnualPlans->id;
        $plansArrayGBP['yearlyProductAmount'] = ($GbpIndividualAnnualPlans->amount / 100);
        $plansArrayGBP['yearlycProductCurrency'] = $GbpIndividualAnnualPlans->currency;
        $plansArrayGBP['yearlyProductInterval'] = $GbpIndividualAnnualPlans->interval;

        // individual monthly plans for GBP
        $GbpIndividualMonthlyPlans = $stripe->plans->retrieve(
            Config::get('constants.gbp_monthly_price_id'),
        );
        $plansArrayGBP['monthlyProductName'] = $GbpIndividualMonthlyPlans->name;
        $plansArrayGBP['monthlyProductID'] = $GbpIndividualMonthlyPlans->product;
        $plansArrayGBP['monthlyPlanID'] = $GbpIndividualMonthlyPlans->id;
        $plansArrayGBP['monthlyProductAmount'] = ($GbpIndividualMonthlyPlans->amount / 100);
        $plansArrayGBP['monthlyProductCurrency'] = $GbpIndividualMonthlyPlans->currency;
        $plansArrayGBP['monthlyProductInterval'] = $GbpIndividualMonthlyPlans->interval;

        // dual monthly plans for GBP
        $GBPDualMonthlyPlans = $stripe->plans->retrieve(
            Config::get('constants.gbp_monthly_price_id_dual'),
        );
        $plansArrayGBP['monthlyProductNameDualGBP'] = $GBPDualMonthlyPlans->name;
        $plansArrayGBP['monthlyProductIDDualGBP'] = $GBPDualMonthlyPlans->product;
        $plansArrayGBP['monthlyPlanIDDualGBP'] = $GBPDualMonthlyPlans->id;
        $plansArrayGBP['monthlyProductAmountDualGBP'] = ($GBPDualMonthlyPlans->amount / 100);
        $plansArrayGBP['monthlyProductCurrencyDualGBP'] = $GBPDualMonthlyPlans->currency;
        $plansArrayGBP['monthlyProductIntervalDualGBP'] = $GBPDualMonthlyPlans->interval;

        // dual annual plans for GBP
        $GbpDualAnnualPlans = $stripe->plans->retrieve(
            Config::get('constants.gbp_annual_price_id_dual'),
        );
        $plansArrayGBP['yearlyProductNameDualGBP'] = $GbpDualAnnualPlans->name;
        $plansArrayGBP['yearlyProductIDDualGBP'] = $GbpDualAnnualPlans->product;
        $plansArrayGBP['yearlyPlanIDDualGBP'] = $GbpDualAnnualPlans->id;
        $plansArrayGBP['yearlyProductAmountDualGBP'] = ($GbpDualAnnualPlans->amount / 100);
        $plansArrayGBP['yearlyProductCurrencyDualGBP'] = $GbpDualAnnualPlans->currency;
        $plansArrayGBP['yearlyProductIntervalDualGBP'] = $GbpDualAnnualPlans->interval;

        return array_merge($plansArrayEUR, $plansArrayGBP);
    }
}

/**
 * This will return the env i.e. local or production
 *
 * @return void
 * @author nehalk
 */
function getAppEnvironment()
{
    return Config::get('constants.app_env');
}
