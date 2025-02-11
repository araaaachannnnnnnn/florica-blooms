<?php
include 'config.php';
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florica Blooms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <?php if (isLoggedIn()): ?>
        <?php
        $user = getLoggedInUser();
        ?>
        <div class="profile-container">
            <h1>Profile</h1>
            <div class="profile-image">
                <img src="<?php echo $user['profile_image']; ?>" alt="Profile Image">
            </div>
            <div class="profile-details">
                <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                <p><strong>Name:</strong> <?php echo isset($user['name']) ? $user['name'] : 'N/A'; ?></p>
            </div>
        </div>
        <p>Welcome back, <?php echo $user['username']; ?>! Enjoy a 5% discount on all products.</p>
    <?php else: ?>
        <p>Welcome to Florica Blooms! Sign up or log in to enjoy a 5% discount on all products.</p>
    <?php endif; ?>

    <h2>Featured Products</h2>
    <div class="product-grid">
        <?php
        $sql = "SELECT * FROM products LIMIT 4";
        $result = $conn->query($sql);
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <div class="product" data-name="<?php echo $row['name']; ?>">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h4><?php echo $row['name']; ?></h4>
                <p><?php echo $row['description']; ?></p>
                <p>Rp<?php echo number_format($row['price']); ?></p>
                <?php if (isLoggedIn()): ?>
                    <p>Discounted Price: Rp<?php echo number_format($row['price'] * 0.95); ?></p>
                <?php endif; ?>
                <form class="add-to-cart-form" data-product-id="<?php echo $row['id']; ?>" data-product-name="<?php echo $row['name']; ?>" data-product-price="<?php echo $row['price']; ?>" data-product-image="<?php echo $row['image']; ?>" data-product-stock="<?php echo $row['stock']; ?>">
                    <button type="button" class="button add-to-cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </form>
            </div>
        <?php endwhile; else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</div>

<script>
// Function to add product to cart using AJAX
document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function() {
        const form = button.closest('.add-to-cart-form');
        const productId = form.getAttribute('data-product-id');
        const productName = form.getAttribute('data-product-name');
        const productPrice = form.getAttribute('data-product-price');
        const productImage = form.getAttribute('data-product-image');
        const productStock = parseInt(form.getAttribute('data-product-stock'));

        // Check stock before adding to cart
        let quantity = 1;  // Default quantity 1
        if (quantity > productStock) {
            alert("Insufficient stock.");
            return;
        }

        // Send product data using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'keranjang.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Prepare data to be sent
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
                alert('Product added to cart successfully!');
                updateCartCount();
            }
        };
    });
});

// Update cart count
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

<?php include 'footer.php'; ?>
</body>
</html>