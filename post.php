<?php
require('function.php');

//ログインしていたら
if(!empty($_SESSION['id'])){
	$user_id = $_SESSION['id'];

	//返信ボタンから遷移していたら
	if(!empty($_REQUEST)){
		$re_id = $_REQUEST['id'];

		//返信元のツイート情報を取得
		$post = getMessage($re_id);

		//変数にツイート元のユーザーIDを代入
		$re_message_user_id = $post['user_id'];
	}
	
	//フォームに入力があったら
	if(!empty($_POST['message'])){

		//画像を選択していたら
		if($_FILES['image']['name'] !== ""){

			//ファイル名を作成し、保存
			$image = date('YmdHis') . $_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'],
					'picture/'. $image);
		}
		$message = $_POST['message'];
		
		//未入力チェック
		validRequired($message, 'message');

		//エラーがなければ
		if(empty($error)){

			//ツイート情報をデータベースに保存
			$stmt = createPost($message,$image,$user_id,$re_id,$re_message_user_id);
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
	header('Location: login.php');
	exit();
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
<textarea id="message" name="message" rows="8" cols="40" class="form-control">
<?php if(!empty($post)): ?>
@<?php echo $post['name'] ?>&#13;
<?php endif; ?>
</textarea>

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