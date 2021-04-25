<?php

//1,结合前几次的作业，写一个自己的FPM框架，要求
//  自动加载 ✅
//  异常容错
//  日志追踪
//  路由自动映射 ✅
//2,pcntl_*系列函数的熟悉与使用

define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class) {
    require_once str_replace('\\', '/', $class) . '.php';
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
}, E_ALL);

set_exception_handler(function () {
});

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
