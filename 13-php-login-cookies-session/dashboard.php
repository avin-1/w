<?php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('remembered_user', '', time() - 3600, '/');
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; display: flex; justify-content: center; padding: 50px 16px; }
    .card { background: white; padding: 28px; border-radius: 10px; width: 100%; max-width: 500px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h3 { margin-bottom: 16px; color: #333; }
    h5 { margin: 16px 0 8px; color: #555; }
    ul { padding-left: 18px; font-size: 14px; line-height: 1.8; }
    code { background: #f1f5f9; padding: 2px 6px; border-radius: 3px; font-size: 13px; }
    p { font-size: 14px; margin-bottom: 8px; }
    .muted { color: #888; }
    a.btn { display: inline-block; margin-top: 16px; padding: 9px 20px; background: #ef4444; color: white; border-radius: 4px; text-decoration: none; font-size: 14px; }
  </style>
</head>
<body>
<div class="card">
  <h3>👋 Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
  <p>You are logged in successfully.</p>

  <h5>Session Info</h5>
  <ul>
    <li>Session ID: <code><?= session_id() ?></code></li>
    <li>User ID: <strong><?= $_SESSION['user_id'] ?></strong></li>
    <li>Username: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></li>
  </ul>

  <h5>Cookie Info</h5>
  <?php if (isset($_COOKIE['remembered_user'])): ?>
    <p>🍪 Remember-me cookie: <strong><?= htmlspecialchars($_COOKIE['remembered_user']) ?></strong></p>
  <?php else: ?>
    <p class="muted">No remember-me cookie set.</p>
  <?php endif; ?>

  <a href="?logout=1" class="btn">Logout</a>
</div>
</body>
</html>
