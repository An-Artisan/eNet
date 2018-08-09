<?php

/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/19
 * Time: 10:18
 */

namespace App\Interfaces;

use Illuminate\Http\Request;

interface MarketInterface
{

    public function show(Request $request,$id);

    public function money(Request $request);

}
