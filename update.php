<?php
session_start();
session_regenerate_id(true);
require('function.php');

$url = 'update.php?update_id='.$_SESSION['id'];
$pageId = $_REQUEST['update_id'];

if($_SESSION['id'] = $pageId){

	$users = $db->prepare('SELECT * FROM users WHERE id=?');
		$users->execute(array($_SESSION['id']));
		$user = $users->fetch();

	if(!empty($_POST) && !empty($_FILES['image']['name'])){
		$image = date('YmdHis') . $_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],
				'user_img/'. $image);
		$updates = $db->prepare('UPDATE users SET name=?, user_img=? WHERE id=?');
		$updates->execute(array(
			$_POST['name'],
			$image,
			$user['id']
		));
		header('Location: myPage.php?myPage_id='.$_SESSION['id']);
		exit();
	}
	if(!empty($_POST) && empty($_FILES['image']['name'])){
		$updates = $db->prepare('UPDATE users SET name=? WHERE id=?');
		$updates->execute(array(
			$_POST['name'],
			$_SESSION['id']
		));
		header('Location: myPage.php?myPage_id='.$_SESSION['id']);
		exit();
	}
}
?>
<?php require('header.php'); ?>
<div class="container">
<div class="wrapper"></div>
<form action="" method="post" enctype="multipart/form-data">
ユーザーネーム: <input type="text" name="name" value="<?php echo $user['name']; ?>">
<img src="user_img/<?php echo(htmlspecialchars($user['user_img'], ENT_QUOTES)); ?>" alt="プロフィール画像"><br>
画像を変更する
<input type="file" name="image" class="form-control-file" id="image">
<img id="preview">
<input type="submit" value="変更する">
</form>
<br>
<a href="myPage.php?myPage_id=<?php echo $_SESSION['id']; ?>">戻る</a>
</div>
<?php require('footer.php'); ?>