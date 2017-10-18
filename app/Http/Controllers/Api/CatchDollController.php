<?php

namespace App\Http\Controllers\Api;

use App\Model\catchLog;
use App\Model\Goods;
use App\Model\GoodsCategory;
use App\Model\UserRucksack;
use App\Model\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CatchDollController extends BaseController
{
    // 娃娃机选择 // 需开启redis
    public function selectDollMachine($id)
    {
        try{
            $key = $this->getRedisKey($id);
            if(!Redis::exists($key))
            {
                Redis::set($key,0);
            }
            $lucky = Redis::get($key);
            $data = Goods::where('goods_cate_id',intval($id))->get()->toArray();
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return array_merge(['code' => 1],['data' => $data],['lucky' => $lucky]);
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

    // 抓取娃娃
    public function catchDoll($id,$gid)
    {
        $openid = $this->getOpenid();
        $gcoin = GoodsCategory::where('id',intval($id))->value('coin');
        $ucoin = Users::where('openid',$openid)->value('coin');
        if($ucoin < $gcoin) {return ['code' => -1,'msg' => '金币不足！'];}

        $key = $this->getRedisKey($id);

        $lucky = Redis::get($key);
        $rate = GoodsCategory::where('id',intval($id))->value('win_rate');
        $arr = ['get'=>$rate + $lucky,'lost'=>1000 - ($rate + $lucky)];
        if(($res = $this->getRand($arr)) == 'get' || $lucky == 100)
        {
            Redis::set($key,0);
            try{
                DB::transaction(function () use ($openid,$gid,$gcoin,$ucoin){
                    $res = UserRucksack::where('openid',$openid)->where('goods_id',$gid)->first();
                    if($res->goods_id == $gid) {
                        UserRucksack::where('openid',$openid)->where('goods_id',$gid)->update([
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
            return ['data' => 'get','lucky' => 'clear'];
        }else{
            Users::where('openid',$openid)->update(['coin' => $ucoin - $gcoin]);
            $add_lucky = $this->reLucky($lucky);
            $ret_lucky = ( ($lucky + $add_lucky) >= 100 ) ? 100 : $lucky + $add_lucky;
            Redis::set($key,$ret_lucky);
            return ['data' => $res,'lucky' => $add_lucky];
        }
    }

    // 添加一个娃娃种类
    public function addGoodsCategory(Request $request)
    {
        $rules = [
            'cate_name' => 'required|unique:goods_category|max:255',
            'win_rate'  => 'required|numeric',
            'spec'      => 'required|integer',
            'coin'      => 'required|integer',
            'tag'       => 'integer'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res  = GoodsCategory::create([
                'cate_name' => $request->cate_name,
                'win_rate'  => $request->win_rate,
                'spec'      => $request->spec,
                'coin'      => $request->coin,
                'tag_id'    => $request->tag,
                'pic'       => $pic
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
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
        if( $lucky < 60) return mt_rand(1,6);
        if( $lucky >= 60  && $lucky < 80) return mt_rand(1,4);
        if( $lucky >= 80  && $lucky < 95) return  mt_rand(1,2);
        if( $lucky >= 95) return 1;
    }
}
