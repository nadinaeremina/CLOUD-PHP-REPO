<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 50px auto;
        }
        td {
            border: 1px solid black;
            padding: 5px;
            width: 100px;
        }
        .negative {
            color: red;
        }
        .positive {
            color: green;
        }
        .zero {
            color: black;
        }
    </style>
</head>
<body>
    <h2>GET FORM</h2>
    <form method="get" action="/">

        <!-- числовое поле -->
        <label for="number">Number:</label>
        <input type="number" id="number" name="number">

        <!-- строковое поле -->
         <label for="text">Text:</label>
        <input type="text" id="text" name="text">

        <!-- кнопка отправки формы -->
        <button>Send</button>
    </form>

    <h2>POST FORM</h2>
    <form method="post" action="/">

        <!-- числовое поле -->
        <label for="number">Number:</label>
        <input type="number" id="number" name="number">

        <!-- строковое поле -->
        <label for="text">Text:</label>
        <input type="text" id="text" name="text">

        <!-- кнопка отправки формы -->
        <button>Send</button>
    </form>

    <?php
    // в php есть много глобальных параметров  $_
    // ассоциативные параметры 
    // содержит в себе get-параметры
    // $_GET
    // содержит в себе post-параметры
    // $_POST

    // в эти два массива будут прилетать параметры, которые мы введем на стр
    echo "GET: ";
    print_r($_GET);
    echo "<br>POST: ";
    print_r($_POST);
    echo "<br>";

    // solveQeEq - решение КВУР вида ax^2 + bx + c = 0
    // вход: коэффициенты a, b, c
    // выход: решение КВУР в виде массива с корнями длины 0, 1 или 2
    // возвращает null если КВУР не решается
    function solveQeEq(float $a, float $b, float $c) : ?array {
        if ($a === 0) {
            return null;    // КВУР решать нельзя
        }
        $d = $b * $b - 4 * $a * $c;
        if ($d < 0) {
            return [];                  // корней нет
        }
        if ($d == 0) {
            return [-$b / (2 * $a)];    // 1 корень
        }
        $x1 = (-$b - sqrt($d)) / (2 * $a);
        $x2 = (-$b + sqrt($d)) / (2 * $a);
        return [$x1, $x2];                // 2 корня
    }

    // входные данные со значениями по умолчанию
    $a = 2; $b = -5; $c = 2;

    // проверка наличия параметров формы в запросе
    // можно проверить, есть ли такая переменная
    if (isset($_GET["a"]) && isset($_GET["b"]) && isset($_GET["c"])) {
        $a = floatval($_GET["a"]);
        $b = floatval($_GET["b"]);
        $c = floatval($_GET["c"]);
    }
    // можно проверить наличие ключа в массиве
    $arr = ["hello" => "world"];
    echo isset($arr["hello"]) ? "set" : "unset";
    echo "<br>";

    // вычисление и подготовка к выводу результата
    $result = solveQeEq($a, $b, $c);
    if ($result === null) {
        $result = "КВУР нельзя решить";
    } elseif (count($result) == 2) {
        $result = "x1 = $result[0]; x2 = $result[1]";
    } elseif (count($result) == 1) {
        $result = "x = $result[0]";
    } elseif (count($result) == 0) {
        $result = "Корней нет";
    } else {
        $result = "Получен некорректный результат";
    }

    // ЗАДАЧА: задана двумерная матрица, необходимо вывести ее в таблицу
    // причем отрицательные элементы красным цветом, положительные зеленым, нулевые черным

    $matrix = [
        [-5, 15, 2, 3],
        [1, -3, 22, 13],
        [-3, -15, 91, 0],
        [5, -15, 0, 3]
    ];
    ?>

    <h1>Решение КВУР</h1>
    <!-- форма КВУР -->
    <form>
        <!-- коэффициент a -->
        <label for="a">a:</label>
        <input type="number" id="a" name="a" step="any" required value="<?= $a ?>" />
        <!-- коэффициент b -->
        <label for="b">b:</label>
        <input type="number" id="b" name="b" step="any" required value="<?= $b ?>" />
        <!-- коэффициент c -->
        <label for="c">c:</label>
        <input type="number" id="c" name="c" step="any" required value="<?= $c ?>" />
        <!-- кнопка отправки формы -->
        <button>Решить</button>
    </form>

    <!-- решение КВУР -->
    <!-- <p><?php echo $result?></p> -->
    <p><?= $result ?></p>

    <!-- ЭТАПЫ РЕАЛИЗАЦИИ ПРИЛОЖЕНИЯ 
    1. верстка страницы будущего приложения
    2. реализовать и протестировать отдельно решение задачи без UI
    3. объявить в PHP-коде переменные, которые будут составлять модель динамической части HTML-кода
    4. проинициализировать значения входных данных по умолчанию и написать код вычисление и подготовки выводимого результата
    5. добавить чтение входные параметров из данных форм ($_GET / $_POST)
    6. протестировать полученное приложение -->

    <h1>Управляющие конструкци</h1>

    <!-- первая версия -->
    <table>
        <?php
            // вывод матрицы
            foreach ($matrix as $row) {
                echo "<tr>";
                foreach ($row as $item) {
                    $class = "zero";
                    if ($item < 0) {
                        $class = "negative";
                    }
                    else if ($item > 0) {
                        $class = "positive";
                    }
                    echo "<td class=\"$class\">$item</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>

    <!-- вторая версия -->
    <table>
        <?php foreach ($matrix as $row): ?>
            <tr>
                <?php foreach ($row as $item): ?> 
                    <!-- здесь выводим без стилей -->
                    <!-- <td><?= $item ?></td> -->

                    <!-- здесь выводим со стилями -->
                    <?php if ($item == 0): ?>
                        <td class="zero"><?= $item ?></td>
                    <?php elseif ($item > 0): ?>
                        <td class="positive"><?= $item ?></td>
                    <?php else: ?>
                        <td class="negative"><?= $item ?></td>
                    <?php endif; ?>
                <!-- здесь закрывается наш внутренний цикл foreach -->
                <?php endforeach; ?>
            </tr>  
        <!-- здесь закрывается наш внешний цикл foreach -->
        <?php endforeach; ?>
    </table>

</body>
</html>