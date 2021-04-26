<?php

namespace Controllers\Api;

use Comm\Request;
use Controllers\ControllerBase;
use Services\WeiXinService;

class User extends ControllerBase
{
    function getOpenId()
    {
        $jsCode = Request::getInstance()->getRequestData('jsCode');

        if (empty($jsCode)) {
            return $this->writeJson(201, null, null, 'jsCode不能是空');
        }

        $res = WeiXinService::getInstance()->getOpenId($jsCode);

        return $this->writeJson(200, null, $res);
    }
}
