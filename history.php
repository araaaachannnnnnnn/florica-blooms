<?php

include 'config.php';
session_start();
include 'header.php';

if(!isset($_SESSION['user_id'])){
    echo "<div class='container'><p>Anda harus login untuk melihat history pesanan.</p></div>";
    include 'footer.php';
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY order_date DESC";
$result = $conn->query($sql);
?>
<div class="container">
  <h2>History Penjualan</h2>
  <?php if($result && $result->num_rows > 0): ?>
    <table class="order-history">
      <tr>
        <th>ID Order</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Metode Pengiriman</th>
        <th>Metode Pembayaran</th>
      </tr>
      <?php while($order = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $order['id']; ?></td>
          <td><?php echo $order['order_date']; ?></td>
          <td>Rp<?php echo number_format($order['total']); ?></td>
          <td><?php echo ucfirst($order['shipping_method']); ?></td>
          <td><?php echo ucfirst($order['payment_method']); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>Belum ada history pesanan.</p>
  <?php endif; ?>
</div>
<?php
include 'footer.php';
?>
