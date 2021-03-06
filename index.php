<?php
session_start();
session_regenerate_id(true);
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 60*60*24*365 > time()) {
	$_SESSION['time'] = time();

	$users = $db->prepare('SELECT * FROM users WHERE id=?');
	$users->execute(array($_SESSION['id']));
	$user = $users->fetch();
}else {
	header('Location: login.php');
	exit();
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
			$user['id'],
			$_POST['re_message_id']
		));

		header('Location: index.php');
      	exit();
	}
}
$page = $_REQUEST['page'];
  if ($page == '') {
    $page = 1;
  }
  $page = max($page,1);

  $counts = $db->query('SELECT COUNT(*) AS cnt FROM 
  posts');
  $cnt = $counts->fetch();
  $maxPage = ceil($cnt['cnt'] / 5);
  $page = min($page, $maxPage);
  
  $start = ($page -1) * 5;

  $posts = $db->prepare('SELECT u.name, u.user_img, p.* FROM users 
  u, posts p WHERE u.id=p.user_id ORDER BY p.created DESC LIMIT ?,5');
  $posts->bindParam(1,$start, PDO::PARAM_INT);
  $posts->execute();
?>

<?php require('header.php'); ?>
<div class="container">
<div class="row">
<div class="col-8 offset-2">

<div class="wrapper"></div>
<form action="" method="post" enctype="multipart/form-data">
    <label for="message">メッセージを投稿する</label>
    <textarea id="message" name="message" rows="8" cols="40" class="form-control"></textarea>
    <label for="inputFile" class="mt-5">画像選択</label>
    <input type="file" name="image" class="form-control-file" id="image">
	<img id="preview">
	<input type="submit" value="送信">
</form>


	<h1>投稿一覧</h1>
<?php foreach ($posts as $post): ?>
<div class="card mb-5 pb-3">
  <div class="card-body">
	  <div class="d-flex">
  	<img src="user_img/<?php echo(htmlspecialchars($post['user_img'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
    <h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo(htmlspecialchars($post['user_id'], ENT_QUOTES));?>" class="mr-5"><?php echo(htmlspecialchars($post['name'], ENT_QUOTES));?><small class="text-muted ml-5"><?php echo(htmlspecialchars($post['created'], ENT_QUOTES));?></small></a></h5>
	</div>
    <p class="card-text ml-5"><a href="show.php?id=<?php echo (htmlspecialchars($post['id'], ENT_QUOTES)); ?>"><?php echo nl2br(htmlspecialchars($post['message'], ENT_QUOTES));?></a></p>
  </div>
<?php if(isset($post['picture'])): ?>
<img src="picture/<?php echo(htmlspecialchars($post['picture'], ENT_QUOTES));?>" class="img-fluid" alt="投稿画像">
<?php endif; ?>
<?php if($post['user_id'] == $user['id']): ?>
<div class="row">
<a href="delete.php?id=<?php echo(htmlspecialchars($post['id'])); ?>" class="btn btn-dark col-1 offset-10 mt-3">削除</a>
</div>
<?php endif;?>
</div>
<?php endforeach; ?>



<ul>
<?php if ($page > 1): ?>
<li><a href="index.php?page=<?php print($page-1); ?>">
前のページへ</a></li>
<?php else: ?>
<li>前のページへ</li>
<?php endif; ?>
<?php if ($page < $maxPage): ?>
<li><a href="index.php?page=<?php print($page+1); ?>">
次のページへ</a></li>
<?php else: ?>
<li>次のページへ</li>
<?php endif; ?>
</ul>
</div>
</div>
</div>
<?php require('footer.php'); ?>
