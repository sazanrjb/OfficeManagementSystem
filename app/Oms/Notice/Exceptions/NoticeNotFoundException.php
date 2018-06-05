<?php

namespace App\Oms\Notice\Exceptions;


use Illuminate\Http\Response;
use Throwable;

class NoticeNotFoundException extends \Exception
{
    public function __construct(
        $message = "Notice not found.",
        $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}