<?php

namespace XuanChen\Petro\Grant;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro\Kernel\BaseClient;

class Client extends BaseClient
{
    protected $app;

    protected $config;

    public $client;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->app    = $app;
        $this->config = $app->config;

        $this->client = new Guzzle([
            'base_uri' => $this->config['base_uri'],
        ]);

    }

    public function __call($method, $args)
    {
        return $this->request($method, ...$args);
    }

}
