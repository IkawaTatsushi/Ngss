<?php
require('function.php');

if(!empty($_POST['search'])){
    $key = '%'.$_POST['search'].'%';
	$_SESSION['key'] = $key;
    $user_id = $_SESSION['id'];
    $searches = getSearch($key);
    $check = getFavoriteAll($user_id);
}

if(!empty($_SESSION['key'])){
	$key = $_SESSION['key'];
	$searches = getSearch($key);
    $check = getFavoriteAll($user_id);
}

?>
<?php require('header.php'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">

    <div class="wrapper"></div>

    <h1>検索結果</h1>

    <?php foreach ($searches as $searche): ?>
			<div class="card mb-5">
				<div class="card-body">
					<div class="d-flex">
						<img src="user_img/<?php echo h($searche['user_img']); ?>" class="rounded-circle mt-4 ml-3" alt="プロフィール画像">
						<h5 class="card-title mt-5 ml-3 mr-auto">
							<a href="myPage.php?myPage_id=<?php echo $searche['user_id'];?>" class="mr-5 mr-auto"><?php echo h($searche['name']);?></a>
						</h5>
						<small class="text-muted mr-5 mt-5 date"><?php echo $searche['created'];?></small>
					</div>
					<p class="card-text ml-5 mt-3"><a href="show.php?id=<?php echo $searche['id']; ?>">
					<?php echo nl2br(h($searche['message']));?></a></p>
				</div>
				<?php if(isset($searche['picture'])): ?>
					<img src="picture/<?php echo h($searche['picture']);?>" class="main_picture mt-4" alt="投稿画像">
				<?php endif; ?>
				<div class="d-flex justify-content-end">
					<?php in_array($searche['id'], $check) ? print'<a href="favorite_delete.php?id='.$searche['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$searche['good'].'</span>'
					:print'<a href="favorite.php?id='.$searche['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$searche['good'].'</span>';?>
					<a href="post.php?id=<?php echo $searche['id']; ?>" class="btn btn-dark mt-3 ml-3 mr-3 mb-3" id="re_message">返信</a>
					<?php if($searche['user_id'] == $user_id): ?>
						<a href="delete.php?id=<?php echo $searche['id']; ?>" class="btn btn-dark mt-3 mr-3 mb-3 delete">削除</a>
					<?php endif;?>
				</div>
			</div>
			<?php endforeach; ?>

    </div>
  </div>
</div>
<?php require('footer.php'); ?>