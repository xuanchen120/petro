<?php

namespace XuanChen\Petro\Check;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['check'] = static function ($app) {
            return new Client($app);
        };
    }
}
