<?php
require('function.php');

if(isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];
    $message = getPost($id);

    if($message['user_id'] === $_SESSION['id']) {
        if(file_exists('picture/'.$message['picture'])){
            unlink('picture/'.$message['picture']);
        }
        deletePost($id);
        header('Location: index.php');
        exit();
    }
}else{
    header('Location: index.php');
    exit();
}
?>