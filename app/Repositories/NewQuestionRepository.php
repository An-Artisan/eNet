<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\NewQuestionResource;
use App\Interfaces\NewQuestionInterface;
use App\Models\HelpCenter\NewQuestion;
use App\Services\API;
use Illuminate\Http\Request;


class NewQuestionRepository implements NewQuestionInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = NewQuestionResource::collection(NewQuestion::get());
        } else {
            $info = NewQuestion::paginate($limit);
            $data['data']['data']['data'] = NewQuestionResource::collection($info);
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

        $param['question_title'] = $request->input('question_title');
        $param['question_desc'] = $request->input('question_desc');
        $param['master_name'] = $request->input('master_name');
        $param['master_phone'] = $request->input('master_phone');
        API::createModel($param,NewQuestion::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,NewQuestion::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
