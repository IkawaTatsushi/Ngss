<?php
require('function.php');
$id = $_SESSION['id'];
$page = $_REQUEST['page'];
if ($page == '') {
	$page = 1;
}
$page = max($page,1);
$cnt = getPageCount();
$maxPage = ceil($cnt['cnt'] / 5);
$page = min($page, $maxPage);
$start = ($page -1) * 5;
$posts = getPostAll($start);
$check = getFavorite($id);

?>

<?php require('header.php'); ?>
<div class="container">
<div class="row">
<div class="col-8 offset-2">

<div class="wrapper"></div>

	<h1>投稿一覧</h1>
<?php foreach ($posts as $post): ?>
<div class="card mb-5 pb-3">
	<div class="card-body">
		<div class="d-flex">
			<img src="user_img/<?php echo h($post['user_img']); ?>" class="rounded-circle" alt="プロフィール画像">
			<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo $post['user_id'];?>" class="mr-5">
			<?php echo h($post['name']);?><small class="text-muted ml-5"><?php echo $post['created'];?></small></a></h5>
		</div>
		<p class="card-text ml-5"><a href="show.php?id=<?php echo $post['id']; ?>">
		<?php echo nl2br(h($post['message']));?></a></p>
	</div>
<?php if(isset($post['picture'])): ?>
	<img src="picture/<?php echo h($post['picture']);?>" class="img-fluid" alt="投稿画像">
<?php endif; ?>
	<div class="row">
<?php in_array($post['id'], $check) ? print'<a href="favorite_delete.php?id='.$post['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 offset-8 good"></a><span class="mt-3 good_count">'.$post['good'].'</span>'
:print'<a href="favorite.php?id='.$post['id'].'" class="far fa-heart fa-2x mt-3 mr-2 offset-8 good"></a><span class="mt-3 good_count">'.$post['good'].'</span>';?>
<a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-dark col-1 mt-3 ml-3">返信</a>
<?php if($post['user_id'] == $id): ?>
		<a href="delete.php?id=<?php echo $post['id']; ?>" class="btn btn-dark col-1 mt-3 ml-3">削除</a>
<?php endif;?>
	</div>
</div>
<?php endforeach; ?>



<ul>
<?php if ($page > 1): ?>
<li><a href="index.php?page=<?php echo ($page-1); ?>">
前のページへ</a></li>
<?php else: ?>
<li>前のページへ</li>
<?php endif; ?>
<?php if ($page < $maxPage): ?>
<li><a href="index.php?page=<?php echo ($page+1); ?>">
次のページへ</a></li>
<?php else: ?>
<li>次のページへ</li>
<?php endif; ?>
</ul>
</div>
</div>
</div>
<?php require('footer.php'); ?>
