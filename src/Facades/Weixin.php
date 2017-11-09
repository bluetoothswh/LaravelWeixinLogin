<?php

namespace LaraMall\Weixin\Facades;
use Illuminate\Support\Facades\Facade;
class Weixin extends Facade
{

	protected static function getFacadeAccessor()
	{
		return 'weixin';
	}
}