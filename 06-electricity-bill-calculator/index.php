<?php
$bill  = null;
$units = null;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $units = floatval($_POST['units']);
    if ($units < 0) {
        $error = "Units cannot be negative.";
    } else {
        if ($units <= 50)       $bill = $units * 3.50;
        elseif ($units <= 150)  $bill = (50 * 3.50) + (($units - 50) * 4.00);
        elseif ($units <= 250)  $bill = (50 * 3.50) + (100 * 4.00) + (($units - 150) * 5.20);
        else                    $bill = (50 * 3.50) + (100 * 4.00) + (100 * 5.20) + (($units - 250) * 6.50);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Electricity Bill Calculator</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 30px; }
    .card { max-width: 520px; margin: 0 auto; background: white; padding: 28px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h3 { text-align: center; margin-bottom: 6px; color: #333; }
    p.subtitle { text-align: center; color: #888; margin-bottom: 20px; font-size: 14px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { padding: 8px 12px; border: 1px solid #ddd; font-size: 14px; }
    th { background: #3b82f6; color: white; }
    label { display: block; font-weight: bold; margin-bottom: 6px; }
    input[type="number"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; margin-bottom: 12px; }
    button { width: 100%; padding: 10px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    button:hover { background: #2563eb; }
    .error { color: #e74c3c; margin-top: 10px; }
    .result { background: #d1fae5; border-radius: 6px; padding: 14px; margin-top: 18px; }
    .result h5 { margin-bottom: 8px; color: #333; }
    .result p { margin: 4px 0; font-size: 14px; }
    .result .total { font-size: 18px; font-weight: bold; color: #16a34a; margin-top: 8px; }
    hr { border: none; border-top: 1px solid #ccc; margin: 8px 0; }
  </style>
</head>
<body>
<div class="card">
  <h3>⚡ Electricity Bill Calculator</h3>
  <p class="subtitle">Maharashtra State Electricity Board</p>

  <table>
    <thead><tr><th>Units Consumed</th><th>Rate per Unit</th></tr></thead>
    <tbody>
      <tr><td>First 50 units</td><td>₹ 3.50</td></tr>
      <tr><td>Next 100 units (51–150)</td><td>₹ 4.00</td></tr>
      <tr><td>Next 100 units (151–250)</td><td>₹ 5.20</td></tr>
      <tr><td>Above 250 units</td><td>₹ 6.50</td></tr>
    </tbody>
  </table>

  <form method="POST">
    <label>Enter Units Consumed:</label>
    <input type="number" name="units" placeholder="e.g. 180"
           value="<?php echo $units !== null ? $units : ''; ?>" min="0" step="0.01" required/>
    <button type="submit">Calculate Bill</button>
  </form>

  <?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
  <?php endif; ?>

  <?php if ($bill !== null && !$error): ?>
    <div class="result">
      <h5>📋 Bill Summary</h5>
      <p>Units Consumed: <strong><?php echo $units; ?> units</strong></p>
      <?php
        if ($units <= 50) {
            echo "<p>Slab 1: $units × ₹3.50 = ₹" . number_format($units * 3.50, 2) . "</p>";
        } elseif ($units <= 150) {
            echo "<p>Slab 1: 50 × ₹3.50 = ₹175.00</p>";
            echo "<p>Slab 2: " . ($units-50) . " × ₹4.00 = ₹" . number_format(($units-50)*4, 2) . "</p>";
        } elseif ($units <= 250) {
            echo "<p>Slab 1: 50 × ₹3.50 = ₹175.00</p>";
            echo "<p>Slab 2: 100 × ₹4.00 = ₹400.00</p>";
            echo "<p>Slab 3: " . ($units-150) . " × ₹5.20 = ₹" . number_format(($units-150)*5.20, 2) . "</p>";
        } else {
            echo "<p>Slab 1: 50 × ₹3.50 = ₹175.00</p>";
            echo "<p>Slab 2: 100 × ₹4.00 = ₹400.00</p>";
            echo "<p>Slab 3: 100 × ₹5.20 = ₹520.00</p>";
            echo "<p>Slab 4: " . ($units-250) . " × ₹6.50 = ₹" . number_format(($units-250)*6.50, 2) . "</p>";
        }
      ?>
      <hr/>
      <p class="total">Total Bill: ₹<?php echo number_format($bill, 2); ?></p>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
