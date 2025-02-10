<?php
include 'config.php';
session_start();
include 'header.php';

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_checkout'])) {

    $selected_products = $_POST['selected_products']; // Produk yang dipilih
    $quantities = $_POST['quantity']; 
    $total = 0;
    $shipping_method = $_POST['shipping_method']; // metode pengantaran
    $payment_method = $_POST['payment_method']; 
    $shipping_fee = ($shipping_method == 'send') ? 10000 : 0; // ongkir 

    // Cek stok dan hitung total
    foreach ($selected_products as $id) {
        $sql = "SELECT * FROM products WHERE id='$id'";
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            $product = $res->fetch_assoc();
            $qty = isset($quantities[$id]) ? $quantities[$id] : 1; // Memastikan jumlah dtok cukup
            if ($qty > $product['stock']) {
                echo "<p>Stok tidak mencukupi untuk produk " . $product['name'] . "</p>";
                include 'footer.php';
                exit();  // menghentikan checkout kalo stok ga mencukupi
            }
            $total += $product['price'] * $qty;
        }
    }

    // menyimpan order ke tabel orders
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
    $order_date = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, shipping_method, shipping_fee, payment_method, order_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idsdss", $user_id, $total, $shipping_method, $shipping_fee, $payment_method, $order_date);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // menyimpan detail order dan perbarui stok produk
    foreach ($selected_products as $id) {
        $sql = "SELECT * FROM products WHERE id='$id'";
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            $product = $res->fetch_assoc();
            $qty = isset($quantities[$id]) ? $quantities[$id] : 1;
            $price = $product['price'];

            $stmt2 = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("iiid", $order_id, $id, $qty, $price);
            $stmt2->execute();

            // Update stok produk setelah dibeli
            $new_stock = $product['stock'] - $qty;
            $conn->query("UPDATE products SET stock='$new_stock' WHERE id='$id'");

            // fitur menghapus cartk
            if (isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    // setelah berhasi proses pembayaran langsung ke halaman terimaksi
    header("Location: terima_kasih.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['confirm_checkout'])) {
    if (isset($_POST['selected_products'])) {
        $selected_products = $_POST['selected_products'];
        $quantities = $_POST['quantity'];
    } else {
        echo "<div class='container'><p>Tidak ada produk yang dipilih untuk checkout.</p></div>";
        include 'footer.php';
        exit();
    }
}
?>

<div class="container">
  <h2>Checkout</h2>

  <?php if (!isset($_POST['confirm_checkout'])): ?>
  <form action="checkout.php" method="post" id="checkoutForm">

    <h3>Pilih Jenis Pengantaran</h3>
    <div class="form-group">
      <label><input type="radio" name="shipping_method" value="send" checked onclick="updateTotal()"> Send (Rp10.000)</label>
      <label><input type="radio" name="shipping_method" value="pick up" onclick="updateTotal()"> Pick Up (Gratis)</label>
    </div>

    <h3>Detail Produk Pesanan</h3>
    <table class="checkout-table">
      <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
      </tr>

      <?php
      $total = 0;
      foreach ($selected_products as $id):
          $sql = "SELECT * FROM products WHERE id='$id'";
          $res = $conn->query($sql);
          if ($res && $res->num_rows > 0):
              $product = $res->fetch_assoc();
              $qty = isset($quantities[$id]) ? $quantities[$id] : 1;
              $subtotal = $product['price'] * $qty;
              $total += $subtotal;
      ?>
      <tr>
        <td><?php echo $product['name']; ?></td>
        <td>Rp<?php echo number_format($product['price']); ?></td>
        <td>
          <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1" max="<?php echo $product['stock']; ?>" class="qty-input" data-price="<?php echo $product['price']; ?>" onchange="updateTotal()">
        </td>
        <td>Rp<span class="subtotal"><?php echo number_format($subtotal); ?></span></td>
      </tr>
      <input type="hidden" name="selected_products[]" value="<?php echo $id; ?>">
      <?php 
          endif;
      endforeach; 
      ?>
    </table>

    <!-- Pilihan Metode Pembayaran -->
    <h3>Pilih Metode Pembayaran</h3>
    <div class="form-group">
      <label><input type="radio" name="payment_method" value="mbanking" checked onclick="togglePaymentField()"> M-Banking</label>
      <label><input type="radio" name="payment_method" value="cash" onclick="togglePaymentField()"> Cash</label>
    </div>

    <!-- Field untuk M-Banking (password-like) -->
    <div id="mbankingField" style="display:block;">
      <label for="mbanking_password">Password M-Banking:</label>
      <input type="text" name="mbanking_password" id="mbanking_password" placeholder="Enter M-Banking password" class="mbanking-input">
    </div>
    
    <!-- Total Harga -->
    <h3>Total Pembayaran</h3>
    <p>Total Belanja: Rp<span id="totalBelanja"><?php echo number_format($total); ?></span></p>
    <p>Ongkir: Rp<span id="ongkir">10.000</span></p>
    <h3><strong>Total Bayar: Rp<span id="totalBayar"><?php echo number_format($total + 10000); ?></span></strong></h3>

    <input type="hidden" name="confirm_checkout" value="1">
    <button type="submit" class="button">Bayar Sekarang</button>
  </form>
  <?php endif; ?>

</div>

<style>
  .checkout-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
  .checkout-table th, .checkout-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center; /* Align text to the center */
  }
  .checkout-table th {
    background-color: #f2f2f2;
  }
</style>

<script>
// memperbarui total harga
function updateTotal() {
    let totalBelanja = 0;
    document.querySelectorAll('.qty-input').forEach(input => {
        let qty = parseInt(input.value);
        let price = parseFloat(input.dataset.price);
        let subtotal = qty * price;
        input.closest('tr').querySelector('.subtotal').innerText = subtotal.toLocaleString();
        totalBelanja += subtotal;
    });

    let shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
    let shippingFee = (shippingMethod === 'send') ? 10000 : 0;
    
    document.getElementById('totalBelanja').innerText = totalBelanja.toLocaleString();
    document.getElementById('ongkir').innerText = shippingFee.toLocaleString();
    document.getElementById('totalBayar').innerText = (totalBelanja + shippingFee).toLocaleString();
}

// menampilkan dan menghilangkan metode pembayarn m-banking hehe
function togglePaymentField() {
    let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    let mbankingField = document.getElementById('mbankingField');
    
    if (paymentMethod === 'mbanking') {
        mbankingField.style.display = 'block'; 
    } else {
        mbankingField.style.display = 'none'; 
    }
}

document.querySelectorAll('.qty-input, input[name="shipping_method"], input[name="payment_method"]').forEach(input => {
    input.addEventListener('change', updateTotal);
});

window.onload = function() {
    updateTotal(); 
    togglePaymentField(); 
};
</script>

<?php include 'footer.php'; ?>