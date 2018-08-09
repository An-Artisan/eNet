<?php

namespace App\Http\Controllers\API\GoodsTypeSecond;




use App\Http\Requests\GoodsTypeSecond\DestroyRequest;
use App\Http\Requests\GoodsTypeSecond\IndexRequest;
use App\Http\Requests\GoodsTypeSecond\StoreRequest;
use App\Http\Requests\GoodsTypeSecond\UpdateRequest;
use App\Interfaces\GoodsTypeSecondInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsTypeSecondController extends Controller
{

    protected  $inter;

    public function __construct (GoodsTypeSecondInterface $inter) {

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

}
