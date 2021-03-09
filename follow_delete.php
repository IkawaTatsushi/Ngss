<?php
session_start();
session_regenerate_id(true);
require('function.php');

if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $follow = $db->prepare('DELETE FROM follow WHERE user_id=? AND follow=?');
    $follow->execute(array(
        $_SESSION['id'],
        $_REQUEST['id']
    ));
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
}else{
    header('Location: error.php');
    exit();
}
?>