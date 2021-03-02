<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!--Font Awesome5-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>ドロップダウンメニュー[レスポンシブ対応]</title>
</head>
<body>
    <header>
        <nav class="globalnav-wrap">
          <h1>美麗photo</h1>
          <div class="nav-button-wrap">
            <div class="nav-button">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <ul class="globalnav">
            <li class="dropdown-btn">
              <a href="top.php">美麗photoとは</a>
              <ul class="dropdown">
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
              </ul>
            </li>
            <li class="dropdown-btn">
              <a href="register.php">新規登録</a>
              <ul class="dropdown">
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
              </ul>
            </li>
            <li class="dropdown-btn">
            <?php if(!empty($_SESSION['id'])): ?>
            <a href="logout.php">ログアウト</a>
            <?php else: ?>
              <a href="login.php">ログイン</a>
            <?php endif; ?>
              <ul class="dropdown">
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
              </ul>
            </li>
            <li class="dropdown-btn">
            <a href="index.php">マイページ</a>
              <ul class="dropdown">
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
                <li><a href="#">ドロップダウンメニュー</a></li>
              </ul>
            </li>
          </ul>
        </nav>
    </header>
    