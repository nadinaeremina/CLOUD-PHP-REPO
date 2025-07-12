<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// NotMatchCodesException - исключение при попытке поменять код
class NotMatchCodesException extends Exception {

    // переопределение конструктора исключения
    public function __construct(Throwable $previous = null) {
        $exceptionMessage = "you are trying to change the unique code!";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::CODES_DIDNT_MATCH,
            previous: $previous,
        );
    }
}