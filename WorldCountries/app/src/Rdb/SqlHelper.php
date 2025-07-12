<?php 

namespace App\Rdb;

use mysqli;
use RuntimeException;
use Exception;

use App\Model\Country;
use App\Model\CountryRepository;

// ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ ДЛЯ РАБОТЫ С БД

class SqlHelper {

    public function __construct() {
    }

    // pingDb - проверить доступность БД
    public function pingDb() : void {
        // открыть и закрыть соединение с БД
        $connection = $this->openDbConnection();
        $connection->close();
    }

    // openDbConnection - открыть соединение с БД
    public function openDbConnection(): mysqli  {
        // зададим параметры подключения к БД 
        $host = $_ENV["DB_HOST"];
        $port = $_ENV["DB_PORT"];
        $user = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];
        $database = $_ENV["DB_NAME"];
        // создать объект подключения через драйвер
        $connection = new mysqli(
            hostname: $host,
            port: $port, 
            username: $user, 
            password: $password, 
            database: $database, 
        );
        return $connection;
    }
}