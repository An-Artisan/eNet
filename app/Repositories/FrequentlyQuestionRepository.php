<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\FrequentlyQuestionResource;
use App\Interfaces\FrequentlyQuestionInterface;
use App\Models\HelpCenter\FrequentlyQuestion;
use App\Services\API;
use Illuminate\Http\Request;


class FrequentlyQuestionRepository implements FrequentlyQuestionInterface
{

    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = FrequentlyQuestionResource::collection(FrequentlyQuestion::get());
        } else {
            $info = FrequentlyQuestion::paginate($limit);
            $data['data']['data']['data'] = FrequentlyQuestionResource::collection($info);
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
        $param['question_answer'] = $request->input('question_answer');
        API::createModel($param,FrequentlyQuestion::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['question_title'] = $request->input('question_title');
        $param['question_answer'] = $request->input('question_answer');
        API::updateModel($id,$param,FrequentlyQuestion::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,FrequentlyQuestion::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
