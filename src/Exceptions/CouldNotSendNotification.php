<?php

namespace FlickerLeap\Clickatell\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * Clickatell responded with an error.
     *
     * @param $description
     * @param string $code
     *
     * @return \FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification
     */
    public static function serviceRespondedWithAnError($description, $code)
    {
        $message = "Clickatell responded with an error '{$description} : {$code}'";

        return new static($message);
    }

    /**
     * Unable to reach Clickatell.
     *
     * @param string $message
     *
     * @return \FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification
     */
    public static function serviceNotReached($message)
    {
        return new static("Unable to connect to Clickatell '{$message}'");
    }

    /**
     * No response from Clickatell.
     *
     * @return \FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification
     */
    public static function noResponse()
    {
        return new static("No response from Clickatell, likely API token.");
    }
}
