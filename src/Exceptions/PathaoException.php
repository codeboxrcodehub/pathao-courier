<?php

namespace Codeboxr\PathaoCourier\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\JsonResponse;

class PathaoException extends Exception
{
    public $errors;

    public function __construct($message = "", $code = 0, $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Json return
     *
     * @return array
     */
    public function render()
    {
        return [
            'error'   => true,
            'code'    => $this->code,
            'message' => $this->getMessage(),
            'errors'  => $this->errors
        ];
    }


    /**
     * Get validation errors
     *
     * @return JsonResponse
     */
    public function getErrors()
    {
        return response()->json($this->errors, $this->code);
    }

}
