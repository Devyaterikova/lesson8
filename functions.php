<?php
session_start();
function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function login($login, $password)
{
    $user = getUser($login);
    if (!$user) {
        return false;
    }
    if ($user['password'] == $password) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function getParamPost($name)
{
    return isset($_POST[$name]) ? $_POST[$name] : null;
}

function getUsers()
{
    $json = file_get_contents(__DIR__ . '/data/login.json');
    $data = json_decode($json, true);
    if (!$data) {
        return [];
    }
    return $data;
}

function getUser($login)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['login'] == $login) {
            return $user;
        }
    }
    return null;
}

function getUserName($login)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['login'] == $login) {
            return $user['user_name'];
        }
    }
    return null;
}

function getGuestName()
{
    if (!empty($_COOKIE['user_name']))
    {
        return $_COOKIE['user_name'];
    }
    return false;
}

function isAuthorized()
{
    return !empty($_SESSION['user']);
}

function name()
{
    if (isAuthorized() && $_SESSION['user'] == true)
    {
        return $_SESSION['user']['user_name'];
    }
    return false;
}

function isGet()
{
    return !empty($_GET['user_name']);
}

function isCookie()
{
    return !empty($_COOKIE['user_name']);
}


function redirect($page)
{
    header("Location: $page.php");
    die;
}

function logout()
{
    session_destroy();
    setcookie('user_name',"");
    redirect('index');
}
