<?php include('config.php'); ?>
<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET nama='$nama', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
