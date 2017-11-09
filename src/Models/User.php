<?php

namespace LaraMall\Weixin\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
class User extends Authenticatable
{
	use Notifiable;
	protected $table = "users";
	protected $fillable = [
        'username', 
        'email',
        'password',
        'phone',
        'register_time',
        'start_time',
        'end_time',
        'ip',
        'weixin_openid',
        'avatar',
    ];


    /*
    |--------------------------------------------------------------------------
    | 
    |   使用微信用户信息注册
    |
    |--------------------------------------------------------------------------
    */
    public static function register($info)
    {
    	return (new static)->create([

    			'username' 			=> $info->nickname,
    			'email'	   			=> 'weixin-'.str_random(5).'@larashuo.com',
    			'phone'	   			=> '10000000000',
    			'password' 			=> Hash::make(str_random(6)),
    			'ip'	   			=> request()->ip(),
    			'register_time' 	=> time(),
    			'start_time'		=> time(),
    			'end_time'			=> time(),
    			'weixin_openid'		=> $info->openid,
    			'avatar'			=> $info->headimgurl,
    	]);
    }
}