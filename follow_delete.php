<?php
require('function.php');
//フォローを外したいユーザーIDがあるかつ、ログインをしている
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $user_id = $_SESSION['id'];
    $re_id = $_REQUEST['id'];

    //フォローしているユーザーIDを取得
    $follow_check = getFollow($user_id, $re_id);

    //取得したIDからフォローをしているか確認
    if(in_array($_REQUEST['id'], $follow_check)){

        //フォローを外す
        $stmt = followDelete($user_id,$re_id);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
    }else{
        header('Location: error.php');
        exit();
    }
}else{
    echo 'ログインしてください';
    echo '<a href="login.php">ログイン</a>';
}
?>