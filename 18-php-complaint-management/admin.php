<?php
require 'db.php';

// Update status
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id     = intval($_GET['id']);
    $status = in_array($_GET['status'], ['In Progress','Resolved','Pending']) ? $_GET['status'] : 'Pending';
    $stmt   = mysqli_prepare($conn, "UPDATE complaints SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    mysqli_stmt_execute($stmt);
    header('Location: admin.php');
    exit;
}

$filter   = $_GET['org'] ?? '';
$query    = $filter
    ? "SELECT * FROM complaints WHERE organization='$filter' ORDER BY submitted_at DESC"
    : "SELECT * FROM complaints ORDER BY submitted_at DESC";
$complaints = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — Complaints</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
    .container { max-width: 960px; margin: 0 auto; }
    .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    h3 { color: #333; }
    .filter-row { display: flex; gap: 8px; align-items: center; font-size: 14px; }
    .filter-row a { padding: 5px 12px; border-radius: 4px; text-decoration: none; background: #e2e8f0; color: #333; }
    .filter-row a.active { background: #3b82f6; color: white; }
    a.back { color: #3b82f6; font-size: 14px; text-decoration: none; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    th, td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 13px; text-align: left; vertical-align: top; }
    th { background: #1e293b; color: white; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    .pending     { background: #fef9c3; color: #854d0e; }
    .in-progress { background: #dbeafe; color: #1e40af; }
    .resolved    { background: #d1fae5; color: #065f46; }
    .action a { display: inline-block; margin-right: 6px; color: #3b82f6; font-size: 13px; }
    .empty { color: #888; font-size: 14px; margin-top: 10px; }
  </style>
</head>
<body>
<div class="container">
  <div class="top">
    <h3>🛠️ Admin — All Complaints</h3>
    <a class="back" href="index.php">← Submit Complaint</a>
  </div>

  <div class="filter-row" style="margin-bottom:14px">
    <span>Filter:</span>
    <a href="admin.php" class="<?= !$filter ? 'active' : '' ?>">All</a>
    <a href="?org=PMC"   class="<?= $filter==='PMC'   ? 'active' : '' ?>">PMC</a>
    <a href="?org=PMT"   class="<?= $filter==='PMT'   ? 'active' : '' ?>">PMT</a>
    <a href="?org=VIT"   class="<?= $filter==='VIT'   ? 'active' : '' ?>">VIT</a>
    <a href="?org=Other" class="<?= $filter==='Other' ? 'active' : '' ?>">Other</a>
  </div>

  <?php if (mysqli_num_rows($complaints) === 0): ?>
    <p class="empty">No complaints found.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>#</th><th>Name</th><th>Org</th><th>Category</th><th>Complaint</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while ($c = mysqli_fetch_assoc($complaints)):
          $badgeClass = match($c['status']) {
            'In Progress' => 'in-progress',
            'Resolved'    => 'resolved',
            default       => 'pending'
          };
        ?>
          <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?><br/><small style="color:#888"><?= $c['email'] ?></small></td>
            <td><?= $c['organization'] ?></td>
            <td><?= htmlspecialchars($c['category']) ?></td>
            <td><?= htmlspecialchars($c['complaint']) ?></td>
            <td><span class="badge <?= $badgeClass ?>"><?= $c['status'] ?></span></td>
            <td class="action">
              <?php if ($c['status'] === 'Pending'): ?>
                <a href="?id=<?= $c['id'] ?>&status=In+Progress">In Progress</a>
              <?php endif; ?>
              <?php if ($c['status'] !== 'Resolved'): ?>
                <a href="?id=<?= $c['id'] ?>&status=Resolved">Resolve</a>
              <?php else: ?>
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
