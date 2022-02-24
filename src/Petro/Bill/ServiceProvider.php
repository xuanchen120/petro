<?php

namespace XuanChen\Petro\Bill;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['bill'] = static function ($app) {
            return new Client($app);
        };
    }
}
