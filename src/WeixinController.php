<?php

namespace LaraMall\Weixin;
use App\Http\Controllers\Controller;
use LaraMall\Weixin\Facades\Weixin;
use LaraMall\Weixin\Models\User;
class WeixinController extends Controller
{

	/*
    |--------------------------------------------------------------------------
    | 
    |   构造函数
    |
    |--------------------------------------------------------------------------
    */
    public function __construct()
    {

    }


    /*
    |--------------------------------------------------------------------------
    | 
    |   登录链接
    |
    |--------------------------------------------------------------------------
    */
    public function login()
    {
    	return  redirect(Weixin::redirect());
    }

    /*
    |--------------------------------------------------------------------------
    | 
    |   处理回调函数
    |
    |--------------------------------------------------------------------------
    */
    public function callback()
    {
    	$info 		= Weixin::user(request()->code);
    	//如果已经注册过直接登录
    	if($user = User::where('weixin_openid',$info->openid)->first())
    	{
    		auth()->guard('web')->login($user);
    		return redirect('auth/center');
    	}
    	//使用微信用户信息注册会员 再登录
    	auth()->guard('web')->login(User::register($info));
    	return redirect('auth/center');

    }
}