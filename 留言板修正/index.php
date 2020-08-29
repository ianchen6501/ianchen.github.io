<?php
session_start();
require_once('conn.php');
require_once('utils.php');

$username = null;
if (!empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
}
//拿到 user 資料
$userdata = getUserdatafromUsername($username);
$nickname = $userdata['nickname'];
$authority = $userdata['authority'];

//錯誤訊息
$errCode = null;
if (!empty($_GET['errCode'])) {
  $errCode = $_GET['errCode'];
}
//設定留言分頁及每頁筆數
$page = 1;
if (!empty($_GET['page'])) {
  $page = intval($_GET['page']);
}
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

//拿到所有 comments 資料
$stmt = $conn->prepare(
  'select '.
  'C.id as id, C.comments as comments, '.
  'C.created_at as created_at, U.nickname as nickname, U.username as username, U.authority as authority '.
  'from Ian_comments as C ' .
  'left join Ian_users as U on C.username = U.username '.
  'where C.is_deleted IS NULL '.
  'order by C.id desc ' .
  'limit ? offset ? '
);
$stmt->bind_param('ii', $items_per_page, $offset);
$result = $stmt->execute();
if (!$result) {
  die($conn->error);
}
$result = $stmt->get_result();

?>

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
  <?php if(!empty($username)) { ?>
    <a href='handle_logout.php' class='board__btn'>登出</a>
    <div id='update-nickname' class='board__btn'>編輯暱稱</div>
    <?php if ($authority === '管理者') {?>
      <a href='authority-management.php' class='board__btn'>權限管理</a>
    <?php } ?>
    <form class="hide board__nickname-form" method="POST" action="handle_updateNickname.php">
      <div class="board__nickname">
        <span>新的暱稱：</span> 
        <input type="text" name="nickname" />
        <input class="board__submit-btn" type="submit" />
      </div>
    </form>
    <div class='board__hr'></div>
    <h3>你好!<?php echo $nickname ?>@(<?php echo $username ?>)</h3>
  <?php } else { ?>
    <a href='register.php' class='board__btn'>註冊</a>
    <a href='login.php' class='board__btn'>登入</a>
  <?php } ?>
    <h1 class='board__title'>Comments</h1>
    <form class='board__new-comment-form' method='POST' action='handle_add_comment.php'>
      <!-- 留言輸入區 -->
      <?php if( $authority === '禁止發言') { ?>
        <h3 class='error'> 您目前無法發布留言，請與管理員聯絡 </h3>
      <?php } ?>
      <?php if(!empty($username) && $authority !== '禁止發言') { ?>
        <div><textarea name='comments' rows='5'></textarea>
        <input class='board__submit-btn' type="submit">
      <?php } ?>
      <?php if(empty($username)) { ?>
        <h3 class='error'> 請登入發布留言 </h3>
      <?php } ?>
      <?php
        if ($errCode === '1') {
      ?>
        <h3 class='error'> 請輸入留言內容 </h3>
      <?php } ?>
      </div>
    </form>
    <div class='board__hr'></div>
    <section>
    <!-- 留言內容 -->
      <?php 
        while ($row = $result->fetch_assoc()) { 
      ?>
        <div class='card'>
          <div class='card__avatar'>
          </div>
            <div class='card__body'>
              <div class='card__info'>
                <span class='card__author'><?php echo escape($row['nickname']); ?>@(<?php echo escape($row['username']); ?>)</span>
                <span class='card__time'><?php echo escape($row['created_at']); ?></span>
                <?php if ($row['username'] === $username || $authority === '管理者') { ?>
                    <a href="update_comments.php?id=<?php echo $row['id'] ?>">編輯</a>
                    <a href="handle_delete_comment.php?id=<?php echo $row['id'] ?>">刪除</a>
                <?php } ?>
                <p class='card__content'><?php echo escape($row['comments']); ?></p>   
              </div>
            </div>
          </div>
      <?php } ?>
    </section>
    <!-- 留言分頁 -->
    <div class="board__hr"></div>
      <?php
        //拿到總留言筆數 $conn
        $stmt = $conn->prepare(
          'select count(id) as count from Ian_comments where is_deleted IS NULL'
        );
        $result = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $total_page = ceil($count / $items_per_page); //取整數
      ?>
      <div class="page-info">
        <span>總共有 <?php echo $count ?> 筆留言，頁數：</span>
        <span><?php echo $page ?> / <?php echo $total_page ?></span>
      </div>
      <div class="paginator">
        <?php if ($page != 1) { ?> 
          <a href="index.php?page=1">首頁</a>
          <a href="index.php?page=<?php echo $page - 1 ?>">上一頁</a>
        <?php } ?>
        <?php if ($page != $total_page) { ?>
          <a href="index.php?page=<?php echo $page + 1 ?>">下一頁</a>
          <a href="index.php?page=<?php echo $total_page ?>">末頁</a> 
        <?php } ?>
      </div>



  </main>
  <script>
    var btn = document.querySelector('#update-nickname')
    btn.addEventListener('click', function() {
      var form = document.querySelector('.board__nickname-form')
      form.classList.toggle('hide')
    })
  </script>
</body>
</html>

