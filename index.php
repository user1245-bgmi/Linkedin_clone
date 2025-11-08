<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feed | LinkedIn Clone</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f3f2ef;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background: #0a66c2;
      color: white;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .navbar h2 {
      margin: 0;
      font-size: 20px;
    }

    .logout {
      color: white;
      text-decoration: none;
      background: #ff4b5c;
      padding: 8px 15px;
      border-radius: 6px;
      transition: 0.3s;
      font-weight: 600;
    }

    .logout:hover {
      background: #e63946;
    }

    .container {
      width: 100%;
      max-width: 550px;
      margin: 30px auto;
      padding: 0 15px;
    }

    .post-box {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 25px;
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    textarea {
      width: 100%;
      height: 90px;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 15px;
      resize: none;
      outline: none;
      transition: border-color 0.3s;
    }

    textarea:focus {
      border-color: #0a66c2;
    }

    button {
      margin-top: 12px;
      width: 100%;
      background-color: #0a66c2;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #004182;
    }

    .feed {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .post {
      background: white;
      border-radius: 10px;
      padding: 15px 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .post b {
      color: #0a66c2;
      font-size: 16px;
    }

    .post p {
      margin: 8px 0 5px;
      line-height: 1.5;
    }

    .post small {
      color: #777;
      font-size: 13px;
    }

    .no-posts {
      text-align: center;
      color: #777;
      margin-top: 20px;
    }

    /* Responsive design */
    @media (max-width: 600px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      .container {
        padding: 0 10px;
      }
      .post-box, .post {
        padding: 15px;
      }
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>👋 Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
    <a href="logout.php" class="logout">Logout</a>
  </div>

  <div class="container">
    <div class="post-box">
      <form method="POST" action="post.php">
        <textarea name="content" placeholder="What's on your mind?" required></textarea>
        <button type="submit">Post</button>
      </form>
    </div>

    <div class="feed">
      <?php
      $query = "SELECT posts.*, users.name 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                ORDER BY posts.created_at DESC";
      $result = mysqli_query($conn, $query);

      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='post'>
                  <b>" . htmlspecialchars($row['name']) . "</b>
                  <p>" . nl2br(htmlspecialchars($row['content'])) . "</p>
                  <small>Posted on " . htmlspecialchars($row['created_at']) . "</small>
                </div>";
        }
      } else {
        echo "<div class='no-posts'>No posts yet. Be the first to post!</div>";
      }
      ?>
    </div>
  </div>

</body>
</html>
