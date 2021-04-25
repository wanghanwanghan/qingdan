<?php

namespace Comm;

use Traits\Singleton;

class Response
{
    use Singleton;

    function afterAction(string $resp): string
    {
        return $resp;
    }

}
