<?php
session_start();
session_regenerate_id(true);
require('function.php');

if(!empty($_POST)){
    $keyword = '%'.$_POST['search'].'%';
    $searchs = $db->prepare('SELECT u.name, u.user_img, p.* FROM users 
    u, posts p WHERE u.id=p.user_id AND message LIKE ? ORDER BY p.created DESC');
    $searchs->execute(array($keyword));
}

$num = 100;

var_dump($num);
exit;
?>
<?php require('header.php'); ?>
<div class="container">
<div class="row">
<div class="col-8 offset-2">

<div class="wrapper"></div>
<h1>検索結果</h1>
<?php foreach ($searchs as $search): ?>
<div class="card mb-5 pb-3">
  <div class="card-body">
	  <div class="d-flex">
  	<img src="user_img/<?php echo(htmlspecialchars($search['user_img'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
    <h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo(htmlspecialchars($search['user_id'], ENT_QUOTES));?>" class="mr-5"><?php echo(htmlspecialchars($search['name'], ENT_QUOTES));?><small class="text-muted ml-5"><?php echo(htmlspecialchars($search['created'], ENT_QUOTES));?></small></a></h5>
	</div>
    <p class="card-text ml-5"><a href="show.php?id=<?php echo (htmlspecialchars($search['id'], ENT_QUOTES)); ?>"><?php echo nl2br(htmlspecialchars($search['message'], ENT_QUOTES));?></a></p>
  </div>
<?php if(isset($search['picture'])): ?>
<img src="picture/<?php echo(htmlspecialchars($search['picture'], ENT_QUOTES));?>" class="img-fluid" alt="投稿画像">
<?php endif; ?>
<?php if($search['user_id'] == $user['id']): ?>
<div class="row">
<a href="delete.php?id=<?php echo(htmlspecialchars($search['id'])); ?>" class="btn btn-dark col-1 offset-10 mt-3">削除</a>
</div>
<?php endif;?>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<?php require('footer.php'); ?>