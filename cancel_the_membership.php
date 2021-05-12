<?php
require('function.php');

//ログインしていたら
if(isset($_SESSION['id'])) {

    //ユーザーIDを変数に代入
    $user_id = $_SESSION['id'];

	//パスワード入力があったら
	if(!empty($_POST['pass'])){
		$pass = $_POST['pass'];

		//パスワードが一致するかチェック
		$match = password_match($user_id,$pass);

		//一致していたら
		if($match){
			//登録情報削除
			cancel_the_membership_user($user_id);
			cancel_the_membership_post($user_id);
			cancel_the_membership_good($user_id);
			cancel_the_membership_follow($user_id);

			//ログアウト処理
			$_SESSION = array();
			if (ini_set('session.use_cookies ')) {
			$params = session_get_cookie_params();
			setcookie(session_name() . '', time() - 3600,
			$params['path'], $params['domain'], $params
			['secure'], $params['HttpOnly']);
			}
			session_destroy();
			setcookie('email', '', time()-3600);

			//退会処理後に画面遷移
			header('Location: thanks.php');
			exit;
		}
	}
}else{
    header('Location: index.php');
    exit();
}

?>
<?php require('header.php'); ?>
<div class="wrapper">
<div class="container">
    <div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="box box1">

				<form role="form" action="" method="post">
					<div class="form-group">
					<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('pass'); ?></small>
					<div class="form-group">
						<label class="label1" for="exampleInputPassword1">パスワード</label>
						<input type="password" name="pass" size="10" maxlength="20" class="form-control form-control1" id="exampleInputPassword1" placeholder="Password">
					</div>
					<div class="divider-form divider-form1"></div>

					<input type="submit" class="btn-block btn btn-lg btn-primary btn-primary1 cancel-the-membership" value="退会する">
				</form>
			</div>
			<a href="index.php">TOPへ戻る</a>
		</div>
	</div>
</div>
</div>
<?php require('footer.php'); ?>