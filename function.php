<?php
try {
    $dbn = 'mysql:dbname=ngss;host=localhost;port=8889;charset=utf8';
    $user =  'root';
    $pass =  'root';
    $db = new PDO( $dbn,$user, $pass);
}catch(PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
}

?>