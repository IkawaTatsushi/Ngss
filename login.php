<?php
require('function.php');

if (!empty($_POST)) {
	$email = $_POST['email'];
    $pass = $_POST['pass'];
	$save = (!empty($_POST['save'])) ? true : false;

	if ($email === ''){
		$error['email'] = 'blank';
	}
	if ($pass === ''){
		$error['pass'] = 'blank';
	}

	if($email !=='' && $pass !=='') {
		try{
			$dbh = dbConnect();
			$sql = 'SELECT password,id FROM users WHERE email = :email';
			$data = array(':email' => $email);
			$stmt = queryPost($dbh, $sql, $data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!empty($result) && password_verify($pass, array_shift($result))){
				$_SESSION['time'] = time();
				$_SESSION['id'] = $result['id'];
					if ($save){
						setcookie('email', $_POST['email'], time()+60*60*24*365);
					}
				header('Location: index.php');
				exit();
			} else{
				$error['pass'] = 'failed';
			}
		} catch(PDOException $e) {
			echo 'DB接続エラー: ' . $e->getMessage();
		}
	}
}

?>
<?php require('header.php'); ?>
<div class="wrapper">
<div class="container">
    <div class="row">
		<div class="col-lg-5 offset-lg-3">
			<div class="box box1">

				<form role="form" action="" method="post">
					<div class="divider-form divider-form1"></div>

					<div class="form-group">
					<?php if ($error['pass'] === 'failed'): ?>
							<small id="passwordHelpBlock" class="form-text text-muted">正しいメールアドレスとパスワードをご記入ください</small>
						<?php endif; ?>
						<label class="label1" for="exampleInputEmail1">メールアドレス</label>
						<input type="email" name="email" size="35" maxlength="255" class="form-control form-control1" id="exampleInputEmail1" placeholder="email">
						<?php if($error['email'] === 'blank'): ?>
						<small id="passwordHelpBlock" class="form-text text-muted">メールアドレスを入力してください</small>
						<?php endif; ?>
					</div>
					<div class="divider-form divider-form1"></div>

					<div class="form-group">
						<label class="label1" for="exampleInputPassword1">パスワード</label>
						<input type="password" name="pass" size="10" maxlength="20" class="form-control form-control1" id="exampleInputPassword1" placeholder="Password">
						<?php if($error['pass'] === 'blank'): ?>
						<small id="passwordHelpBlock" class="form-text text-muted">パスワードを入力してください</small>
						<?php endif; ?>
					</div>

					<div class="divider-form divider-form1"></div>

					<input type="checkbox" id="save" name="save" value="on">
					<label class="label1" for="save">次回からは自動的にログインする</label>

					<input type="submit" class="btn-block btn btn-lg btn-primary btn-primary1" value="ログイン">
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php require('footer.php'); ?>