<?php

namespace XuanChen\Petro\Invalid;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['invalid'] = static function ($app) {
            return new Client($app);
        };
    }
}
