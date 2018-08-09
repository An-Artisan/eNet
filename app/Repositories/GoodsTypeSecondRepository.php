<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\GoodsTypeSecondResource;
use App\Interfaces\GoodsTypeSecondInterface;
use App\Models\GoodsType\GoodsTypeSecond;
use App\Services\API;
use Illuminate\Http\Request;


class GoodsTypeSecondRepository implements GoodsTypeSecondInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = GoodsTypeSecondResource::collection(GoodsTypeSecond::get());
        } else {
            $info = GoodsTypeSecond::paginate($limit);
            $data['data']['data']['data'] = GoodsTypeSecondResource::collection($info);
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

        $param['goods_type_second_name'] = $request->input('goods_type_second_name');
        $param['goods_type_second_desc'] = $request->input('goods_type_second_desc');
        $param['goods_type_id'] = $request->input('goods_type_id');
        API::createModel($param,GoodsTypeSecond::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['goods_type_second_name'] = $request->input('goods_type_second_name');
        $param['goods_type_second_desc'] = $request->input('goods_type_second_desc');
        $param['goods_type_id'] = $request->input('goods_type_id');
        API::updateModel($id,$param,GoodsTypeSecond::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,GoodsTypeSecond::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
