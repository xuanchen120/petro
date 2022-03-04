<?php

namespace XuanChen\Petro\Kernel\Listeners;

use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use RuntimeException;
use XuanChen\Petro\Kernel\Event\CouponNotice;

class PetroConponNoticeListener implements ShouldQueue
{

    public $queue = 'LISTENER';

    /**
     * Handle the event.
     *  本时生活 2 核销 3 作废  1撤销
     *
     * @param  XuanChen\UnionPay\Event\UnionpayConponCallback  $event
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(CouponNotice $event)
    {
        $coupon = $event->petro_coupon;
        info(__CLASS__);

        $notice_url = config('petro.ysd_notice_url');
        info($notice_url);

        if ($notice_url && in_array($coupon->status, [2, 3])) {
            $client = new Client();
            $status = [3 => 2, 2 => 1,][$coupon->status];

            $response = $client->request('post', $notice_url, [
                'timeout' => 30,
                'query'   => [
                    'code'   => $coupon->couponNo,
                    'status' => $status,
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $body   = $response->getBody();
                $result = json_decode($body->getContents(), true);
                $error  = false;
                info(json_encode($result));
            } else {
                $remark = '接口错误';
                $error  = true;
            }

            if ($error) {
                throw new RuntimeException($remark);
            }
        }

    }

}
