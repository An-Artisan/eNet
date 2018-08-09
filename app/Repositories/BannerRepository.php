<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\BannerResource;
use App\Interfaces\BannerInterface;
use App\Models\Banner\Banner;
use App\Services\API;
use Illuminate\Http\Request;


class BannerRepository implements BannerInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = BannerResource::collection(Banner::get());
        } else {
            $info = Banner::paginate($limit);
            $data['data']['data']['data'] = BannerResource::collection($info);
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

        $param['banner_image_address'] = $request->input('banner_image_address');
        $param['banner_href_address'] = $request->input('banner_href_address');
        API::createModel($param,Banner::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['banner_image_address'] = $request->input('banner_image_address');
        $param['banner_href_address'] = $request->input('banner_href_address');
        API::updateModel($id,$param,Banner::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,Banner::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
