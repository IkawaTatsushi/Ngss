<?php
//共通関数読み込み
require('function.php');

//ログインしていたら
if(!empty($_SESSION['id'])){
	$user_id = $_SESSION['id'];
	$re_id = $_REQUEST['id'];

	//投稿の情報を受け取っていたら
	if(!empty($_POST)){

		//ファイル名が存在したら
		if($_FILES['image']['name'] !== ""){

			//年月日とファイル名をつなげ、変数に代入
			$image = date('YmdHis') . $_FILES['image']['name'];

					//画像保存
					move_uploaded_file($_FILES['image']['tmp_name'],
					'picture/'. $image);
		}

		//メッセージを変数に代入
		$message = $_POST['message'];

		//未入力チェック
		validRequired($message, 'message');
		if(empty($error)){

			//postsテーブルに書き込み
			$stmt = createPost($message,$image,$user_id,$re_id);

			//成功したらindex.phpに遷移,失敗したらerror.phpに遷移
			if($stmt){
				header('Location: index.php');
				exit();
			}else{
				header('Location: error.php');
				exit();
			}
		}
	}
}else{
	header('Location: error.php');
	exit();
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