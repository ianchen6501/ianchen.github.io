<?php
require_once('conn.php');
//用 username 取得相關資料
function getUserdatafromUsername ($username) {
  global $conn;
  $sql = sprintf("SELECT * From Ian_users WHERE username='%s'",
  $username);
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return $row;
}

function escape($str) {
  return htmlspecialchars($str, ENT_QUOTES);
}


?>