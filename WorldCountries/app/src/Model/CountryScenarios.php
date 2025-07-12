<?php

namespace App\Model;

use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\InvalidCodeException;
use App\Model\Exceptions\DuplicatedCodeException;
use App\Model\Exceptions\DuplicatedCountryException;
use App\Model\Exceptions\InvalidFieldException;
use App\Model\Exceptions\EmptyFieldsException;
use App\Model\Exceptions\TheSameCountryException;
use App\Model\Exceptions\NotMatchCodesException;

// 'CountryScenarios' - класс с методами работы с объектами - странами
class CountryScenarios {

    public function __construct(
        private readonly CountryRepository $storage
    ) {

    }

    // GetAll(): array - получение списка всех стран
    // вход: -
    // выход: список объектов 'Country'
    public function getAll(): array {
        return $this->storage->selectAll();
    }

    // Get(code) : Country - получение страны по коду
    // get - получение страны по коду
    // вход: код страны (трехбуквенный, двубуквенный или числовой)
    // выход: объект извлеченной страны
    // исключения: CountryNotFoundException, InvalidCodeException
    public function get(string $code) : Country {
        // выполнить проверку корректности кода
        if (!$this->validateCode($code)) {
            throw new InvalidCodeException($code, 'validation failed');
        }
        // получить страну по данному коду
        $country = $this->storage->selectByCode($code);
        if ($country === null) {
            // если страна не найдена - выбросить ошибку
            throw new CountryNotFoundException($code);
        }
        //  вернуть полученный аэропорт
        return $country;
    }

    // Store(country): void - сохранение новой страны
    // вход: объект страны
    // выход: -
    // исключения: InvalidCodeException, DuplicatedCodeException, 
    // DuplicatedCountryException, InvalidFieldException
    public function store(Country $country): void {
        // выполнить проверку корректности кода
        if (!$this->validateCode(code: $country->isoAlpha2)) {
            throw new InvalidCodeException(
                invalidCode: $country->isoAlpha2, 
                message: 'validation failed',
            );
        } else if (!$this->validateCode(code: $country->isoAlpha3)) {
            throw new InvalidCodeException(
                invalidCode: $country->isoAlpha3, 
                message: 'validation failed',
            );
        } else if (!$this->validateCode(code: $country->isoNumeric)) {
            throw new InvalidCodeException(
                invalidCode: $country->isoNumeric, 
                message: 'validation failed',
            );
        }
        // выполнить проверку уникальности кода
        $codeAlpha2 = $this->storage->selectByCode(code: $country->isoAlpha2);
        if ($codeAlpha2 != null) {
            throw new DuplicatedCodeException(duplicatedCode: $codeAlpha2->isoAlpha2);
        }
        $codeAlpha3 = $this->storage->selectByCode(code: $country->isoAlpha3);
        if ($codeAlpha3 != null) {
            throw new DuplicatedCodeException(duplicatedCode: $codeAlpha3->isoAlpha3);
        }
        $codeNumeric = $this->storage->selectByCode(code: $country->isoNumeric);
        if ($codeNumeric != null) {
            throw new DuplicatedCodeException(duplicatedCode: $codeNumeric->isoNumeric);
        }
        // выполнить проверку уникальности названия страны
        $shortName = $this->storage->isName(name: $country->shortName, type: "shortName_f");
        if ($shortName != null) {
            throw new DuplicatedCountryException(duplicatedName: $country->shortName);
        }
        $fullName = $this->storage->isName(name: $country->fullName, type: "fullName_f");
        if ($fullName != null) {
            throw new DuplicatedCountryException(duplicatedName: $country->fullName);
        }
        // выполнить проверку значения населения 
        if ($country->population <= 0) {
            throw new InvalidFieldException(message: 'validation failed',);
        }
        // выполнить проверку значения площади
        if ($country->square <= 0) {
            throw new InvalidFieldException(message: 'validation failed',);
        }
        // если все ок, то сохранить страну в БД
        $this->storage->save(country: $country);
    }

    // Edit(code, country): void - редактирование страны по коду
    // вход: код редактируемой страны (не обновленный), сама страна
    // выход: -
    // исключения: InvalidCodeException, CountryNotFoundException, NotMatchCodesException,
    // InvalidFieldException, TheSameCountryException
    public function edit(string $code, Country $country): void  {
        // выполнить проверку корректности кода
        if (!$this->validateCode($code)) {
            throw new InvalidCodeException($code, 'validation failed');
        }
        // получить страну по данному коду
        $ourcountry = $this->storage->selectByCode($code);
        if ($ourcountry === null) {
            // если страна не найдена - выбросить ошибку
            throw new CountryNotFoundException($code);
        }
        // проверить, не пытаются ли изменить один из уникальных кодов
        if (!$this->notMatchCodes($country, $ourcountry)) {
            throw new NotMatchCodesException();
        }
        // проверить, не отрицательное ли значение у поля 'население'
        if ($country->population <= 0) {
            throw new InvalidFieldException(message: 'validation failed',);
        }
        // проверить, не отрицательное ли значение у поля 'площадь'
        if ($country->square <= 0) {
            throw new InvalidFieldException(message: 'validation failed',);
        }
        // проверить, есть ли вообще отличные данные 
        if ($this->comparisonCountry($country, $ourcountry)) {
            throw new TheSameCountryException();
        }
        // если все ок, то сделать update
        $this->storage->update(code: $code, country: $country);
    }

    // Delete(code): void - удаление страны по коду. 
    // вход: код удаляемой страны
    // выход: -
    // исключения: InvalidCodeException, CountryNotFoundException
    public function remove(string $code) : void {
        // выполнить проверку корректности кода
        if (!$this->validateCode($code)) {
            throw new InvalidCodeException($code, 'validation failed');
        }
        // получить страну по данному коду
        $country = $this->storage->selectByCode($code);
        if ($country === null) {
            // если страна не найдена - выбросить ошибку
            throw new CountryNotFoundException($code);
        }
        // если все ок - удалить
        $this->storage->delete(code: $code);
    }

    // validateCode - проверка корректности кода страны
    // вход: строка кода страны
    // выход: true если строка корректная, иначе false
    private function validateCode(string $code): bool {
        if (ctype_alpha($code)) {
            if (strlen($code) == 2 || strlen($code) == 3) {
                return true;
            } else {
                return false;
            }
        } else if (ctype_digit($code)) {
            if (strlen($code) == 3) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // comparisonCountry - сравнение двух стран
    // вход: две страны
    // выход: true если странытрока равны, иначе false
    private function comparisonCountry(Country $countryFirst, Country $countrySecond): bool {
        if ($countryFirst->shortName == $countrySecond->shortName && 
        $countryFirst->fullName == $countrySecond->fullName &&
        $countryFirst->population == $countrySecond->population &&
        $countryFirst->square == $countrySecond->square) {
            return true;
        }
        return false;
    }

    // notMatchCodes - сравнение уникальных кодов двух стран
    // вход: две страны
    // выход: true если коды равны, иначе false
    private function notMatchCodes(Country $countryFirst, Country $countrySecond): bool {
        if ($countryFirst->isoAlpha2 == $countrySecond->isoAlpha2 && 
        $countryFirst->isoAlpha3 == $countrySecond->isoAlpha3 &&
        $countryFirst->isoNumeric == $countrySecond->isoNumeric) {
            return true;
        }
        return false;
    }
}