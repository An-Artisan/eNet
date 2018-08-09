<?php

namespace App\Http\Controllers\API\Distribution;


use App\Http\Requests\Distribution\DestroyRequest;
use App\Http\Requests\Distribution\IndexRequest;
use App\Http\Requests\Distribution\StoreRequest;
use App\Http\Requests\Distribution\UpdateRequest;
use App\Interfaces\DistributionInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributionController extends Controller
{

    protected  $inter;

    public function __construct (DistributionInterface $inter) {

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
