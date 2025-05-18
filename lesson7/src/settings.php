<!-- настройки сайта -->

<?php

// здесь можем увидеть поле: 'request_method'
// оно будет заполнено методом 'get'
// print_r ($_SERVER);

// следующий код нужен для того, чтобы не попадать сразу же в 'if'
// как только загрузим страницу
print_r($_SERVER);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    print_r($_SERVER);
    $color = $_POST['color'];
    setcookie("color", $color, time() + 36000, "/");

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
$color = $_COOKIE["color"] ?? 'white';
// если такая переменная существует - она будет присвоена в 'color'

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Настройки</title>
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

    <h2>Выберите цвет</h2>

    <form action="" method="post">
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
