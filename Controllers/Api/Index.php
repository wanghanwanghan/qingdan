<?php

namespace Controllers\Api;

use Comm\DAOPDO;
use Controllers\ControllerBase;

class Index extends ControllerBase
{
    function index()
    {
        return $this->writeJson(200, null, null, DAOPDO::getInstance()->resultRows());
    }
}
