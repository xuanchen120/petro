<?php

namespace XuanChen\Petro\DetailBatch;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple): void
    {
        $pimple['detailbatch'] = static function ($app) {
            return new Client($app);
        };
    }
}
