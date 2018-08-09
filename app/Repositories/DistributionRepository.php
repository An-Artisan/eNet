<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\DistributionResource;
use App\Interfaces\DistributionInterface;
use App\Models\Distribution\Distribution;
use App\Services\API;
use Illuminate\Http\Request;


class DistributionRepository implements DistributionInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = DistributionResource::collection(Distribution::get());
        } else {
            $info = Distribution::paginate($limit);
            $data['data']['data']['data'] = DistributionResource::collection($info);
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

        $param['distribution_title'] = $request->input('distribution_title');
        $param['distribution_desc'] = $request->input('distribution_desc');
        $param['distribution_fee'] = $request->input('distribution_fee');
        API::createModel($param,Distribution::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['distribution_title'] = $request->input('distribution_title');
        $param['distribution_desc'] = $request->input('distribution_desc');
        $param['distribution_fee'] = $request->input('distribution_fee');
        API::updateModel($id,$param,Distribution::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,Distribution::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
