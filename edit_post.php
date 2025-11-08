<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle POST request to update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Fetch post to verify ownership
    $result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$post_id' AND user_id='$user_id'");
    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['content'])) {
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            mysqli_query($conn, "UPDATE posts SET content='$content' WHERE id='$post_id'");
            header("Location: feed.php");
            exit();
        }
        $post = mysqli_fetch_assoc($result);
    } else {
        die("You are not authorized to edit this post.");
    }
}

// Show edit form if GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$post_id' AND user_id='$user_id'");
    if (mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
    } else {
        die("You are not authorized to edit this post.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Post</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit Post</h2>
<form method="post">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
    <button type="submit">Update</button>
</form>
<a href="feed.php">Cancel</a>
</body>
</html>
