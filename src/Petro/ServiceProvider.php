<?php

namespace XuanChen\CouponAssemble;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Notes: 部署
     *
     * @Author: 玄尘
     * @Date: 2022/2/21 9:31
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/config.php' => config_path('coupon-assemble.php')], 'coupon-assemble');
        }
    }

    /**
     * Notes: 注册功能
     *
     * @Author: 玄尘
     * @Date: 2022/2/21 9:31
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'coupon-assemble');
    }
}
