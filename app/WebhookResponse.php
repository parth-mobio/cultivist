<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebhookResponse extends Model
{
    public $table = 'webhook_response_log';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_modified_date';
}
