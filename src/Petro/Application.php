<?php

namespace XuanChen\Petro;

use Pimple\Container;

/**
 * Class Application.
 *
 * @method static Grang\Client Grang
 * @method static Detail\Client Detail
 * @method static DetailBatch\Client DetailBatch
 * @method static Kernel\Client Client
 */
class Application extends Container
{
    /**
     * 要注册的服务类.
     *
     * @var array
     */
    protected array $providers = [
        Grang\ServiceProvider::class,
        Detail\ServiceProvider::class,
        DetailBatch\ServiceProvider::class,
        Kernel\ServiceProvider::class,
    ];

    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this['config'] = static function () {
            return config('petro');
        };

        $this->registerProviders();
    }

    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * Notes: 获取服务
     *
     * @Author: 玄尘
     * @Date: 2022/2/21 13:22
     * @param  string  $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->offsetGet(strtolower($name));
    }

    /**
     * Notes: 获取服务
     *
     * @Author: 玄尘
     * @Date: 2022/2/21 13:22
     * @param  string  $name
     * @param $arguments
     * @return mixed
     */
    public function __call(string $name, $arguments)
    {
        return $this->offsetGet(strtolower($name));
    }
}