<?php
session_start();
session_regenerate_id(true);
require('function.php');

if (!isset($_SESSION['join'])) {
	header('Location: sign_up.php');
	exit();
}
$hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);

if(!empty($_POST)){
	$statement = $db->prepare('INSERT INTO users SET 
	name=?, email=?, user_img=?, password=?, created=NOW()');
	$statement->execute(array(
		$_SESSION['join']['name'],
		$_SESSION['join']['email'],
		$_SESSION['join']['image'],
		$hash
	));
	unset($_SESSION['join']);
	header('Location: thanks.php');
	exit();
}


?>
<?php require('header.php'); ?>
<div class="wrapper">
<!-- Page Content -->
<div class="container mt-5 p-lg-5 bg-light">
<p>〇記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="submit">
	<table class="table">
	<thead>
		<tr>
		<th scope="col">ユーザーネーム</th>
		<th scope="col"><?php echo(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
		<th scope="row">メールアドレス</th>
		<td><?php echo(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?></td>
		</tr>
		<tr>
		<th scope="row">パスワード</th>
		<td>表示されません</td>
		</tr>
		<tr>
		<th scope="row">プロフィール画像</th>
		<td><?php if ($_SESSION['join']['name'] !==''): ?>
		<img src="user_img/<?php echo(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
	<?php endif; ?></td>
		</tr>
	</tbody>
	</table>
	<a href="sign_up.php?action=rewrite">書き直す</a>
	<input type="submit" class="btn-block btn btn-lg btn-primary btn-primary1" value="登録する">
	</form>
	</div><!-- /container -->
</div>
<?php require('footer.php'); ?>
</html>