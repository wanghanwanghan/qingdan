<?php

namespace Services;

use Comm\Config;

class WeiXinService
{
    function getOpenId($code): array
    {
        $url = Config::getInstance()->getConf('weixin', 'getOpenIdUrl');

        $data = [
            'appid' => Config::getInstance()->getConf('weixin', 'miniappid'),
            'secret' => Config::getInstance()->getConf('weixin', 'miniappsecret'),
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];

        return (new HttpCliService())->send($url, $data, [], [], 'get');
    }
}
