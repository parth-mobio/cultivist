<?php

namespace App\Http\Controllers;

use App\customer;
use App\WebhookResponse;
use Illuminate\Http\Request;
use App\Traits\SalesForceApiTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{

    use SalesForceApiTrait;

    public $appEnvironment;
    public $salesForceUsername;
    public $salesForcePassword;
    public $salesForceClientId;
    public $salesForceClientSecret;
    public $salesForceBaseUrl;
    public $salesForceToken;
    public $salesForceTokenUrl;

    public function __construct()
    {
        $this->appEnvironment = getAppEnvironment() == 'production' ? 'production' : 'sandbox';
        $this->salesForceUsername = getSalesForceUsername($this->appEnvironment);
        $this->salesForcePassword = getSalesForcePassword($this->appEnvironment);
        $this->salesForceClientId = getSalesForceClientId($this->appEnvironment);
        $this->salesForceClientSecret = getSalesForceClientSecret($this->appEnvironment);
        $this->salesForceBaseUrl = getSalesForceBaseUrl($this->appEnvironment);
        $this->salesForceToken = getSalesForceToken($this->appEnvironment);
        $this->salesForceTokenUrl = getSalesForceTokenUrl($this->appEnvironment);
    }

    /**
     * Handle incoming webhooks from Stripe.
     *
     * @param Request $request
     * @return void
     */
    public function handleWebhook(Request $request)
    {
        $endpoint_secret = 'whsec_...'; // get this keys from lizzie

        $webhookResponse = @file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $webhookResponseDecoded = json_decode($webhookResponse, true);
        $eventType = $webhookResponseDecoded['object'];
        try {

            $event = \Stripe\Webhook::constructEvent(
                $webhookResponse,
                $sigHeader,
                $endpoint_secret
            );

            // Handle the event
            switch ($event->type) {
                case 'invoice.payment_succeeded':
                    $payload = json_decode($event->data->object, true);
                    if (isset($payload['billing_reason']) && $payload['billing_reason'] == 'subscription_cycle') {
                        $this->handleInvoicePaymentSucceed($event->type, $webhookResponse, $payload);
                    }
                    break;

                default:
                    echo 'Received unknown event type ' . $event->type;
            }

            return true;
        } catch (\Throwable $e) {

            // store the response in the table
            $storeWebHookResponse = new WebhookResponse();
            $storeWebHookResponse->customer_id = 1;
            $storeWebHookResponse->response = $webhookResponse;
            $storeWebHookResponse->webhook_event = $eventType;
            $storeWebHookResponse->created_by = 1;
            $storeWebHookResponse->last_modified_by = 1;
            $storeWebHookResponse->created_date = date('Y-m-d H:i:s');
            $storeWebHookResponse->last_modified_date = date('Y-m-d H:i:s');
            $storeWebHookResponse->error_response = json_encode([
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            $storeWebHookResponse->save();

            Log::error($e->getMessage() . " in file: " . $e->getFile() . " at Line No: " . $e->getLine());

            throw $e;
        }
    }

    /**
     * This will have the invoice payment success response
     *
     * @param string $eventType
     * @param object $webhookResponse
     * @param array $payload
     * @return void
     */
    public function handleInvoicePaymentSucceed($eventType, $webhookResponse, $payload)
    {
        // get the customer detail
        $customerDetail = customer::select('id')->where('email', $payload['customer_email'])->get()->first();
        if (!empty($customerDetail)) {
            $customerDetail = $customerDetail->toArray();
            $customerId = $customerDetail['id'];
        }

        // store the response in the table
        $storeWebHookResponse = new WebhookResponse();
        $storeWebHookResponse->customer_id = $customerId;
        $storeWebHookResponse->response = $webhookResponse;
        $storeWebHookResponse->webhook_event = $eventType;
        $storeWebHookResponse->created_by = 1;
        $storeWebHookResponse->last_modified_by = 1;
        $storeWebHookResponse->created_date = date('Y-m-d H:i:s');
        $storeWebHookResponse->last_modified_date = date('Y-m-d H:i:s');
        $storeWebHookResponse->save();
        $storeWebHookResponseId = $storeWebHookResponse->id;

        // generate the token
        $token = getSalesForceToken($this->appEnvironment);

        // call the update stripe api
        $leadDataToUpdate = [
            'email' => $payload['customer_email'],
            'stripeId' => $payload['subscription']['customer']['id'],
            'lastPaymentDate' => date('Y-m-d H:i:s', strtotime($payload['created'])),
            'membershipExpiryDate' => date('Y-m-d H:i:s', strtotime($payload['period_end'])),
            'cardValidThroughDate' => date('Y-m-d H:i:s', strtotime($payload['period_end'])),
            'paymentStatus' => Config::get("constants.payment_status.payment_success")
        ];

        $leadUpdatedData = $this->generateSalesForceLead($token, $this->salesForceBaseUrl, $leadDataToUpdate);

        WebhookResponse::where('id', $storeWebHookResponseId)->update(['sf_response' => json_encode($leadUpdatedData)]);
    }
}
