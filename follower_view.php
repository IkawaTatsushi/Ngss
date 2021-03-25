<?php
require('function.php');
$user_id = $_SESSION['id'];
$re_id = $_REQUEST['id'];
$_SESSION['myPage_id'] = $_REQUEST['id'];
$followers = getFollowerView($re_id);
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
<?php if($_SESSION['id'] !== $follower['id']){
            in_array($follower['id'], $check) ? print '<a href="follow_delete.php?id='.$follower['id'].'"class="btn btn-primary">フォローをはずす</a><br>'
            :print '<a href="follow.php?id='.$follower['id'].'"class="btn btn-primary">フォローする</a><br>';}?>
<?php endforeach; ?>
            <br>
            <a href="myPage.php?myPage_id=<?php echo $_SESSION['myPage_id'];?>">戻る</a>
        </div>
    </div>
</div>
<?php require('footer.php'); ?>