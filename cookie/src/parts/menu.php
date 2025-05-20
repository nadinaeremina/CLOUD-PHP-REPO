<?php if (!is_null($message)): ?>
    <div>
        <?= $message ?>
    </div>
<?php endif; ?>
<?php if ($auth): ?>
    Добро пожаловать <?= $user ?> <a href="?action=logout">Выход</a> <br>
<?php else: ?>
<form action="?action=login" method="post">
    <input type="text" name="login" placeholder="login">
    <input type="password" name="password" placeholder="password">
    Запомнить?
    <input type="checkbox" name="save">
    <input type="submit" value="Войти">
</form>
<?php endif; ?>
<a href="/index.php">Главная</a>
<a href="/settings.php">Настройки</a><br>