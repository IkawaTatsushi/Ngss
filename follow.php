<?php
require('function.php');

if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $user_id = $_SESSION['id'];
    $re_id = $_REQUEST['id'];
    $follow_check = getFollow($user_id, $re_id);
    if(in_array($_REQUEST['id'], $follow_check)){
        header('Location: error.php');
        exit();
    }else{
        $stmt = follow($user_id,$re_id);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
    }
}else{
    echo 'ログインしてください';
    echo '<a href="login.php">ログイン</a>';
}
?>