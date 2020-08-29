<?php
session_start();
require_once('conn.php');
require_once('utils.php');

//取得會員資料
$stmt = $conn->prepare(
  'SELECT * FROM Ian_users'
);
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
    <a href='index.php' class='board__btn'>回留言板</a>

      <table class="users-info__table">
        <tr>
          <th>username</th>
          <th>nickname</th>
          <th>創立時間</th>
          <th>權限</th>
          <th>權限管理</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['username'] ?></td>
          <td><?php echo $row['nickname'] ?></td>
          <td><?php echo $row['created_at'] ?></td>
          <td><?php echo $row['authority'] ?></td>
          <td class="users-info__table__radio">
            <form class='board__new-comment-form' method='POST' action='handle_authority-management.php'>
              <div><label><input type="radio" name='authority' value="管理者">管理者</label></div>
              <div><label><input type="radio" name='authority' value="ㄧ般使用者">ㄧ般使用者</label></div>
              <div><label><input type="radio" name='authority' value="禁止發言">禁止發言</label></div>
              <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
              <div>
                <input class='board__submit-btn' type="submit">
              </div>
            </form>
          </td>
        </tr>
        <?php } ?>
      </table>



  </main>
  <script>
  </script>
</body>
</html>

