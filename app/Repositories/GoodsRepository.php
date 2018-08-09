<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\GoodsResource;
use App\Http\Resources\OftenGoodsResource;
use App\Interfaces\GoodsInterface;
use App\Models\Goods\Goods;
use App\Models\Goods\OftenBrowse;
use App\Models\Goods\Search;
use App\Services\API;
use App\Utils\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use TomLingham\Searchy\Facades\Searchy;

class GoodsRepository implements GoodsInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = GoodsResource::collection(Goods::get());

        } else {
            $info = Goods::paginate($limit);
            $data['data']['data']['data'] = GoodsResource::collection($info);
            $info = $info->toArray();
            unset($info['data']);
            $data['data']['data']['paginate'] = $info;
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function store (Request $request)
    {

        $param['goods_title'] = $request->input('goods_title');
        $param['goods_desc'] = $request->input('goods_desc');
        $param['goods_price'] = $request->input('goods_price');
        $param['goods_original_price'] = $request->input('goods_original_price');
        $param['goods_type_id'] = $request->input('goods_type_id');
        $param['goods_supplier_id'] = $request->input('goods_supplier_id');

        if (!($goodsIsPublish = config('R.' . $request->input('goods_is_publish')))){
            $goodsIsPublish = config('R.GOODS_NOT_PUBLISH');
        }

        $param['goods_is_publish'] = $goodsIsPublish;
        $param['goods_photo'] = $request->input('goods_photo');
        $param['goods_count'] = $request->input('goods_count');
        API::createModel($param,Goods::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['goods_title'] = $request->input('goods_title');
        $param['goods_desc'] = $request->input('goods_desc');
        $param['goods_price'] = $request->input('goods_price');
        $param['goods_original_price'] = $request->input('goods_original_price');
        $param['goods_type_id'] = $request->input('goods_type_id');
        $param['goods_supplier_id'] = $request->input('goods_supplier_id');

        if (!($goodsIsPublish = config('R.' . $request->input('goods_is_publish')))){
            $goodsIsPublish = config('R.GOODS_NOT_PUBLISH');
        }

        $param['goods_is_publish'] = $goodsIsPublish;
        $param['goods_photo'] = $request->input('goods_photo');
        $param['goods_count'] = $request->input('goods_count');
        API::updateModel($id,$param,Goods::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }


    public function destroy (Request $request,$id)
    {
        $resp = API::deteleModel($id,Goods::class);

        $path = public_path() . $resp->goods_photo;
        self::deleteGoodsImage($path);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function show (Request $request, $ids)
    {
        foreach ($ids as $id) {
            $arr[] = Goods::find($id);
        }
        $collection =  Collection::make($arr);

        $data['data']['data'] = GoodsResource::collection($collection);
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    /**
     * Desc: 上传图片
     * Date: 2018/8/1 0001
     * Time: 下午 12:37
     * @param Request $request
     * @return object
     * Created by StubbornGrass.
     */
    public function upload(Request $request)
    {
        $path = public_path() . DIRECTORY_SEPARATOR .'goodsImage' . DIRECTORY_SEPARATOR;
        $imagePath = 'goodsImage' . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path,0777);
        }
        $data['status'] = config('R.SUCCESS');

        if ($_FILES['image']['error'] !== 4) {
            // 返回值的地址赋值给cover
            $cover = Upload::uploadImage($_FILES,$path,$imagePath,"image");
            $imagePath =   DIRECTORY_SEPARATOR . $cover;
            $data['data']['data'] = ["domain" => config("app.url") ,"imagePath" => $imagePath];
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
        }
        return (object) $data;
    }

    /**
     * Desc: 导出商品
     * Date: 2018/8/1 0001
     * Time: 下午 12:37
     * @param Request $request
     * @return mixed
     * Created by StubbornGrass.
     */
    public function export (Request $request)
    {
        $goods = Goods::get(["id","goods_title","goods_desc","goods_price",
            "goods_original_price","goods_type_id","goods_supplier_id",
            "goods_is_publish","goods_count","created_at","updated_at"])->toArray();
        array_unshift($goods,["商品id","商品标题","商品描述","商品价格","商品原价","商品类别","商品供应商"
            ,"是否发布","商品数量","创建时间","修改时间"]);
        return $goods;
    }

    /**
     * Desc: 上传excel到服务器
     * Date: 2018/8/1 0001
     * Time: 下午 12:37
     * @param Request $request
     * @return object
     * Created by StubbornGrass.
     */
    public function import (Request $request)
    {
        $path = public_path() . DIRECTORY_SEPARATOR .'goodsExcel' . DIRECTORY_SEPARATOR;
        $imagePath = 'goodsExcel' . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path,0777);
        }
        $data['status'] = config('R.SUCCESS');

        if ($_FILES['file']['error'] !== 4) {
            // 返回值的地址赋值给cover
            $cover = Upload::uploadImage($_FILES,$path,$imagePath,"file");
            $excelPath =   DIRECTORY_SEPARATOR . $cover;

        }
        global $flag;
        $filePath = public_path() .  $excelPath;
        Excel::load($filePath, function($reader) {
            $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();

            if (!self::importGoods($data)) {
                global $flag;
                $flag = 'ERROR';
            }
        });
        if ($flag == 'ERROR') {
            $data['status'] = config('R.ERROR');
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.ERROR');
            $data['data']['message'] = config('M.EXCEL_ERROR');
            return (object) $data;
        }
        $data['status'] = config('R.SUCCESS');
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        return (object) $data;
    }


    public function goodsList (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');
        $typeid = $request->input('typeid');
        if (!$page) {
            $data['data']['data'] = GoodsResource::collection(Goods::where("goods_type_id",$typeid)->get());
        } else {
            $data['data']['data'] = GoodsResource::collection(Goods::where("goods_type_id",$typeid)->paginate($limit));
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }


    public function oftenBrowse (Request $request)
    {
        $goodsId = $request->input('goods_id');

        $userid = $request->user()->id;

        foreach ($goodsId as $id) {
            $param['userid'] = $userid;
            $param['goods_id'] = $id;
            API::createModel($param,OftenBrowse::class);
        }
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function getOftenBrowse (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');
        $userid = $request->user()->id;
        if (!$page) {
            $data['data']['data']['data'] = OftenGoodsResource::collection(OftenBrowse::where("userid",$userid)->get());
        } else {
            $info = OftenBrowse::where("userid",$userid)->paginate($limit);
            $data['data']['data']['data'] = OftenGoodsResource::collection($info);
            $info = $info->toArray();
            unset($info['data']);
            $data['data']['data']['paginate'] = $info;
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function searchGoods (Request $request)
    {
        $keyWord = $request->input('key_word');

        $goods = Searchy::goods('goods_title', 'goods_desc')->query($keyWord)->get();

        $userid = $request->user()->id;
        $param['userid'] = $userid;
        $param['key_word'] = $keyWord;
        API::createModel($param,Search::class);
        $data['data']['data'] = $goods;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function getHistorySearch(Request $request) {
        $userid = $request->user()->id;

        $keys = Search::where("userid",$userid)->limit(10)->get();

        $data['data']['data'] = $keys;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;

    }

    public function getHotSearch(Request $request) {


        $keys = Search::orderBy("key_word")->limit(10)->get();

        $data['data']['data'] = $keys;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
    
    public function deleteHistorySearch (Request $request)
    {
        $userid = $request->user()->id;

        Search::where("userid",$userid)->delete();

        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;

    }

    /**
     * Desc: 删除图片
     * Date: 2018/8/1 0001
     * Time: 下午 12:37
     * @param $path
     * @return bool
     * Created by StubbornGrass.
     */
    protected  function deleteGoodsImage($path) {
        return unlink($path);
    }


    /**
     * Desc: 导入商品数据
     * Date: 2018/8/1 0001
     * Time: 下午 12:36
     * @param $data
     * Created by StubbornGrass.
     */
    protected  function importGoods($data){

        // 删除商品标题
        unset($data[0]);
        if (count($data[1]) < 11) {
            return false;
        }
        foreach ($data as $value) {
            $param["goods_title"] = $value[1];
            $param["goods_desc"] = $value[2];
            $param["goods_price"] = $value[3];
            $param["goods_original_price"] = $value[4];
            $param["goods_type_id"] = $value[6];
            $param["goods_supplier_id"] = $value[6];
            $param["goods_photo"] = $value[7];
            $param["goods_is_publish"] = $value[8];
            $param["created_at"] = $value[9];
            $param["updated_at"] = $value[10];
            API::createModel($param,Goods::class);
        }
    }





}
