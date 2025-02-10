<?php
// index.php
include 'config.php';
include 'header.php';

// maksimal 4 gambar yang di beranda
$sql = "SELECT * FROM products LIMIT 4";
$result = $conn->query($sql);
?>
<div class="container">
  <h2>Selamat Datang di Florica Blooms</h2>
  <p>Florica Blooms toko bunga unik yang menghadirkan Pipe Cleaner Boquet dan Keychain handmade dengan desain kreatif dan penuh warna.</p>
  <p>Dapatkan diskon 5% khusus member! >< </p>

  <h3>Produk Unggulan</h3>
  <div class="product-slider">
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="product">
          <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Tidak ada produk.</p>
    <?php endif; ?>
  </div>
</div>

<style>
  .product-slider {
    display: flex;
    gap: 15px;
    overflow-x: auto;
  }
  .product {
    flex: 0 0 auto;
    width: 200px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .product img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 5px;
  }
  .product:hover {
    transform: scale(1.05);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  }
</style>

<?php
include 'footer.php';
?>