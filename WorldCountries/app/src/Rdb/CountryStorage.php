<?php 

namespace App\Rdb;

use mysqli;
use RuntimeException;
use Exception;

use App\Model\Country;
use App\Model\CountryRepository;
use App\Rdb\SqlHelper;

// CountryStorage - имплементация хранилища стран, работающая с БД
class CountryStorage implements CountryRepository {

    public function __construct(
        private readonly SqlHelper $sqlHelper
    ) {
        $sqlHelper->pingDb();
    }

    // ПЕРЕОПРЕДЕЛЕНИЕ МЕТОДОВ ИНТЕРФЕЙСА CountryStorage
    public function selectAll(): array {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT shortName_f, fullName_f, isoAlpha2_f, isoAlpha3_f, 
                isoNumeric_f, population_f, square_f
                FROM country_t;';
            // выполнить запрос
            $rows = $connection->query(query: $queryStr);
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                $country = new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: intval($row[4]),
                    population: intval($row[5]),
                    square: $row[6],
                );
                array_push($countries, $country);
            }
            // вернуть результат
            return $countries;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function selectByCode(string $code): ?Country {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // узнаем, какой тип кода нам прилетел на вход
            $enterCode;
            if (ctype_alpha($code)) {
                if (strlen($code) == 2) {
                    $enterCode = 'isoAlpha2_f';
                } else {
                    $enterCode = 'isoAlpha3_f';
                }
            } else {
                $enterCode = 'isoNumeric_f';
            }
            // подготовить строку запроса
            $queryStr = 'SELECT shortName_f, fullName_f, isoAlpha2_f, isoAlpha3_f,
                isoNumeric_f, population_f, square_f 
                FROM country_t
                WHERE ';
            $queryStr = $queryStr.$enterCode;
            $queryStr = $queryStr.' = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            while ($row = $rows->fetch_array()) {
                // если есть результат - вернем его
                return new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value: $row[5]),
                    square: intval(value: $row[6])
                );
            }
            // иначе вернуть null
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function isName(string $name, string $type): ?Country {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = 'SELECT shortName_f, fullName_f, isoAlpha2_f, isoAlpha3_f,
                isoNumeric_f, population_f, square_f 
                FROM country_t
                WHERE ';
            $queryStr = $queryStr.$type;
            $queryStr = $queryStr.' = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $name);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            while ($row = $rows->fetch_array()) {
                // если есть результат - вернем его
                return new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value: $row[5]),
                    square: intval(value: $row[6])
                );
            }
            // иначе вернуть null
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function save(Country $country): void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить запрос INSERT
            $queryStr = 'INSERT INTO country_t (shortName_f, fullName_f, isoAlpha2_f, isoAlpha3_f,
                isoNumeric_f, population_f, square_f)
                VALUES (?, ?, ?, ?, ?, ?, ?);';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                'sssssii', 
                $country->shortName,
                $country->fullName, 
                $country->isoAlpha2, 
                $country->isoAlpha3, 
                $country->isoNumeric,
                $country->population, 
                $country->square, 
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new EmptyFieldsException(message: 'validation failed',);;
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function update(string $code, Country $country) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
             // узнаем, какой тип кода нам прилетел на вход
            $enterCode;
            if (ctype_alpha($code)) {
                if (strlen($code) == 2) {
                    $enterCode = 'isoAlpha2_f';
                } else {
                    $enterCode = 'isoAlpha3_f';
                }
            } else {
                $enterCode = 'isoNumeric_f';
            }
            // подготовить запрос INSERT
            $queryStr = 'UPDATE country_t SET 
                    shortName_f = ?,
                    fullName_f = ?, 
                    population_f = ?, 
                    square_f = ?  
                WHERE ';
            $queryStr = $queryStr.$enterCode;
            $queryStr = $queryStr.' = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                'ssiis', 
                $country->shortName, 
                $country->fullName,
                $country->population, 
                $country->square, 
                $code,
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'update execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function delete(string $code):void {
        try {
            // создать подключеник к БД
             $connection = $this->sqlHelper->openDbConnection();
            // узнаем, какой тип кода нам прилетел на вход
            $enterCode;
            if (ctype_alpha($code)) {
                if (strlen($code) == 2) {
                    $enterCode = 'isoAlpha2_f';
                } else {
                    $enterCode = 'isoAlpha3_f';
                }
            } else {
                $enterCode = 'isoNumeric_f';
            }
            // подготовить запрос DELETE
            $queryStr = 'DELETE FROM country_t WHERE ';
            $queryStr = $queryStr.$enterCode;
            $queryStr = $queryStr.' = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'delete execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }
}