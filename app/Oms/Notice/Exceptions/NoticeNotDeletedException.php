<?php

namespace App\Oms\Notice\Exceptions;


use Illuminate\Http\Response;
use Throwable;

class NoticeNotDeletedException extends \Exception
{
    public function __construct(
        $message = "Notice not deleted.",
        $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}