<?php
require('function.php');

if(isset($_SESSION['id'])) {
    $user_id = $_REQUEST['id'];
    $message = getPost($user_id);
    if($message['user_id'] == $_SESSION['id']) {
        if(file_exists('picture/'.$message['picture'])){
            unlink('picture/'.$message['picture']);
        }
        $stmt = deletePost($user_id);
        if($stmt){
        header('Location: index.php');
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