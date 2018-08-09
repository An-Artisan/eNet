<?php

namespace App\Http\Controllers\API\Transport;


use App\Http\Requests\Transport\DestroyRequest;
use App\Http\Requests\Transport\IndexRequest;
use App\Http\Requests\Transport\StoreRequest;
use App\Http\Requests\Transport\UpdateRequest;
use App\Interfaces\TransportInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransportController extends Controller
{

    protected  $inter;

    public function __construct (TransportInterface $inter) {

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
