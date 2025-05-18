<?php
    // подключение файлов с кодом
    require_once($_SERVER["DOCUMENT_ROOT"]."/src/cities.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/src/form.php");

    // откроем сессию при обработке страницы
    ini_set('session.cookie_lifetime', 3600 * 24 * 365);
    session_start();

    // обработка формы изменения города
    if (isset($_GET["action"]) && $_GET["action"] == "set-city") {
        setCity($_GET["city"]);
        // сделать redirect-запроса после обновления куки
        header("Location: /");
    }

    // обработка сохранения черновика формы
    if (isset($_GET["action"]) && $_GET["action"] == "save-draft") {
        saveForm($_GET["name"], $_GET["address"], $_GET["contacts"], $_GET["type"]);
        // сделать redirect-запроса после обновления сессии
        session_write_close();
        header("Location: /");
    }

    // обработка очистки формы
    if (isset($_GET["action"]) && $_GET["action"] == "clear") {
        // задестроить сессию и сделать redirect
        session_destroy();
        header("Location: /");
    }

    // обработка отправки формы
    if (isset($_GET["action"]) && $_GET["action"] == "save") {
        // сохранить данные формы из сессии в файл
        saveFormToFile();
        // задестроить сессию и сделать redirect
        session_destroy();
        header("Location: /");
    }

    // получим имеющиеся города для вывода и текущий выбранный город
    $cities = getCities();
    $currentCity = getCurrentCity();

    // получим данные имеющейся формы
    $exists = false;
    $form = getForm($exists);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка на подключение интернетов</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        // область трассировочного вывода
        
    ?>

    <form method="get" action="/">
        <label for="city">Ваш город: </label>
        <select id="city" name="city">
            <?php foreach ($cities as $code => $name): ?>
                <option value="<?= $code ?>" <?= $currentCity == $code? "selected" : "" ?>>
                    <?= $name ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button name="action" value="set-city">Выбрать</button>
    </form>

    <form method="get" action="/">
        <fieldset>
            <legend>Заявка на подключение интернета</legend>
            
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" value="<?= $form["name"] ?>" required minlength="1" />
            <br>

            <label for="address">Адрес:</label>
            <input type="text" id="address" name="address" value="<?= $form["address"] ?>" required minlength="1" />
            <br>

            <label for="contacts">Контакты:</label>
            <input type="text" id="contacts" name="contacts" value="<?= $form["contacts"] ?>" required minlength="1" />
            <br>

            <label for="slow">100мб/с</label>
            <input type="radio" id="slow" name="type" value="slow" <?= $form["type"] === "slow" ? "checked" : "" ?> />
            <label for="middle">500мб/с</label>
            <input type="radio" id="middle" name="type" value="middle" <?= $form["type"] === "middle" ? "checked" : "" ?> />
            <label for="high">1000мб/с</label>
            <input type="radio" id="high" name="type" value="high" <?= $form["type"] === "high" ? "checked" : "" ?> />
            <br>

            <button name="action" value="save-draft">Сохранить черновик</button>
            <button name="action" value="save" <?= !$exists? "hidden" : "" ?>>Отправить</button>
            <button name="action" value="clear">Очистить</button>
        </fieldset>
    </form>
</body>
</html>
