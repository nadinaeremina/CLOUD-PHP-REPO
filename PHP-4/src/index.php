<?php
    // разделение программы на файлы
    // include
    // include_once
    // require
    // require_once

    // подключаем наш файл
    include "./greeting.php";
    // будет ошибка - тк два раза подключаем один и тот же файл
    // include("./printer.php");
    // поэтому лучше подключать так
    include_once "./printer.php";
    // он отслеживает, сколько раз было подключено 

    // 'require_once' в отличие от 'include_once' - выкинет ошибку - 'fatal error'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        pprint("Greeting TEST");
        greeting("John Doe");
    ?>
</body>
</html>