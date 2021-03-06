<?php
session_start();
session_regenerate_id(true);
require('dbconnect.php');

if(isset($_REQUEST['id']) && $_SESSION['id']){

    $follow_checks = $db->prepare('SELECT follow FROM follow WHERE user_id=?');
    $follow_checks->execute(array($_SESSION['id']));
    $follow_check = $follow_checks->fetchAll(PDO::FETCH_ASSOC);

    if(in_array($_REQUEST['id'], $follow_check)){
        header('Location: error.php');
        exit();
    }else{
        $follow = $db->prepare('INSERT INTO follow SET user_id=?, follow=?, created=NOW()');
        $follow->execute(array(
        $_SESSION['id'],
        $_REQUEST['id']
    ));
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
    }
}else{
    header('Location: error.php');
    exit();
}
?>