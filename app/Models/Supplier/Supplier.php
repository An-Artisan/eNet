<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected  $table = 'supplier';

    protected $fillable = [
        'id', 'supplier_name', 'master_name','master_phone', 'supplier_address'
    ];
}
