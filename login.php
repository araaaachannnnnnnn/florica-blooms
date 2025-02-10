<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); // Assuming passwords are stored as MD5 hashes

    $sql = "SELECT * FROM users_member WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
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
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            padding: 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Login</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>