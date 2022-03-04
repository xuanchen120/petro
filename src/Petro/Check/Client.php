<?php

namespace XuanChen\Petro\Check;

use Exception;
use XuanChen\Petro\Kernel\BaseClient;
use XuanChen\Petro\Kernel\Models\PetroCoupon;

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
            $this->setActionType('getCheckCode');
            $this->app->client->getGrant($this->getPostData());//获取优惠券
            $this->app->callback->setInData($this->app->client->resData)->start();//解密
            $checkCode = $this->app->callback->truthfulData['checkCode'];

            //入库
            $this->app->log->setData([
                'in_source'  => $this->client->postData,
                'out_source' => $this->app->callback->inData
            ])->start();

            return $checkCode;
        } catch (\Exception $e) {
            $this->app->log->setData([
                'in_source'  => $this->app->client->postData,
                'out_source' => ['error' => $e->getMessage()]
            ])->start();

            return $e->getMessage();
        }

    }

}
