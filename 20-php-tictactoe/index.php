<?php
session_start();

// Initialize game state
if (!isset($_SESSION['board']) || isset($_GET['reset'])) {
    $_SESSION['board']  = array_fill(0, 9, '');
    $_SESSION['turn']   = 'X';
    $_SESSION['winner'] = null;
    $_SESSION['draw']   = false;
}

// Handle a move
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cell']) && !$_SESSION['winner'] && !$_SESSION['draw']) {
    $cell = intval($_POST['cell']);

    if ($_SESSION['board'][$cell] === '') {
        $_SESSION['board'][$cell] = $_SESSION['turn'];

        // Check winner
        $wins = [[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];
        foreach ($wins as $combo) {
            [$a,$b,$c] = $combo;
            $b = $_SESSION['board'];
            if ($b[$a] && $b[$a] === $b[$combo[1]] && $b[$a] === $b[$combo[2]]) {
                $_SESSION['winner'] = $_SESSION['turn'];
                break;
            }
        }

        // Check draw
        if (!$_SESSION['winner'] && !in_array('', $_SESSION['board'])) {
            $_SESSION['draw'] = true;
        }

        // Switch turn
        if (!$_SESSION['winner'] && !$_SESSION['draw']) {
            $_SESSION['turn'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
        }
    }
}

$board  = $_SESSION['board'];
$turn   = $_SESSION['turn'];
$winner = $_SESSION['winner'];
$draw   = $_SESSION['draw'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tic-Tac-Toe</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; display: flex; justify-content: center; padding: 40px 16px; }
    .container { text-align: center; }
    h3 { color: #333; margin-bottom: 8px; }

    .status { font-size: 16px; margin-bottom: 16px; padding: 8px 16px; border-radius: 6px; display: inline-block; }
    .status.playing  { background: #dbeafe; color: #1e40af; }
    .status.winner   { background: #d1fae5; color: #065f46; font-weight: bold; }
    .status.draw     { background: #fef9c3; color: #854d0e; font-weight: bold; }

    .board { display: grid; grid-template-columns: repeat(3, 100px); gap: 6px; margin: 0 auto 20px; width: fit-content; }

    .cell { width: 100px; height: 100px; background: white; border: 2px solid #cbd5e1;
            border-radius: 8px; font-size: 36px; font-weight: bold; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s; }
    .cell:hover:not(.taken) { background: #eff6ff; }
    .cell.taken { cursor: default; }
    .cell.X { color: #3b82f6; }
    .cell.O { color: #ef4444; }

    .reset-btn { padding: 10px 28px; background: #3b82f6; color: white; border: none;
                 border-radius: 6px; font-size: 15px; cursor: pointer; }
    .reset-btn:hover { background: #2563eb; }

    .score { display: flex; justify-content: center; gap: 24px; margin-bottom: 16px; }
    .score-box { background: white; padding: 10px 20px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    .score-box .label { font-size: 12px; color: #888; }
    .score-box .val   { font-size: 22px; font-weight: bold; }
    .score-box.x .val { color: #3b82f6; }
    .score-box.o .val { color: #ef4444; }
  </style>
</head>
<body>
<div class="container">
  <h3>❌ Tic-Tac-Toe ⭕</h3>
  <p style="color:#888;font-size:13px;margin-bottom:16px">2 Player Game</p>

  <?php
  if ($winner) {
      echo "<div class='status winner'>🎉 Player $winner wins!</div>";
  } elseif ($draw) {
      echo "<div class='status draw'>🤝 It's a Draw!</div>";
  } else {
      echo "<div class='status playing'>Player <strong>$turn</strong>'s turn</div>";
  }
  ?>

  <!-- Board -->
  <div class="board">
    <?php for ($i = 0; $i < 9; $i++):
      $val   = $board[$i];
      $taken = $val !== '' ? 'taken' : '';
    ?>
      <form method="POST" style="margin:0">
        <input type="hidden" name="cell" value="<?= $i ?>"/>
        <button type="submit" class="cell <?= $taken ?> <?= $val ?>"
          <?= ($taken || $winner || $draw) ? 'disabled' : '' ?>>
          <?= $val ?>
        </button>
      </form>
    <?php endfor; ?>
  </div>

  <a href="?reset=1"><button class="reset-btn">🔄 New Game</button></a>
</div>
</body>
</html>
