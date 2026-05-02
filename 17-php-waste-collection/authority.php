<?php
require 'db.php';

// Update status
if (isset($_GET['update']) && isset($_GET['status'])) {
    $id     = intval($_GET['update']);
    $status = in_array($_GET['status'], ['Assigned','Collected']) ? $_GET['status'] : 'Pending';
    $stmt   = mysqli_prepare($conn, "UPDATE waste_reports SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    mysqli_stmt_execute($stmt);
    header('Location: authority.php');
    exit;
}

$reports = mysqli_query($conn, "SELECT * FROM waste_reports ORDER BY reported_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Authority Panel</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0fdf4; padding: 24px 16px; }
    .container { max-width: 860px; margin: 0 auto; }
    .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    h3 { color: #166534; }
    a { color: #16a34a; font-size: 14px; text-decoration: none; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    th, td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 13px; text-align: left; }
    th { background: #166534; color: white; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    .pending   { background: #fef9c3; color: #854d0e; }
    .assigned  { background: #dbeafe; color: #1e40af; }
    .collected { background: #d1fae5; color: #065f46; }
    .action-links a { margin-right: 8px; }
    .empty { color: #888; font-size: 14px; }
  </style>
</head>
<body>
<div class="container">
  <div class="top">
    <h3>🏛️ Authority Panel — Waste Reports</h3>
    <a href="index.php">← Back</a>
  </div>

  <?php if (mysqli_num_rows($reports) === 0): ?>
    <p class="empty">No reports submitted yet.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>#</th><th>Type</th><th>Location</th><th>Description</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while ($r = mysqli_fetch_assoc($reports)): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['waste_type'] ?></td>
            <td><?= htmlspecialchars($r['location']) ?></td>
            <td><?= htmlspecialchars($r['description'] ?: '—') ?></td>
            <td><span class="badge <?= strtolower($r['status']) ?>"><?= $r['status'] ?></span></td>
            <td class="action-links">
              <?php if ($r['status'] === 'Pending'): ?>
                <a href="?update=<?= $r['id'] ?>&status=Assigned">Assign</a>
              <?php endif; ?>
              <?php if ($r['status'] === 'Assigned'): ?>
                <a href="?update=<?= $r['id'] ?>&status=Collected">Mark Collected</a>
              <?php endif; ?>
              <?php if ($r['status'] === 'Collected'): ?>
                <span style="color:#888">Done</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
