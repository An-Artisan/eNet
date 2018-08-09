<?php

namespace App\Http\Controllers\API\Banner;



use App\Http\Requests\Banner\DestroyRequest;
use App\Http\Requests\Banner\IndexRequest;
use App\Http\Requests\Banner\StoreRequest;
use App\Http\Requests\Banner\UpdateRequest;
use App\Interfaces\BannerInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{

    protected  $inter;

    public function __construct (BannerInterface $inter) {

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
