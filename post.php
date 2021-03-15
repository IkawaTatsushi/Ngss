<?php
require('function.php');

if(!empty($_POST)) {
	if($_FILES['image']['name'] !== ""){
		$image = date('YmdHis') . $_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],
				'picture/'. $image);
		}
		
	if ($_POST['message'] !== '') {
		$message = $db->prepare('INSERT INTO posts SET message=?,
		picture=?, user_id=?, re_message_id=?, created=NOW()');
		$message->execute(array(
			$_POST['message'],
			$image,
			$_SESSION['id'],
			$_POST['re_message_id']
		));

		header('Location: index.php');
      	exit();
	}
}
?>
<?php require('header.php'); ?>
<div class="container">
<div class="row">
<div class="col-8 offset-2">

<div class="wrapper"></div>
<h1>投稿する</h1>

<form action="" method="post" enctype="multipart/form-data">
    <label for="message">メッセージを投稿する</label>
    <textarea id="message" name="message" rows="8" cols="40" class="form-control"></textarea>
    <label for="inputFile" class="mt-5">画像選択</label>
    <input type="file" name="image" class="form-control-file" id="image">
	<img id="preview">
	<input type="submit" value="送信">
</form>
<?php require('footer.php'); ?>