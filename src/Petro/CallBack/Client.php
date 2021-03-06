<?php

namespace XuanChen\Petro\CallBack;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro\Exceptions\PetroException;
use XuanChen\Petro\Kernel\BaseClient;

class Client extends BaseClient
{
    public $inData;
    public $truthfulData;

    /**
     * Notes: 开始执行
     *
     * @Author: 玄尘
     * @Date: 2022/2/22 14:05
     * @throws Exception
     */
    public function start()
    {
        try {
            $type               = isset($this->inData['postMessage']) ? 'postMessage' : 'sendMessage';
            $this->truthfulData = $this->inData[$type]['truthfulData'] = $this->decrypt($this->inData[$type]['body']);
            return $this;
        } catch (\Exception $e) {
            throw new PetroException($e->getMessage());
        }
    }

    public function setInData(array $data)
    {
        $this->inData = $data;
        return $this;
    }
}
