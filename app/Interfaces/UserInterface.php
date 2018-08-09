<?php

/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/19
 * Time: 10:18
 */

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UserInterface
{
    public function login(Request $request);
    public function logout(Request $request);
    public function register(Request $request);
    public function getUserList(Request $request);
    public function getUserDetail(Request $request);
    public function getMarketList(Request $request);
    public function updatePhone(Request $request);
    public function updatePassword(Request $request);

}
