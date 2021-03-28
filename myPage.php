<?php
//共通関数読み込み
require('function.php');

//自ユーザIDと閲覧中ユーザーIDを変数に代入
$user_id = $_SESSION['id'];
$re_id = $_REQUEST['myPage_id'];

//閲覧中ユーザーをフォローしているか判別
$follow_check = getFollow($user_id, $re_id);

//自分がフォローしているユーザIDを$checkに全て代入
$check = getFavoriteAll($user_id);

//閲覧中ユーザーのIDを受け取っていたら
if(!empty($re_id)){

  //ユーザー情報取得
	$reUser = getUser($re_id);

  //ユーザーの全投稿情報取得
  $contents = getUserContents($re_id);
}
?>
<?php require('header.php'); ?>
<div class="container">
  <div class="wrapper"></div>

  <h1>ユーザー情報</h1>
  <img src="user_img/<?php echo h($reUser['user_img']); ?>" class="rounded-circle" alt="プロフィール画像">
  <p>ユーザーネーム</p>
  <p><?php echo h($reUser['name']);?></p>
<?php if($reUser['id'] == $user_id): ?>
  <a href="update.php?update_id=<?php echo $user_id; ?>">ユーザー情報を変更する</a><br>
<?php endif; ?>
  <a href="follow_view.php?id=<?php echo $reUser['id']; ?>" class="btn btn-primary">フォロー</a>
  <a href="follower_view.php?id=<?php echo $reUser['id']; ?>" class="btn btn-primary">フォロワー</a><br>
<?php if($re_id !== $user_id && empty($follow_check)): ?>
  <a href="follow.php?id=<?php echo $reUser['id'];?>" class="btn btn-primary mt-3">フォローする</a><br>
<?php endif; ?>
<?php if($re_id !== $user_id && !empty($follow_check)): ?>
  <a href="follow_delete.php?id=<?php echo $reUser['id'];?>" class="btn btn-primary mt-3">フォローをはずす</a>
<?php endif; ?>
  <h1>投稿一覧</h1>
<?php foreach ($contents as $content): ?>
    <div class="card mb-5">
      <div class="card-body">
        <div class="d-flex">
          <img src="user_img/<?php echo h($content['user_img']); ?>" class="rounded-circle" alt="プロフィール画像">
          <h5 class="card-title"><a href="myPage.php?myPage_id=<?php echo h($content['user_id']);?>"><?php echo h($content['name']);?></a></h5>
        </div>
        <p class="card-text"><a href="show.php?id=<?php echo h($content['id']); ?>"><?php echo nl2br(h($content['message']));?></a></p>
      </div>
<?php if(isset($content['picture'])): ?>
    <img src="picture/<?php echo h($content['picture']);?>" class="img-fluid" alt="投稿画像">
<?php endif; ?>

      <div class="row">
<?php in_array($content['id'], $check) ? print'<a href="favorite_delete.php?id='.$content['id'].'" class="fas fa-heart fa-2x mt-3 mr-2 offset-8 good"></a><span class="mt-3 good_count">'.$content['good'].'</span>'
:print'<a href="favorite.php?id='.$content['id'].'" class="far fa-heart fa-2x mt-3 mr-2 offset-8 good"></a><span class="mt-3 good_count">'.$content['good'].'</span>';?>
        <a href="post.php?id=<?php echo $content['id']; ?>" class="btn btn-dark col-1 mt-3 ml-3">返信</a>
<?php if($reUser['id'] == $user_id): ?>
        <a href="delete.php?id=<?php echo $content['id']; ?>" class="btn btn-dark col-1 mt-3 ml-3">削除</a>
<?php endif;?>
      </div>
      <small class="text-muted"><?php echo h($content['created']);?></small>
    </div>
<?php endforeach; ?>
    </div>
<?php require('footer.php'); ?>