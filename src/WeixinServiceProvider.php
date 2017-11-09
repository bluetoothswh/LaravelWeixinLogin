<?php

namespace LaraMall\Weixin;

use Illuminate\Support\ServiceProvider;

class WeixinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   
        //发布配置文件
        $this->publishes([
            __DIR__.'/config/weixin.php' => config_path('weixin.php'),
        ]);

        //加载路由文件
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/weixin.php', 'weixin'
        );
        $this->app->bind('weixin','LaraMall\Weixin\Weixin');
    }
}
