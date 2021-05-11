<?php

declare(strict_types=1);

namespace Quiz\Exceptions;

use Exception;
use Illuminate\Http\Response;

class GameException extends Exception
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
