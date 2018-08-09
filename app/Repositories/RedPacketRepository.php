<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\RedPacketResource;
use App\Http\Resources\UserRedPacketResource;
use App\Interfaces\RedPacketInterface;
use App\Models\RedPacket\RedPacket;
use App\Models\RedPacket\UserRedPacket;
use App\Services\API;
use App\User;
use Illuminate\Http\Request;


class RedPacketRepository implements RedPacketInterface
{

    public function index (Request $request)
    {


        $limit = $request->input('limit');
        $page = $request->input('page');

        $expire =  $request->input('expire');

        $isPublish =  $request->input('is_publish');

        if (!is_null($expire)) $expire = (int) $expire;
        if (!is_null($isPublish)) $isPublish = (int) $isPublish;

        $redPacket = null;

        if ($expire === config('R.RED_EXPIRE')) {
            $redPacket = RedPacket::where('end_at','<',date('Y-m-d H:i:s',time()))
                ->orWhere('start_at','>',date('Y-m-d H:i:s',time()));

        } else if ($expire === config('R.RED_NOT_EXPIRE')) {
            $redPacket = RedPacket::where('end_at','>',date('Y-m-d H:i:s',time()))
                ->where('start_at','<',date('Y-m-d H:i:s',time()));
        }

        if ($isPublish === config('R.RED_PUBLISH')) {
            if ($redPacket) {
                $redPacket = $redPacket->where("is_publish", config('R.RED_PUBLISH'));
            } else {
                $redPacket = RedPacket::where("is_publish", config('R.RED_PUBLISH'));
            }
        }else if ($isPublish === config('R.RED_NOT_PUBLISH')) {
            if ($redPacket) {
                $redPacket = $redPacket->where("is_publish", config('R.RED_NOT_PUBLISH'));
            } else {
                $redPacket = RedPacket::where("is_publish", config('R.RED_NOT_PUBLISH'));
            }
        }

        if (!$page) {
            if ($redPacket) {
                $data['data']['data'] = RedPacketResource::collection($redPacket->get());
            } else {
                $data['data']['data'] = RedPacketResource::collection(RedPacket::get());
            }
        } else {
            if ($redPacket) {
                $info = $redPacket->paginate($limit);
                $data['data']['data']['data'] = RedPacketResource::collection($info);
                $info = $info->toArray();
                unset($info['data']);
                $data['data']['data']['paginate'] = $info;
            } else {
                $info = RedPacket::paginate($limit);
                $data['data']['data']['data'] = RedPacketResource::collection($info);
                $info = $info->toArray();
                unset($info['data']);
                $data['data']['data']['paginate'] = $info;
            }
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function store (Request $request)
    {

        $param['red_packet_name'] = $request->input('red_packet_name');
        $param['red_packet_price'] = $request->input('red_packet_price');
        $param['is_red_packet_threshold'] = $request->input('is_red_packet_threshold');
        $param['red_packet_threshold_price'] = $request->input('red_packet_threshold_price');
        $param['is_publish'] = $request->input('is_publish');
        $param['start_at'] = $request->input('start_at');
        $param['end_at'] = $request->input('end_at');
        $resp = API::createModel($param,RedPacket::class);
        if ($param['is_publish'] == config('R.RED_PUBLISH')) self::addUserRedPacket($resp->id);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['red_packet_name'] = $request->input('red_packet_name');
        $param['red_packet_price'] = $request->input('red_packet_price');
        $param['is_red_packet_threshold'] = $request->input('is_red_packet_threshold');
        $param['red_packet_threshold_price'] = $request->input('red_packet_threshold_price');
        $param['is_publish'] = $request->input('is_publish');
        $param['start_at'] = $request->input('start_at');
        $param['end_at'] = $request->input('end_at');
        API::updateModel($id,$param,RedPacket::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,RedPacket::class);
        UserRedPacket::where("red_packet_id",$id)->delete();
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public  function  getRedPacketWithUserid (Request $request,$userid) {

        $page =  $request->input('page');
        $limit =  $request->input('limit');
        $receive = $request->input('is_receive');
        if (is_null($receive))
            $userRedPacket = UserRedPacket::where("userid",$userid)->where("is_receive",$receive);
        else
            $userRedPacket = UserRedPacket::where("userid",$userid);

        if (!$page) {
            $data['data']['data'] = UserRedPacketResource::collection($userRedPacket->get());
        } else {
            $data['data']['data'] = UserRedPacketResource::collection($userRedPacket->paginate($limit));
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function ReceiveRedPacket($userRedPacketId) {
        $userRedPacket = UserRedPacket::find($userRedPacketId);
        $userRedPacket->is_receive = config("R.RED_RECEIVE");
        $userRedPacket->update();
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function deleteRedPacketWithUserid ($repacketid)
    {
        UserRedPacket::find($repacketid)->delete();
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    protected function addUserRedPacket($id) {
        $users = User::get();

        foreach ($users as $user) {
            $param["userid"] = $user->id;
            $param["red_packet_id"] = $id;
            $param["is_receive"] = config('R.RED_NOT_RECEIVE');
            API::createModel($param,UserRedPacket::class);
        }
        return true;
    }


}
