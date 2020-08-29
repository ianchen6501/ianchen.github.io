<?php
// 建立 mysqli 基本資料
$servername = "localhost";
$username = "mtr04group2";
$password = "Lidemymtr04group2";
$dbname = "mtr04group2";

// 建立 db 連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if (!empty($conn->connect_error)) {
  die('connect error:' . $conn->connect_error);
}
?>