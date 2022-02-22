<?php

namespace XuanChen\Petro\Kernel;

use Illuminate\Support\Arr;

class BaseClient
{
    protected $app;

    protected $config;

    protected $params;

    protected $client;

    public function __construct($app)
    {
        $this->app    = $app;
        $this->config = $app->config;
        $this->client = $app->client;
    }

    /**
     * 获取毫秒级别的时间戳
     */
    public function getMsecTime()
    {
        [$msec, $sec] = explode(' ', microtime());
        $msectime = (float) sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $msectime = explode('.', $msectime);

        return $msectime[0];
    }


    /**
     * Notes: 签名
     *
     * @Author: 玄尘
     * @Date: 2022/2/22 9:52
     */
    public function setSign($body)
    {
        $this->verifyCode = md5($body);
        return $this;
    }

    /**
     * Notes: 设置header
     *
     * @Author: 玄尘
     * @Date: 2022/2/22 10:05
     */
    public function setHeader()
    {
        $this->header = [
            'characterSet'  => Arr::get($this->config, 'characterSet', ''),
            'strVendorCode' => Arr::get($this->config, 'strVendorCode', ''),
            'signType'      => Arr::get($this->config, 'signType', 'MD5'),
            'strActionType' => Arr::get($this->config, 'strActionType', 'pfQueryCoupon'),
            'verifyCode'    => $this->verifyCode,
            'timestamp'     => $this->getMsecTime(),
        ];

    }

    //加密
    public function encrypt($data): string
    {
        if (! is_string($data) && ! is_array($data)) {
            throw new \Exception('The encrypt data must be a string or an array.');
        }
        if (is_array($data)) {
            $data = json_encode($data);
        }

        return base64_encode(openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA));
    }

    //解密
    public function decrypt($data)
    {
        $data  = openssl_decrypt(base64_decode($data), $this->method, $this->key, OPENSSL_RAW_DATA);
        $array = json_decode($data, true);
        return is_array($array) ? $array : $data;
    }

    /**
     * Notes: 设置传入数据
     *
     * @Author: 玄尘
     * @Date: 2022/2/22 9:28
     * @param  array  $args
     * @return $this
     */
    public function setParams(array $args)
    {
        $this->params = $args;

        return $this;
    }

}
