<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected  $table = 'transport';

    protected $fillable = [
        'id', 'userid', 'name',"phone","city","address","address"
    ];
}
