<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\GoodsTypeResource;
use App\Http\Resources\ShoppingCartResource;
use App\Interfaces\ShoppingCartInterface;
use App\Models\ShoppingCart\ShoppingCart;
use App\Services\API;
use Illuminate\Http\Request;


class ShoppingCartRepository implements ShoppingCartInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = ShoppingCartResource::collection(ShoppingCart::get());
        } else {
            $info = ShoppingCart::paginate($limit);
            $data['data']['data']['data'] = ShoppingCartResource::collection($info);
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

        $param['userid'] = $request->user()->id;
        $param['single_price'] = json_encode($request->input('single_price'));
        $param['goods_id'] = json_encode($request->input('goods_id'));
        $param['sum_price'] = $request->input('sum_price');
        $param['count'] = json_encode($request->input('count'));
        API::createModel($param,ShoppingCart::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['userid'] = $request->user()->id;
        $param['single_price'] = json_encode($request->input('single_price'));
        $param['goods_id'] = json_encode($request->input('goods_id'));
        $param['sum_price'] = $request->input('sum_price');
        $param['count'] = json_encode($request->input('count'));
        API::updateModel($id,$param,ShoppingCart::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,ShoppingCart::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
