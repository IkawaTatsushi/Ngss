<?php
require('function.php');

//閲覧中のユーザーIDを受け取っているかつログインしている場合
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){

    //閲覧中のユーザーIDと自ユーザーIDを変数に代入
    $user_id = $_SESSION['id'];
    $re_id = $_REQUEST['id'];

    //自分のフォローしているIDを変数に代入
    $follow_check = getFollow($user_id, $re_id);
    
    //$follow_checkの中に他IDが存在するか確認
    if(in_array($re_id, $follow_check)){

        //存在すればerror.phpに遷移
        header('Location: error.php');
        exit();

    //存在しなければ
    }else{
        
        //フォローテーブルに挿入し、前ページに遷移
        $stmt = follow($user_id,$re_id);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
    }

//閲覧中のユーザーIDを受け取っていないか、ログインしていない場合
}else{
    header('Location: error.php');
    exit();
}
?>