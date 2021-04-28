<?php
require('function.php');
$user_id = $_SESSION['id'];
$re_id = $_REQUEST['id'];
$_SESSION['myPage_id'] = $_REQUEST['id'];

//閲覧中ユーザーのフォロー一覧を取得
$follows = getFollowView($re_id);

//自分の全フォロー一覧取得
$check = getFollowAll($user_id);
?>

<?php require('header.php'); ?>
<div class="container">
<div class="wrapper"></div>
<div class="row">
    <div class="col-8 offset-2 ">
        <h3>フォロー一覧</h3>
        <?php foreach($follows as $follow): ?>
            <img src="user_img/<?php echo h($follow['user_img']) ?>" alt="プロフ写真" class="rounded-circle">
            <a href="myPage.php?myPage_id=<?php echo $follow['id']?>"><?php echo h($follow['name'])?></a>
        <?php if($follow['id'] == $user_id):?><br>
        <?php endif; ?>
        <?php if($_SESSION['id'] !== $follow['id']){
        in_array($follow['id'], $check) ? print '<a href="follow_delete.php?id='.$follow['id'].'"class="btn btn-primary">フォローをはずす</a><br>'
        :print '<a href="follow.php?id='.$follow['id'].'"class="btn btn-primary">フォローする</a><br>';}?>
        <?php endforeach; ?>
        <br>
        <a href="myPage.php?myPage_id=<?php echo $_SESSION['myPage_id'];?>">戻る</a>
        </div>
    </div>
</div>
<?php require('footer.php'); ?>