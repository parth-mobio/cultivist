<?php
// constants.php file returd default configuration setting.
return [
    'status_error_code' => 400,
    'base_URL' => 'https://thecultivist--kandisa21.my.salesforce.com/services/apexrest/',
    'create_lead_API_name'=> 'createlead',
    'authorized_token_URL' => 'https://thecultivist--kandisa21.my.salesforce.com/services/oauth2/token',
    'usd_annual_price_id'=>'plan_Go7csmSqtUz9QH',
    'usd_monthly_price_id'=>'price_1JnNqxDMBMll2GWqikXoKIXX',
    'eur_annual_price_id'=>'price_1J7o4YG3kTPNIyeJ2kXavK8E',
    'eur_monthly_price_id'=>'price_1Jn82sG3kTPNIyeJ7vEzVxgz',
    'gbp_annual_price_id'=>'price_1J7o3jG3kTPNIyeJqj4teox4',
    'gbp_monthly_price_id'=>'price_1Jn82MG3kTPNIyeJJkqk3m9Z',
    'eur_monthly_price_id_dual' => 'price_1JpXvZG3kTPNIyeJHO9xIsYO',
    'eur_annual_price_id_dual' => 'price_1JpXwsG3kTPNIyeJ85eKoaqI',
    'gbp_monthly_price_id_dual' => 'price_1JpXxrG3kTPNIyeJEYS0KB7r',
    'gbp_annual_price_id_dual' => 'price_1JpXxQG3kTPNIyeJpKedKKZY',
    'usd_monthly_price_id_dual' => 'price_1JpXtMDMBMll2GWqVLO0Geqg',
    'usd_annual_price_id_dual' => 'price_1JpXstDMBMll2GWqemyC34Up',
    'curlopt_httpheader' => [
        'gift_browser_id' => 'tdG2nKgDEeu56Q1Yr4wGvQ',
        'individual_dual_browser_id' => 'bPUO05dxEeusWeWw8fMlDw',
    ],
    'app_env' => env('APP_ENV')
];

?>
