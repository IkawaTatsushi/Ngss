<?php
session_start();
require('dbconnect.php');

if (!empty($_POST)) {
	if ($_POST['email'] === ''){
		$error['email'] = 'blank';
	}
	if ($_POST['login'] === ''){
		$error['login'] = 'blank';
	}

	if($_POST['email'] !=='' && $_POST['login'] !=='') {
		$login = $db->prepare('SELECT * FROM users WHERE email=?');
		$login->execute(array(
			$_POST['email']
		));
		$user = $login->fetch();
		
		if(!$user){
			$error['login'] = 'failed';
		}
		if(!password_verify($_POST['login'], $user['password'])){
			$error['login'] = 'failed';
		}
		
		if (empty($error)){
			$_SESSION['id'] = $user['id'];
			$_SESSION['time'] = time();

			if($_POST['save'] == 'on') {
				setcookie('email', $_POST['email'], time()+60*60*24*14);
			}
			header('Location: index.php');
      		exit();
		}
	}
}

?>
<?php require('header.php'); ?>
<div class="wrapper">
<div class="container-fluid">
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="box box1">
				<div class="input-group input-group1">
					<span class="input-group-addon addon-facebook addon-facebook1">
						<i class="fab fa-facebook-square fa-2x"></i>
					</span>
					<a class="btn btn-lg btn-block btn-facebook btn-facebook1" href="#"> Facebookでログイン</a>
				</div>

				<div class="input-group input-group1">
					<span class="input-group-addon addon-twitter addon-twitter1">
						<i class="fab fa-twitter-square fa-2x"></i>
					</span>
					<a class="btn btn-lg btn-block btn-twitter btn-twitter1" href="#"> Twitterでログイン</a>
				</div>

				<form role="form" action="" method="post">

					<div class="divider-form divider-form1"></div>

					<div class="form-group">
					<?php if ($error['login'] === 'failed'): ?>
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
						<input type="password" name="login" size="10" maxlength="20" class="form-control form-control1" id="exampleInputPassword1" placeholder="Password">
						<?php if($error['login'] === 'blank'): ?>
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
</body>
</html>