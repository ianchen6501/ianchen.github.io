<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  //取得 id 及 username
  $id = $_GET['id'];
  $username = NULL;
  $user = NULL;
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }
  //取得留言內容
  $stmt = $conn->prepare(
    'select * from Ian_comments where id = ?'
  );
  $stmt->bind_param("i", $id);
  $result = $stmt->execute();
  if (!$result) {
    die('Error:' . $conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  //錯誤訊息
  $errCode = null;
  if (!empty($_GET['errCode'])) {
    $errCode = $_GET['errCode'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header class="warning">
    <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
  </header>
  <main class="board">      
      <h1 class="board__title">編輯留言</h1>
      <form class="board__new-comment-form" method="POST" action="handle_update_comment.php">
        <textarea name="comments" rows="5"><?php echo $row['comments'] ?></textarea>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
        <input class="board__submit-btn" type="submit" />
      </form>
      <?php
        if ($errCode === '1') {
      ?>
        <h3 class='error'> 請輸入留言內容 </h3>
      <?php } ?>
  </main>
</body>
</html> 