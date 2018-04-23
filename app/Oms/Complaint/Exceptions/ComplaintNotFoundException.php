<?php

namespace App\Oms\Complaint\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class ComplaintNotFoundException extends \Exception
{
    public function __construct(
        $message = "Complaint not found.",
        $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}