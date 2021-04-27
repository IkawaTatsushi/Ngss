<?php
require('function.php');
$user_id = $_SESSION['id'];
$re_id = $_REQUEST['id'];

//返信されたコメント一覧
$res = getReMessage($re_id);

//コメント詳細
$post = getMessage($re_id);

//お気に入りチェック
$check = getFavoriteAll($user_id);

//このコメントが誰かへの返信コメントの場合
if(!empty($post['re_message_id'])){
	
	//返信元のコメントを取得
	$comon = getMessage($post['re_message_id']);

	//配列に追加
	$comons[] = $comon;
	
	//返信元のコメントも誰かへの返信コメントであった場合、元のコメントを取得を繰り返し
	//大元のコメントまで、配列に追加する
	while(1){
		$comon = getMessage($comon['re_message_id']);
		if($comon !== false){
			array_unshift($comons,$comon);
		}else{
			break;
		}
	}
}


?>

<?php require('header.php'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<div class="wrapper"></div>

			<!--返信元-->
			<?php if(!empty($comons)): ?>
				<?php foreach ($comons as $comon): ?>
					<div class="card pb-3 comon" id="<?php echo $comon['id'] ;?>">
						<div class="card-body">
							<div class="d-flex">
								<img src="user_img/<?php echo(h($comon['user_img'])); ?>" class="rounded-circle" alt="プロフィール画像">
								<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo $comon['user_id'];?>" class="mr-5"><?php echo h($comon['name']);?>
								<small class="text-muted ml-5 date"><?php echo h($comon['created']);?></small></a></h5>
							</div>
							<p class="card-text ml-5"><a href="show.php?id=<?php echo $comon['id']; ?>"><?php echo nl2br(h($comon['message']));?></a></p>
						</div>
						<?php if(isset($comon['picture'])): ?>
							<img src="picture/<?php echo h($comon['picture']);?>" class="show_picture" alt="投稿画像">
						<?php endif; ?>
						<div class="d-flex justify-content-end">
							<?php in_array($comon['id'], $check) ? print'<a href="favorite_delete.php?id='.$comon['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$comon['good'].'</span>'
							:print'<a href="favorite.php?id='.$comon['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$comon['good'].'</span>';?>
							<a href="post.php?id=<?php echo $comon['id']; ?>" class="btn btn-dark mt-3 mr-3 ml-3">返信</a>
						<?php if($comon['user_id'] == $_SESSION['id']): ?>
							<a href="delete.php?id=<?php echo $comon['id']; ?>" class="btn btn-dark mt-3 mr-3 delete">削除</a>
							<?php endif;?>
						</div>	
					</div>
					<div class="d-flex justify-content-center">
						<div class="tenSen"></div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

				

				<!--ツイート詳細-->
			<?php if($post): ?>
				<div class="card mb-5 pb-3"  id="<?php echo $post['id'] ;?>">
					<div class="card-body">
						<div class="d-flex">
							<img src="user_img/<?php echo(h($post['user_img'])); ?>" class="rounded-circle" alt="プロフィール画像">
							<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo $post['user_id'];?>" class="mr-5"><?php echo h($post['name']);?>
							<small class="text-muted ml-5 date"><?php echo h($post['created']);?></small></a></h5>
						</div>
						<p class="card-text ml-5"><a href="show.php?id=<?php echo $post['id']; ?>"><?php echo nl2br(h($post['message']));?></a></p>
					</div>
					<?php if(isset($post['picture'])): ?>
					<img src="picture/<?php echo h($post['picture']);?>" class="main_picture" alt="投稿画像">
					<?php endif; ?>
					<div class="d-flex justify-content-end">
						<?php in_array($post['id'], $check) ? print'<a href="favorite_delete.php?id='.$post['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$post['good'].'</span>'
						:print'<a href="favorite.php?id='.$post['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$post['good'].'</span>';?>
						<a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-dark mt-3 mr-3 ml-3">返信</a>
					<?php if($post['user_id'] == $_SESSION['id']): ?>
						<a href="delete.php?id=<?php echo $post['id']; ?>" class="btn btn-dark mt-3 mr-3 delete">削除</a>
						<?php endif;?>
					</div>	
				</div>

			<?php else: ?>

				<div class="card mb-5 pb-3"  id="<?php echo $post['id'] ;?>">
					<div class="card-body">
					このコメントは存在しないか削除されました。
					</div>	
				</div>

			<?php endif; ?>

				<a href="javascript:history.go(-1)">[戻る]</a>

				<?php if(!empty($res)): ?>
					<p>返信一覧</p>
				<?php endif;?>
				<?php foreach ($res as $re): ?>
					<div class="card mb-5 pb-3" id="<?php echo $re['id'] ;?>">
				<div class="card-body">
					<div class="d-flex">
					<img src="user_img/<?php echo h($re['user_img']); ?>" class="rounded-circle" alt="プロフィール画像">
					<h5 class="card-title mt-3"><a href="myPage.php?myPage_id=<?php echo $re['user_id'];?>" class="mr-5"><?php echo h($re['name']);?>
					<small class="text-muted ml-5 date"><?php echo h($re['created']);?></small></a></h5>
					</div>
					<p class="card-text ml-5"><a href="show.php?id=<?php echo h($re['id']); ?>"><?php echo nl2br(h($re['message']));?></a></p>
				</div>
				<?php if(isset($re['picture'])): ?>
					<img src="picture/<?php echo h($re['picture']);?>" class="show_picture" alt="投稿画像">
				<?php endif; ?>
				<div class="d-flex justify-content-end">
					<?php in_array($re['id'], $check) ? print'<a href="favorite_delete.php?id='.$re['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$re['good'].'</span>'
						:print'<a href="favorite.php?id='.$re['id'].'" class="far fa-heart fa-2x mt-3 mr-2 good"></a><span class="mt-3 good_count">'.$re['good'].'</span>';?>
						<a href="post.php?id=<?php echo $re['id']; ?>" class="btn btn-dark mt-3 mr-3 ml-3">返信</a>
					<?php if($re['user_id'] == $user_id): ?>
						<a href="delete.php?id=<?php echo $re['id']; ?>" class="btn btn-dark mt-3 mr-3 delete">削除</a>
					<?php endif;?>
				</div>
			</div>
				<?php endforeach; ?>
		</div>
	</div>
</div>
<?php require('footer.php'); ?>
