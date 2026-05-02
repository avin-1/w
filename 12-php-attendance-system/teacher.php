<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
    $date = htmlspecialchars($_POST['date']);
    $stmt = mysqli_prepare($conn, "DELETE FROM attendance WHERE date = ?");
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);

    $students = mysqli_query($conn, "SELECT id FROM students");
    while ($s = mysqli_fetch_assoc($students)) {
        $sid    = $s['id'];
        $status = isset($_POST['attendance'][$sid]) ? 'Present' : 'Absent';
        $stmt2  = mysqli_prepare($conn, "INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt2, "iss", $sid, $date, $status);
        mysqli_stmt_execute($stmt2);
    }
    $message = "✅ Attendance saved for $date";
}

$students  = mysqli_query($conn, "SELECT * FROM students ORDER BY rollno");
$today     = date('Y-m-d');
$viewDate  = $_GET['date'] ?? $today;
$attendanceMap = [];
$res = mysqli_query($conn, "SELECT student_id, status FROM attendance WHERE date='$viewDate'");
while ($row = mysqli_fetch_assoc($res)) {
    $attendanceMap[$row['student_id']] = $row['status'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Teacher — Attendance</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px; }
    .container { max-width: 700px; margin: 0 auto; }
    h3 { margin-bottom: 14px; color: #333; }
    h5 { margin: 16px 0 10px; color: #333; }
    a { color: #3b82f6; text-decoration: none; font-size: 14px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; background: #d1fae5; color: #065f46; font-size: 14px; }
    .warn  { background: #fef9c3; color: #854d0e; padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    .date-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
    .date-row label { font-weight: bold; }
    input[type="date"] { padding: 7px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1); margin-bottom: 16px; }
    th, td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 14px; text-align: left; }
    th { background: #1e293b; color: white; }
    td.center { text-align: center; }
    button { padding: 9px 20px; background: #22c55e; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
    .view-form { display: flex; gap: 10px; margin-bottom: 12px; }
    .view-form button { background: #3b82f6; }
    .present { color: green; font-weight: bold; }
    .absent  { color: red; font-weight: bold; }
    .empty { color: #888; font-size: 14px; }
    hr { border: none; border-top: 1px solid #ddd; margin: 20px 0; }
  </style>
</head>
<body>
<div class="container">
  <h3>📋 Teacher Panel — Take Attendance</h3>
  <a href="index.php">← Student Registration</a>

  <?php if ($message): ?>
    <div class="alert" style="margin-top:12px"><?= $message ?></div>
  <?php endif; ?>

  <?php if (mysqli_num_rows($students) === 0): ?>
    <div class="warn" style="margin-top:12px">No students registered yet.</div>
  <?php else: ?>
    <form method="POST" style="margin-top:14px">
      <div class="date-row">
        <label>Date:</label>
        <input type="date" name="date" value="<?= $today ?>" required/>
      </div>
      <table>
        <thead><tr><th>Roll No</th><th>Name</th><th class="center">Present</th></tr></thead>
        <tbody>
          <?php
          mysqli_data_seek($students, 0);
          while ($s = mysqli_fetch_assoc($students)):
            $checked = isset($attendanceMap[$s['id']]) && $attendanceMap[$s['id']] === 'Present';
          ?>
            <tr>
              <td><?= $s['rollno'] ?></td>
              <td><?= htmlspecialchars($s['name']) ?></td>
              <td class="center">
                <input type="checkbox" name="attendance[<?= $s['id'] ?>]" <?= $checked ? 'checked' : '' ?>/>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <button type="submit">Save Attendance</button>
    </form>

    <hr/>
    <h5>View Attendance Report</h5>
    <form method="GET" class="view-form">
      <input type="date" name="date" value="<?= $viewDate ?>"/>
      <button type="submit">View</button>
    </form>

    <?php if (!empty($attendanceMap)): ?>
      <table>
        <thead><tr><th>Roll No</th><th>Name</th><th>Status</th></tr></thead>
        <tbody>
          <?php
          mysqli_data_seek($students, 0);
          while ($s = mysqli_fetch_assoc($students)):
            $status = $attendanceMap[$s['id']] ?? 'Absent';
          ?>
            <tr>
              <td><?= $s['rollno'] ?></td>
              <td><?= htmlspecialchars($s['name']) ?></td>
              <td class="<?= $status === 'Present' ? 'present' : 'absent' ?>"><?= $status ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="empty">No attendance recorded for <?= $viewDate ?>.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
