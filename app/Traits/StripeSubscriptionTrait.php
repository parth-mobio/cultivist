<?php

namespace App\Traits;

use App\customer;

trait StripeSubscriptionTrait
{

    /**
     * This will create the subscription and customer in stripe
     *
     * @param string $paymentMethod
     * @param string $email
     * @param string $priceId
     * @return array
     */
    public function createStripeSubscription($paymentMethod, $email, $priceId, $options = [])
    {
        $customerData = customer::select('id')->where('email', $email)->get()->toArray();
        $customer = customer::find($customerData[0]['id']);
        $customer->createOrGetStripeCustomer(array_merge(['email' => $email], $options));
        $customer->addPaymentMethod($paymentMethod);
        $subscriptionResponse =  $customer->newSubscription('default', $priceId)->create($paymentMethod);

        return ['subscription_response' => $subscriptionResponse, 'customer_id' => $customer->id];
    }

    /**
     * This will update the customer on stripe platform
     *
     * @param int $customerId
     * @param array $data
     *
     * @return void
     */
    public function updateStripeCustomerData($customerId, $data)
    {
        $customer = customer::find($customerId);
        $stripeCustomer = $customer->updateStripeCustomer($data);
        return $stripeCustomer;
    }

    /**
     * This will prepare the customer data for stripe
     * @param request $request
     *
     * @return array
     */
    public function prepareDataToUpdate($request)
    {
        return [
            'address' => [
                'city' => $request->billing_city == null ? $request->shipping_city : $request->billing_city,
                'country' => $request->billing_country_name == null ? $request->shipping_country_name : $request->billing_country_name,
                'line1' => $request->billing_address == null ? $request->shipping_address : $request->billing_address,
                'postal_code' => $request->billing_zipcode == null ? $request->shipping_zipcode : $request->billing_zipcode,
                'state' => $request->billing_state == null ? $request->shipping_state : $request->billing_state,
            ],
            'name' => $request->first_name . ' ' . $request->last_name,
            'phone' => $request->phone_number,
            'shipping' => [
                'address' => [
                    'city' => $request->shipping_city,
                    'country' => $request->shipping_country_name,
                    'line1' => $request->shipping_address,
                    'postal_code' => $request->shipping_zipcode,
                    'state' => $request->shipping_state
                ],
                'name' => $request->first_name . ' ' . $request->last_name
            ]
        ];
    }
}
