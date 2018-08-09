<?php

namespace App\Http\Controllers\API\DataStatistics;

use App\Http\Requests\DataStatistics\IndexRequest;
use App\Interfaces\DataStatisticsInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataStatisticsController extends Controller
{

    protected  $inter;

    public function __construct ( DataStatisticsInterface $inter) {

        $this->inter = $inter;
    }


    public function index(IndexRequest $request) {

        $result = $this->inter->index($request);

        return response()->json($result->data, $result->status);
    }



}
