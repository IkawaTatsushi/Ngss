<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Ngss</title>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">Ngss</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="sign_up.php">新規登録</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">投稿一覧</a>
      </li>
<?php if(!empty($_SESSION['id'])): ?>
      <li class="nav-item">
        <a class="nav-link" href="post.php">投稿する</a>
<?php endif; ?>
      </li>
<?php if(!empty($_SESSION['id'])): ?>
        <li class="nav-item">
        <a class="nav-link " href="logout.php">ログアウト</a>
        </li>
        <li class="nav-item">
        <a class="nav-link " href="myPage.php?myPage_id=<?php echo $_SESSION['id'];?>">マイページ</a>
        </li>
<?php else: ?>
        <li class="nav-item">
        <a class="nav-link " href="login.php">ログイン</a>
<?php endif; ?>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="post">
      <input class="form-control mr-sm-2" type="search" placeholder="キーワード検索" aria-label="Search" name="search" required>
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">検索</button>
    </form>
  </div>
</nav>
<body>