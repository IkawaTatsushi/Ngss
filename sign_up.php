<?php
require('function.php');

if(!empty($_POST)) {
	//メールチェック
	validEmailDup($_POST['email']);
	validEmailType($_POST['email']);

	//未入力チェック
	validRequired($_POST['name'], 'name');
	validRequired($_POST['email'], 'email');
	validRequired($_POST['password'], 'password');
	
	if 	(!empty($_FILES['image']['name'])) {
		$fileName = $_FILES['image']['name'];
		imagetype($fileName);
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
if ($_REQUEST['action'] =='rewrite' && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
	if($_SESSION['join']['image'] !== 'DefaultIcon.jpeg'){
	unlink('user_img/'.$_SESSION['join']['image']);
	}
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
                <input type="name" name="name" maxlength="255" value="<?php echo
			(h($_POST['name'])); ?>" class="form-control" id="inputName">
			<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('name'); ?></small>
        	</div>
            </div>
		

        <!--Eメール-->
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Eメール</label>
            <div class="col-sm-10">
                <input type="email" name="email" maxlength="255" value="<?php echo
			(h($_POST['email'])); ?>" class="form-control" id="inputEmail">
			<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('email'); ?></small>
            </div>
			</div>
		
        <!--/Eメール-->

        <!--パスワード-->
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" name="password" maxlength="20">
                <small id="passwordHelpBlock" class="error">パスワードは4文字以上の英数字でご記入ください。</small>
				<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('password'); ?></small>
            </div>
        </div>
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