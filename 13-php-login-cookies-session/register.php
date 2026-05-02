<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = htmlspecialchars(trim($_POST['name']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    if (!$name || !$email || !$password) {
        $message = "❌ All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email format.";
    } elseif (strlen($password) < 6) {
        $message = "❌ Password must be at least 6 characters.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt   = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed);
        $message = mysqli_stmt_execute($stmt)
            ? "✅ Registered! <a href='login.php'>Login here</a>"
            : "❌ Username or email already exists.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; display: flex; justify-content: center; padding: 50px 16px; }
    .card { background: white; padding: 28px; border-radius: 10px; width: 100%; max-width: 420px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h3 { margin-bottom: 16px; color: #333; }
    .alert { padding: 10px; border-radius: 5px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 12px; }
    input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    button { width: 100%; padding: 10px; margin-top: 16px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    p { margin-top: 14px; text-align: center; font-size: 14px; }
    a { color: #3b82f6; }
  </style>
</head>
<body>
<div class="card">
  <h3>📝 Register</h3>
  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>"><?= $message ?></div>
  <?php endif; ?>
  <form method="POST">
    <label>Username</label>
    <input type="text" name="name" placeholder="Choose a username" required/>
    <label>Email</label>
    <input type="email" name="email" placeholder="Your email" required/>
    <label>Password</label>
    <input type="password" name="password" placeholder="Min 6 characters" required/>
    <button>Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
