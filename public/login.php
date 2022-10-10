<?php

use IdPExample\Helper\Utils;

require_once '../bootstrap.php';

$_SESSION['logged'] = $_SESSION['logged'] ?? false;
$_SESSION['user']   = $_SESSION['user'] ?? null;

if ($_SESSION['logged']) {
    Utils::redirect('/redirect.php');
}

$database = require_once '../database_fake.php';
$users = $database['users'];

if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $current_user = array_key_exists($user['username'], $users) ? $users[$user['username']] : null;

    if (is_null($current_user) || password_verify($user['password'], $current_user['password']) === false) {
        Utils::redirect('/login.php');
    }

    $_SESSION['logged'] = true;
    $_SESSION['user'] = $current_user;

    Utils::redirect('/redirect.php');
}

echo Utils::view('login');
