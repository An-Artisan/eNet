<?php

namespace App\Models\Distribution;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected  $table = 'distribution';

    protected $fillable = [
        'id', 'distribution_title', 'distribution_desc'
    ];
}
