<?php

namespace App\Traits;

trait SalesForceApiTrait
{
    /**
     * This will generate the salesforce auth token
     * @param string $tokenUrl
     * @param string $clientId
     * @param string $clientSecret
     * @param string $username
     * @param string $password
     * @param string $securityToken
     * @return string
     *
     * @author nehalk
     */
    public function getSalesForceAuthToken($tokenUrl, $clientId, $clientSecret, $username, $password, $token = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $tokenUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&client_id=' . $clientId . '&client_secret=' . $clientSecret . '&username=' . $username . '&password=' . $password . $token,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw; CookieConsentPolicy=0:0'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return 'Authorization: Bearer ' . $response['access_token'];
    }

    /**
     * This will generate the lead
     * @param string $authToken
     * @param string $baseUrl
     * @param string $leadData
     *
     * @return array
     *
     * @author nehalk
     */
    public function  generateSalesForceLead($authToken, $baseUrl, $leadData)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl . 'createlead',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $leadData,
            CURLOPT_HTTPHEADER => array(
                $authToken,
                'Content-Type: application/json',
                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
            ),
        ));

        $lead_response = curl_exec($curl);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $lead_response;

        return ['lead_data' => json_decode($lead_response, true), 'http_status' => $http_status];
    }

    /**
     * This will create the member in salesforce
     *
     * @param string $authToken
     * @param string $baseUrl
     * @param string $lead_response
     *
     * @return array
     *
     * @author nehalk
     */
    public function  createMember($authToken, $baseUrl, $lead_response)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl . 'createmember',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $lead_response,
            CURLOPT_HTTPHEADER => array(
                $authToken,
                'Content-Type: application/json',
                'Cookie: BrowserId=bPUO05dxEeusWeWw8fMlDw'
            ),
        ));

        $lead_response = curl_exec($curl);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $lead_response;

        return ['lead_data' => json_decode($lead_response, true), 'http_status' => $http_status];
    }
}
