<?php
    // require_once "./../internal/printer.php";
    // лучше писать так: '$_SERVER["DOCUMENT_ROOT"]' -
    // та часть, которая идет до  корня с исходным кодом,
    // те до папки, где лежит index (var/www/html)
    require_once $_SERVER["DOCUMENT_ROOT"]."/internal/printer.php";
    // если запустим в другом окружении - скрипт отработает без проблем
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>HOME PAGE</h1>

    <ul>
        <?php foreach ($_SERVER as $key => $value): ?> 
            <li><?= "$key: $value" ?></li>
        <?php endforeach; ?>
    </ul>
    <!-- DOCUMENT_ROOT: /var/www/html - абсолютный корень проекта - вычисляется самим php -->

     <ul>
         <li><a href="/">INDEX</a></li>
        <li><a href="/pages/home.php">HOME</a></li>
        <li><a href="/pages/about.php">ABOUT</a></li>
        <li><a href="/pages/gallery.php">GALLERY</a></li>
    </ul>

    <?php brPrinter("TEST BR_PRINT FROM HOME"); ?>
</body>
</html>