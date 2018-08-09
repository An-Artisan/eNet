<?php

namespace App\Models\SMSCode;

use Illuminate\Database\Eloquent\Model;

class SMSCode extends Model
{
    protected  $table = 'sms_code';

    protected $fillable = [
        'id', 'phone', 'code'
    ];
}
