<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class customer extends Model
{
    use Billable;

    public $table = 'customer';
}
