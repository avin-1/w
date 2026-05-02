<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type     = htmlspecialchars($_POST['waste_type']);
    $location = htmlspecialchars(trim($_POST['location']));
    $desc     = htmlspecialchars(trim($_POST['description']));

    if ($type && $location) {
        $stmt = mysqli_prepare($conn, "INSERT INTO waste_reports (waste_type, location, description) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $type, $location, $desc);
        mysqli_stmt_execute($stmt);
        $message = "✅ Waste report submitted! Concerned authority has been notified.";
    } else {
        $message = "❌ Waste type and location are required.";
    }
}

$reports = mysqli_query($conn, "SELECT * FROM waste_reports ORDER BY reported_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Waste Collection System</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0fdf4; padding: 24px 16px; }
    .container { max-width: 700px; margin: 0 auto; }
    h3 { color: #166534; margin-bottom: 6px; }
    .tagline { color: #888; font-size: 14px; margin-bottom: 20px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }
    .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    .card h5 { margin-bottom: 14px; color: #333; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 12px; }
    select, input[type="text"], textarea {
      width: 100%; padding: 8px; border: 1px solid #ccc;
      border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif;
    }
    button { width: 100%; padding: 10px; margin-top: 14px; background: #16a34a; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
    button:hover { background: #15803d; }
    h5.list-title { margin-bottom: 10px; color: #333; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    th, td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 13px; text-align: left; }
    th { background: #166534; color: white; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    .pending   { background: #fef9c3; color: #854d0e; }
    .assigned  { background: #dbeafe; color: #1e40af; }
    .collected { background: #d1fae5; color: #065f46; }
    .empty { color: #888; font-size: 14px; }
    a { color: #16a34a; font-size: 14px; }
  </style>
</head>
<body>
<div class="container">
  <h3>♻️ Waste Collection System</h3>
  <p class="tagline">Report waste location — concerned authority will be directed to collect it.</p>

  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>"><?= $message ?></div>
  <?php endif; ?>

  <div class="card">
    <h5>Report Waste</h5>
    <form method="POST">
      <label>Waste Type</label>
      <select name="waste_type" required>
        <option value="">-- Select Type --</option>
        <option value="Plastic">🧴 Plastic</option>
        <option value="Paper">📄 Paper</option>
        <option value="Metal">🔩 Metal</option>
        <option value="Other">🗑️ Other</option>
      </select>

      <label>Location</label>
      <input type="text" name="location" placeholder="e.g. Near VIT Gate 2, Pune" required/>

      <label>Description (optional)</label>
      <textarea name="description" rows="2" placeholder="Any additional details..."></textarea>

      <button>Submit Report</button>
    </form>
  </div>

  <h5 class="list-title">All Reports (<?= mysqli_num_rows($reports) ?>)
    &nbsp;<a href="authority.php">→ Authority Panel</a>
  </h5>

  <?php if (mysqli_num_rows($reports) === 0): ?>
    <p class="empty">No reports yet.</p>
  <?php else: ?>
    <table>
      <thead><tr><th>#</th><th>Type</th><th>Location</th><th>Status</th><th>Reported At</th></tr></thead>
      <tbody>
        <?php while ($r = mysqli_fetch_assoc($reports)): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['waste_type'] ?></td>
            <td><?= htmlspecialchars($r['location']) ?></td>
            <td><span class="badge <?= strtolower($r['status']) ?>"><?= $r['status'] ?></span></td>
            <td><?= date('d M, H:i', strtotime($r['reported_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
