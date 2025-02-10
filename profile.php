<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users_member WHERE id_users_member='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Florica Blooms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
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
</div>
<?php include 'footer.php'; ?>
</body>
</html>