<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// EmptyFieldsException - не все поля заполнены
class EmptyFieldsException extends Exception {

    // переопределение конструктора исключения
    public function __construct($message, Throwable $previous = null) {
        $exceptionMessage = "not all fields are filled in ".$message;
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::EMPTY_FIELD_ERROR,
            previous: $previous,
        );
    }
}