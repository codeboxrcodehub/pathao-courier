<?php

namespace Codeboxr\PathaoCourier\Exceptions;

use Exception;
use Throwable;

class PathaoCourierValidationException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (is_array($message)) {
            $requiredColumnsImplode = implode(",", $message);
            parent::__construct("$requiredColumnsImplode filed is required", $code, $previous);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }
}
