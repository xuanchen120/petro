<?php

namespace XuanChen\Petro\Models;

use App\Models\Model;

class PetroLog extends Model
{
    const  TYPE_GRANT   = 'getCoupon';
    const  TYPE_QUERY   = 'pfQueryCoupon';
    const  TYPE_DESTORY = 'pfRevokeCoupon';

    const  TYPES = [
        self::TYPE_GRANT   => '发券',
        self::TYPE_QUERY   => '查询',
        self::TYPE_DESTORY => '作废',
    ];

    public $casts = [
        'in_source'  => 'json',
        'out_source' => 'json',
    ];
}
