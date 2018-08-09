<?php

namespace App\Http\Controllers\API\Order;


use App\Http\Requests\Order\DestroyRequest;
use App\Http\Requests\Order\IndexRequest;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    protected  $inter;

    public function __construct (OrderInterface $inter) {

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

    public function getOrderWithUserid(Request $request) {


        $userid = $request->user()->id;

        $result = $this->inter->getOrderWithUserid($request,$userid);

        return response()->json($result->data, $result->status);
    }
    public function show (Request $request,$id) {

        $result = $this->inter->show($request,$id);

        return response()->json($result->data, $result->status);
    }

}
