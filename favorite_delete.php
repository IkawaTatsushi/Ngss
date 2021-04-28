<?php
require('function.php');

//いいねを外したいツイートIDがある、かつログインしていたら
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){

    $re_id = $_REQUEST['id'];
    $user_id = $_SESSION['id'];

    //いいねを外し、前画面に遷移
    $favorite = favoriteDelete($re_id,$user_id);
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
}else{
    header('Location: error.php');
    exit();
}
?>