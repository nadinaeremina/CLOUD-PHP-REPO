<?php

// user, time, path
// 'setcookie' - формирует что-то в заголовке ответа
// функция для установки куки
// ключ - user, значение - "Вася", далее идет срок действия куки
// если его не поставить - то кука действует только один раз
// 4-ым параметром задаем путь - лучше задаать
// setcookie("user", "Admin", time() + 36000, "/");
// setcookie("color", "red", time() + 36000, "/");

// setcookie("color", "red", time() - 36000, "/");
// если поставить отрицательное значение - команда удаления куки

// echo "<pre>";
// форматированный вывод

// читаем сохраненную информацию
// print_r($_COOKIE);
// кука читается только при повторном запросе

$color = $_COOKIE["color"] ?? 'white';
// если такая переменная существует - она будет присвоена в 'color'

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
     <style>
        body {
            background: <?=$color?>;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .color-form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .color-preview {
            width: 100px;
            height: 100px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="color"] {
            width: 80px;
            height: 40px;
            padding: 2px;
            border: 1px solid #ccc;
            border-radius: 4px;
            }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <a href="/index.php">Главная</a>
    <a href="/settings.php">Настройки</a><br>

    Главная страница

    Куки
    +++ 
    Сохраняются даже после выхода (настройки сайта, чекбокс, запомнить вход)

    ---
    Безопасность, тк хранится на клиенте (информацию может словить троян)
</body>
</html>