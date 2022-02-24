<?php

namespace XuanChen\Petro\Invalid;

use Exception;
use GuzzleHttp\Client as Guzzle;
use XuanChen\Petro;
use XuanChen\Petro\Exceptions\PetroException;
use XuanChen\Petro\Kernel\BaseClient;
use XuanChen\Petro\Models\PetroCoupon;

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
            $this->setActionType('pfRevokeCoupon');

            $coupon = PetroCoupon::query()->where('couponNo', $this->params['cxcouponNo'])->first();

            if (! $coupon) {
                throw new PetroException('未查询到优惠券信息');
            }

            $this->app->client->invalidCoupon($this->getPostData());//获取优惠券

            $this->app->callback->setInData($this->app->client->resData)->start();//解密
            //入库
            $this->app->log->setData([
                'in_source'  => $this->app->client->postData,
                'out_source' => $this->app->callback->inData
            ])->start();

            $coupon->update([
                'status' => PetroCoupon::STATUS_REPEAL
            ]);

            return $this->app->callback->truthfulData;

        } catch (\Exception $e) {
            if ($this->app->client->postData) {
                $this->app->log->setData([
                    'in_source'  => $this->app->client->postData,
                    'out_source' => ['error' => $e->getMessage()]
                ])->start();
            }

            throw new PetroException($e->getMessage());
        }


    }

}
