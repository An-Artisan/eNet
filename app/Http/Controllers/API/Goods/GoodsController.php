<?php

namespace App\Http\Controllers\API\Goods;

use App\Http\Requests\Goods\DestroyRequest;
use App\Http\Requests\Goods\ExportRequest;
use App\Http\Requests\Goods\ImportRequest;
use App\Http\Requests\Goods\IndexRequest;
use App\Http\Requests\Goods\StoreRequest;
use App\Http\Requests\Goods\UpdateRequest;
use App\Http\Requests\Goods\UploadRequest;
use App\Interfaces\GoodsInterface;
use App\Models\Goods\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class GoodsController extends Controller
{

    protected  $inter;

    public function __construct (GoodsInterface $inter) {

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

    public function show (Request $request,$ids) {


        $ids = (json_decode($ids))->id;
        $result = $this->inter->show($request,$ids);

        return response()->json($result->data, $result->status);
    }
    public function uploadGoodsImage(UploadRequest $request) {

        $result = $this->inter->upload($request);

        return response()->json($result->data, $result->status);
    }

    public function exportGoods(ExportRequest $request) {
        $goods = $this->inter->export($request);
        Excel::create('goodsList',function($excel) use ($goods){
            $excel->sheet('goods', function($sheet) use ($goods){
                $sheet->rows($goods);
            });
        })->export('xlsx');
    }

    public function importGoods(ImportRequest $request) {

        $result = $this->inter->import($request);

        return response()->json($result->data, $result->status);
    }

    public function goodsList(Request $request) {

        $result = $this->inter->goodsList($request);

        return response()->json($result->data, $result->status);
    }

    public function oftenBrowse(Request $request) {

        $result = $this->inter->oftenBrowse($request);

        return response()->json($result->data, $result->status);
    }

    public function getOftenBrowse(Request $request) {

        $result = $this->inter->getOftenBrowse($request);

        return response()->json($result->data, $result->status);
    }

    public function searchGoods(Request $request) {
        $result = $this->inter->searchGoods($request);

        return response()->json($result->data, $result->status);
    }

    public function getHistorySearch(Request $request) {

        $result = $this->inter->getHistorySearch($request);

        return response()->json($result->data, $result->status);
    }

    public function getHotSearch(Request $request) {

        $result = $this->inter->getHotSearch($request);

        return response()->json($result->data, $result->status);
    }

    public function deleteHistorySearch(Request $request){

        $result = $this->inter->deleteHistorySearch($request);

        return response()->json($result->data, $result->status);
    }

}
