<?php

namespace XuanChen\Petro\Log;

use Exception;
use Illuminate\Support\Arr;
use XuanChen\Petro\Exceptions\PetroException;
use XuanChen\Petro\Models\PetroLog;

class Client
{
    protected $params;

    public $source;

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
            $this->source = PetroLog::create([
                'type'       => Arr::get($this->params, 'in_source.sendMessage.head.strActionType', ''),
                'in_source'  => Arr::get($this->params, 'in_source', ''),
                'out_source' => Arr::get($this->params, 'out_source', ''),
            ]);

            return $this;
        } catch (PetroException $exception) {
            throw new PetroException($exception->getMessage());
        }

    }

    /**
     * Notes: 设置入库数据
     *
     * @Author: 玄尘
     * @Date: 2022/2/22 14:58
     * @param $params
     * @return mixed
     */
    public function setData($params)
    {
        $this->params = $params;

        return $this;
    }

}
