<?php
    // относительный путь
    // require_once "./internal/printer.php";

    // можно использовать абсолютный путь - если локально
    // require_once "D:\TOP\PHP\many_pages\src\internal\printer.php";

    // тк запускаем в докере - заменяем все, что до 'src'
    require_once "/var/www/html/internal/printer.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>INDEX</h1>

    <ul>
        <li><a href="/">INDEX</a></li>
        <li><a href="/pages/home.php">HOME</a></li>
        <li><a href="/pages/about.php">ABOUT</a></li>
        <li><a href="/pages/gallery.php">GALLERY</a></li>
    </ul>

    <?php brPrinter("TEST BR_PRINT FROM INDEX"); ?>
</body>
</html>