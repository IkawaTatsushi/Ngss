<?php
//共通関数読み込み
require('function.php');

if(!empty($_POST)){
    $key = '%'.$_POST['search'].'%';
    $user_id = $_SESSION['id'];
    $searches = getSearch($key);
    $check = getFavoriteAll($user_id);
}
?>
<?php require('header.php'); ?>
<div class="container">
  <div class="row">
    <div class="col-8 offset-2">

    <div class="wrapper"></div>
    <h1>検索結果</h1>
    <?php foreach ($searches as $search): ?>
<div class="card mb-5 pb-3">
	<div class="card-body">
		<div class="d-flex">
			<img src="user_img/<?php echo h($search['user_img']); ?>" class="rounded-circle" alt="プロフィール画像">
			<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo $search['user_id'];?>" class="mr-5">
			<?php echo h($search['name']);?><small class="text-muted ml-5"><?php echo $search['created'];?></small></a></h5>
		</div>
		<p class="card-text ml-5"><a href="show.php?id=<?php echo $search['id']; ?>">
		<?php echo nl2br(h($search['message']));?></a></p>
	</div>
<?php if(isset($search['picture'])): ?>
	<img src="picture/<?php echo h($search['picture']);?>" class="img-fluid" alt="投稿画像">
<?php endif; ?>
	<div class="row">
<?php in_array($search['id'], $check) ? print'<a href="favorite_delete.php?id='.$search['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 offset-8 good"></a><span class="mt-3 good_count">'.$search['good'].'</span>'
:print'<a href="favorite.php?id='.$search['id'].'" class="far fa-heart fa-2x mt-3 mr-2 offset-8 good"></a><span class="mt-3 good_count">'.$search['good'].'</span>';?>
<a href="post.php?id=<?php echo $search['id']; ?>" class="btn btn-dark col-1 mt-3 ml-3">返信</a>
<?php if($search['user_id'] == $user_id): ?>
		<a href="delete.php?id=<?php echo $search['id']; ?>" class="btn btn-dark col-1 mt-3 ml-3">削除</a>
<?php endif;?>
	</div>
</div>
<?php endforeach; ?>
    </div>
  </div>
</div>
<?php require('footer.php'); ?>