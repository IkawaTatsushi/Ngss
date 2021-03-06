<?php
session_start();
session_regenerate_id(true);
require('dbconnect.php');

if(isset($_REQUEST['id']) && $_SESSION['id']){
    $follow = $db->prepare('DELETE FROM follow WHERE follow=?');
    $follow->execute(array(
        $_REQUEST['id'],
    ));
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
}else{
    header('Location: error.php');
    exit();
}
?>