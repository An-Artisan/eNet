<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected  $table = 'banner';

    protected $fillable = [
        'id', 'banner_image_address', 'banner_href_address',
    ];
}
