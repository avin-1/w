<?php
session_start();

// Get form data (works for both GET and POST)
$name     = isset($_REQUEST['name'])     ? htmlspecialchars(trim($_REQUEST['name']))     : '';
$email    = isset($_REQUEST['email'])    ? htmlspecialchars(trim($_REQUEST['email']))    : '';
$password = isset($_REQUEST['password']) ? trim($_REQUEST['password'])                   : '';
$method   = $_SERVER['REQUEST_METHOD'];

$errors = [];

// Server-side validation
if (empty($name)) {
    $errors[] = "Name is required.";
}

// Validate email format
if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (empty($password)) {
    $errors[] = "Password is required.";
} elseif (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters.";
}

if (!empty($errors)) {
    // Show errors
    echo "<h3>Validation Errors:</h3><ul>";
    foreach ($errors as $err) {
        echo "<li style='color:red;'>$err</li>";
    }
    echo "</ul>";
    echo "<a href='index.html'>Go Back</a>";
    exit;
}

// Set cookie to store username (expires in 1 day)
setcookie("username", $name, time() + 86400, "/");

// Store in session
$_SESSION['user_name']  = $name;
$_SESSION['user_email'] = $email;
$_SESSION['logged_in']  = true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Form Processed</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 30px; }
    .box {
      max-width: 500px; margin: 0 auto;
      background: white; padding: 25px;
      border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 { color: #27ae60; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    td { padding: 8px 12px; border: 1px solid #ddd; }
    td:first-child { font-weight: bold; background: #f8f9fa; width: 40%; }
    .badge {
      display: inline-block; padding: 3px 10px;
      background: #3498db; color: white;
      border-radius: 12px; font-size: 13px;
    }
    a { display: inline-block; margin-top: 15px; color: #3498db; }
  </style>
</head>
<body>
<div class="box">
  <h2>✅ Form Submitted Successfully!</h2>

  <table>
    <tr><td>Method Used</td><td><span class="badge"><?php echo $method; ?></span></td></tr>
    <tr><td>Name</td><td><?php echo $name; ?></td></tr>
    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
    <tr><td>Password</td><td><?php echo str_repeat('*', strlen($password)); ?></td></tr>
  </table>

  <h3 style="margin-top:20px;">🍪 Cookie Info</h3>
  <p>Cookie <strong>'username'</strong> set to: <strong><?php echo $name; ?></strong> (expires in 1 day)</p>

  <?php if (isset($_COOKIE['username'])): ?>
    <p>Cookie already exists from previous visit: <strong><?php echo htmlspecialchars($_COOKIE['username']); ?></strong></p>
  <?php endif; ?>

  <h3>🔐 Session Info</h3>
  <p>Session ID: <code><?php echo session_id(); ?></code></p>
  <p>Logged in as: <strong><?php echo $_SESSION['user_name']; ?></strong></p>

  <a href="session_demo.php">→ Go to Session Login Demo</a><br/>
  <a href="index.html">← Back to Form</a>
</div>
</body>
</html>
