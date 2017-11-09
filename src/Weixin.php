<?php

namespace LaraMall\Weixin;

class Weixin
{
	protected $appid;
	protected $secret;
	protected $callback_url;
	/*
    |--------------------------------------------------------------------------
    | 
    |   构造函数
    |
    |--------------------------------------------------------------------------
    */
    public function __construct()
    {
    	$this->appid 			= config('weixin.appid');
    	$this->secret 			= config('weixin.secret');
    	$this->callback_url		= config('weixin.callback_url');
    }

    /*
    |--------------------------------------------------------------------------
    | 
    |   用户同意授权获取code
    |
    |--------------------------------------------------------------------------
    */
    public function redirect()
    {
    	return  'https://open.weixin.qq.com/connect/oauth2/'
    			.'authorize?appid='
    			.$this->appid
    			.'&redirect_uri='
    			.urlencode($this->callback_url)
    			.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
    }

    /*
	|----------------------------------------------------------------------------
	|
	|  通过code 获取access_token
	|
	|----------------------------------------------------------------------------
	*/
	public function getAccessToken($code)
	{

		$url 		= 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='
					  .$this->appid
					  .'&secret='
					  .$this->secret
					  .'&code='
					  .$code
					  .'&grant_type=authorization_code';
		return $url;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|  通过refresh_token 来刷新access_token 获取openid
	|
	|----------------------------------------------------------------------------
	*/
	public function getOpenId($refresh_token)
	{

		return      'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='
					 .$this->appid
					 .'&grant_type=refresh_token&refresh_token='.$refresh_token;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|  通过第三步获取的 access_token 和 openid 来获取用户信息
	|
	|----------------------------------------------------------------------------
	*/
	public function getUserInfo($access_token,$openid)
	{

		$url 		= 'https://api.weixin.qq.com/sns/userinfo?access_token='
					  .$access_token
					  .'&openid='
					  .$openid
					  .'&lang=zh_CN';
		return $url;
	}



	/*
	|----------------------------------------------------------------------------
	|
	|  读取远程json格式数据
	|
	|----------------------------------------------------------------------------
	*/
	public function json($url)
	{
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}

	/*
	|----------------------------------------------------------------------------
	|
	|  获取最终用户的信息对象
	|
	|----------------------------------------------------------------------------
	*/
	public function user($code)
	{
		//通过code 获取access_token
		$url 					= $this->getAccessToken($code);
		$json 					= $this->json($url);
		$json 					= json_decode($json);
		//刷新access_token
		$url 					= $this->getOpenId($json->refresh_token);
		$json 					= $this->json($url);
		$json 					= json_decode($json);

		//获取用户信息
		$url 					= $this->getUserInfo($json->access_token,$json->openid);
		$json 					= $this->json($url);
		$json 					= json_decode($json);
		//返回最后获取的用户的信息
		return $json;
	}
}