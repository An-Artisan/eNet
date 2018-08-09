<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\TransportResource;
use App\Interfaces\TransportInterface;
use App\Models\Transport\Transport;
use App\Services\API;
use Illuminate\Http\Request;


class TransportRepository implements TransportInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = TransportResource::collection(Transport::get());
        } else {
            $info = Transport::paginate($limit);
            $data['data']['data']['data'] = TransportResource::collection($info);
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
        $userid = $request->user()->id;
        $param['userid'] = $request->user()->id;
        $param['name'] = $request->input('name');
        $param['phone'] = $request->input('phone');
        $param['city'] = $request->input('city');
        $param['address'] = $request->input('address');
        $param['is_default'] = $request->input('is_default');
        Transport::where("userid",$userid)->update(["is_default" => 0]);
        API::createModel($param,Transport::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $userid = $request->user()->id;
        $param['name'] = $request->input('name');
        $param['phone'] = $request->input('phone');
        $param['city'] = $request->input('city');
        $param['address'] = $request->input('address');
        $param['is_default'] = $request->input('is_default');
        Transport::where("userid",$userid)->update(["is_default" => 0]);
        API::updateModel($id,$param,Transport::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,Transport::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
