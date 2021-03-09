<?php
session_start();
session_regenerate_id(true);
require('function.php');

if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $post_id = $_REQUEST['id'];
    $user_id = $_SESSION['id'];

    $favorite_checks = $db->prepare('SELECT * FROM favorite WHERE post_id=? AND user_id=?');
    $favorite_checks->execute(array(
        $post_id,
        $user_id
    ));
    $favorite_check = $favorite_checks->fetch();
    
    if(empty($favorite_check)){
        $favorites = $db->prepare('INSERT INTO favorite SET post_id=?, user_id=?, created=NOW()');
        $favorites->execute(array($post_id, $user_id));

        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>