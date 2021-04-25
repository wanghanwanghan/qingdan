<?php

namespace Router;

use Traits\Singleton;

class HandleRouter
{
    use Singleton;

    public $pathInfo = '';

    private function __construct($pathInfo)
    {
        $this->pathInfo = $pathInfo;
    }

    public function getRequestRouter(): ?array
    {
        return array_filter(explode('/', trim($this->pathInfo, '/')));
    }


}
