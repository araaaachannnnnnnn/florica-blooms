<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florica Blooms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<header>
        <div class="top-bar">
            <div class="right-links">
                <a href="register.php">Daftar</a>
                <a href="login.php">Log In</a>
            </div>
            <div class="nav-links">
                <a href="index.php">Beranda</a>
                <a href="produk.php">Produk</a>
                <a href="kategori.php">Kategori</a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Cari produk...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="cart">
                <a href="keranjang.php"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
        <div class="main-header">
            <div class="logo">
                <img src="img/logo 3.png" alt="Logo Florica Blooms" class="logo">
                <div class="title">
                <h1>FLORICA BLOOMS</h1>
                <p>Hadirkan Keindahan dalam Setiap Kreasi!</p>
            </div>
        </div>
        </div>
    </header>
<main>