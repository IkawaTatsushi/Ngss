<?php
//共通関数読み込み
require('function.php');

//フォームから値を受け取っていたら
if (!empty($_POST)) {

	//パスとメールを変数に代入
	$email = $_POST['email'];
    $pass = $_POST['pass'];

	//メールアドレスを記憶するにチェックが入っているかチェックし変数に代入
	$save = (!empty($_POST['save'])) ? true : false;

	//メールとパスに値を受け取っていたら
	if($email !=='' && $pass !=='') {
		try{

			//データベース接続
			$dbh = dbConnect();

			//usersテーブルからパスとメールの一致るすデータからパスワードとIDを選択
			$sql = 'SELECT password,id FROM users WHERE email = :email';
			$data = array(':email' => $email);

			//sql実行
			$stmt = queryPost($dbh, $sql, $data);

			//あれば変数へ代入
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

			//$データベースから受け取ったパスとログインページから受け取ったパスが一致していたら
			if (!empty($result) && password_verify($pass, array_shift($result))){

				//セッション変数に自IDを代入
				$_SESSION['id'] = $result['id'];

					//メールアドレスを記憶する場合
					if ($save){

						//emailをクッキーに１年保存
						setcookie('email', $_POST['email'], time()+60*60*24*365);
					}
				
				//index.phpへ遷移
				header('Location: index.php');
				exit();

			//パスが一致していなかったらエラー変数に値を代入
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
					<!-- ログインできていなかったら -->
					<?php if ($error['pass'] === 'failed'): ?>
							<small id="passwordHelpBlock" class="form-text text-muted">正しいメールアドレスとパスワードをご記入ください</small>
						<?php endif; ?>
						<label class="label1" for="exampleInputEmail1">メールアドレス</label>
						<p>ゲスト:test5@gmail.com</p>
						<input type="email" name="email" size="35" maxlength="255" class="form-control form-control1" id="exampleInputEmail1" placeholder="email">
					</div>
					<div class="divider-form divider-form1"></div>

					<div class="form-group">
						<label class="label1" for="exampleInputPassword1">パスワード</label>
						<p>ゲスト:test1212</p>
						<input type="password" name="pass" size="10" maxlength="20" class="form-control form-control1" id="exampleInputPassword1" placeholder="Password">
					</div>
					<div class="divider-form divider-form1"></div>

					<input type="checkbox" id="save" name="save" value="on">
					<label class="label1" for="save">メールアドレスを記憶する</label>

					<input type="submit" class="btn-block btn btn-lg btn-primary btn-primary1" value="ログイン">
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php require('footer.php'); ?>