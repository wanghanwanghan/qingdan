<?php

namespace Comm;

use Traits\Singleton;

class Config
{
    use Singleton;

    private $confContent = [];

    function readConf($configPath): bool
    {
        if ($handle = opendir($configPath)) {
            while (($file = readdir($handle)) !== false) {
                if (strpos($file, '.ini') !== false) {
                    $filename = str_replace('.ini', '', $file);
                    $file = fopen($configPath . '/' . $file, 'r');
                    while (!feof($file)) {
                        $str = fgets($file);
                        $arr = explode('=', $str);
                        $key = trim($arr[0]);
                        $val = trim($arr[1]);
                        $this->confContent[$filename][$key] = $val;
                    }
                    fclose($file);
                }
            }
            closedir($handle);
        }
        return true;
    }

    function getConf($filename, $key, $default = ''): string
    {
        return isset($this->confContent[$filename][$key]) ?
            $this->confContent[$filename][$key] . '' :
            $default . '';
    }


}
