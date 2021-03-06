<?php
session_start();
session_regenerate_id(true);
require('dbconnect.php');

if(isset($_REQUEST['id'])) {
    $posts = $db->prepare('SELECT u.name, u.user_img, p.* FROM users 
    u, posts p WHERE u.id=p.user_id AND p.id=?');
    $posts->execute(array($_REQUEST['id']));
    $post = $posts->fetch();

	$res = $db->prepare('SELECT u.name, u.user_img, p.* FROM users 
	u, posts p WHERE u.id=p.user_id AND p.re_message_id=? ORDER BY p.created DESC');
	$res->execute(array($_REQUEST['id']));

}

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
			$_REQUEST['id']
		));
	}
	header("Location: show.php?id=" . $_REQUEST['id']);
	exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員登録</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<h1>掲示板だよ～って</h1>
<img src="user_img/<?php echo(htmlspecialchars($post['user_img'], ENT_QUOTES)); ?>" alt="プロフィール画像">
<p><?php echo(htmlspecialchars($post['name'], ENT_QUOTES)); ?></p>
<p><?php echo nl2br(htmlspecialchars($post['message'], ENT_QUOTES)); ?></p>
<?php if(isset($post['picture'])): ?>
	<p>投稿画像</p>
<img src="picture/<?php echo(htmlspecialchars($post['picture'], ENT_QUOTES));?>" alt="">
<?php endif; ?>
<p><?php echo(htmlspecialchars($post['created'], ENT_QUOTES));?></p>
<a href="index.php">戻る</a>

<p>返信を投稿</p>
<form action="" method="post" enctype="multipart/form-data">
<textarea name="message" cols="50" rows="5"></textarea><br>
<input type="file" id="image" name="image" size="35" value="test" />
<img id="preview">
<input type="submit" value="送信">
</form>

<p>返信一覧</p>
<?php foreach ($res as $re): ?>
<p><?php echo(htmlspecialchars($re['name'], ENT_QUOTES));?></p>
<p><?php echo(htmlspecialchars($re['message'], ENT_QUOTES));?></p>
<?php endforeach; ?>
<script src="main.js"></script>
</body>
</html>