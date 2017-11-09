<?php

Route::namespace('LaraMall\Weixin')
	 ->middleware('web')
	 ->group(function(){
	 	
	 Route::get('weixin/login','WeixinController@login');
	 Route::get('weixin/callback','WeixinController@callback');

});