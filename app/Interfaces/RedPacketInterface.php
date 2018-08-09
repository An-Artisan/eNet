<?php

/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/19
 * Time: 10:18
 */

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RedPacketInterface
{

    public function index(Request $request);

    public function store(Request $request);

    public function update(Request $request,$id);

    public function  destroy(Request $request,$id);

    public function getRedPacketWithUserid(Request $request,$userid);

    public function ReceiveRedPacket($userRedacketId);

    public function deleteRedPacketWithUserid($repacketid);

}
