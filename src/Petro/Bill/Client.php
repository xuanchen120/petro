<?php

namespace XuanChen\Petro\Bill;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro;
use XuanChen\Petro\Kernel\BaseClient;
use XuanChen\Petro\Models\PetroCoupon;
use XuanChen\Petro\Exceptions\PetroException;

class Client extends BaseClient
{

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
            $this->setActionType('pfQueryBillList');
            $this->app->client->getBill($this->getPostData());//获取对账
            $this->app->callback->setInData($this->app->client->resData)->start();//解密返回值

            //入库
            $this->app->log->setData([
                'in_source'  => $this->client->postData,
                'out_source' => $this->app->callback->inData
            ])->start();
            return $this->app->callback->truthfulData;

        } catch (\Exception $e) {
            $this->app->log->setData([
                'in_source'  => $this->app->client->postData,
                'out_source' => [$e->getMessage()]
            ])->start();

            return $e->getMessage();
        }

    }

}
