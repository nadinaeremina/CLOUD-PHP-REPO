<?php
require "functions/auth.php";

// здесь можем увидеть поле: 'request_method'
// оно будет заполнено методом 'get'
// print_r ($_SERVER);

// следующий код нужен для того, чтобы не попадать сразу же в 'if'
// как только загрузим страницу
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == "setcolor") {
    // обработчик обработает только форму цвета

    $color = $_POST['color'];

    // COOKIE // 1
    setcookie("color", $color, time() + 36000, "/");

    // SESSIONS // 2
    // $_SESSION['color'] = $color;

    // редирект - перезагрузка страницы
    // 'header' - устанавливает любой заголовок
    header("Location: settings.php");
    // переход на след страницу - в данном случае на эту же

    // чтобы код дальше не пошел - останавливаем программу и просто перезагружаем страницу
    // но уже при повторном заходе будет отправлена кука и страница загрузится
    die();
}

// если установлены куки 'color'

// 1
// if (isset($_COOKIE["color"])) {
//     $color = $_COOKIE["color"];
// } else {
//     $color = 'white';
// }

// 2 // краткая версия
// COOKIE // 1
$color = $_COOKIE["color"] ?? 'white';
// если такая переменная существует - она будет присвоена в 'color'

// SESSIONS // 2
// $color = $_SESSION["color"] ?? 'white';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Настройки</title>
    <?php include "parts/style.php" ?>
</head>
<body>

<?php include "parts/menu.php" ?>

    <h2>Выберите цвет</h2>
    <!-- 
    можно ли одновременно отправить данные и методом 'get' и методом 'post'
    переписка после знака вопроса будет добавлена к текущему url 
    сработает метод 'post', но информация 'get' будет отправлена-->
    <form action="?action=setcolor" method="post">
        <!-- method="get" - сформируется get-запрос:
        http://localhost:8080/settings.php?selectedColor=%23ea2a9a -->
        
        <!-- method="post" - данные сформируются в теле запроса -->

        <div class="form-group">
            <label for="colorpicker">Цвет:</label>
            <input type="color" id="colorpicker" name="color" value="<?=$color?>">
        </div>

        <div class="form-group">
            <label>Предпросмотр:</label>
            <div class="color-preview" id="colorPreview" style="background-color: <?=$color?>;"></div>
        </div>

        <div class="form-group">
            <input type="submit" value="Подтвердить">
        </div>

    </form>

    <script>
    document.getElementById('colorpicker').addEventListener('input', function() {
        document.getElementById('colorPreview').style.backgroundColor = this.value;
    });
    </script>

</body>
</html>
