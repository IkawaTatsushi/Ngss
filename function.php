<?php
session_start();
session_regenerate_id(true);

//エスケープ処理
function h($str, $encode='UTF-8'){
    return htmlspecialchars($str, ENT_QUOTES, $encode);
}

//=====================================
//定数
//=====================================
//エラーメッセージ用定数
define('MSG01', 'Eメールの形式で入力して下さい');
define('MSG02', 'このメールアドレスは既に登録されています');
define('MSG03', '画像はjpg,ping,gif,jpegの形式でご指定ください');
define('MSG04', '入力必須です');
define('MSG05', '');
define('MSG06', '');
define('MSG07', '');
define('MSG08', '');

$error = array();

//email形式チェック
function validEmailType($email){
    global $error;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL )) {
        $error['email'] = MSG01;
    }
}

//email重複チェック
function validEmailDup($email){
    global $error;
    try {
        $dbh = dbConnect();
        $sql = 'SELECT COUNT(*) AS cnt FROM users WHERE email = :email';
        $data = array(':email' => $email);
        $stmt = queryPost($dbh, $sql, $data);
        $result = $stmt->fetch();
        if (($result['cnt']) > 0) {
            $error['email'] = MSG02;
        }
    } catch (Exception $e) {
        $err_msg['common'] = MSG03;
        echo 'DB接続エラー: ' . $e->getMessage();  
    }
}

//画像拡張子を確認
function imagetype($fileName){
    global $error;
    if(!preg_match( "/.*?\.jpg|.*?\.png||.*?\.gif.*?\.jpeg/i", $fileName)){
       return $error['image'] = MSG02;
    }
}

//未入力チェック
function validRequired($str, $key){
    if ($str === '') {
        global $error;
        $error[$key] = MSG04;
    }
}

//エラーメッセージ取得
function getErrMsg($key){
    global $error;
    if (!empty($error[$key])) {
        return $error[$key];
    }
}

//データベース取得
function dbConnect(){
    $dsn = 'mysql:dbname=ngss;host=localhost;port=8889;charset=utf8';
    $user = 'root';
    $password = 'root';
    $options = array(PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
        $dbh = new PDO($dsn, $user, $password, $options);
        return $dbh;
}

//SQL実行
function queryPost($dbh, $sql, $data){
    $stmt = $dbh->prepare($sql);
    if (!$stmt->execute($data)) {
        return 0;
    }
    return $stmt;
}

//投稿総件数取得
function getPageCount(){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT COUNT(*) AS cnt FROM posts';
        $data = array();
        $stmt = queryPost($dbh, $sql, $data);
            return $stmt->fetch();
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

//投稿全件から5件ごとに取得
function getPostAll($data){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT u.id, u.name, u.user_img, p.*, COUNT(f.user_id)  AS good FROM users u RIGHT JOIN posts p 
        ON u.id=p.user_id LEFT JOIN favorite f ON p.id = f.post_id GROUP BY p.id ORDER BY p.created DESC LIMIT :limit,5';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':limit', (int)$data, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
    
}

//いいねしたメッセージを全件を配列に挿入
function getFavorite($user_id){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT post_id FROM favorite WHERE user_id = :user_id';
        $data = array(':user_id' => $user_id);
        $stmt = queryPost($dbh, $sql, $data);

        while($favorite_check = $stmt->fetch()){
            $check[]=$favorite_check['post_id'];
        }
        return $check;
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

//フォローチェック
function getFollow($user_id, $re_id){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM follow WHERE user_id = :user_id AND follow = :follow';
        $data = array(':user_id' => $user_id, ':follow' => $re_id);
        $stmt = queryPost($dbh, $sql, $data);
        return $stmt->fetch();
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

//各ユーザーの登録情報取得
function getUser($re_id){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM users WHERE id = :re_id';
        $data = array(':re_id' => $re_id);
        $stmt = queryPost($dbh, $sql, $data);
        return $stmt->fetch();
            
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}
//各ユーザーの投稿情報取得
function getUserContents($re_id){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT u.name, u.user_img, p.* FROM users 
        u, posts p WHERE u.id = :re_id AND u.id = p.user_id ORDER BY p.created';
        $data = array(':re_id' => $re_id);
        $stmt = queryPost($dbh, $sql, $data);
            return $stmt;
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

//メッセージ詳細取得
function getPost($id){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM posts WHERE id = :id';
        $data = array(':id' => $id);
        $stmt = queryPost($dbh, $sql, $data);
        return $stmt->fetch();
            
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

//メッセージ削除
function deletePost($id){
    try {
        $dbh = dbConnect();
        $sql = 'DELETE FROM posts WHERE id=:id';
        $data = array(':id' => $id);
        $stmt = queryPost($dbh, $sql, $data);
        return $stmt;
            
    } catch(PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}
?>