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
<div class="container">
	<div class="wrapper"></div>
	<form action="" method="post" enctype="multipart/form-data">
		ユーザーネーム: <input type="text" name="name" value="<?php echo h($user['name']); ?>">
		<img src="user_img/<?php echo h($user['user_img']); ?>" class="rounded-circle" alt="プロフィール画像"><br>
		画像を変更する
		<input type="file" name="image" class="form-control-file" id="image">
		<img id="preview" class="rounded-circle">
		<input type="submit" value="変更する">
	</form><br>
	<a href="myPage.php?myPage_id=<?php echo $user_id; ?>">戻る</a>
</div>
<?php require('footer.php'); ?>