<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Handle new post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    mysqli_query($conn, "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')");
}

// Fetch all posts (latest first)
$posts = mysqli_query($conn, "SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LinkedIn Clone - Feed</title>
<link rel="stylesheet" href="style.css">
<style>
.feed-container { max-width: 600px; margin: auto; }
.feed-post { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 10px; background: #fff; }
.btn-edit, .btn-delete { padding: 5px 10px; margin-left: 5px; border: none; border-radius: 5px; cursor: pointer; }
.btn-edit { background-color: #4CAF50; color: white; }
.btn-delete { background-color: #f44336; color: white; }
.post-box textarea { width: 100%; height: 80px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
.btn { padding: 8px 15px; border: none; border-radius: 5px; background-color: #0073b1; color: white; cursor: pointer; }
</style>
</head>
<body class="bg-feed">

<div class="navbar">
    <h2>Linked<span>In</span> Clone</h2>
    <div class="nav-right">
        <span>Welcome, <?php echo $name; ?> 👋</span>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="feed-container">
    <div class="post-box">
        <form method="POST">
            <textarea name="content" placeholder="Start a post..." required></textarea><br>
            <button type="submit" class="btn">Post</button>
        </form>
    </div>

    <h3 style="margin-top:30px;">Recent Posts</h3>
    <hr>

    <?php while ($post = mysqli_fetch_assoc($posts)) { ?>
        <div class="feed-post">
            <h3><?php echo htmlspecialchars($post['name']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <small>🕒 <?php echo $post['created_at']; ?></small>

            <?php if ($_SESSION['user_id'] == $post['user_id']) : ?>
                <form action="edit_post.php" method="post" style="display:inline;">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <button type="submit" class="btn-edit">Edit</button>
                </form>

                <form action="delete_post.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <button type="submit" class="btn-delete">Delete</button>
                </form>
            <?php endif; ?>
        </div>
    <?php } ?>
</div>

</body>
</html>
