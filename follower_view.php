<?php
//共通関数読み込み
require('function.php');

//自ユーザIDと閲覧中ユーザーIDを変数に代入
$user_id = $_SESSION['id'];
$re_id = $_REQUEST['id'];

//フォローのつけはずし処理を繰り返しても閲覧していたユーザーページに戻れる様
//閲覧中ユーザーIDをセッション変数に代入
$_SESSION['myPage_id'] = $_REQUEST['id'];

//閲覧中ユーザーのフォロワー一覧を取得
$followers = getFollowerView($re_id);

//自分のフォローしているIDを全て変数に代入
$check = getFollowAll($user_id);
?>

<?php require('header.php'); ?>
<div class="container">
    <div class="wrapper"></div>
    <div class="row">
        <div class="col-8 offset-2 ">
            <h3>フォロワー一覧</h3>
<?php foreach($followers as $follower): ?>
                <img src="user_img/<?php echo h($follower['user_img']) ?>" alt="プロフ写真" class="rounded-circle">
                <a href="myPage.php?myPage_id=<?php echo $follower['id']?>"><?php echo h($follower['name'])?></a>
<?php if($follower['id'] == $user_id):?>
                <br>
<?php endif; ?>

<!-- 自ユーザーIDと閲覧中のユーザーIDが一致していない場合 -->
<?php if($_SESSION['id'] !== $follower['id']){

//自分がフォローしているかを判別し、ボタンを表示
in_array($follower['id'], $check) ? print '<a href="follow_delete.php?id='.$follower['id'].'"class="btn btn-primary">フォローをはずす</a><br>'
:print '<a href="follow.php?id='.$follower['id'].'"class="btn btn-primary">フォローする</a><br>';}?>
<?php endforeach; ?>
            <br>
            <a href="myPage.php?myPage_id=<?php echo $_SESSION['myPage_id'];?>">戻る</a>
        </div>
    </div>
</div>
<?php require('footer.php'); ?>