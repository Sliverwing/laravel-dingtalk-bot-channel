<?php

namespace Sliverwing\DingtalkBotChannel\Exceptions;

class CouldNotSendMessageException extends \Exception
{
    public static function tokenIsRequired()
    {
        return new static('Token is not found');
    }

    public static function responseError($code, $message)
    {
        return new static('Status Code: ' . $code . 'Error Message: ' . $message);
    }

}