<?php
require('function.php');
$user_id = $_SESSION['id'];
$url = 'update.php?update_id='.$user_id;
$pageId = $_REQUEST['update_id'];
if($user_id == $pageId){
	$user = getUser($user_id);
	if(!empty($_POST) && !empty($_FILES['image']['name'])){
		$name = $_POST['name'];
		$image = date('YmdHis') . $_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],
				'user_img/'. $image);
		$update = updateAll($name,$image,$user_id);
		header('Location: myPage.php?myPage_id='.$user_id);
		exit();
	}
	if(!empty($_POST) && empty($_FILES['image']['name'])){
		$name = $_POST['name'];
		$update = update($name,$user_id);
		header('Location: myPage.php?myPage_id='.$_SESSION['id']);
		exit();
	}
}
?>

<?php require('header.php'); ?>
<div class="wrapper1">
<div class="container">
    <div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="box box1">

				<form role="form" action="" method="post">
					<div class="form-group text-center">
						<label class="label1" for="exampleInputEmail1">ユーザーネーム</label>
						<input type="text" name="name" size="35" maxlength="255" class="form-control form-control1 text-center" value="<?php echo h($user['name']); ?>">
					</div>
					<div class="divider-form divider-form1"></div>

					<div class="form-group text-center">
						<label class="label1" for="exampleInputPassword1">プロフィール画像</label><br>
						<img src="user_img/<?php echo h($user['user_img']); ?>" class="rounded-circle" alt="プロフィール画像">
					</div>
					<div class="divider-form divider-form1"></div>

					<div class="form-group text-center">
						<label class="label1" for="exampleInputPassword1">変更後プロフィール画像</label><br>
						<input type="file" name="image" class="form-control-file" id="images">
						<img id="previews" class="rounded-circle">
					</div>
					<div class="divider-form divider-form1"></div>

					<input type="submit" class="btn-block btn btn-lg btn-primary btn-primary1" value="変更する">
				</form>
				<a href="myPage.php?myPage_id=<?php echo $user_id; ?>" class="btn-block btn btn-lg btn-primary btn-primary1">戻る</a>
			</div>
		</div>
	</div>
</div>
</div>
<?php require('footer.php'); ?>