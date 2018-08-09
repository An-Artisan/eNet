<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\GoodsTypeResource;
use App\Http\Resources\GoodsTypeSecondResource;
use App\Interfaces\GoodsTypeInterface;
use App\Models\GoodsType\GoodsType;
use App\Models\GoodsType\GoodsTypeSecond;
use App\Services\API;
use Illuminate\Http\Request;


class GoodsTypeRepository implements GoodsTypeInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = GoodsTypeResource::collection(GoodsType::get());
        } else {
            $info = GoodsType::paginate($limit);
            $data['data']['data']['data'] = GoodsTypeResource::collection($info);
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

        $param['goods_type_name'] = $request->input('goods_type_name');
        $param['goods_type_desc'] = $request->input('goods_type_desc');
        $param['goods_type_leaset'] = $request->input('goods_type_leaset');
        API::createModel($param,GoodsType::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['goods_type_name'] = $request->input('goods_type_name');
        $param['goods_type_desc'] = $request->input('goods_type_desc');
        $param['goods_type_leaset'] = $request->input('goods_type_leaset');
        API::updateModel($id,$param,GoodsType::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,GoodsType::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function getSecondTypeWithId ($id)
    {
        $data['data']['data'] = GoodsTypeSecondResource::collection( GoodsTypeSecond::where("goods_type_id",$id)->get());
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
