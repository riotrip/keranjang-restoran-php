<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'restoran');
$id_produk = $_GET['id'];

$ambil = $con->query("SELECT FROM barang WHERE id=$id_produk");

if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk] += 1;
} else {
    $_SESSION['keranjang'][$id_produk] = 1;
}

echo "<script>alert('Menu telah masuk dikeranjang');</script>";
echo "<script>location='keranjang.php';</script>";
