<?php

namespace XuanChen\Petro\Grant;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['grant'] = static function ($app) {
            return new Client($app);
        };
    }
}
