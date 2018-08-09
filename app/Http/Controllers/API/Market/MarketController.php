<?php

namespace App\Http\Controllers\API\Market;



use App\Http\Requests\Market\IndexRequest;
use App\Http\Requests\Market\MoneyRequest;
use App\Interfaces\MarketInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketController extends Controller
{

    protected  $inter;

    public function __construct (MarketInterface $inter) {

        $this->inter = $inter;
    }


    public function show(IndexRequest $request,$id) {

        $result = $this->inter->show($request,$id);

        return response()->json($result->data, $result->status);
    }

    public function money(MoneyRequest $request) {

        $result = $this->inter->money($request);

        return response()->json($result->data, $result->status);
    }

}
