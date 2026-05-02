<?php
require 'db.php';
$message     = '';
$edit_student = null;

// INSERT
if (isset($_POST['action']) && $_POST['action'] === 'insert') {
    $name   = htmlspecialchars(trim($_POST['name']));
    $email  = htmlspecialchars(trim($_POST['email']));
    $course = htmlspecialchars(trim($_POST['course']));
    if ($name && $email && $course) {
        $stmt = mysqli_prepare($conn, "INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $course);
        mysqli_stmt_execute($stmt);
        $message = "✅ Student added.";
    }
}

// UPDATE
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id     = intval($_POST['id']);
    $name   = htmlspecialchars(trim($_POST['name']));
    $email  = htmlspecialchars(trim($_POST['email']));
    $course = htmlspecialchars(trim($_POST['course']));
    $stmt   = mysqli_prepare($conn, "UPDATE students SET name=?, email=?, course=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $course, $id);
    mysqli_stmt_execute($stmt);
    $message = "✅ Student updated.";
}

// DELETE
if (isset($_GET['delete'])) {
    $id   = intval($_GET['delete']);
    $stmt = mysqli_prepare($conn, "DELETE FROM students WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $message = "🗑️ Student deleted.";
}

// FETCH for edit
if (isset($_GET['edit'])) {
    $id     = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
    $edit_student = mysqli_fetch_assoc($result);
}

$students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Records</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
    .container { max-width: 800px; margin: 0 auto; }
    h3 { color: #333; margin-bottom: 16px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; background: #d1fae5; color: #065f46; }
    .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    .card h5 { margin-bottom: 14px; color: #333; }
    .form-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .form-row .col { flex: 1; min-width: 140px; }
    label { display: block; font-weight: bold; margin-bottom: 4px; font-size: 14px; }
    input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    .btn-row { display: flex; gap: 10px; margin-top: 14px; }
    button { padding: 9px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; color: white; }
    .btn-blue   { background: #3b82f6; }
    .btn-orange { background: #f59e0b; }
    a.cancel    { padding: 9px 16px; background: #e2e8f0; color: #333; border-radius: 4px; text-decoration: none; font-size: 14px; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    th, td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 14px; text-align: left; }
    th { background: #1e293b; color: white; }
    tr:hover td { background: #f9f9f9; }
    a.edit-btn   { color: #3b82f6; margin-right: 10px; font-size: 13px; }
    a.delete-btn { color: #ef4444; font-size: 13px; }
    .empty { color: #888; font-size: 14px; }
  </style>
</head>
<body>
<div class="container">
  <h3>🎓 Student Records</h3>

  <?php if ($message): ?>
    <div class="alert"><?= $message ?></div>
  <?php endif; ?>

  <div class="card">
    <h5><?= $edit_student ? 'Edit Student' : 'Add New Student' ?></h5>
    <form method="POST">
      <input type="hidden" name="action" value="<?= $edit_student ? 'update' : 'insert' ?>"/>
      <?php if ($edit_student): ?>
        <input type="hidden" name="id" value="<?= $edit_student['id'] ?>"/>
      <?php endif; ?>

      <div class="form-row">
        <div class="col">
          <label>Name</label>
          <input type="text" name="name" placeholder="Student name"
            value="<?= $edit_student ? htmlspecialchars($edit_student['name']) : '' ?>" required/>
        </div>
        <div class="col">
          <label>Email</label>
          <input type="email" name="email" placeholder="Email"
            value="<?= $edit_student ? htmlspecialchars($edit_student['email']) : '' ?>" required/>
        </div>
        <div class="col">
          <label>Course</label>
          <input type="text" name="course" placeholder="e.g. B.Tech CSE"
            value="<?= $edit_student ? htmlspecialchars($edit_student['course']) : '' ?>" required/>
        </div>
      </div>

      <div class="btn-row">
        <button type="submit" class="<?= $edit_student ? 'btn-orange' : 'btn-blue' ?>">
          <?= $edit_student ? 'Update Student' : 'Add Student' ?>
        </button>
        <?php if ($edit_student): ?>
          <a href="index.php" class="cancel">Cancel</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <h5 style="margin-bottom:10px;color:#333">All Students</h5>
  <?php if (mysqli_num_rows($students) === 0): ?>
    <p class="empty">No students yet. Add one above.</p>
  <?php else: ?>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Actions</th></tr></thead>
      <tbody>
        <?php while ($s = mysqli_fetch_assoc($students)): ?>
          <tr>
            <td><?= $s['id'] ?></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['course']) ?></td>
            <td>
              <a href="?edit=<?= $s['id'] ?>" class="edit-btn">Edit</a>
              <a href="?delete=<?= $s['id'] ?>" class="delete-btn"
                 onclick="return confirm('Delete this student?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
