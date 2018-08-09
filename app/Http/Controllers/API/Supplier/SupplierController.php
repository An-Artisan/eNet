<?php

namespace App\Http\Controllers\API\Supplier;

use App\Http\Requests\Supplier\DestroyRequest;
use App\Http\Requests\Supplier\IndexRequest;
use App\Http\Requests\Supplier\StoreRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Interfaces\SupplierInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{

    protected  $inter;

    public function __construct (SupplierInterface $inter) {

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
