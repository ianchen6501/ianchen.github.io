<?php
session_start();
require_once('conn.php');
require_once('utils.php');

$authority = $_POST['authority'];
$id = $_POST['id'];

$sql = "UPDATE Ian_users SET authority = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $authority, $id);
$result = $stmt->execute();

header('location: authority-management.php');
?>
