<?php
session_start();
session_regenerate_id(true);

//データベース取得
function dbConnect(){
    $dsn = 'mysql:dbname=ngss;host=localhost;port=8889;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
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
function getPostData($data){
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
?>