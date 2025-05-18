<?php

// cities.php - файл с кодом для работы с городами

// setCity - установка текущего города
function setCity($cityCode) : void {
    setcookie("city_code", $cityCode, time() + 3600 * 24 * 365);
}

// getCurrentCity - получения текущего выбранного города
function getCurrentCity() : string {
    $cities = getCities();

    if (isset($_COOKIE["city_code"])) {
        // достать текущий город из куки
        $cityCode = $_COOKIE["city_code"];
        if (isset($cities[$cityCode])) {
            // если есть такой город (проверка по коду)
            return $cityCode;
        }
    }
    
    // задать и установить текущий город по умолчанию в куки
    $cityCode = array_key_first($cities);
    setcookie("city_code", $cityCode, time() + 3600 * 24 * 365);
    return $cityCode;
}

// getCities - получение городов, имеющихся в системе
function getCities() : array {
    return [
        "msc" => "Москва",
        "ptr" => "Санкт-Петербург",
        "brn" => "Барнаул",
        "oms" => "Омск",
        "msk" => "Мурманск",
        "rst" => "Ростов-на-Дону"
        // etc.
    ];
}
