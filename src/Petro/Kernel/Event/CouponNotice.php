<?php

namespace XuanChen\Petro\Kernel\Event;


use XuanChen\Petro\Kernel\Models\PetroCoupon;

/**
 * 核券之后的回调
 */
class CouponNotice
{

    public $petro_coupon;

    public function __construct(PetroCoupon $petro_coupon)
    {
        info(__CLASS__);
        $this->petro_coupon = $petro_coupon;
    }

}
