<?php

namespace FlickerLeap\Clickatell\Exceptions;

use Exception;

class ConfigError extends Exception
{


    public static function configNotSet($config, $env)
    {
        $message = "Clickatell configuration error. '{$config} needs to be set on ENV {$env}'";

        return new static($message);
    }
}
