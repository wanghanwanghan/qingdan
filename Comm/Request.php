<?php

namespace Comm;

use Traits\Singleton;

class Request
{
    use Singleton;

    private $requestData;

    function handleRequestData(): bool
    {
        //get提交
        empty($_GET) ? $get = [] : $get = $_GET;

        //post提交
        empty($_POST) ? $post = [] : $post = $_POST;

        //json提交
        $json = file_get_contents('php://input');
        $json = json_decode($json, true);
        !empty($json) ?: $json = [];

        $this->requestData = array_merge($get, $post, $json);

        return true;
    }

    function getRequestData($key, $default = ''): string
    {
        return isset($this->requestData[$key]) ? $this->requestData[$key] : $default;
    }

    function getRequestAllData(): array
    {
        return $this->requestData;
    }





}
