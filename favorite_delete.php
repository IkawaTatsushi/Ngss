<?php
require('function.php');

//投稿IDを受け取っているかつログインしている場合
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){

    //投稿IDと自ユーザーIDを変数に代入
    $re_id = $_REQUEST['id'];
    $user_id = $_SESSION['id'];

    //この投稿にいいねしているかを確認
    $stmt = getFavorite($user_id,$re_id);

    //していたら
    if($stmt){

    //favoriteテーブルからログインIDと投稿IDが一致するデータを削除し前ページに遷移
    $favorite = favoriteDelete($re_id,$user_id);
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();

    //していなかったら
    }else{
        header('Location: error.php');
        exit();
    }
//投稿IDを受け取っていない、またはログインしていない場合error.phpに遷移
}else{
    header('Location: error.php');
    exit();
}
?>