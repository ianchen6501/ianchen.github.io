<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>留言板</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='style.css'> 
</head>

<body>
  <header class='warning'>
    <strong>注意!本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
  </header>
  <main class='board'>
    <a href='index.php' class='board__btn'>回留言板</a>
    <a href='login.php' class='board__btn'>登入</a>
    <h1 class='board__title'>註冊</h1>
    <form class='board__new-comment-form' method='POST' action='handle_register.php'>
      <div class='board__nickname'>
        <span>帳號:</span>
        <input type="text" name='username'>
      </div>
      <div class='board__nickname'>
        <span>密碼:</span>
        <input type='password' name='password'>
      </div>
      <div class='board__nickname'>
        <span>暱稱:</span>
        <input type="text" name='nickname'>
      </div>
      <div>
        <input class='board__submit-btn' type="submit">
      </div>
      <?php
      //建立錯誤警示
      $errCode = '';
      if(!empty($_GET['errCode'])) { 
        $errCode = $_GET['errCode'];
        if ($errCode === '1') { //注意 querystring 帶進來是 string
      ?>
        <div class='error'>
          <h3>請輸入完整資料</h3>
        </div>
      <?php }} ?>
      <?php if ($errCode === '2') {?>
        <div class='error'>
          <h3>此帳號已被註冊</h3>
        </div>
      <?php } ?>
    </form>

  </main>

  <script>
  </script>
</body>
</html>

