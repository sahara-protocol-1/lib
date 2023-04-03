<?php
session_start();
require 'function.php';

$username = $_POST['username'];
$password = $_POST['password'];


$user = get_user_by_username($username);


if(empty($user)){
    set_flash_message('danger', 'неверный логин или пароль');
    redirect_to('../index.php');
    exit;
};

if (!password_verify($password, $user['password'])){
    set_flash_message('danger', 'неверный логин или пароль');
    redirect_to('../index.php');
    exit;
};

$_SESSION['user'] = $user['username']; // Записываем теперь данные пользователя в глобальную переменную, уже из которой мы будет дальше предоставлять информацию по ним.

redirect_to('../books.php');
exit;















?>