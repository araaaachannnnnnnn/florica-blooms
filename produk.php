<?php
include 'config.php';
include 'header.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM products";
}
$result = $conn->query($sql);
?>
<div class="container">
    <h2>Semua Produk</h2>
    <div class="product-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product" data-name="<?php echo $row['name']; ?>">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <h4><?php echo $row['name']; ?></h4>
                    <p><?php echo $row['description']; ?></p>
                    <p>Rp<?php echo number_format($row['price']); ?></p>
                    <p>Stok Tersedia: <?php echo $row['stock']; ?></p> <!-- nampilin stok produk -->
                    <form class="add-to-cart-form" data-product-id="<?php echo $row['id']; ?>" data-product-name="<?php echo $row['name']; ?>" data-product-price="<?php echo $row['price']; ?>" data-product-image="<?php echo $row['image']; ?>" data-product-stock="<?php echo $row['stock']; ?>">
                        <button type="button" class="button add-to-cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada produk.</p>
        <?php endif; ?>
    </div>
</div>

<script>
// nambahi produk ke keranjang pake AJAX
document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function() {
        const form = button.closest('.add-to-cart-form');
        const productId = form.getAttribute('data-product-id');
        const productName = form.getAttribute('data-product-name');
        const productPrice = form.getAttribute('data-product-price');
        const productImage = form.getAttribute('data-product-image');
        const productStock = parseInt(form.getAttribute('data-product-stock'));

        // ngecek stok, sebelum nambahi ke keranjang
        let quantity = 1;  
        if (quantity > productStock) {
            alert("Stok tidak mencukupi.");
            return;
        }

        // ngirim data produk menggunakan AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'keranjang.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

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

//mengasi tahu jumlah keranjang
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