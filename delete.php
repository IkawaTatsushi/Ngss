<?php
require('function.php');

//ログインしていたら
if(isset($_SESSION['id'])) {

    //ツイートIDを変数に代入
    $user_id = $_REQUEST['id'];

    //ツイート情報を変数に代入
    $message = getPost($user_id);

    //投稿者ＩＤとログインＩＤが一致していたら
    if($message['user_id'] == $_SESSION['id']) {

        //ツイート画像があるか確認、あればフォルダから削除
        if(file_exists('picture/'.$message['picture'])){
            unlink('picture/'.$message['picture']);
        }

        //ツイートを削除
        $stmt = deletePost($user_id);
        if($stmt){
            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }else{
            echo '削除に失敗しました';
        }
    }
}else{
    header('Location: index.php');
    exit();
}
?>