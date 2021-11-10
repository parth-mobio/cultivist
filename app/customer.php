<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Config;

class customer extends Model
{
    use Notifiable, Billable;

    public $table = 'customer';

    public function country()
    {
        return $this->hasOne(Country::class);
    }

    public function stripeOptions(array $options = [])
    {
        if (!is_null($this->country_val)) {

            // Get country specific cashier key
            $config = Config::get('billing.stripe');

            if (in_array($this->country_val, Config::get('constants.gbp_countries'))) {
                // Update cashier's config
                config(['cashier.key' => $config['eur']['key']]);
                config(['cashier.secret' => $config['eur']['secret']]);
                // config(['cashier.currency' => $config['eur']['currency']]);
            } else if (in_array($this->country_val, Config::get('constants.eur_countries'))) {
                // Update cashier's config
                config(['cashier.key' => $config['gb']['key']]);
                config(['cashier.secret' => $config['gb']['secret']]);
                // config(['cashier.currency' => $config['gb']['currency']]);
            } else {
                // Update cashier's config
                config(['cashier.key' => $config['us']['key']]);
                config(['cashier.secret' => $config['us']['secret']]);
                // config(['cashier.currency' => $config['us']['currency']]);
            }
        }

        // use default config
        return Cashier::stripeOptions($options);
    }
}
