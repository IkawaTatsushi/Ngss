<?php
require('function.php');
if(!empty($_SESSION['id'])){
if(!empty($_POST)) {

	if($_FILES['image']['name'] !== ""){
		$image = date('YmdHis') . $_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],
				'picture/'. $image);
	}
		$id = $_SESSION['id'];
		$message = $_POST['message'];
		validRequired($message, 'message');
		$re_message_id = $_SESSION['id'];

	if(empty($error)){
		try {
			$dbh = dbConnect();
			$sql = 'INSERT INTO posts (message,picture,user_id) VALUES (:message,:picture,:user_id)';
			$data = array(':message' => $message,':picture' => $image,':user_id' => $id);
			$stmt = queryPost($dbh, $sql, $data);
			if($stmt){
				header('Location: index.php');
				exit();
			}
		} catch(PDOException $e) {
			echo 'DB接続エラー: ' . $e->getMessage();
		}
	}
}
}else{
	header('Location: index.php');
	exit();
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
    <textarea id="message" name="message" rows="8" cols="40" class="form-control"><?php echo getErrMsg('message'); ?></textarea>
    <label for="inputFile" class="mt-5">画像選択</label>
    <input type="file" name="image" class="form-control-file" id="image">
	<img id="preview">
	<input type="submit" value="送信">
</form>
<?php require('footer.php'); ?>