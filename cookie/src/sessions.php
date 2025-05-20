<?php
// обязательная команда
session_start();
$_SESSION['user'] = 'Admin';
print_r($_SESSION);