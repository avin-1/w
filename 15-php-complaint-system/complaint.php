<?php
session_start();
require 'db.php';

if (!isset($_SESSION['student_id'])) { header('Location: index.php'); exit; }

$sid     = $_SESSION['student_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $desc  = htmlspecialchars(trim($_POST['description']));
    if ($title && $desc) {
        $stmt = mysqli_prepare($conn, "INSERT INTO complaints (student_id, title, description) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iss", $sid, $title, $desc);
        mysqli_stmt_execute($stmt);
        $message = "✅ Complaint submitted successfully.";
    }
}

if (isset($_GET['logout'])) { session_destroy(); header('Location: index.php'); exit; }

$complaints = mysqli_query($conn, "SELECT * FROM complaints WHERE student_id=$sid ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Complaints</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
    .container { max-width: 700px; margin: 0 auto; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    h3 { color: #333; }
    .top-bar span { font-size: 14px; color: #555; }
    a.logout { color: #ef4444; font-size: 14px; text-decoration: none; }
    .alert { padding: 10px; border-radius: 5px; margin-bottom: 14px; background: #d1fae5; color: #065f46; font-size: 14px; }
    .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .card h5 { margin-bottom: 12px; color: #333; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 10px; }
    input[type="text"], textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
    button { padding: 9px 20px; margin-top: 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
    h5.list-title { margin-bottom: 10px; color: #333; }
    .complaint-item { background: white; border-left: 4px solid #f59e0b; border-radius: 4px; padding: 12px 14px; margin-bottom: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); }
    .complaint-item.resolved { border-color: #22c55e; }
    .item-top { display: flex; justify-content: space-between; margin-bottom: 4px; }
    .badge { font-size: 12px; padding: 2px 8px; border-radius: 10px; }
    .badge-pending  { background: #fef9c3; color: #854d0e; }
    .badge-resolved { background: #d1fae5; color: #065f46; }
    .item-desc { font-size: 14px; margin: 4px 0; }
    .item-date { font-size: 12px; color: #888; }
    .empty { color: #888; font-size: 14px; }
  </style>
</head>
<body>
<div class="container">
  <div class="top-bar">
    <h3>📋 My Complaints</h3>
    <div>
      <span>👤 <?= htmlspecialchars($_SESSION['student_name']) ?> &nbsp;</span>
      <a href="?logout=1" class="logout">Logout</a>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert"><?= $message ?></div>
  <?php endif; ?>

  <div class="card">
    <h5>Submit New Complaint</h5>
    <form method="POST">
      <label>Title</label>
      <input type="text" name="title" placeholder="Complaint title" required/>
      <label>Description</label>
      <textarea name="description" rows="3" placeholder="Describe your complaint..." required></textarea>
      <button>Submit Complaint</button>
    </form>
  </div>

  <h5 class="list-title">My Submitted Complaints</h5>
  <?php if (mysqli_num_rows($complaints) === 0): ?>
    <p class="empty">No complaints submitted yet.</p>
  <?php else: ?>
    <?php while ($c = mysqli_fetch_assoc($complaints)): ?>
      <div class="complaint-item <?= $c['status'] === 'Resolved' ? 'resolved' : '' ?>">
        <div class="item-top">
          <strong><?= htmlspecialchars($c['title']) ?></strong>
          <span class="badge <?= $c['status'] === 'Resolved' ? 'badge-resolved' : 'badge-pending' ?>">
            <?= $c['status'] ?>
          </span>
        </div>
        <p class="item-desc"><?= htmlspecialchars($c['description']) ?></p>
        <span class="item-date"><?= $c['created_at'] ?></span>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>
</body>
</html>
