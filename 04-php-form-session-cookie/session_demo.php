<?php
session_start();

// Simple hardcoded user for demo
$valid_user = "admin";
$valid_pass = "admin123";

$message = "";

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'login') {
        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);

        if ($user === $valid_user && $pass === $valid_pass) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_name'] = $user;
            $message = "success";
        } else {
            $message = "Invalid username or password.";
        }
    }

    if ($_POST['action'] === 'logout') {
        session_destroy();
        header("Location: session_demo.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Session Login Demo</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 30px; }
    .box {
      max-width: 400px; margin: 0 auto;
      background: white; padding: 25px;
      border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    input[type="text"], input[type="password"] {
      width: 100%; padding: 8px; margin-top: 5px;
      border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;
    }
    label { display: block; margin-top: 12px; font-weight: bold; }
    button {
      width: 100%; padding: 10px; margin-top: 15px;
      background: #2ecc71; color: white;
      border: none; border-radius: 5px; cursor: pointer; font-size: 15px;
    }
    .logout-btn { background: #e74c3c; }
    .error { color: red; margin-top: 10px; }
    .success { color: green; margin-top: 10px; }
    .hint { font-size: 12px; color: #888; margin-top: 8px; }
  </style>
</head>
<body>
<div class="box">

  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>

    <h2>👋 Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>You are logged in. Session is active.</p>
    <p>Session ID: <code><?php echo session_id(); ?></code></p>

    <?php if (isset($_COOKIE['username'])): ?>
      <p>Cookie username: <strong><?php echo htmlspecialchars($_COOKIE['username']); ?></strong></p>
    <?php endif; ?>

    <form method="POST">
      <input type="hidden" name="action" value="logout"/>
      <button type="submit" class="logout-btn">Logout</button>
    </form>

  <?php else: ?>

    <h2>🔐 Session Login</h2>

    <?php if ($message && $message !== 'success'): ?>
      <p class="error"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
      <input type="hidden" name="action" value="login"/>

      <label>Username:</label>
      <input type="text" name="username" placeholder="Enter username"/>

      <label>Password:</label>
      <input type="password" name="password" placeholder="Enter password"/>

      <button type="submit">Login</button>
    </form>

    <p class="hint">Demo credentials: username = <strong>admin</strong>, password = <strong>admin123</strong></p>
    <a href="index.html">← Back to Registration</a>

  <?php endif; ?>

</div>
</body>
</html>
