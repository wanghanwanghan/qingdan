<?php

namespace Comm;

use Traits\Singleton;

class Log
{
    use Singleton;

    //写日志
    function writeLog($content = '', $type = 'info', $logFileName = '')
    {
        //非字符串的内容处理一下
        if (!empty($content) && !is_string($content)) {
            $content = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $content = '[' . date('Y-m-d H:i:s', time()) . '] [' . strtoupper($type) . '] : ' . $content . PHP_EOL;

        if (empty($logFileName)) {
            $logFileName = 'run.log.' . date('Ymd', time());
        }

        $dir = APP_ROOT . 'Log/';

        try {
            $status = true;
            file_put_contents($dir . $logFileName, $content, FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            $status = false;
        }

        return $status;
    }

}
