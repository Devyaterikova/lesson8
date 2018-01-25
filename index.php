<?php
require_once 'functions.php';
$notice = 0;
if (isGet()) {
    setcookie('user_name', $_GET['user_name']);
    redirect('list');
}
if (isAuthorized()) {
    redirect('admin');
}
if (isPost()) {
    if (login(getParamPost('login'), getParamPost('password'))) {
        redirect('admin');
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Авторизация</title>
<body>
<div class="form">
    <form action="" method="get">
        <label for="login">Чтобы войти как гость введите только имя</label><br>
        <input id="login" type="text" name="user_name" placeholder="Введите имя"><br><br>
        <input type="submit" value="Войти как гость">
    </form>
    <h1>Авторизация</h1>
    <form action="" method="post">
        <label for="login">Login</label><br>
        <input id="login" type="text" name="login" placeholder="Введите логин"><br><br>
        <label for="password">Password</label><br>
        <input id="password" type="password" name="password" placeholder="Введите пароль"><br><br>
        <input type="submit" value="Войти">
    </form>
</div>
</body>
</html>
