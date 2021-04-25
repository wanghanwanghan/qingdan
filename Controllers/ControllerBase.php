<?php

namespace Controllers;

class ControllerBase
{
    function writeJson($code = 200, $paging = null, $result = null, $msg = null, $info = null): string
    {
        $code = $code - 0;

        if (is_array($paging)) {
            foreach ($paging as $key => $val) {
                $paging[$key] = $val - 0;
            }
        } else {
            $paging = null;
        }

        return json_encode([
            'code' => $code,
            'paging' => $paging,
            'result' => $result,
            'msg' => $msg,
            'info' => $info
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
