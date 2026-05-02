<?php
require 'db.php';

$message = "";
$edit_student = null;

// INSERT
if (isset($_POST['action']) && $_POST['action'] === 'insert') {
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    if (!empty($name) && !empty($email)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO students (name, email) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);
        mysqli_stmt_execute($stmt);
        $message = "✅ Student added successfully!";
    } else {
        $message = "❌ Name and Email are required.";
    }
}

// UPDATE
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id    = intval($_POST['id']);
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    $stmt = mysqli_prepare($conn, "UPDATE students SET name=?, email=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $id);
    mysqli_stmt_execute($stmt);
    $message = "✅ Student updated successfully!";
}

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = mysqli_prepare($conn, "DELETE FROM students WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $message = "🗑️ Student deleted.";
}

// FETCH for edit
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
    $edit_student = mysqli_fetch_assoc($result);
}

// FETCH all students
$students = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student DB - CRUD</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px; }
    h2 { color: #333; }
    .container { max-width: 800px; margin: 0 auto; }
    .form-box {
      background: white; padding: 20px;
      border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    input[type="text"], input[type="email"] {
      padding: 8px; margin: 5px 0 10px 0;
      border: 1px solid #ccc; border-radius: 4px;
      width: 100%; box-sizing: border-box;
    }
    label { font-weight: bold; display: block; margin-top: 8px; }
    .btn {
      padding: 8px 16px; border: none;
      border-radius: 4px; cursor: pointer; color: white;
    }
    .btn-blue   { background: #3498db; }
    .btn-green  { background: #2ecc71; }
    .btn-red    { background: #e74c3c; }
    .btn-orange { background: #e67e22; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
    th { background: #3498db; color: white; padding: 10px; text-align: left; }
    td { padding: 10px; border-bottom: 1px solid #eee; }
    tr:hover { background: #f9f9f9; }
    .message { padding: 10px; border-radius: 5px; background: #d4edda; color: #155724; margin-bottom: 15px; }
    a { color: #3498db; text-decoration: none; }
  </style>
</head>
<body>
<div class="container">
  <h2>📚 Student Database — CRUD Operations</h2>

  <?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
  <?php endif; ?>

  <!-- Add / Edit Form -->
  <div class="form-box">
    <h3><?php echo $edit_student ? 'Edit Student' : 'Add New Student'; ?></h3>
    <form method="POST">
      <input type="hidden" name="action" value="<?php echo $edit_student ? 'update' : 'insert'; ?>"/>
      <?php if ($edit_student): ?>
        <input type="hidden" name="id" value="<?php echo $edit_student['id']; ?>"/>
      <?php endif; ?>

      <label>Name:</label>
      <input type="text" name="name" placeholder="Student name"
             value="<?php echo $edit_student ? htmlspecialchars($edit_student['name']) : ''; ?>" required/>

      <label>Email:</label>
      <input type="email" name="email" placeholder="Student email"
             value="<?php echo $edit_student ? htmlspecialchars($edit_student['email']) : ''; ?>" required/>

      <button type="submit" class="btn <?php echo $edit_student ? 'btn-orange' : 'btn-blue'; ?>">
        <?php echo $edit_student ? 'Update Student' : 'Add Student'; ?>
      </button>

      <?php if ($edit_student): ?>
        <a href="index.php" style="margin-left:10px;">Cancel</a>
      <?php endif; ?>
    </form>
  </div>

  <!-- Students Table -->
  <h3>All Students</h3>
  <?php if (mysqli_num_rows($students) === 0): ?>
    <p>No students found. Add one above!</p>
  <?php else: ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($students)): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td>
            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-green" style="padding:5px 10px; border-radius:4px; color:white;">Edit</a>
            &nbsp;
            <a href="?delete=<?php echo $row['id']; ?>"
               class="btn btn-red" style="padding:5px 10px; border-radius:4px; color:white;"
               onclick="return confirm('Delete this student?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>

</div>
</body>
</html>
