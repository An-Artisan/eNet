<?php

namespace App\Http\Controllers\API\GoodsType;



use App\Http\Requests\GoodsType\DestroyRequest;
use App\Http\Requests\GoodsType\IndexRequest;
use App\Http\Requests\GoodsType\StoreRequest;
use App\Http\Requests\GoodsType\UpdateRequest;
use App\Interfaces\GoodsTypeInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsTypeController extends Controller
{

    protected  $inter;

    public function __construct (GoodsTypeInterface $inter) {

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

    public function getSecondTypeWithId(Request $request) {

        $result = $this->inter->getSecondTypeWithId($request->input('id'));

        return response()->json($result->data, $result->status);

    }

}
