<?php
require_once('conn.php');
session_start();
//檢查是否為輸入空
if (empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
  header('location: register.php?errCode=1');
  exit();
}
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$nickname = $_POST['nickname'];
$authority = 'ㄧ般使用者';
//註冊資料
$sql = "insert into Ian_users(nickname, username, password, authority) values(?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nickname, $username, $password, $authority);
$result = $stmt->execute(); 
//檢查連線
if (!$result) {
  $code = $conn->errno;
  if ($code === 1062) {
    header('Location: register.php?errCode=2');
  }
  die($conn->error);
}
//保持登入狀態
$_SESSION['username'] = $username;
header('location: index.php');
?>