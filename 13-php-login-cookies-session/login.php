<?php
session_start();
require 'db.php';
$message = '';

if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }

$savedUsername = $_COOKIE['remembered_user'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']);

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        if ($remember) {
            setcookie('remembered_user', $username, time() + (30 * 86400), '/');
        } else {
            setcookie('remembered_user', '', time() - 3600, '/');
        }
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "❌ Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; display: flex; justify-content: center; padding: 50px 16px; }
    .card { background: white; padding: 28px; border-radius: 10px; width: 100%; max-width: 420px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h3 { margin-bottom: 16px; color: #333; }
    .alert { padding: 10px; border-radius: 5px; margin-bottom: 14px; font-size: 14px; background: #fee2e2; color: #991b1b; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 12px; }
    input[type="text"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    .check-row { display: flex; align-items: center; gap: 8px; margin-top: 12px; font-size: 14px; }
    button { width: 100%; padding: 10px; margin-top: 16px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    p { margin-top: 14px; text-align: center; font-size: 14px; }
    a { color: #3b82f6; }
  </style>
</head>
<body>
<div class="card">
  <h3>🔐 Login</h3>
  <?php if ($message): ?>
    <div class="alert"><?= $message ?></div>
  <?php endif; ?>
  <form method="POST">
    <label>Username</label>
    <input type="text" name="username" value="<?= htmlspecialchars($savedUsername) ?>" placeholder="Your username" required/>
    <label>Password</label>
    <input type="password" name="password" placeholder="Your password" required/>
    <div class="check-row">
      <input type="checkbox" name="remember" id="remember"/>
      <label for="remember" style="margin:0;font-weight:normal">Remember me (cookie)</label>
    </div>
    <button>Login</button>
  </form>
  <p>No account? <a href="register.php">Register</a></p>
</div>
</body>
</html>
