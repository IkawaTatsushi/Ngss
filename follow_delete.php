<?php
require('function.php');

//フォローをはずしたいユーザーIDを受け取っているかつログインしている場合
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){

    //他ユーザーIDと自ユーザーIDを変数に代入
    $user_id = $_SESSION['id'];
    $re_id = $_REQUEST['id'];

    //自分のフォローしているIDを変数に代入
    $follow_check = getFollow($user_id, $re_id);

    //$follow_checkの中に他IDが存在するか確認
    if(in_array($re_id, $follow_check)){

        //存在していた場合、followテーブルから削除し、前ページに遷移
        $stmt = followDelete($user_id,$re_id);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
     
    //$follow_checkの中に他IDが存在しなければerror.phpに遷移
    }else{
        header('Location: error.php');
        exit();
    }

//フォローをはずしたいユーザーIDを受け取っていないか、ログインしていない場合error.phpに遷移
}else{
    header('Location: error.php');
    exit();
}
?>