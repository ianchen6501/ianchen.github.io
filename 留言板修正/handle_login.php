<?php
session_start();
require_once('conn.php');
require_once('utils.php');
//檢查是否有輸入帳密
if (empty($_POST['username']) || empty($_POST['password'])) {
  header('location: login.php?errCode=1');
  die();
} else {
  $username = $_POST['username'];
  $password = $_POST['password'];
  //取得資料
  $sql ="select * from Ian_users where username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  //用 num->rows 檢查是否有註冊
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    header("Location: login.php?errCode=2");
    exit();
  }
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    // 登入成功
    $_SESSION['username'] = $username;
    header("Location: index.php");
  } else {
    header("Location: login.php?errCode=2");
  }}
?>
