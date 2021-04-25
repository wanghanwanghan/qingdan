<?php

namespace Controllers\Api;

use Controllers\ControllerBase;

class Index extends ControllerBase
{
    function index()
    {
        return $this->writeJson();
    }
}
