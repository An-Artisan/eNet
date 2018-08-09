<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected  $table = 'search';

    protected $fillable = [
        'id', 'userid', 'key_word'
    ];


}
