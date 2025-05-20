<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MYSQL TEMPLATE</title>
</head>
<body>
    <h1>PHP MYSQL TEMPLATE</h1>
    <?php 
        require_once($_SERVER["DOCUMENT_ROOT"]."/src/connection.php");
        pingDb();
    ?>

    <h2>Select all rows</h2>

    <?php
        // получение всех записей таблицы
        // 1. создатьподключение к БД
        $conn = openDbConnection();
        // 2. подготовить запрос к БД
        $query = "SELECT id, some_field_f FROM some_table_t";
        // 3. выполнить запрос 
        $rows = $conn->execute_query($query);
        // 4. считать результаты запроса
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row;
        }
        // закрыть соединение 
        $conn->close();

        print_r($result);
    ?>

    <!-- красивый вывод записей -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Some Field</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["some_field_f"] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>