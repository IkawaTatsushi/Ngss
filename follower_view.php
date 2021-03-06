<?php
session_start();
session_regenerate_id(true);
require('function.php');

$_SESSION['myPage_id'] = $_REQUEST['id'];

$followers = $db->prepare('SELECT u.id, u.name, u.user_img, f.* FROM users 
  u, follow f WHERE u.id=f.user_id AND f.follow=? ORDER BY f.created DESC');
$followers->execute(array($_REQUEST['id']));

$follow_checks = $db->prepare('SELECT follow FROM follow WHERE user_id=?');
$follow_checks->execute(array($_SESSION['id']));

while($follow_check = $follow_checks->fetch()){
  $check[]=$follow_check['follow'];
}

?>
<?php require('header.php'); ?>
<div class="container">
<div class="wrapper"></div>
<div class="row">
<div class="col-8 offset-2 ">
<h3>フォロワー一覧</h3>
<?php foreach($followers as $follower): ?>
    <img src="user_img/<?php echo htmlspecialchars($follower['user_img']) ?>" alt="プロフ写真" class="rounded-circle">
    <a href="myPage.php?myPage_id=<?php echo $follower['id']?>"><?php echo $follower['name']?></a>

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