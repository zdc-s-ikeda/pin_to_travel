<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>新規登録ページ</title>
  <link type="text/css" rel="stylesheet" href="./view/common.css">
</head>
<body>
  <header>
    <div class="header-box">
      <a href="top.php"><img class="logo" src="./image/logo.png" alt="CodeSHOP"></a>
      <a href="cart_page.php" class="nemu">カート</a>
    </div>
  </header>
  <div class="content">
    <div class="register">
      <div class="err-msg"><?php display_error($errors); ?></div>
      <div class="success-msg"><?php display_success($success); ?></div>
      <form method="post" action="register.php">
        <div><input type="text" name="user_name" placeholder="ユーザー名"></div>
        <div><input type="password" name="password" placeholder="パスワード"></div>
        <div><input type="submit" value="新規作成"></div>
      </form>
      <div class="login-link"><a href="./login.php">ログインページに移動する</a></div>
    </div>
  </div>
</body>
</html>
