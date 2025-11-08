<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

$content = $_POST['content'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
mysqli_query($conn, $sql);
header("Location: feed.php");
?>
