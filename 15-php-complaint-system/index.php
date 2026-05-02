<?php
session_start();
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') {
        $name     = htmlspecialchars(trim($_POST['name']));
        $email    = htmlspecialchars(trim($_POST['email']));
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);
        $message = mysqli_stmt_execute($stmt) ? "✅ Registered! Please login." : "❌ Email already registered.";
    }

    if ($action === 'login') {
        $email    = htmlspecialchars(trim($_POST['email']));
        $password = trim($_POST['password']);
        $stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['student_id']   = $user['id'];
            $_SESSION['student_name'] = $user['name'];
            header('Location: complaint.php');
            exit;
        } else {
            $message = "❌ Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Login</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 30px 16px; }
    .container { max-width: 480px; margin: 0 auto; }
    h3 { text-align: center; margin-bottom: 20px; color: #333; }
    .alert { padding: 10px; border-radius: 5px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }
    .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .card h5 { margin-bottom: 12px; color: #333; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 10px; }
    input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    button { width: 100%; padding: 9px; margin-top: 14px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 14px; }
    .btn-blue  { background: #3b82f6; }
    .btn-green { background: #22c55e; }
    p { text-align: center; margin-top: 12px; font-size: 14px; }
    a { color: #3b82f6; }
  </style>
</head>
<body>
<div class="container">
  <h3>🎓 Student Complaint Portal</h3>

  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>"><?= $message ?></div>
  <?php endif; ?>

  <div class="card">
    <h5>Login</h5>
    <form method="POST">
      <input type="hidden" name="action" value="login"/>
      <label>Email</label>
      <input type="email" name="email" placeholder="Your email" required/>
      <label>Password</label>
      <input type="password" name="password" placeholder="Your password" required/>
      <button class="btn-blue">Login</button>
    </form>
  </div>

  <div class="card">
    <h5>Register</h5>
    <form method="POST">
      <input type="hidden" name="action" value="register"/>
      <label>Full Name</label>
      <input type="text" name="name" placeholder="Your name" required/>
      <label>Email</label>
      <input type="email" name="email" placeholder="Your email" required/>
      <label>Password</label>
      <input type="password" name="password" placeholder="Your password" required/>
      <button class="btn-green">Register</button>
    </form>
  </div>

  <p><a href="admin.php">Admin Login →</a></p>
</div>
</body>
</html>
