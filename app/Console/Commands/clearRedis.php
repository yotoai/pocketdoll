<?php

namespace App\Console\Commands;

use App\Model\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class clearRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearRedis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $data = Player::all();
        foreach ($data as $v){
            Redis::del($v->user_id . '_catch');
            Redis::del($v->user_id . '_catched');
            Redis::del($v->user_id . '_point');
            Redis::del($v->user_id . '_charge');
            Redis::del($v->user_id . '_mission');
            Redis::del($v->user_id . '_shareWithWx');
            $keys = Redis::keys($v->user_id . '_*_mission');
            foreach ($keys as $s){
                Redis::del($s);
            }
        }
    }
}
