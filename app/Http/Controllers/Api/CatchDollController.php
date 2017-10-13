<?php

namespace App\Http\Controllers\Api;

use App\Model\Goods;
use App\Model\GoodsCategory;
use App\Model\UserRucksack;
use App\Model\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CatchDollController extends BaseController
{
    // 娃娃机选择
    public function selectDollMachine($id)
    {
        $user = session('wechat.oauth_user')->toArray(); // 拿到授权用户资料
        if(!Redis::exists($user['id'] . '_'. $id .'_lucky'))
        {
            Redis::set( $user['id'] . '_'. $id .'_lucky',0);
        }
        $lucky = Redis::get($user['id'] . '_'. $id .'_lucky');
        $data = Goods::where('goods_cate_id',intval($id))->get()->toArray();
        return array_merge(['data' => $data],['lucky' => $lucky]);
    }

    // 随机返回6个娃娃种类
    public function getRandDollMachine()
    {
        //Redis::del('doll_machine');
        $key = 'doll_machine';
        if(Redis::scard($key) > 0){
            return json_decode('['.implode(',',Redis::srandmember($key, 6)).']',true);
        }else {
            foreach (GoodsCategory::all() as $item) {
                Redis::sadd($key, $item);
            }
            return json_decode('['.implode(',',Redis::srandmember($key, 6)).']',true);
        }
    }

    // 抓取娃娃
    public function catchDoll($id,$gid)
    {
        $user = session('wechat.oauth_user')->toArray(); // 拿到授权用户资料
        $gcoin = GoodsCategory::where('id',intval($id))->value('coin');
        $ucoin = Users::where('openid',$user['id'])->value('coin');
        if($ucoin < $gcoin)
        {
            return ['code' => -1,'msg' => '金币不足！'];
        }

        $lucky = Redis::get($user['id'] . '_'. $id .'_lucky');
        $rate = GoodsCategory::where('id',intval($id))->value('win_rate');
        $arr = ['get'=>$rate + $lucky,'lost'=>1000 - ($rate + $lucky)];
        if(($res = $this->getRand($arr)) == 'get' || $lucky == 100)
        {
            Redis::set($user['id'] . '_'. $id .'_lucky',0);
            try{
                UserRucksack::create([
                    'user_id'   => 1,
                    'goods_id'  => $gid,
                    'status'    => '0',
                    'gain_time' => date('Y-m-d H:i:s',time())
                ]);

                Users::where('openid',$user['id'])->update(['coin' => $ucoin - $gcoin]);
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
            return ['data' => 'get','lucky' => 'clear'];
        }else{
            Users::where('openid',$user['id'])->update(['coin' => $ucoin - $gcoin]);
            $add_lucky = $this->reLucky($lucky);
            $ret_lucky = ( ($lucky + $add_lucky) >= 100 ) ? 100 : $lucky + $add_lucky;
            Redis::set($user['id'] . '_'. $id .'_lucky',$ret_lucky);
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

    // 返回随机键
    private function getRand($arr)
    {
	 	$sum = array_sum($arr);
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
        if( $lucky < 60) return mt_rand(1,9);
        if( $lucky >= 60  && $lucky < 80) return mt_rand(1,5);
        if( $lucky >= 80  && $lucky < 95) return  mt_rand(1,2);
        if( $lucky >= 95) return 1;
    }
}
