<?php
session_start();
session_regenerate_id(true);
require('dbconnect.php');
?>
<?php require('header.php'); ?>
<div class="container">
<div class="wrapper"></div>
<h1>エラーが発生しました</h1>
    <a href="javascript:history.go(-1);">戻る</a>
</div>
<?php require('footer.php'); ?>