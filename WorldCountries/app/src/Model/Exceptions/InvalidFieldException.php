<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// InvalidFieldException - исключение невалидного поля страны
class InvalidFieldException extends Exception {

    // переопределение конструктора исключения
    public function __construct($message, Throwable $previous = null) {
        $exceptionMessage = "not all fields are filled in correctly ".$message;
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::INVALID_FIELD_ERROR,
            previous: $previous,
        );
    }
}

