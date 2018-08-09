<?php

namespace App\Http\Controllers\API\RedPacket;

use App\Http\Requests\RedPacket\DestroyRequest;
use App\Http\Requests\RedPacket\IndexRequest;
use App\Http\Requests\RedPacket\StoreRequest;
use App\Http\Requests\RedPacket\UpdateRequest;
use App\Interfaces\RedPacketInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedPacketController extends Controller
{

    protected  $inter;

    public function __construct (RedPacketInterface $inter) {


        $this->inter = $inter;
    }


    public function index(IndexRequest $request) {


        $result = $this->inter->index($request);

        return response()->json($result->data, $result->status);
    }

    public function store(StoreRequest $request) {

        $result = $this->inter->store($request);

        return response()->json($result->data, $result->status);
    }

    public function update(UpdateRequest $request,$id) {

        $result = $this->inter->update($request,$id);

        return response()->json($result->data, $result->status);
    }

    public function destroy(DestroyRequest $request,$id) {

        $result = $this->inter->destroy($request,$id);

        return response()->json($result->data, $result->status);
    }

    public function getRedPacketWithUserid(Request $request) {

        $result = $this->inter->getRedPacketWithUserid($request,$request->user()->id);

        return response()->json($result->data, $result->status);
    }

    public function ReceiveRedPacket(Request $request) {

        $result = $this->inter->ReceiveRedPacket($request->input('user_redpacket_id'));

        return response()->json($result->data, $result->status);
    }

    public function deleteRedPacketWithUserid(Request $request) {

        $result = $this->inter->deleteRedPacketWithUserid($request->input('repacketid'));

        return response()->json($result->data, $result->status);
    }

}
