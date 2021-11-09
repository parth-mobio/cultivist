<?php

namespace App\Traits;

use App\customer;
use Throwable;

trait CustomerTrait
{
    /**
     * This will update the customer
     *
     * @param int $customerId
     * @param array $data
     *
     * @return void
     */
    public function updateCustomerData($customerId, $data)
    {
        $customer = new customer();
        $customer->where(['id' => $customerId])->update($data);
    }
}
