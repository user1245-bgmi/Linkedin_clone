<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Verify ownership
    $result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$post_id' AND user_id='$user_id'");
    if (mysqli_num_rows($result) > 0) {
        mysqli_query($conn, "DELETE FROM posts WHERE id='$post_id'");
        header("Location: feed.php");
        exit();
    } else {
        die("You are not authorized to delete this post.");
    }
}
?>
