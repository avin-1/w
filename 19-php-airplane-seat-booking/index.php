<?php
require 'db.php';
$message = '';

// Book a seat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seat_no'])) {
    $seat      = htmlspecialchars($_POST['seat_no']);
    $passenger = htmlspecialchars(trim($_POST['passenger']));

    if (!$passenger) {
        $message = "❌ Please enter passenger name.";
    } else {
        // Check if still available
        $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM seats WHERE seat_no='$seat'"));
        if ($check['status'] === 'Booked') {
            $message = "❌ Seat $seat is already booked.";
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE seats SET status='Booked', passenger=? WHERE seat_no=?");
            mysqli_stmt_bind_param($stmt, "ss", $passenger, $seat);
            mysqli_stmt_execute($stmt);
            $message = "✅ Seat $seat booked for $passenger!";
        }
    }
}

// Cancel a booking
if (isset($_GET['cancel'])) {
    $seat = htmlspecialchars($_GET['cancel']);
    mysqli_query($conn, "UPDATE seats SET status='Available', passenger=NULL WHERE seat_no='$seat'");
    header('Location: index.php');
    exit;
}

// Fetch all seats
$result = mysqli_query($conn, "SELECT * FROM seats ORDER BY seat_no");
$seats  = [];
while ($row = mysqli_fetch_assoc($result)) {
    $seats[$row['seat_no']] = $row;
}

$rows = ['1','2','3','4','5','6'];
$cols = ['A','B','C','D','E'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Airplane Seat Booking</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
    .container { max-width: 760px; margin: 0 auto; }
    h3 { color: #333; margin-bottom: 6px; }
    .tagline { color: #888; font-size: 14px; margin-bottom: 20px; }
    .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error   { background: #fee2e2; color: #991b1b; }

    /* Seat map */
    .plane { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .plane-nose { text-align: center; font-size: 28px; margin-bottom: 10px; }
    .col-labels { display: flex; justify-content: center; gap: 8px; margin-bottom: 6px; padding-left: 36px; }
    .col-label  { width: 44px; text-align: center; font-weight: bold; font-size: 13px; color: #555; }
    .seat-row   { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 6px; }
    .row-label  { width: 28px; text-align: right; font-size: 13px; color: #888; padding-right: 4px; }
    .seat { width: 44px; height: 38px; border-radius: 6px 6px 4px 4px; border: none; cursor: pointer;
            font-size: 12px; font-weight: bold; transition: transform 0.1s; }
    .seat:hover { transform: scale(1.08); }
    .seat.available.business { background: #bfdbfe; color: #1e40af; }
    .seat.available.economy  { background: #bbf7d0; color: #166534; }
    .seat.booked             { background: #fca5a5; color: #7f1d1d; cursor: not-allowed; }
    .aisle { width: 20px; }

    /* Legend */
    .legend { display: flex; gap: 16px; margin-bottom: 16px; font-size: 13px; flex-wrap: wrap; }
    .legend-item { display: flex; align-items: center; gap: 6px; }
    .dot { width: 16px; height: 16px; border-radius: 3px; }

    /* Booking form */
    .book-form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    .book-form h5 { margin-bottom: 12px; color: #333; }
    .form-row { display: flex; gap: 10px; align-items: flex-end; }
    label { display: block; font-weight: bold; margin-bottom: 4px; font-size: 14px; }
    input[type="text"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; width: 100%; }
    .selected-seat { padding: 8px 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 4px; font-size: 14px; min-width: 80px; text-align: center; }
    button.book-btn { padding: 9px 20px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; white-space: nowrap; }

    /* Booked list */
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); margin-top: 20px; }
    th, td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 13px; text-align: left; }
    th { background: #1e293b; color: white; }
    a.cancel { color: #ef4444; font-size: 13px; }
  </style>
</head>
<body>
<div class="container">
  <h3>✈️ Airplane Seat Booking</h3>
  <p class="tagline">Click an available seat to select it, then enter passenger name to book.</p>

  <?php if ($message): ?>
    <div class="alert <?= str_starts_with($message,'✅') ? 'alert-success' : 'alert-error' ?>"><?= $message ?></div>
  <?php endif; ?>

  <div class="legend">
    <div class="legend-item"><div class="dot" style="background:#bfdbfe"></div> Business (Available)</div>
    <div class="legend-item"><div class="dot" style="background:#bbf7d0"></div> Economy (Available)</div>
    <div class="legend-item"><div class="dot" style="background:#fca5a5"></div> Booked</div>
  </div>

  <!-- Seat Map -->
  <div class="plane">
    <div class="plane-nose">🛩️</div>
    <div class="col-labels">
      <?php foreach ($cols as $i => $col): ?>
        <div class="col-label"><?= $col ?></div>
        <?php if ($i == 1): ?><div class="aisle"></div><?php endif; ?>
      <?php endforeach; ?>
    </div>

    <?php foreach ($rows as $row): ?>
      <div class="seat-row">
        <div class="row-label"><?= $row ?></div>
        <?php foreach ($cols as $i => $col):
          $seatNo = $row . $col;
          $s      = $seats[$seatNo];
          $cls    = $s['status'] === 'Booked' ? 'booked' : ('available ' . strtolower($s['class']));
          $title  = $s['status'] === 'Booked' ? "Booked: {$s['passenger']}" : "Click to select";
        ?>
          <button class="seat <?= $cls ?>"
            <?= $s['status'] === 'Available' ? "onclick=\"selectSeat('$seatNo')\"" : 'disabled' ?>
            title="<?= $title ?>">
            <?= $seatNo ?>
          </button>
          <?php if ($i == 1): ?><div class="aisle"></div><?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Booking Form -->
  <div class="book-form">
    <h5>Book Selected Seat</h5>
    <form method="POST">
      <div class="form-row">
        <div>
          <label>Selected Seat</label>
          <div class="selected-seat" id="selectedDisplay">None</div>
          <input type="hidden" name="seat_no" id="seatInput"/>
        </div>
        <div style="flex:1">
          <label>Passenger Name</label>
          <input type="text" name="passenger" id="passengerInput" placeholder="Enter passenger name"/>
        </div>
        <button type="submit" class="book-btn">Book Seat</button>
      </div>
    </form>
  </div>

  <!-- Booked Seats List -->
  <?php
  $booked = array_filter($seats, fn($s) => $s['status'] === 'Booked');
  if (!empty($booked)):
  ?>
    <table>
      <thead><tr><th>Seat</th><th>Class</th><th>Passenger</th><th>Action</th></tr></thead>
      <tbody>
        <?php foreach ($booked as $s): ?>
          <tr>
            <td><?= $s['seat_no'] ?></td>
            <td><?= $s['class'] ?></td>
            <td><?= htmlspecialchars($s['passenger']) ?></td>
            <td><a href="?cancel=<?= $s['seat_no'] ?>" class="cancel"
                   onclick="return confirm('Cancel booking for <?= $s['seat_no'] ?>?')">Cancel</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<script>
  function selectSeat(seatNo) {
    document.getElementById('selectedDisplay').textContent = seatNo;
    document.getElementById('seatInput').value = seatNo;
    document.getElementById('passengerInput').focus();
  }
</script>
</body>
</html>
