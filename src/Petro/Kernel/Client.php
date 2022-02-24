<?php

namespace XuanChen\Petro\Kernel;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro\Exceptions\CouponException;
use XuanChen\Petro\Exceptions\PetroException;
use XuanChen\Petro\Kernel\Support\RpcRequest;
use function PHPUnit\Framework\isNull;

class Client
{
    protected $app;

    protected $config;

    public $client;

    public $postData;

    public $resData;

    public $response;

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
        try {
            $this->postData = $body->getParams();
            $this->response = $this->client->post('', [
                'body'    => json_encode($this->postData, JSON_UNESCAPED_SLASHES),
                'headers' => [
                    'Content-Type' => 'application/json;charset=utf-8',
                    'accept'       => 'application/json;charset=utf-8',
                ],
            ]);

            $this->resData = json_decode($this->response->getBody()->getContents(), true);

            if (is_null($this->resData)) {
                throw new PetroException('未获取到返回数据');
            }

            if (isset($this->resData['_error'])) {
                throw new PetroException($this->resData['_error']);
            }

            $this->app->log->setData([
                'in_source'  => $this->postData,
                'out_source' => $this->resData ?? [$this->response->getBody()->getContents()]
            ])->start();

            return true;
        } catch (Exception $exception) {
            throw new PetroException($exception->getMessage());
        }
    }
}
