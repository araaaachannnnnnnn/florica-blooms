<?php
include 'config.php';
include 'session.php';

$user = getLoggedInUser();

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = array(
            "name"     => $name,
            "price"    => $price,
            "image"    => $image,
            "quantity" => 1
        );
    }

    echo json_encode(["status" => "success", "message" => "Produk berhasil ditambahkan!"]);
    exit();
}

// Handle removing from cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    echo json_encode(["status" => "success", "message" => "Produk dihapus dari keranjang!"]);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Florica Blooms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <?php if ($user): ?>
    <div class="profile-container">
        <h1>Profile</h1>
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Name:</strong> <?php echo isset($user['name']) ? $user['name'] : 'N/A'; ?></p>
        </div>
    </div>
    <?php endif; ?>

    <h2>Keranjang Saya</h2>
    <form action="checkout.php" method="post" id="cartForm">
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="cart-list">
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <div class="cart-item" data-product-id="<?php echo $id; ?>">
                        <input type="checkbox" name="selected_products[]" value="<?php echo $id; ?>" class="product-checkbox" checked onchange="calculateTotal()">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div class="cart-details">
                            <strong><?php echo $item['name']; ?></strong>
                            <p>Harga: Rp<?php echo number_format($item['price']); ?></p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <p>Harga Diskon: Rp<?php echo number_format($item['price'] * 0.95); ?></p>
                            <?php endif; ?>
                            <p>
                                Qty: 
                                <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="100" class="qty-input" data-price="<?php echo isset($_SESSION['user_id']) ? $item['price'] * 0.95 : $item['price']; ?>" onchange="calculateTotal()">
                            </p>
                        </div>
                        <button type="button" class="remove-btn" onclick="removeFromCart('<?php echo $id; ?>')">Hapus</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <h3>Total: Rp<span id="totalHarga">0</span></h3>
            <button type="submit" class="button">Checkout</button>
        <?php else: ?>
            <p>Keranjang kosong.</p>
        <?php endif; ?>
    </form>
</div>

<script>
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach(function(item) {
        let checkbox = item.querySelector('.product-checkbox');
        if (checkbox.checked) {
            let qty = parseInt(item.querySelector('.qty-input').value);
            let price = parseFloat(item.querySelector('.qty-input').dataset.price);
            total += qty * price;
        }
    });
    document.getElementById('totalHarga').innerText = total.toLocaleString();
}

function removeFromCart(productId) {
    let formData = new FormData();
    formData.append('remove_from_cart', '1');
    formData.append('product_id', productId);

    fetch('keranjang.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.querySelector(`.cart-item[data-product-id="${productId}"]`).remove();
            calculateTotal();
        } else {
            alert('Gagal menghapus produk dari keranjang.');
        }
    });
}

window.onload = calculateTotal;
</script>

<?php include 'footer.php'; ?>
</body>
</html>