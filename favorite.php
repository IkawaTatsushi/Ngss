<?php
require('function.php');

//いいねしたいツイートのIDがある、かつログインしていたら
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $re_id = $_REQUEST['id'];
    $user_id = $_SESSION['id'];

    //いいねしていないか確認
    $stmt = getFavorite($user_id,$re_id);
    if(!$stmt){
        //ツイートをいいねする
        $favorite = favorite($re_id,$user_id);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
    }else{
        header('Location: error.php');
        exit();
    }
}else{
    header('Location: error.php');
    exit();
}
?>