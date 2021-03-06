<?php
try {
    $db = new PDO('mysql:dbname=gsp;host=localhost;port=8889;charset=utf8',
    'root','root');
}catch(PDOException $e) {
    echo 'DB接続エラー: ' . $e->getMessage();
}

function search() {
    $keyword = '%'.$_POST['search'].'%';

    $searchs = $db->prepare('SELECT u.name, u.user_img, p.* FROM users 
    u, posts p WHERE u.id=p.user_id AND message LIKE message=? ORDER BY p.created DESC');
    $searchs->execute(array($keyword));
    $search = $searchs->fetch();
}
?>