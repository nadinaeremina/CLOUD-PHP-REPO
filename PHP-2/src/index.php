<?php
    // Php-код
    // надо получить данные о сегодняшнем дне: год, месяц, число и день недели
    // транслировать с помощью if-else / switch / match  в русский язык
    // заполнить таблицу, записав в таблицу нужные значения
    $todaYear = date("Y");
    $todayMonth = intval(date("m"));
    $todayMonth = match ($todayMonth) {
         1 => "Январь",
         2 => "Февраль",
         3 => "Март",
         4 => "Апрель",
         5 => "Май",
         6 => "Июнь",
         // и тд
         default => "invalid"
    };
    $todayDay = date("d");
    $todayWeekday = intval(date("w"));
    $todayWeekday = match ($todayWeekday) {
        0 => "Воскресенье",
        1 => "Понедельник",
        2 => "Вторник",
        3 => "Среда",
        4 => "Четверг",
        5 => "Пятница",
        6 => "Суббота",
        // и тд
        default => "invalid"
   };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            text-align: center;
            font-size: 20px;
            font-family: consolas;
        }

        td, th {
            border: 1px solid black;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php
    // любое значение будет конвертироваться в true
    // 0 - в false
    if (1) {
        // код, если true
        echo "true";
    } else {
        // код, если false
        echo "false";
    }

    echo "<br>";
    echo "<br>";

    // исходные данные
    $a = 2.44; $b = 5.45; $x = 3.14;
    echo "a = $a; b = $b; x = $x<br>";

    // решение и вывод результата (где находится значение X)
    if ($a < $x && $x < $b) {
        echo "Внутри<br>";
    // в php есть 'elseif ()'
    } elseif ($x == $a || $x == $b) {
        echo "На границе<br>";
    } else {
        echo "Снаружи<br>";
    }

    // КВУР
    $a1 = 2; $b1 = -3; $c1 = 1;
    echo "<br>$a1 x^2 + $b1 x + $c1 = 0<br><br>";

    // задан номер дня - вывести название этого дня
    $dayNumber = 3; // 1 - пн, 2 - вт, 3 - ср, 4 - чт, и тд

    switch ($dayNumber) {
        case 1:
            echo "Понедельник";
            break;
        case 2: 
            echo "Вторнк";
            break;
        case 3: 
            echo "Среда";
            break;
        // и тд
        default:
            echo "Некорректный номер дня: $dayNumber";
    }

    echo "<br>";

    $res = match ($dayNumber) {
        1 => "Понедельник",
        2 => "Вторник",
        3 => "Среда",
        default => "Некорректный номер дня"
    };

    echo "$res<br><br>";
    ?>
    <table>
        <thead>
            <!-- встраивание переменной в html-разметку -->
            <tr>
                <th>Год</th>
                <th>Месяц</th>
                <th>Число</th>
                <th>День недели</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $todaYear ?></td>
                <td><?= $todayMonth ?></td>
                <td><?= $todayDay ?></td>
                <td><?= $todayWeekday ?></td>
            </tr>
        </tbody>
    </table>

    <!-- 'while' - цикл с предусловие
    'do while' - цикл с послеусловием
    'for' - цикл со счетчиком
    'foreach' - цикл перебора (элементов и ключей массивов) -->
    <?php
    $count = 5;
    while ($count > 0) {
        echo "count: $count<br>";
        $count--;
    }

    for ($i = 0; $i < 10; $i++) { 
        for ($j = 0; $j < 10; $j++) { 
           echo "*";
           // обозначили, какой цикл прервать
           break 2;
        }
        echo "<br>";
    }

    // массив в php - это множество пар ключ-значение
    // все массивы ассоциативны
    // массивы с доступом по индексу (индексы с 0 являются ключами)
    $arr = [10, 25, 15];
    echo "$arr<br>"; //Array
    $arr["test"] = "TEST";
    print_r($arr);
    echo "<br>arr[0] = $arr[0]<br>"; //Array

    // массив ключ-значение
    $map = ["first" => 10, "second" => 25, false => "Hello, world!"];
    print_r($map);

    // 1 // инициализация пустого массива
    $arr2 = [];

    // 2 // заполнение его случайными числами
    for ($i=0; $i < 10; $i++) { 
        // функция заполнения массива случайными числами
        // array_push($arr2, rand(1, 100));
        // в php8 можно так
        $arr2[] = rand(1,100);
    }

    echo "<br>";
    print_r($arr2);

    // 3 // умножаем все элементы на 2
    for ($i=0; $i < count($arr2); $i++) { 
        $arr2[$i] *= 2;
    }

    echo "<br>";
    print_r($arr2);

    // 4 // "красивый" вывод элементов массива - по факту демонстрация foreach (readonly цикл!)
    echo "<ol>";
    foreach ($arr2 as $item) {
        echo "<li>$item</li>";
    }
    echo "</ol>";

    // 5 // foreach с перебором ключей и значений
    // первая переменная будет индексом, а вторая - значением
    echo "<table>";
    foreach ($arr2 as $index => $value) {
        echo "<tr>";
        echo "<td>$index</td><td>$value</td>";
        echo "</tr>";
    }
    echo "</table>";

    // социативные массивы
    $map2 = ["first" => 10, "second" => 15];
    // множество ключей - уникальны, а множество значений нет
    print_r($map2);
    $map2["first"] = 20;
    print_r($map2);

    echo "<br>";

    foreach ($map2 as $key => $value) {
        echo "map[$key] = $value<br>";
    }

    // процедуры, функции
    // функции функции:
    // дублирование кода, декомпозиция (разбили решение на отдельные процедуры), передача колбеков
    function printHeader($text) {
        echo "<h1>$text</h1>";
    }

    printHeader("Hello, world!");

    ///////////// что есть а php-процедурах
    // 1) динамическая типизация => параметры и тип результата любых типов 
    // тогда в нашу ф-цию можно будет передать не только текст - но и число

    // 2) поддерживаются type-hints (отличие от JS)
    // интерпретатор будет проверять, какого типа передали переменную и что возвращает ф-ция
    // типы return важно прописывать в функциях, которые что-то вычисляют
    function sum(int $a, int $b) : int {
        // будет ошибка
        // return "Hello";
        return $a + $b;
    }

    echo sum(10,15)."<br>";
    // так возникнет ошибка 
    // echo sum("hello",15)."<br>";

    // 3) возможность делать return в разных местах

    // 4) variadic args - могут быть разнотипными, в отличие от c#
    // если мы передаем массив - то можем указать тип только array, больше ничего не можем указать
    function sum2(int $a, int $b, ...$vars) : int {
        print_r($vars);
        return $a + $b;
    }

    echo sum2(10, 15, false, 1234, "abcd")."<br>";

    // 5) параметры по умолчанию
    function sum3(int $a, int $b=0) : int {
        return $a + $b;
    }

    // 6) именнованный вызов параметров
    function sum4(int $a=0, int $b=0) : int {
        return $a + $b;
    }
    // и если я не хочу передавать a, но хочу передать b
    echo sum4(b: 15)."<br>";

    // 7) передача параметров-ссылок (тип ссылки)
    function zeroing(array &$arr) {
        for ($i=0; $i < count($arr); $i++) { 
            $arr[$i] = 0;
        }
    }

    $origin = [10, 20, 15];
    zeroing($origin);
    print_r($origin);

    function swap(&$a, &$b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }

    $vars = [10, 15];
    echo "<br>";
    print_r($vars);
    swap ($vars[0], $vars[1]);
    echo "<br>";
    print_r($vars);

    ///////////// что нет а php-процедурах
    // 1) отсутствуют параметрические пергрузки функции 
    // данная й-ция не отработает
    // function sum(int $a, int $b, iint $c) : int {
    //     return $a + $b + $c;
    // }

    // 2) передача параметров по ссылке

    //////// строки
    $str = "Hello, world!";
    echo "<br>".$str[0]."<br>";
    $str[0] = "W";
    echo $str;
    echo "<br>";
    echo strlen($str);

    function sayHello($name, $color="green") {
        echo "<h1 style=\"color: $color;\">Hello, $name</h1>";
    }

    sayHello("John Doe");
    sayHello("John Doe", "red");

    // validateIPv4 - валидация ipv4 - адреса
    // вход: строка проверяемого ipv4 - адреса
    // выход: true, если валидный адрес, иначе false
    // ? - nullable - тип
    function validateIPv4 (?string $ipv4) : bool {
        // die("implement me!");
        // 'die' - функция, которая прекращает выполнение скрипта с ошибкой
        return filter_var($ipv4, FILTER_VALIDATE_IP);
        // 'FILTER_VALIDATE_IP' - валидатор ip-адресов, есть также валидатор email-адресов и тд
    }

    validateIPv4("");
    validateIPv4(null); // не является строкой
    
    echo "127.0.0.1: ".(validateIPv4("127.0.0.1") ? "valid" : "invalid")."<br>"; // valid
    echo "hello: ".(validateIPv4("hello") ? "valid" : "invalid")."<br>"; // invalid

    ?>
</body>
</html>