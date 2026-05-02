<?php
ini_set('session.gc_maxlifetime', 300);
session_set_cookie_params(300);
session_start();

define('MAX_SESSIONS', 3);
define('SESSION_FILE', __DIR__ . '/active_sessions.json');

function loadSessions() {
    if (!file_exists(SESSION_FILE)) return [];
    return json_decode(file_get_contents(SESSION_FILE), true) ?? [];
}
function saveSessions($sessions) {
    file_put_contents(SESSION_FILE, json_encode($sessions));
}
function cleanExpired($sessions) {
    return array_filter($sessions, fn($s) => (time() - $s['last_active']) < 300);
}

$message = '';
$action  = $_POST['action'] ?? '';

if ($action === 'login') {
    $username = trim($_POST['username']);
    $sessions = cleanExpired(loadSessions());
    $userSessions = array_filter($sessions, fn($s) => $s['username'] === $username);

    if (count($userSessions) >= MAX_SESSIONS) {
        $message = "❌ Max session limit (3) reached for '$username'.";
    } else {
        $sessions[session_id()] = ['username' => $username, 'last_active' => time()];
        saveSessions($sessions);
        $_SESSION['username']   = $username;
        $_SESSION['login_time'] = time();
        $message = "✅ Logged in as '$username'.";
    }
}

if ($action === 'logout') {
    $sessions = loadSessions();
    unset($sessions[session_id()]);
    saveSessions($sessions);
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['username'])) {
    $sessions = loadSessions();
    if (isset($sessions[session_id()])) {
        $sessions[session_id()]['last_active'] = time();
        saveSessions($sessions);
    }
}

$allSessions = cleanExpired(loadSessions());
saveSessions($allSessions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Session Limit Demo</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 30px; }
    .container { max-width: 600px; margin: 0 auto; }
    h3 { margin-bottom: 16px; color: #333; }
    .info { background: #dbeafe; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px; font-size: 14px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }
    .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .card h5 { margin-bottom: 12px; }
    label { display: block; font-weight: bold; margin-bottom: 6px; }
    input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 12px; }
    button { width: 100%; padding: 9px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 14px; }
    .btn-primary { background: #3b82f6; }
    .btn-danger  { background: #ef4444; }
    p { margin: 6px 0; font-size: 14px; }
    code { background: #f1f5f9; padding: 2px 6px; border-radius: 3px; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    th, td { padding: 8px 10px; border: 1px solid #ddd; font-size: 13px; text-align: left; }
    th { background: #e2e8f0; }
    .highlight td { background: #d1fae5; }
    .hint { color: #888; font-size: 12px; margin-top: 8px; }
  </style>
</head>
<body>
<div class="container">
  <h3>🔐 Session Limit Demo</h3>
  <div class="info">
    Max concurrent sessions per user: <strong><?= MAX_SESSIONS ?></strong> &nbsp;|&nbsp;
    Session timeout: <strong>5 minutes</strong>
  </div>

  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>">
      <?= $message ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['username'])): ?>
    <div class="card">
      <p>Logged in as: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
      <p>Session started: <strong><?= date('H:i:s', $_SESSION['login_time']) ?></strong></p>
      <p>Session ID: <code><?= session_id() ?></code></p>
      <form method="POST" style="margin-top:12px">
        <input type="hidden" name="action" value="logout"/>
        <button class="btn-danger">Logout</button>
      </form>
    </div>
  <?php else: ?>
    <div class="card">
      <h5>Login</h5>
      <form method="POST">
        <input type="hidden" name="action" value="login"/>
        <label>Username</label>
        <input type="text" name="username" placeholder="e.g. alice" required/>
        <button class="btn-primary">Login</button>
      </form>
      <p class="hint">Open 3 tabs with same username — 4th will be blocked.</p>
    </div>
  <?php endif; ?>

  <h5 style="margin-bottom:8px">Active Sessions (<?= count($allSessions) ?>)</h5>
  <?php if (empty($allSessions)): ?>
    <p style="color:#888">No active sessions.</p>
  <?php else: ?>
    <table>
      <thead><tr><th>Session ID</th><th>Username</th><th>Last Active</th></tr></thead>
      <tbody>
        <?php foreach ($allSessions as $sid => $s): ?>
          <tr <?= $sid === session_id() ? 'class="highlight"' : '' ?>>
            <td><code><?= substr($sid, 0, 12) ?>...</code></td>
            <td><?= htmlspecialchars($s['username']) ?></td>
            <td><?= date('H:i:s', $s['last_active']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
