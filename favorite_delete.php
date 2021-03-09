<?php
session_start();
session_regenerate_id(true);
require('function.php');

if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $favorite = $db->prepare('DELETE FROM favorite WHERE user_id=? AND post_id=?');
    $favorite->execute(array(
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