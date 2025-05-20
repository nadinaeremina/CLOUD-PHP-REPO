<?php
// 'connection.php' функции открытия и проверки соединения с БД

// функция для проверки соединения - открывает соединение и проверяет, что все работает
function pingDb() : void {
    try {
        $conn = openDbConnection();
        echo "connection successfully established<br>";
        $conn->close();
         echo "connection successfully closed, ping OK<br>";
    } catch (Exception $ex) {
        die("ping failed: ".$ex->getMessage());//свернуть и вызываеем функцию
    }
}

// openDbConnection - создание подключения БД - процедурный метод
function openDbConnection() : mysqli {
    // TODO: вынести пар-ры в конфигурационный файл 
    $host = "db";
    $port = 3306;
    $username = "root";
    $password = "root";
    $database = "some_db";
    // если php будет работать на хосте -пар-ры будут отличаться

    // создать и вернуть подключение к БД
    return new mysqli($host, $username, $password, $database, $port);
}