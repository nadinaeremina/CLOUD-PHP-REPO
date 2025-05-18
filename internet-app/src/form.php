<?php

// form.php - файл с кодом для работы с данными формы заявки на подключение интернета

// getForm - получение данных формы, которые извлекаются из сессии, либо создается новая форма
// перед использованием функции обязательно необходимо открыть сессию в вызывающем файле-странице (session_start())
function getForm(bool &$exists) : array {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        // проверим открыта ли сессия
        die("session is not active");
    }
    if (isset($_SESSION["form"])) {
        // если данные ранее сохраненной формы есть в сессии, то декодировать их и вернуть
        $exists = true;
        return json_decode($_SESSION["form"], true);
    }
    // иначе вернуть форму по умолчанию
    $exists = false;
    return newEmptyForm();
}

// saveForm - сохранение данных формы в сессии
function saveForm(string $name, string $address, string $contacts, $type) : void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        // проверим открыта ли сессия
        die("session is not active");
    }
    $form = [
        "name" => $name,
        "address" => $address,
        "contacts" => $contacts,
        "type" => $type
    ];
    $_SESSION["form"] = json_encode($form);
}

// newEmptyForm - инициализация данных новой формы
function newEmptyForm() : array {
    return [
        "name" => "",
        "address" => "",
        "contacts" => "",
        "type" => "middle"
    ];
}

// saveFormToFile - сохранение данных формы из сессии в файл
// имя файла задано фиксировано
function saveFormToFile() {
    $exists = false;
    $form = getForm($exists);
    if (!$exists) {
        die("no form in session");
    }
    $path = $_SERVER["DOCUMENT_ROOT"]."/data/forms.dat";

    // ЗАДАНИЕ: дописать код записи очередной формы в файл
    // формат записи:
    // <дата и время отправки заявки>: <город> : <имя> : <адрес> : <контакты> : <тип>
    // каждая заявка пишется с новой строки
    die("implement me!");
}
