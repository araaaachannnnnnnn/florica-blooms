<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users_member WHERE id_users_member='$user_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = null;
}
?>
<?php if ($user): ?>
<div class="profile-container">
    <h1>Profile</h1>
    <div class="profile-details">
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Name:</strong> <?php echo isset($user['name']) ? $user['name'] : 'N/A'; ?></p>
    </div>
</div>
<?php endif; ?>