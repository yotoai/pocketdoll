<?php

namespace App\Http\Controllers\Api;

use App\Model\catchLog;
use App\Model\Goods;
use App\Model\GoodsCategory;
use App\Model\Mission;
use App\Model\UserRucksack;
use App\Model\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CatchDollController extends BaseController
{
    // 娃娃机选择 // 需开启redis
    public function selectDollMachine($id)
    {
        try{
            $lucky = $this->getLuckyRedis($id);
            if(!$lucky >= 0 )
            {
                $this->setLuckyRedis($id,0);
                $lucky = $this->getLuckyRedis($id);
            }
            $data = Goods::where('goods_cate_id',intval($id))->get()->toArray();
            if(empty($data)) return ['code' => -1,'msg' => '该娃娃机不存在...'];
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'data' => $data,'lucky' => $lucky];
    }

    /**
     * 随机返回娃娃机
     *  notice ：要开redis
     * @return array
     */
    public function getRandDollMachine()
    {
        //Redis::del('doll_machine');
        $key = 'doll_machine';
        if(Redis::scard($key) > 0){
            return $this->randDollMachine($key);
        }else {
            foreach (GoodsCategory::all() as $item) {
                Redis::sadd($key, $item);
            }
            return $this->randDollMachine($key);
        }
    }

    /**
     * 抓取娃娃
     * @param $id        @娃娃机id
     * @param $gid       @娃娃id
     * @return array
     */
    public function catchDoll($id,$gid)
    {
        $openid = $this->getOpenid();
        $gcoin = GoodsCategory::where('id',intval($id))->value('coin');
        $ucoin = Users::where('openid',$openid)->value('coin');
        if($ucoin < $gcoin) {return ['code' => -1,'msg' => '金币不足！'];}

        $lucky = $this->getLuckyRedis($id);
        $rate = GoodsCategory::where('id',intval($id))->value('win_rate');

        $arr = ['get'=>$rate + $lucky,'lost'=>1000 - ($rate + $lucky)];

        if(($res = $this->getRand($arr)) == 'get' || $lucky == 100)
        {
            $this->setLuckyRedis($id,0);
            try{
                DB::transaction(function () use ($openid,$gid,$gcoin,$ucoin){
                    $res = UserRucksack::where('user_id',$openid)->where('goods_id',$gid)->first();
                    if($res->goods_id == $gid) {
                        UserRucksack::where('user_id',$openid)->where('goods_id',$gid)->update([
                            'num' => $res->num + 1
                        ]);
                    }else {
                        UserRucksack::create([
                            'user_id'   => $openid,
                            'goods_id'  => $gid,
                            'num'       => 1,
                            'gain_time' => date('Y-m-d H:i:s', time())
                        ]);
                    }
                    catchLog::create([
                        'user_id'  => $openid,
                        'goods_id' => $gid,
                    ]);
                    Users::where('openid',$openid)->update(['coin' => $ucoin - $gcoin]);
                });
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
            $this->finishMission('catched');
            $this->setCatchedNum(1);
            return ['data' => 'get','lucky' => 'clear'];
        }else{
            $this->setCatchNum(1);
            $this->finishMission('catch');
            Users::where('openid',$openid)->update(['coin' => $ucoin - $gcoin]);
            $add_lucky = $this->reLucky($lucky);
            $this->setLuckyRedis($id,$add_lucky);
            return ['data' => $res,'lucky' => $add_lucky];
        }
    }


    // 返回 $num 个随机 娃娃机
    protected function randDollMachine($key,$num = 6)
    {
        return json_decode('['.implode(',',Redis::srandmember($key, $num)).']',true);
    }

    // 返回随机键
    private function getRand($arr)
    {
	 	$sum = array_sum($arr);
        $res = 'lost';
	 	foreach($arr as $k => $v)
	 	{
	 		$current = mt_rand(1,$sum);

	 		if($current <= $v)
	 		{
	 			$res = $k;
	 			break;
	 		}else{
	 			$sum -= $current;
	 		}
	 	}
	 	return $res;
    }

    // 返回增加的幸运值
    protected function reLucky($lucky)
    {
        if( $lucky < 60 && $lucky >=0) return mt_rand(1,6);
        if( $lucky >= 60  && $lucky < 80) return mt_rand(1,4);
        if( $lucky >= 80  && $lucky < 95) return  mt_rand(1,2);
        if( $lucky >= 95 && $lucky <=100) return 1;
    }

    protected function finishMission($action)
    {
        if($action == 'catch'){
            $num = $this->getCatchNum();
            $res = Mission::where('type',2)->get(['id','need_num']);
            foreach ($res as $v){
                if($v->need_num == $num && $this->getMissionRedis($v->id) != 1){
                    $this->setMissionRedis($v->id,1);
                }
            }
        }elseif($action == 'catched'){
            $num = $this->getCatchedNum();
            $res = Mission::where('type',5)->get(['id','need_num']);
            foreach ($res as $v){
                if($v->need_num == $num && $this->getMissionRedis($v->id) != 1){
                    $this->setMissionRedis($v->id,1);
                }
            }
        }
    }
}
