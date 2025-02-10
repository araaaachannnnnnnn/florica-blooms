<?php
include 'config.php';
session_start();

$message = "";
if(isset($_POST['register'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $name = $conn->real_escape_string($_POST['name']);
    // cek user
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if($result && $result->num_rows > 0){
        $_SESSION['register_status'] = 'fail';
        $_SESSION['register_message'] = "Username sudah ada. Pilih username lain.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users_member (username, password, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $name);
        if($stmt->execute()){
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['register_status'] = 'success';
            $_SESSION['register_message'] = "Registrasi berhasil! Anda telah berhasil mendaftar.";
        } else {
            $_SESSION['register_status'] = 'fail';
            $_SESSION['register_message'] = "Registrasi gagal.";
        }
    }
    header("Location: register_success.php");
    exit();
}
include 'header.php';
?>
<div class="container">
  <h2>Daftar</h2>
  <?php if(isset($message) && $message != "") echo "<p style='color:red;'>$message</p>"; ?>
  <form action="register.php" method="post">
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" required>
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" name="password" required>
    </div>
    <div class="form-group">
      <label>Name:</label>
      <input type="text" name="name" required>
    </div>
    <button type="submit" name="register" class="button">Daftar</button>
  </form>
</div>
<?php
include 'footer.php';
?>