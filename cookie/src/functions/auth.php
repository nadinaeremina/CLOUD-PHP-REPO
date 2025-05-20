<?php
session_start();

$auth = false;
$message = null;

//Аутентификация по логину паролю
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == "login") {
    //аутентификация //приходят данные с формы - мы их читаем
    $login = $_POST['login'];
    $password = $_POST['password'];
    //валидация
    if (empty($login) || empty($password)) {
        $_SESSION['message'] = "Заполните поля логин пароль";
        header("location: /");
        die();
    }

    if ($login === "admin" && $password === "123") {
        $_SESSION['login'] = "admin";
        if (isset($_POST['save'])) {
            // сгенерируется случайный код
            // $hash = sha1(uniqid(mt_rand(), true));
            // пример
            $hash = '12345678random';
            setcookie("hash", $hash, time() + 36000, '/');
        }
        $_SESSION['message'] = 'Успешный вход, добро пожаловать!';
    } else {
        $_SESSION['message'] = "Не правильный логин пароль";
    }
    header("Location:/");
    die();
}

// как сюда попасть??????????????????????????????????????????????????????
//аутентификация по куке
if (!isset($_SESSION['login']) && isset($_COOKIE['hash'])) {
    $hash = $_COOKIE['hash'];
    if ($hash === "12345678random") {
        $_SESSION['login'] = "admin";
        $_SESSION['message'] = "Это опять вы, привет!";
        header("Location:/");
        die();
    }
}

//аутенификация по сессии
if (isset($_SESSION['login'])) {
    $auth = true;
    $user = $_SESSION['login'];
}

//разлогинивание
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['login']);
    setcookie("hash", "", time() - 3600, '/');
    session_destroy();
    header("Location:/");
    die();
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}