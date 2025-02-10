<?php
include 'config.php';
include 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); // Assuming passwords are stored as MD5 hashes

    $sql = "SELECT * FROM users_member WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id_users_member'];
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect to the main page after successful login
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Florica Blooms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <div class="login-container">
        <h1>Login</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="button">Login</button>
        </form>
        <button onclick="window.history.back()" class="button">Back</button>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>