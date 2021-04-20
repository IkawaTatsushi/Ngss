<?php
require('function.php');
if(!empty($_SESSION['id'])){
	$user_id = $_SESSION['id'];

	if(!empty($_REQUEST)){
		$re_id = $_REQUEST['id'];
		$post = getPost($re_id);
		$re_message_user_id = $post['user_id'];
	}
	
	if(!empty($_POST)){
		if($_FILES['image']['name'] !== ""){
			$image = date('YmdHis') . $_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'],
					'picture/'. $image);
		}
		$message = $_POST['message'];
		validRequired($message, 'message');
		if(empty($error)){
			$stmt = createPost($message,$image,$user_id,$re_id,$re_message_user_id);
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
<div class="col-md-8 offset-md-2">

<div class="wrapper"></div>
<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('message'); ?></small>
<form action="" method="post" enctype="multipart/form-data">
    <label for="message">メッセージを投稿する</label>
    <textarea id="message" name="message" rows="8" cols="40" class="form-control"></textarea>

	<label for="formFileMultiple" class="form-label mt-3">画像選択</label>
  	<input class="form-control" type="file" name="image" size="35" value="test" id="image" multiple>
	<img id="preview">

	<div class="row">
		<div class="col-sm-12 mt-3">
					<input type="submit" class="btn btn-primary btn-block" value="送信">
		</div>
	</div>
</form>
<?php require('footer.php'); ?>