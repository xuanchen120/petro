<?php

namespace XuanChen\Petro\Detail;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro\Exceptions\PetroException;
use XuanChen\Petro\Kernel\BaseClient;
use XuanChen\Petro\Kernel\Models\PetroCoupon;

class Client extends BaseClient
{
    public function start()
    {
        try {
            $this->setActionType('pfQueryCoupon');
            $coupon = PetroCoupon::query()->where('couponNo', $this->params['couponNo'])->first();
            if (! $coupon) {
                throw new PetroException('未查询到优惠券信息');
            }

            $this->app->client->getGrantInfo($this->getPostData());//获取优惠券
            $this->app->callback->setInData($this->app->client->resData)->start();//解密
            //入库
            $this->app->log->setData([
                'in_source'  => $this->app->client->postData,
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
