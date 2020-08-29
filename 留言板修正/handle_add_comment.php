<?php
session_start();
require_once('conn.php');
require_once('utils.php');
$comments = $_POST['comments'];
//檢查留言是否為空
if (empty($comments)) {
  header('Location: index.php?errCode=1');
  exit();
}
//update 留言
$username = $_SESSION['username'];
$userdata = getUserdatafromUsername ($username);

$sql = "insert into Ian_comments(username, comments) values(?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $comments);
$result = $stmt->execute();
if(!$result) {
  die($conn->error);
}

header('location: index.php');
?>