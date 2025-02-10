<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getLoggedInUser() {
    global $conn;
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users_member WHERE id_users_member='$user_id'";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }
    return null;
}
?>