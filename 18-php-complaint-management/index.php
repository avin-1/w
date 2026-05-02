<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $org   = htmlspecialchars($_POST['organization']);
    $cat   = htmlspecialchars(trim($_POST['category']));
    $comp  = htmlspecialchars(trim($_POST['complaint']));

    if ($name && $email && $org && $cat && $comp) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "❌ Invalid email format.";
        } else {
            $stmt = mysqli_prepare($conn,
                "INSERT INTO complaints (name, email, organization, category, complaint) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $org, $cat, $comp);
            mysqli_stmt_execute($stmt);
            $message = "✅ Complaint submitted successfully! We will get back to you at $email.";
        }
    } else {
        $message = "❌ All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Complaint Management</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
    .container { max-width: 620px; margin: 0 auto; }
    h3 { color: #333; margin-bottom: 6px; }
    .tagline { color: #888; font-size: 14px; margin-bottom: 20px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }
    .card { background: white; padding: 24px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    .card h5 { margin-bottom: 16px; color: #333; }
    label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 12px; }
    input[type="text"], input[type="email"], select, textarea {
      width: 100%; padding: 8px; border: 1px solid #ccc;
      border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif;
    }
    .row { display: flex; gap: 12px; }
    .row .col { flex: 1; }
    button { width: 100%; padding: 10px; margin-top: 16px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    button:hover { background: #2563eb; }
    p.admin-link { margin-top: 14px; text-align: center; font-size: 14px; }
    a { color: #3b82f6; }
  </style>
</head>
<body>
<div class="container">
  <h3>📢 Complaint Management System</h3>
  <p class="tagline">Submit complaints about services from PMC, PMT, VIT or other organizations.</p>

  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>"><?= $message ?></div>
  <?php endif; ?>

  <div class="card">
    <h5>Submit a Complaint</h5>
    <form method="POST">
      <div class="row">
        <div class="col">
          <label>Your Name</label>
          <input type="text" name="name" placeholder="Full name" required/>
        </div>
        <div class="col">
          <label>Email</label>
          <input type="email" name="email" placeholder="Your email" required/>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>Organization</label>
          <select name="organization" required>
            <option value="">-- Select --</option>
            <option value="PMC">PMC (Pune Municipal Corporation)</option>
            <option value="PMT">PMT (Pune Mahanagar Transport)</option>
            <option value="VIT">VIT University</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="col">
          <label>Category</label>
          <input type="text" name="category" placeholder="e.g. Road, Water, Bus"/>
        </div>
      </div>

      <label>Complaint Details</label>
      <textarea name="complaint" rows="4" placeholder="Describe your complaint in detail..." required></textarea>

      <button>Submit Complaint</button>
    </form>
  </div>

  <p class="admin-link"><a href="admin.php">Admin Panel →</a></p>
</div>
</body>
</html>
