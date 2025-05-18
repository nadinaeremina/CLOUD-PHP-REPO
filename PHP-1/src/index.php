<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP SANDBOX</title>
</head>
<body>
    <h1>Hello from PHP Sandbox!</h1>
    <?php
        // тут пишется php-код
        // это просто консольный вывод
        echo "Hello, world!"; 
        
        // эта строка пройдет через интерпретатор и превратится в: <h1>Hello world!</h1>
        echo "<h1>Hello world!</h1>";
        
        // обьявление и инициализация переменной
        $a = 10;
        $str = 'abcd';
        $str2 = "abcd";
        // для того, чтобы делать строку на несколько строк без конкатенации
        $str3 = `sbcd
        
        dcba`;

        echo "a = "; echo $a; echo "<br>";

        // конкатенация через '.'
        echo "a = ".$a."<br>"; 

        // форматированная строка
        echo sprintf("a = %d", $a);

        // интерполяция (работает только в двойных кавычках)
        echo "<br>a = $a<br>";

        // даны 2 переменные: a, b; необходимо выполнить swap их значений и вывести результат
        $a = 10; $b = 15;
        echo "<h4>Before swap:</h4>";
        echo "<br><br>a = $a; b = $b<br>"; 
        
        // swap
        // 1
        // $temp = $a;
        // $a = $b;
        // $b = $temp;

        // 2
        // $a = $a ^ $b;
        // $b = $a ^ $b;
        // $a = $b ^ $a;

        // 3
        [$a, $b] = [$b, $a];

        // result
        echo "<h4>After swap:</h4>";
        echo "a = $a; b = $b<br>"; 

        // деление всегда дробно (если делить целое число на целое - получим дробное)
        $a = 7; $b = 123;
        echo "<br>";
        echo $b / $a; // так получим дробное
        echo "<br>";
        echo intdiv($b, $a); // так получим целое
        echo "<br>";
        echo "<br>";

        // сравнение
        echo ("1" == 1? "true" : "false")."<br>";
        echo ("1" === 1? "true" : "false")."<br>";
        echo "<br>";

        // космический корабль -сравнение двух значений
        echo $a <=> $b;
        // возвращает отричательное число, если левый операнд меньше правого
        // если они равны - 0
        // положительное, если левый больше правого
    ?>
</body>
</html>

<!-- Если код чисо php - то пишем: (php-файлы могут содержать только php-код) -->
<?php
    phpinfo();
    // печатает информацию о php, говорит, что php работает
// без закрывающего тега