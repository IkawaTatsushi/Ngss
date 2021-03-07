<?php
session_start();
session_regenerate_id(true);
require('function.php');

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

<?php require('header.php'); ?>
<div class="container">
	<div class="row">
		<div class="col-8 offset-2">
			<div class="wrapper"></div>
			<a href="index.php">戻る</a>
			<div class="card mb-5 pb-3">
				<div class="card-body">
					<div class="d-flex">
						<img src="user_img/<?php echo(htmlspecialchars($post['user_img'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
						<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo(htmlspecialchars($post['user_id'], ENT_QUOTES));?>" class="mr-5"><?php echo(htmlspecialchars($post['name'], ENT_QUOTES));?><small class="text-muted ml-5"><?php echo(htmlspecialchars($post['created'], ENT_QUOTES));?></small></a></h5>
					</div>
					<p class="card-text ml-5"><a href="show.php?id=<?php echo (htmlspecialchars($post['id'], ENT_QUOTES)); ?>"><?php echo nl2br(htmlspecialchars($post['message'], ENT_QUOTES));?></a></p>
				</div>
				<?php if(isset($post['picture'])): ?>
				<img src="picture/<?php echo(htmlspecialchars($post['picture'], ENT_QUOTES));?>" class="show_picture ml-5" alt="投稿画像">
				<?php endif; ?>
				<?php if($post['user_id'] == $user['id']): ?>
				<div class="row">
					<a href="delete.php?id=<?php echo(htmlspecialchars($post['id'])); ?>" class="btn btn-dark col-1 offset-10 mt-3">削除</a>
				</div>
				<?php endif;?>
			</div>

			<form action="" method="post" enctype="multipart/form-data">
				<label for="message">返信を投稿する</label>
				<textarea id="message" name="message" rows="5" cols="40" class="form-control"></textarea>
				<label for="inputFile" class="mt-5">画像選択</label>
				<input type="file" name="image" class="form-control-file" id="image">
				<img id="preview">
				<input type="submit" value="送信">

				<p>返信一覧</p>
			<?php foreach ($res as $re): ?>
				<div class="card mb-5 pb-3">
			<div class="card-body">
				<div class="d-flex">
				<img src="user_img/<?php echo(htmlspecialchars($re['user_img'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
				<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo(htmlspecialchars($re['user_id'], ENT_QUOTES));?>" class="mr-5"><?php echo(htmlspecialchars($re['name'], ENT_QUOTES));?><small class="text-muted ml-5"><?php echo(htmlspecialchars($re['created'], ENT_QUOTES));?></small></a></h5>
				</div>
				<p class="card-text ml-5"><a href="show.php?id=<?php echo (htmlspecialchars($re['id'], ENT_QUOTES)); ?>"><?php echo nl2br(htmlspecialchars($re['message'], ENT_QUOTES));?></a></p>
			</div>
			<?php if(isset($re['picture'])): ?>
			<img src="picture/<?php echo(htmlspecialchars($re['picture'], ENT_QUOTES));?>" class="show_picture ml-5" alt="投稿画像">
			<?php endif; ?>
			<?php if($re['user_id'] == $user['id']): ?>
			<div class="row">
			<a href="delete.php?id=<?php echo(htmlspecialchars($re['id'])); ?>" class="btn btn-dark col-1 offset-10 mt-3">削除</a>
			</div>
			<?php endif;?>
			</div>
			<?php endforeach; ?>

			</div>
		</div>
	</div>
</div>
<?php require('footer.php'); ?>
