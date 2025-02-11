<?php
include 'config.php';
include 'header.php';

//MENGAMBIL KATAGORI DAR DB
$sqlCat = "SELECT * FROM categories LIMIT 2"; // Hanya mengambil 2 kategori
$catResult = $conn->query($sqlCat);
?>
<div class="container">
    <h2>Kategori Produk</h2>
    <?php if ($catResult->num_rows > 0): ?>
        <?php while ($cat = $catResult->fetch_assoc()): ?>
            <h3><?php echo $cat['name']; ?></h3>
            <div class="product-grid">
                <?php
                $cat_id = $cat['id'];
                $sqlProd = "SELECT * FROM products WHERE category_id = '$cat_id'";
                $prodResult = $conn->query($sqlProd);
                if ($prodResult->num_rows > 0):
                    while ($row = $prodResult->fetch_assoc()):
                ?>
                        <div class="product" data-name="<?php echo $row['name']; ?>">
                            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            <h4><?php echo $row['name']; ?></h4>
                            <p><?php echo $row['description']; ?></p>
                            <p>Rp<?php echo number_format($row['price']); ?></p>
                            <p>Stok Tersedia: <?php echo $row['stock']; ?></p> 
                            <form class="add-to-cart-form" data-product-id="<?php echo $row['id']; ?>" data-product-name="<?php echo $row['name']; ?>" data-product-price="<?php echo $row['price']; ?>" data-product-image="<?php echo $row['image']; ?>" data-product-stock="<?php echo $row['stock']; ?>">
                                <button type="button" class="button add-to-cart">
                                    <i class="fas fa-shopping-cart"></i> 
                                </button>
                            </form>
                        </div>
                <?php endwhile; else: ?>
                    <p>Tidak ada produk di kategori ini.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada kategori.</p>
    <?php endif; ?>
</div>

<script>
// Fungsi untuk menambah produk ke keranjang menggunakan AJAX
document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function() {
        const form = button.closest('.add-to-cart-form');
        const productId = form.getAttribute('data-product-id');
        const productName = form.getAttribute('data-product-name');
        const productPrice = form.getAttribute('data-product-price');
        const productImage = form.getAttribute('data-product-image');
        const productStock = parseInt(form.getAttribute('data-product-stock'));

        // Mengecek stok sebelum menambahkan ke keranjang
        let quantity = 1;  // Default jumlah 1
        if (quantity > productStock) {
            alert("Stok tidak mencukupi.");
            return;
        }

        // Kirim data produk menggunakan AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'keranjang.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Menyiapkan data untuk dikirim
        const data = new URLSearchParams();
        data.append('add_to_cart', 'true');
        data.append('product_id', productId);
        data.append('name', productName);
        data.append('price', productPrice);
        data.append('image', productImage);
        data.append('stock', productStock);
        data.append('quantity', quantity);

        xhr.send(data);

        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                updateCartCount();
            }
        };
    });
});

// Mengupdate jumlah keranjang
function updateCartCount() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'keranjang_count.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const count = xhr.responseText;
            document.getElementById('cart-count').textContent = count;
        }
    };
    xhr.send();
}

window.onload = updateCartCount;
</script>

<?php
include 'footer.php';
?>