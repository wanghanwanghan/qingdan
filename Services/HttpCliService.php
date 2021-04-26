<?php

namespace Services;

class HttpCliService
{
    private $curl;

    private $connectionTimeout = 10;

    function __construct()
    {
        //初始化
        $this->curl = curl_init();
    }

    function send($url, $data = [], $headers = [], $options = [], $method = 'post'): array
    {
        //设置请求地址
        curl_setopt($this->curl, CURLOPT_URL, $url);

        //设置headers
        if (!empty($headers)) {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        }

        //几秒后没链接上就自动断开
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);

        //不验证
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

        //返回值不直接显示
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $method = strtoupper($method);

        //设置post方式请求
        if (strtoupper($method) === 'POST') {
            curl_setopt($this->curl, CURLOPT_POST, true);
            //转换成json
            $data = json_encode($data);
            //提交的数据
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        } else {
            $url = trim($url, '/') . '?' . http_build_query($data);
            curl_setopt($this->curl, CURLOPT_URL, $url);
        }

        //发送请求
        $res = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            $resp = curl_error($this->curl);
        } else {
            $resp = $res;
        }

        curl_close($this->curl);

        return [$resp];
    }
}
