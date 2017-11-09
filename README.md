# LaravelWeixinLogin

<p>Laravel 使用微信公众号登录Package </p>

## 安装
````

composer require laramall/laravel-weixin-login

````

## 配置
````
php artisan vendor:publish

//配置文件在 config/wexin.php

return [
		'appid'			=>env('weixin_appid'),
		'secret'		=>env('weixin_secret'),
		'callback_url'	=>env('weixin_callback_url'),
];

//然后可以在.env文件中添加如下数据

weixin_appid='微信公众号appid'
weixin_secret='微信公众号秘钥'
weixin_callback_url='您的回调函数链接'

````

## 相关说明
```
//组件已经默认集成了登录所需的路由和控制器

//微信登录链接为

url('weixin/login');

//处理回调函数 并获取微信用户信息的链接为

url('weixin/callback');

//也可以自定义链接路由
//获取微信登录链接

use Weixin;

public function login()
{
    	return  redirect(Weixin::redirect());
}

//获取回调函数

public function callback()
{
   $user = Weixin::user(request()->code);
   
   dd($user);
}

//获取用户的相关信息

$user->openid;
$user->nickname;
$user->sex;
$user->city;
$user->province;
$user->country;
$user->headimgurl;


```
