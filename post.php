<?php
//共通関数読み込み
require('function.php');
if(!empty($_SESSION['id'])){
	$user_id = $_SESSION['id'];
	$re_id = $_REQUEST['id'];
	if(!empty($_POST)){
		if($_FILES['image']['name'] !== ""){
			$image = date('YmdHis') . $_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'],
					'picture/'. $image);
		}
		$message = $_POST['message'];
		validRequired($message, 'message');
		if(empty($error)){
			$stmt = createPost($message,$image,$user_id,$re_id);
			if($stmt){
				header('Location: index.php');
				exit();
			}else{
				header('Location: error.php');
			}
		}
	}
}else{
	echo 'ログインしてください';
    echo '<a href="login.php">ログイン</a>';
}
?>
<?php require('header.php'); ?>
<div class="container">
	<div class="row">
		<div class="col-8 offset-2">

			<div class="wrapper"></div>
			<h1>投稿する</h1>
			<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('message'); ?></small>
			<form action="" method="post" enctype="multipart/form-data">
				<label for="message">メッセージを投稿する</label>
				<textarea id="message" name="message" rows="8" cols="40" class="form-control"></textarea>
				<label for="inputFile" class="mt-5">画像選択</label>
				<input type="file" name="image" class="form-control-file" id="image">
				<img id="preview">
				<input type="submit" value="送信">
			</form>
		</div>
	</div>
</div>
<?php require('footer.php'); ?>