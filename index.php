<?php

//1,结合前几次的作业，写一个自己的FPM框架，要求
//  自动加载 ✅
//  异常容错 ✅
//  日志追踪 ✅
//  路由自动映射 ✅
//2,pcntl_*系列函数的熟悉与使用

define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

//自动加载
spl_autoload_register(function ($class) {
    require_once str_replace('\\', '/', $class) . '.php';
});

//设置用户自定义的错误处理程序，然后通过trigger_error()触发
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $err = [
        'no' => $errno,
        'str' => $errstr,
        'file' => $errfile,
        'line' => $errline,
    ];
    \Comm\Log::getInstance()->writeLog($err, 'user-trigger', 'user-trigger.log');
}, E_ALL);

//设置异常处理，用于没有用 try/catch 块来捕获的异常
set_exception_handler(function (\Throwable $e) {
    $err = [
        'no' => $e->getCode(),
        'str' => $e->getTraceAsString(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'msg' => $e->getMessage(),
    ];
    \Comm\Log::getInstance()->writeLog($err, 'user-throwable', 'user-throwable.log');
});

//捕获致命错误，php脚本执行完也会执行
register_shutdown_function(function () {
});

$getRequestRouter = \Router\HandleRouter::getInstance($_SERVER['PATH_INFO'])->getRequestRouter();

$type = ucfirst($getRequestRouter[0]);
$controller = ucfirst($getRequestRouter[1]);
$action = $getRequestRouter[2];

$controllerPath = "\Controllers\\{$type}\\{$controller}";

$controller = new $controllerPath;

//读取配置文件
\Comm\Config::getInstance()->readConf(__DIR__ . '/Config');

//获取请求参数
\Comm\Request::getInstance()->handleRequestData();

$resp = $controller->$action();

$resp = \Comm\Response::getInstance()->afterAction($resp);

header('Content-Type: application/json;charset=UTF-8');
header('Content-Length: ' . strlen($resp));

echo $resp;
