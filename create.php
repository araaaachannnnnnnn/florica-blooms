<?php include('config.php'); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (nama, email) VALUES ('$nama', '$email')";
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
    <title>Tambah Data</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
