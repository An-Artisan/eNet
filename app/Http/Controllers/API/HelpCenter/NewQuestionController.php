<?php

namespace App\Http\Controllers\API\HelpCenter;

use App\Http\Requests\NewQuestion\DestroyRequest;
use App\Http\Requests\NewQuestion\IndexRequest;
use App\Http\Requests\NewQuestion\StoreRequest;
use App\Interfaces\NewQuestionInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewQuestionController extends Controller
{

    protected  $inter;

    public function __construct (NewQuestionInterface $inter) {

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

    public function destroy(DestroyRequest $request,$id) {

        $result = $this->inter->destroy($request,$id);

        return response()->json($result->data, $result->status);
    }

}
