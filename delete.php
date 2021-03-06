<?php
session_start();
require('function.php');

if(isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
    $messages->execute(array($_REQUEST['id']));
    $message = $messages->fetch();
    
    if($message['user_id'] == $_SESSION['id']) {
        if(file_exists('picture/'.$message['picture'])){
            unlink('picture/'.$message['picture']);
        }
        $delete = $db->prepare('DELETE FROM posts WHERE id=?');
        $delete->execute(array($id));
    }

    header('Location: index.php');
    exit();
}
?>