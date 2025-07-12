<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// DuplicatedCountryException - исключение дублирующегося имени страны
class DuplicatedCountryException extends Exception {

    // переопределение конструктора исключения
    public function __construct(string $duplicatedName, Throwable $previous = null) {
        $exceptionMessage = "country with name '". $duplicatedName ."' is duplicated";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::DUPLICATED_COUNTRY_ERROR,
            previous: $previous,
        );
    }
}

