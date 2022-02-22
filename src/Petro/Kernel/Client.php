<?php

namespace XuanChen\Petro\Kernel;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro\Exceptions\CouponException;
use XuanChen\Petro\Kernel\Support\RpcRequest;

class Client
{
    protected $app;

    protected $config;

    public $client;

    public function __construct($app)
    {
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

    public function request(string $method, array $params = [])
    {
        $rpcRequest = new RpcRequest();

        $rpcRequest->setMethod($method);

        if (! empty($params)) {
            $rpcRequest->setParams($params);
        }

        return $this->post($rpcRequest);
    }

    protected function post(RpcRequest $body)
    {
        dd($body->getParams());
        try {
            $response = $this->client->post('', $body->getParams());
            $resJson  = json_decode($response->getBody()->getContents(), true);
            dd($resJson);

            if ($resJson['error']) {
                throw new CouponException($resJson['error']);
            }

            return $resJson['result'];
        } catch (Exception $exception) {
            throw new CouponException($exception->getMessage());
        }
    }
}
