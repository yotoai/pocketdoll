<?php

namespace App\Http\Controllers\Api;

use App\Model\catchLog;
use App\Model\ChargeConfig;
use App\Model\Goods;
use App\Model\GoodsCategory;
use App\Model\Mission;
use App\Model\Player;
use App\Model\TalkExpression;
use App\Model\UserRucksack;
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
            if(!($lucky >= 0))
            {
                $this->setLuckyRedis($id,0);
                $lucky = $this->getLuckyRedis($id);
            }
            $data = Goods::where('goods_cate_id',intval($id))
                ->where('status','<>','-1')
                ->get([
                    'id',
                    'goods_cate_id',
                    'add_num',
                    'name',
                    'pic',
                    'sc_pic',
                    'width',
                    'height',
                ]);
            if(empty($data)) return ['code' => -1,'msg' => '该娃娃机不存在...'];
            $list = [];
            foreach ($data as $d) {
                for ($i = $d->add_num;$i > 0 ;$i-- ){
                    $list[] = [
                        'id' => $d->id,
                        'goods_cate_id' => $d->goods_cate_id,
                        'name' => $d->name,
                        'pic' => env('APP_URL').'/uploads/'.$d->pic,
                        'sc_pic' => env('APP_URL').'/uploads/'.$d->sc_pic,
                        'width' => $d->width,
                        'height' => $d->height,
                    ];
                }
            }
            $coin = GoodsCategory::where('id',$id)->value('coin');
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '查询成功','coin' => $coin,'lucky' => $lucky,'data' => $list];
    }

    /**
     * 随机返回娃娃机
     *  notice ：要开redis
     * @return array
     */
    public function getRandDollMachine()
    {
        $key = 'doll_machine';
        if(Redis::scard($key) > 0){
            return $this->randDollMachine($key);
        }else {
            $cate_id = Goods::where('status','<>','-1')->distinct()->get(['goods_cate_id'])->pluck('goods_cate_id');
            $data = GoodsCategory::join('goods_tags_cate','goods_tags_cate.id','=','goods_category.tag_id')
                ->whereIn('goods_category.id',$cate_id)
                ->where('goods_category.status','<>','-1')
                ->get([
                    'goods_category.id as id',
                    'goods_category.cate_name as name',
                    'goods_category.spec as spec',
                    'goods_category.coin as coin',
                    'goods_category.pic as pic',
                    'goods_tags_cate.tag_icon as tag_icon'
                ]);
            foreach ($data as $d){
                $d->pic = env('APP_URL').'/uploads/'.$d->pic;
                $d->tag_icon = env('APP_URL').'/uploads/'.$d->tag_icon;
            }
            foreach ($data as $item) {
                Redis::sadd($key, $item);
            }
            return $this->randDollMachine($key);
        }
    }

    // 返回 $num 个随机 娃娃机
    protected function randDollMachine($key,$num = 4)
    {
        return ['code' => 1,'msg' => '查询成功','data' => json_decode('['.implode(',',Redis::srandmember($key, $num)).']',true)];
    }

    /**
     * 抓取娃娃
     * @param $id        @娃娃机id
     * @param $gid       @娃娃id
     * @return array
     */
    public function catchDoll($id,$gid,Request $request)
    {
        $this->validate($request,[
            'iscatch' => 'required'
        ]);
        $uid = $this->getUserid();
        $gcoin = GoodsCategory::where('id',intval($id))->value('coin');
        $ucoin = Player::where('user_id',$uid)->value('coin');
        if($ucoin < $gcoin) {return ['code' => -1,'msg' => '金币不足！'];}

//        $udata = Player::find($uid);
//        $this->setRebate($udata,$gcoin); // 返佣

        $lucky = $this->getLuckyRedis($id);

        if($request->iscatch == 'false' || intval($gid) == 0){
            $this->setCatchNum(1);
            $this->finishMission('catch');
            Player::where('user_id',$uid)->update(['coin' => $ucoin - $gcoin]);
            if($lucky >= 100){
                $add_lucky = 0;
            }else{
                $add_lucky = $this->reLucky($lucky);
                $this->setLuckyRedis($id,$add_lucky);
            }
            return ['code' => 1,'data' => 'lost','lucky' => $add_lucky];
        }
        $rate = GoodsCategory::where('id',intval($id))->value('win_rate');

        $arr = ['get' => $rate,'lost'=>1000];
        if((($res = $this->getRand($arr)) == 'get' || $lucky == 100) && $request->iscatch == 'true' && $rate > 0)
        {
            try{
                $res = UserRucksack::where('user_id',$uid)->where('goods_id',$gid)->first();
                DB::transaction(function () use ($uid,$gid,$gcoin,$ucoin,$res){
                    if(!empty($res) && $res->goods_id == $gid) {
                        UserRucksack::where('user_id',$uid)->where('goods_id',$gid)->update([
                            'num' => $res->num + 1
                        ]);
                    }else {
                        UserRucksack::create([
                            'user_id'   => $uid,
                            'goods_id'  => $gid,
                            'num'       => 1,
                            'gain_time' => date('Y-m-d H:i:s', time())
                        ]);
                    }
                    catchLog::create([
                        'user_id'  => $uid,
                        'goods_id' => $gid,
                    ]);
                    Player::where('user_id',$uid)->update(['coin' => $ucoin - $gcoin]);
                });
                $this->setLuckyRedis($id,0);
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
            $this->finishMission('catched');
            $this->setCatchedNum(1);
            return ['code' => 1,'data' => 'get','lucky' => 'clear'];
        }else{
            try{
                $this->setCatchNum(1);
                $this->finishMission('catch');
                Player::where('user_id',$uid)->update(['coin' => $ucoin - $gcoin]);
                if($lucky >= 100){
                    $add_lucky = 0;
                }else{
                    $add_lucky = $this->reLucky($lucky);
                    $this->setLuckyRedis($id,$add_lucky);
                }
                return ['code' => 1,'data' => $res,'lucky' => $add_lucky];
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
        }
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
        if( $lucky < 60 && $lucky >=0) return mt_rand(5,10);
        if( $lucky >= 60  && $lucky < 80) return mt_rand(3,5);
        if( $lucky >= 80  && $lucky < 95) return  mt_rand(2,3);
        if( $lucky >= 95 && $lucky <=100) return 1;
    }

    // 完成 抓取 抓到 任务
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

    // 抓取到后分享
    public function getShare($id)
    {
        $goods = Goods::find($id);
        $user = Player::orderBy(DB::raw('RAND()'))->take(2)->get(['user_name'])->pluck('user_name')->toArray();
        $catch = $this->getCatchNum();
        $data = [
            'goods_name' => $goods->name,
            'pic' => env('APP_URL').'/uploads/'.$goods->pic,
            'user_name' => $user,
            'catchnum' => $catch
        ];
        return ['code' => 1,'msg' =>'查询成功','data' => $data];
    }

    // 返佣 （作废）
    protected function setRebate($data,$gcoin,$rate=1)
    {
        if(!empty($data->parent_id)){
            $pdata = Player::find($data->parent_id);
            $cc = ChargeConfig::where('identity','rebate_ratio_'.$rate.'v')->first();
            $pdata->coin = $pdata->coin + $gcoin * $cc->rebate_ratio;
            $pdata->save();

            if(!empty($pdata->parent_id)) {
                $this->setRebate($pdata,$gcoin,++$rate);
            }
//                $ddata = Player::find($pdata->parent_id);
//                $cc = ChargeConfig::where('identity','rebate_ratio_2v')->first();
//                $ddata->coin = $ddata->coin + $gcoin * $cc->rebate_ratio;
//                $ddata->save();
//                if(!empty($ddata->parent_id)){
//                    $sdata = Player::find($ddata->parent_id);
//                    $cc = ChargeConfig::where('identity','rebate_ratio_3v')->first();
//                    $sdata->coin = $sdata->coin + $gcoin * $cc->rebate_ratio;
//                    $sdata->save();
//                }
//            }
        }else{
            return;
        }
    }


    // 返回 娃娃互动信息
    public function getDollInteraction(Request $request)
    {
        $this->validate($request,[
            'machine_id' => 'required|integer'
        ]);
        if(in_array($request->type,[1,2,3])){
            $te = TalkExpression::where('dollmachine_id',$request->machine_id)
                ->where('type',$request->type)
                ->first();
            $talk = explode(',',$te->talk_doll);

            $se = $te->small_expression;
            foreach ($se as $k=>$v){
                $se[$k] = env('APP_URL') . '/uploads/' . $v;
            }
            $ts = array_merge($se,$talk);
            return ['code' => 1,'msg' => '查询成功','data' => $ts[array_rand($ts)]];
        }else {
            $te = TalkExpression::where('dollmachine_id',$request->machine_id)
                ->where('type',3)
                ->first();
            $talk = explode(',',$te->talk_doll);

            $se = $te->small_expression;
            foreach ($se as $k=>$v){
                $se[$k] = env('APP_URL') . '/uploads/' . $v;
            }
            $ts = array_merge($se,$talk);
            return ['code' => 1,'msg' => '查询成功','data' => $ts[array_rand($ts)]];
        }
    }
}
