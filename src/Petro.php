<?php

namespace XuanChen;

use Illuminate\Support\Facades\Facade;

/**
 * Class Petro.
 *
 * @method static Petro\Grant\Client Grant
 * @method static Petro\Detail\Client Detail
 * @method static Petro\DetailBatch\Client DetailBatch
 * @method static Petro\Kernel\Client Client
 * @method static Petro\CallBack\Client CallBack
 * @method static Petro\Invalid\Client Invalid
 * @method static Petro\Bill\Client Bill
 * @method static Petro\Notice\Client Notice
 * @method static Petro\Cehck\Client Check
 */
class Petro extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Petro\Application::class;
    }
}
