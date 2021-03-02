<?php
session_start();
require('dbconnect.php');

if(isset($_REQUEST['id'])){
    $follow = $db->prepare('INSERT INTO follow SET 
    user_id=?, follow=?, created=NOW()');
    $follow->execute(array(
        $_SESSION['id'],
        $_REQUEST['id']
    ));
}

?>
<?php require('header.php'); ?>
<div class="container">
<div class="wrapper"></div>

<form action="" method="post" enctype="multipart/form-data">
    <label for="message">メッセージを投稿する</label>
    <textarea id="message" name="message" rows="8" cols="40" class="form-control"></textarea>
    <label for="inputFile" class="mt-5">画像選択</label>
    <input type="file" name="image" class="form-control-file" id="image">
	<img id="preview">
	<input type="submit" value="送信">
</form>

<h1>フォローあっざっす</h1>

</div>
<?php require('footer.php'); ?>