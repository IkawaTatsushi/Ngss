<?php
session_start();
require('dbconnect.php');

$follow_checks = $db->prepare('SELECT * FROM follow WHERE user_id=? AND follow=?');
$follow_checks->execute(array(
  $_SESSION['id'],
  $_REQUEST['myPage_id']
));
$follow_check = $follow_checks->fetch();

if(!empty($_REQUEST['myPage_id'])){

    $users = $db->prepare('SELECT * FROM users WHERE id=?');
	$users->execute(array($_REQUEST['myPage_id']));
	$konoPageNoUser = $users->fetch();


    $myPages = $db->prepare('SELECT u.name, u.user_img, p.* FROM users 
    u, posts p WHERE u.id=? AND u.id=p.user_id ORDER BY p.created');
    $myPages->execute(array($_REQUEST['myPage_id']));
}
?>
<?php require('header.php'); ?>
<div class="container">
<div class="wrapper"></div>

<form action="" method="post" enctype="multipart/form-data">
    <label for="message">メッセージを投稿する</label>
    <textarea id="message" name="message" rows="8" cols="40" class="form-control"></textarea>
    <label for="inputFile" class="mt-5">画像選択</label>
    <input type="file" name="image" class="form-control-file" id="image">
	<img id="preview">
	<input type="submit" value="送信">
</form>

<h1>ユーザじょほおおお</h1>
<img src="user_img/<?php echo(htmlspecialchars($konoPageNoUser['user_img'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
<p>ユーザーねいむぅ</p>
<p><?php echo(htmlspecialchars($konoPageNoUser['name'], ENT_QUOTES));?></p>
<p>フォロー</p>
<p>フォロワー</p>
<?php if($_REQUEST['myPage_id'] != $_SESSION['id'] && empty($follow_check)): ?>
<a href="follow.php?id=<?php echo(htmlspecialchars($konoPageNoUser['id'], ENT_QUOTES));?>">フォローするぅぅぅ</a><br>
<?php endif; ?>
<?php if($_REQUEST['myPage_id'] != $_SESSION['id'] && !empty($follow_check)): ?>
<a href="follow_delete.php?id=<?php echo(htmlspecialchars($konoPageNoUser['id'], ENT_QUOTES));?>">フォローはずすううう</a>
<?php endif; ?>
<h1>投稿一覧</h1>
<?php foreach ($myPages as $myPage): ?>
<div class="card mb-5">
  <div class="card-body">
	  <div class="d-flex">
  	<img src="user_img/<?php echo(htmlspecialchars($myPage['user_img'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
    <h5 class="card-title"><a href="myPage.php?myPage_id=<?php echo(htmlspecialchars($myPage['user_id'], ENT_QUOTES));?>"><?php echo(htmlspecialchars($myPage['name'], ENT_QUOTES));?></a></h5>
	</div>
    <p class="card-text"><a href="show.php?id=<?php print(htmlspecialchars($myPage['id'], ENT_QUOTES)); ?>"><?php echo(htmlspecialchars($myPage['message'], ENT_QUOTES));?></a></p>
  </div>
<?php if(isset($myPage['picture'])): ?>
<img src="picture/<?php echo(htmlspecialchars($myPage['picture'], ENT_QUOTES));?>" class="img-fluid" alt="投稿画像">
<?php endif; ?>
<a href="" class="btn btn-dark float-right">削除</a>
<small class="text-muted"><?php echo(htmlspecialchars($myPage['created'], ENT_QUOTES));?></small>
<a href="delete.php?id=<?php echo(htmlspecialchars($myPage['id'])); ?>">削除</a>
</div>
<?php endforeach; ?>

</div>
<?php require('footer.php'); ?>