<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// TheSameCountryException - исключение, связанное с повторяющимися данными
class TheSameCountryException extends Exception {

    // переопределение конструктора исключения
    public function __construct(Throwable $previous = null) {
        $exceptionMessage = "you have not entered any new data";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::THE_SAME_COUNTRY_ERROR,
            previous: $previous,
        );
    }
}