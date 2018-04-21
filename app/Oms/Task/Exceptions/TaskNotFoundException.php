<?php

namespace App\Oms\Task\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class TaskNotFoundException extends \Exception
{
    /**
     * TaskNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = 'Task not found',
        $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}