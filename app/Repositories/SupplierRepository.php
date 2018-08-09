<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\SupplierResource;
use App\Interfaces\SupplierInterface;
use App\Models\Supplier\Supplier;
use App\Services\API;
use Illuminate\Http\Request;


class SupplierRepository implements SupplierInterface
{


    public function index (Request $request)
    {

        $limit = $request->input('limit');
        $page = $request->input('page');
        if (!$page) {
            $data['data']['data']['data'] = SupplierResource::collection(Supplier::get());

        } else {
            $info = Supplier::paginate($limit);
            $data['data']['data']['data'] = SupplierResource::collection($info);
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

        $param['supplier_name'] = $request->input('supplier_name');
        $param['master_name'] = $request->input('master_name');
        $param['master_phone'] = $request->input('master_phone');
        $param['supplier_address'] = $request->input('supplier_address');
        API::createModel($param,Supplier::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['supplier_name'] = $request->input('supplier_name');
        $param['master_name'] = $request->input('master_name');
        $param['master_phone'] = $request->input('master_phone');
        $param['supplier_address'] = $request->input('supplier_address');
        API::updateModel($id,$param,Supplier::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,Supplier::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
