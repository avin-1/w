<?php
session_start();
require 'db.php';

$ADMIN_USER = 'admin';
$ADMIN_PASS = 'admin123';
$message    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    if ($_POST['username'] === $ADMIN_USER && $_POST['password'] === $ADMIN_PASS) {
        $_SESSION['admin'] = true;
    } else {
        $message = "❌ Invalid admin credentials.";
    }
}

if (isset($_GET['resolve'])) {
    $id   = intval($_GET['resolve']);
    $stmt = mysqli_prepare($conn, "UPDATE complaints SET status='Resolved' WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header('Location: admin.php');
    exit;
}

if (isset($_GET['logout'])) { session_destroy(); header('Location: admin.php'); exit; }

$complaints = mysqli_query($conn,
    "SELECT c.*, s.name AS student_name FROM complaints c
     JOIN students s ON c.student_id = s.id ORDER BY c.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
    .container { max-width: 860px; margin: 0 auto; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    h3, h4 { color: #333; }
    a.logout { color: #ef4444; font-size: 14px; text-decoration: none; }
    .card { background: white; padding: 24px; border-radius: 8px; max-width: 400px; margin: 0 auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .alert { padding: 10px; border-radius: 5px; margin-bottom: 14px; background: #fee2e2; color: #991b1b; font-size: 14px; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 12px; }
    input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    button { width: 100%; padding: 9px; margin-top: 14px; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
    small { display: block; color: #888; font-size: 12px; margin-top: 8px; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    th, td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 14px; text-align: left; }
    th { background: #1e293b; color: white; }
    .badge { font-size: 12px; padding: 2px 8px; border-radius: 10px; }
    .badge-pending  { background: #fef9c3; color: #854d0e; }
    .badge-resolved { background: #d1fae5; color: #065f46; }
    a.resolve-btn { color: white; background: #22c55e; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 13px; }
    .muted { color: #888; font-size: 13px; }
    .empty { color: #888; font-size: 14px; margin-top: 10px; }
  </style>
</head>
<body>
<div class="container">

  <?php if (!isset($_SESSION['admin'])): ?>
    <div class="card">
      <h4>🔐 Admin Login</h4>
      <?php if ($message): ?><div class="alert"><?= $message ?></div><?php endif; ?>
      <form method="POST">
        <input type="hidden" name="admin_login" value="1"/>
        <label>Username</label>
        <input type="text" name="username" placeholder="Admin username" required/>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required/>
        <button>Login as Admin</button>
      </form>
      <small>Credentials: admin / admin123</small>
    </div>

  <?php else: ?>
    <div class="top-bar">
      <h3>🛠️ Admin — All Complaints</h3>
      <a href="?logout=1" class="logout">Logout</a>
    </div>

    <?php if (mysqli_num_rows($complaints) === 0): ?>
      <p class="empty">No complaints submitted yet.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr><th>#</th><th>Student</th><th>Title</th><th>Description</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
          <?php while ($c = mysqli_fetch_assoc($complaints)): ?>
            <tr>
              <td><?= $c['id'] ?></td>
              <td><?= htmlspecialchars($c['student_name']) ?></td>
              <td><?= htmlspecialchars($c['title']) ?></td>
              <td><?= htmlspecialchars($c['description']) ?></td>
              <td>
                <span class="badge <?= $c['status']==='Resolved' ? 'badge-resolved' : 'badge-pending' ?>">
                  <?= $c['status'] ?>
                </span>
              </td>
              <td>
                <?php if ($c['status'] === 'Pending'): ?>
                  <a href="?resolve=<?= $c['id'] ?>" class="resolve-btn">Mark Resolved</a>
                <?php else: ?>
                  <span class="muted">Done</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
