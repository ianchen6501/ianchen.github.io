<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');
  if (
    empty($_POST['comments'])
  ) {
    header('Location: update_comments.php?errCode=1&id='.$_POST['id']);
    die('資料不齊全');
  }

  $username = $_SESSION['username'];
  $id = $_POST['id'];
  $comments = $_POST['comments'];

  $sql = "update Ian_comments set comments=? where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $comments, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>