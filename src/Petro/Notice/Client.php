<?php

namespace XuanChen\Petro\Notice;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Str;
use XuanChen\Petro;
use XuanChen\Petro\Kernel\BaseClient;
use XuanChen\Petro\Models\PetroCoupon;
use XuanChen\Petro\Exceptions\PetroException;

class Client extends BaseClient
{

    public $coupon_list;
    public $back_params;
    public $back_body;

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
            $this->setActionType('Notice');
            $verifyCode = $this->params['sendMessage']['head']['verifyCode'];
            $body       = $this->params['sendMessage']['body'];
            $this->setSign($body);

            if ($verifyCode != strtoupper($this->verifyCode)) {
                throw  new  PetroException('签名错误');
            }

            $data = $this->decrypt($body);

            $couponList = $data['couponStateChangeRequestVo']['couponList'];

            foreach ($couponList as $couponInfo) {
                PetroCoupon::query()->where('couponNo', $couponInfo['couponNo'])->update([
                    'useTime'     => Carbon::parse($couponInfo['useTime']),
                    'status'      => $couponInfo['status'],
                    'stationName' => $couponInfo['stationName'],
                    'stationCode' => $couponInfo['stationCode'],
                    'goodsInfo'   => $couponInfo['goodsInfo'],
                ]);

                $this->coupon_list .= ','.$couponInfo['couponNo'];
            }

            $backData = $this->getBackData(true, $this->coupon_list);

            $this->app->log->setData([
                'in_source'  => $this->params,
                'out_source' => $backData
            ])->start();

            return $backData;

        } catch (\Exception $e) {
            $this->app->log->setData([
                'in_source'  => $this->params,
                'out_source' => $this->getBackData(false, $this->coupon_list)
            ])->start();
            return $e->getMessage();
        }

    }

}
