<?php
session_start();
include 'db.php'; // Connect to database

if (isset($_POST['login'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
       // consistent with feed.php
      $_SESSION['name'] = $user_name; // after successful login

      header("Location: feed.php");
      exit();
    } else {
      echo "<script>alert('Invalid password!');</script>";
    }
  } else {
    echo "<script>alert('No user found with that email!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | LinkedIn Clone</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #0077b5, #004182);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 380px;
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    img {
      width: 60px;
      margin-bottom: 15px;
    }

    h2 {
      color: #0a66c2;
      margin-bottom: 25px;
      font-size: 24px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
      outline: none;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #0a66c2;
    }

    button {
      width: 100%;
      background-color: #0a66c2;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 12px;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #004182;
    }

    p {
      margin-top: 18px;
      font-size: 14px;
    }

    a {
      color: #0a66c2;
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .container {
        padding: 30px 20px;
      }

      h2 {
        font-size: 22px;
      }

      input, button {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="Images/imageslinkedin.png" alt="LinkedIn Logo">
    <h2>Welcome Back</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email address" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
      <p>New here? <a href="signup.php">Create an account</a></p>
    </form>
  </div>
</body>
</html>
