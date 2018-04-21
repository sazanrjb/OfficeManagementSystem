<?php

namespace App\Oms\User\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class UserNotFoundException extends \Exception
{
    public function __construct(
        $message = "User not found.",
        $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}