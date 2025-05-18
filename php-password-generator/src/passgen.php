<?php

// generatePassword - генерация пароля по заданным параметрами
// вход:
//  - length - длина требуемого пароля, по умолчанию == 6; length >= 4 && length <= 20, иначе length == 6
//  - requiredSymbols - строка символов, обязательно встречающиеся в пароле (хотя бы 1 раз), по умолчанию пустая
//  - exludedSymbols - строка символов, которые не должны встречаться в пароле, по умолчанию пустая
//  - excludedCombinations - массив строк через variadic args, которые представляют сочетания, не встречающиеся в пароле
// выход:
//  - сгенерированный пароль если все параметры валидные
//  - null если входные параметры некорректные или генерация пароля не возможна по тем или иным причинам
function generatePassword(
    int $length=6, 
    string $requiredSymbols="", 
    string $exludedSymbols="", 
    string ...$excludedCombinations // массив строк
) : ?string {
    throw new Error("implement me!");
}
