<?php
//共通関数読み込み
require('function.php');
//ログインしている時
if(isset($_SESSION['id'])) {

    //投稿IDと自ユーザーIDを変数に代入
    $post_id = $_REQUEST['id'];
    $user_id = $_SESSION['id'];

    //投稿IDから投稿情報を取得
    $message = getPost($post_id);

    //投稿者ユーザーIDと自分のIDが一致している場合
    if($message['user_id'] == $user_id) {

        //画像投稿の有無を確認
        if(file_exists('picture/'.$message['picture'])){

            //あれば画像フォルダから削除
            unlink('picture/'.$message['picture']);
        }
        //投稿IDの一致するデータを削除
        $stmt = deletePost($post_id);

        //削除に成功した場合
        if($stmt){
        
        //index.phpに遷移
        header('Location: index.php');
        exit();

        //削除に失敗した場合、エラーペーッジへ遷移
        }else{
            header('Location: error.php');
            exit();
        }
    }

//ログインしていなければindex.phpへ遷移
}else{
    header('Location: index.php');
    exit();
}
?>