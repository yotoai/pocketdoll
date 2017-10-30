<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    //
    use Notifiable;

    protected $table = 'user';

    protected $fillable = ['openid','coin','point','login_time','nickname','icon','new_user_mission'];

}
