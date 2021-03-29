<?php
//共通関数読み込み
require('function.php');

if(!empty($_POST)) {

	//メールチェック
	validEmailDup($_POST['email']);
	validEmailType($_POST['email']);

	//未入力チェック
	validRequired($_POST['name'], 'name');
	validRequired($_POST['email'], 'email');
	validRequired($_POST['password'], 'password');
	
		//ファイル名を受け取っていたら
	if 	(!empty($_FILES['image']['name'])) {
		$fileName = $_FILES['image']['name'];

		//ファイルタイプチェック
		imagetype($fileName);
	}

	if(empty($error)) {
		//セッション変数に受け取った情報を代入
		$_SESSION['join'] = $_POST;

		//画像を受け取っていたら
		if(!empty($_FILES['image']['name'])){

			//画像の名前を変数に代入
			$image = date('YmdHis') . $_FILES['image']['name'];

					//画像を保存
					move_uploaded_file($_FILES['image']['tmp_name'],
					'user_img/' . $image);

			//セッション変数に画像の名前を代入
			$_SESSION['join']['image'] = $image;

		//画像を受け取っていない場合デフォルト画像に設定
		}else{
			$_SESSION['join']['image'] = 'DefaultIcon.jpeg';
		}
		header('Location: check.php');
		exit();
	}
}

//チェックページから戻るボタンが押された場合
if ($_REQUEST['action'] =='rewrite' && isset($_SESSION['join'])) {
	//セッション変数を$_POSTに戻す
	$_POST = $_SESSION['join'];

	//画像がデフォルト画像以外に設定されていたら、フォルダから画像を削除
	if($_SESSION['join']['image'] !== 'DefaultIcon.jpeg'){
	unlink('user_img/'.$_SESSION['join']['image']);
	}
}
?>
<?php require('header.php'); ?>
<div class="wrapper"></div>
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
		
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Eメール</label>
            <div class="col-sm-10">
                <input type="email" name="email" maxlength="255" value="<?php echo
				(h($_POST['email'])); ?>" class="form-control" id="inputEmail">
				<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('email'); ?></small>
            </div>
		</div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" name="password" maxlength="20">
				<small id="passwordHelpBlock" class="error"><?php echo getErrMsg('password'); ?></small>
            </div>
        </div>

        <div class="mb-3">
  			<label for="formFileMultiple" class="form-label">プロフィール画像</label>
  			<input class="form-control" type="file" name="image" size="35" value="test" id="formFileMultiple" multiple>
		</div>

        <div class="form-group row">
            <div class="col-sm-12">
                <input type="submit" class="btn btn-primary btn-block" value="入力内容を確認してください">
            </div>
        </div>
    </form>
</div>
<?php require('footer.php');?>