<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = htmlspecialchars(trim($_POST['name']));
    $rollno = htmlspecialchars(trim($_POST['rollno']));
    $email  = htmlspecialchars(trim($_POST['email']));

    if ($name && $rollno && $email) {
        $stmt = mysqli_prepare($conn, "INSERT INTO students (name, rollno, email) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $rollno, $email);
        $message = mysqli_stmt_execute($stmt)
            ? "✅ Registered successfully!"
            : "❌ Roll number already registered.";
    }
}

$students = mysqli_query($conn, "SELECT * FROM students ORDER BY rollno");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Registration</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px; }
    .container { max-width: 600px; margin: 0 auto; }
    h3 { margin-bottom: 16px; color: #333; }
    h5 { margin: 16px 0 10px; color: #333; }
    .link { display: inline-block; margin-bottom: 14px; color: #3b82f6; text-decoration: none; font-size: 14px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }
    .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 10px; }
    input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    button { width: 100%; padding: 9px; margin-top: 14px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px 10px; border: 1px solid #ddd; font-size: 14px; text-align: left; }
    th { background: #3b82f6; color: white; }
    tr:hover td { background: #f9f9f9; }
    .empty { color: #888; font-size: 14px; }
  </style>
</head>
<body>
<div class="container">
  <h3>🎓 Student Registration</h3>
  <a class="link" href="teacher.php">→ Teacher Panel</a>

  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>">
      <?= $message ?>
    </div>
  <?php endif; ?>

  <div class="card">
    <h5>Register Yourself</h5>
    <form method="POST">
      <label>Full Name</label>
      <input type="text" name="name" placeholder="Your name" required/>
      <label>Roll Number</label>
      <input type="text" name="rollno" placeholder="e.g. 22CSE001" required/>
      <label>Email</label>
      <input type="email" name="email" placeholder="Your email" required/>
      <button>Register</button>
    </form>
  </div>

  <h5>Registered Students (<?= mysqli_num_rows($students) ?>)</h5>
  <?php if (mysqli_num_rows($students) === 0): ?>
    <p class="empty">No students registered yet.</p>
  <?php else: ?>
    <table>
      <thead><tr><th>Roll No</th><th>Name</th><th>Email</th></tr></thead>
      <tbody>
        <?php while ($s = mysqli_fetch_assoc($students)): ?>
          <tr>
            <td><?= $s['rollno'] ?></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
