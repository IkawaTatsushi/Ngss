<?php
session_start();
session_regenerate_id(true);
require('function.php');

if(!empty($_POST)) {
	if ($_POST['name'] === ''){
		$error['name'] = 'blank';
	}
	if ($_POST['email'] === ''){
		$error['email'] = 'blank';
	}
	if (strlen($_POST['password']) < 4){
		$error['password'] ='length';
	}
	if ($_POST['password'] === ''){
		$error['password'] = 'blank';
	}
	$fileName = $_FILES['image']['name'];
	if 	(!empty($fileName)) {
		$ext = substr($fileName, -3);
		if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'jpeg') {
			$error['image'] = 'type';
		}
	}

	if(empty($error)){
		$user = $db->prepare('SELECT COUNT(*) AS cnt
		FROM users WHERE email=?');
		$user->execute(array($_POST['email']));
		$record = $user->fetch();
		if ($record['cnt'] > 0) {
			$error['email'] = 'duplicate';
		}
	}
	if(empty($error)) {
		$_SESSION['join'] = $_POST;
		
		if(!empty($_FILES['image']['name'])){
			$image = date('YmdHis') . $_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'],
					'user_img/' . $image);
			$_SESSION['join']['image'] = $image;
		}else{
			$_SESSION['join']['image'] = 'DefaultIcon.jpeg';
		}

		header('Location: check.php');
		exit();
	}
}

if ($_REQUEST['action'] =='rewrite' && isset($_SESSION
['join'])) {
	$_POST = $_SESSION['join'];
	$_SESSION['join']['image'] != 'DefaultIcon.jpeg' ? unlink('user_img/'.$_SESSION['join']['image']) : $a=1 ;
}
?>
<?php require('header.php'); ?>
<div class="wrapper">
<!-- Page Content -->
<div class="container">
	<h1>ユーザー登録</h1>
	<p>次のフォームに必要事項をご記入ください。</p>

    <form action="" method="post" enctype="multipart/form-data">
	<div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">ユーザーネーム</label>
            <div class="col-sm-10">
                <input type="name" name="name" maxlength="255" value="<?php print
			(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" class="form-control" id="inputName">
			<?php if ($error['name'] === 'blank'): ?>
			<small id="passwordHelpBlock" class="form-text text-muted">ユーザーネームを入力してください</small>
			<?php endif; ?>
        	</div>
            </div>
		

        <!--Eメール-->
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Eメール</label>
            <div class="col-sm-10">
                <input type="email" name="email" maxlength="255" value="<?php print
			(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" class="form-control" id="inputEmail">
			<?php if ($error['email'] === 'blank'): ?>
			<small id="passwordHelpBlock" class="form-text text-muted">メールアドレスを入力してください</small>
			<?php endif; ?>
			<?php if ($error['email'] === 'duplicate'): ?>
			<small id="passwordHelpBlock" class="form-text text-muted">このメールアドレスは既に使われています</small>
			<?php endif; ?>
            </div>
			</div>
		
        <!--/Eメール-->

        <!--パスワード-->
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" name="password" maxlength="20" placeholder="パスワード">
                <small id="passwordHelpBlock" class="form-text text-muted">パスワードは4文字以上の英数字でご記入ください。</small>
            </div>
        </div>
		<?php if ($error['password'] === 'length'): ?>
		<p>パスワードは4文字以上で入力してください</p>
		<?php endif; ?>
        <!--/パスワード-->

        <!--ファイル選択-->
        <div class="mb-3">
  <label for="formFileMultiple" class="form-label">プロフィール画像</label>
  <input class="form-control" type="file" name="image" size="35" value="test" id="formFileMultiple" multiple>
</div>
        <!--/ファイル選択-->
		

        <!--ボタンブロック-->
        <div class="form-group row">
            <div class="col-sm-12">
                <input type="submit" class="btn btn-primary btn-block" value="入力内容を確認してください">
            </div>
        </div>
        <!--/ボタンブロック-->
    </form>
</div><!-- /container -->
</div>
<?php
require('footer.php');
?>
</html>