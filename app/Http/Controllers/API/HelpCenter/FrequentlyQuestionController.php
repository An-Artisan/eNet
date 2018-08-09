<?php

namespace App\Http\Controllers\API\HelpCenter;



use App\Http\Requests\FrequentlyQuestion\DestroyRequest;
use App\Http\Requests\FrequentlyQuestion\IndexRequest;
use App\Http\Requests\FrequentlyQuestion\StoreRequest;
use App\Http\Requests\FrequentlyQuestion\UpdateRequest;
use App\Interfaces\FrequentlyQuestionInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrequentlyQuestionController extends Controller
{

    protected  $inter;

    public function __construct (FrequentlyQuestionInterface $inter) {

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
