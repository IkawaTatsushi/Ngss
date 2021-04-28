<?php
require('function.php');

//フォローしたいIDがあり、ログインしている場合
if(isset($_REQUEST['id']) && isset($_SESSION['id'])){
    $user_id = $_SESSION['id'];
    $re_id = $_REQUEST['id'];

    //自分のフォローID一覧を取得
    $follow_check = getFollow($user_id, $re_id);

    //フォローしたいIDが自分のフォローID一覧に存在しているか確認
    if(in_array($_REQUEST['id'], $follow_check)){
        header('Location: error.php');
        exit();
    }else{
        //していなかったらフォローする
        $stmt = follow($user_id,$re_id);
        header('Location:'.$_SERVER['HTTP_REFERER']);
        exit();
    }
}else{
    echo 'ログインしてください';
    echo '<a href="login.php">ログイン</a>';
}
?>