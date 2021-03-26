<?php
require('function.php');

//セッションに何もない配列を代入
$_SESSION = array();
if (ini_set('session.use_cookies ')) {
    $params = session_get_cookie_params();
    setcookie(session_name() . '', time() - 3600,
        $params['path'], $params['domain'], $params
        ['secure'], $params['HttpOnly']);
}
session_destroy();

setcookie('email', '', time()-3600);

    header('Location: login.php');
    exit();
?>