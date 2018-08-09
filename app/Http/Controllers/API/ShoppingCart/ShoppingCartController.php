<?php

namespace App\Http\Controllers\API\ShoppingCart;


use App\Interfaces\ShoppingCartInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{

    protected  $inter;

    public function __construct (ShoppingCartInterface $inter) {

        $this->inter = $inter;
    }


    public function index(Request $request) {

        $result = $this->inter->index($request);

        return response()->json($result->data, $result->status);
    }

    public function store(Request $request) {

        $result = $this->inter->store($request);

        return response()->json($result->data, $result->status);
    }

    public function update(Request $request,$id) {

        $result = $this->inter->update($request,$id);

        return response()->json($result->data, $result->status);
    }

    public function destroy(Request $request,$id) {

        $result = $this->inter->destroy($request,$id);

        return response()->json($result->data, $result->status);
    }

}
