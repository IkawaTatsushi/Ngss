<?php
require('function.php');

//$_SESSION['join']になにもなければsign_up.phpへ遷移
if (!isset($_SESSION['join'])) {
	header('Location: sign_up.php');
	exit();
}	

	//$_SESSION['join']の中身を各変数へ代入
	$name = $_SESSION['join']['name'];
	$email = $_SESSION['join']['email'];
	$user_img = $_SESSION['join']['image'];
	$pass = $_SESSION['join']['password'];

	//登録するボタンが押されたら
	if(!empty($_POST)){
		try {
			$dbh = dbConnect();
			//usersテーブルに挿入
			$sql = 'INSERT INTO users (name,email,user_img,password) VALUES (:name,:email,:user_img,:pass)';
			$data = array(':name' => $name,':email' => $email,
						':user_img' => $user_img,':pass' => password_hash($pass, PASSWORD_BCRYPT));
			$stmt = queryPost($dbh, $sql, $data);

			//書き込みに成功したら
			if($stmt){
				//$_SESSION['join']を消す
				unset($_SESSION['join']);
				//テーブルに挿入したIDを$_SESSION['id']に代入
				$_SESSION['id'] = $dbh->lastInsertId();
				header('Location: index.php');
				exit();
			}
		} catch(PDOException $e) {
			echo 'DB接続エラー: ' . $e->getMessage();
		}
	}

?>
<?php require('header.php'); ?>
<div class="wrapper"></div>
<div class="container mt-5 p-lg-5 bg-light">
	<p>〇記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="submit">
		<table class="table">
			<thead>
				<tr>
				<th scope="col">ユーザーネーム</th>
				<th scope="col"><?php echo h($_SESSION['join']['name']); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<th scope="row">メールアドレス</th>
				<td><?php echo h($_SESSION['join']['email']); ?></td>
				</tr>
				<tr>
				<th scope="row">パスワード</th>
				<td>表示されません</td>
				</tr>
				<tr>
				<th scope="row">プロフィール画像</th>
				<td><?php if ($_SESSION['join']['name'] !==''): ?>
				<img src="user_img/<?php echo h($_SESSION['join']['image']); ?>" class="rounded-circle" alt="プロフィール画像">
<?php endif; ?></td>
				</tr>
			</tbody>
		</table>
		<a href="sign_up.php?action=rewrite">書き直す</a>
		<input type="submit" class="btn-block btn btn-lg btn-primary btn-primary1" value="登録する">
	</form>
</div>

<?php require('footer.php'); ?>
</html>