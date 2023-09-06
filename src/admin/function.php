<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'restoran');

// Input barang
if (isset($_POST['inputbarang'])) {
    $name = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $allowed_extension = array('png', 'jpg', 'jpeg');
    $nama = $_FILES['gambar']['name'];
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot));
    $file_tmp = $_FILES['gambar']['tmp_name'];

    if (!empty($nama)) {
        $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi;

        if (in_array($ekstensi, $allowed_extension) === true) {
            move_uploaded_file($file_tmp, '../img/' . $image);
        } else {
            echo "<script type='text/javascript'>alert('File harus png/jpg');</script>";
            echo "<script> window.location.href='input.php';</script>";
        }
    } else {
        $image = "";
    }

    $addbarang = mysqli_query($con, "INSERT INTO barang (nama, harga, stok, gambar) VALUES ('$name', '$harga', '$stok', '$image')");
    if ($addbarang) {
        echo "<script type='text/javascript'>alert('Barang berhasil diinput!');</script>";
        echo "<script> window.location.href='edit.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Barang gagal diinput!');</script>";
        echo "<script> window.location.href='input.php';</script>";
    }
}

//Update barang
if (isset($_POST['updatebarang'])) {
    $id = $_POST['id'];
    $name = $_POST['produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $allowed_extension = array('png', 'jpg', 'jpeg');
    $nama = $_FILES['gambar']['name'];
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot));
    $ukuran = $_FILES['gambar']['size'];
    $file_tmp = $_FILES['gambar']['tmp_name'];

    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi;

    if ($ukuran == 0) {
        $update = mysqli_query($con, "UPDATE barang SET nama='$name',harga='$harga',stok='$stok' WHERE id='$id'");
        if ($update) {
            header('location:edit.php');
        } else {
            echo 'Gagal';
            header('location:edit.php');
        }
    } else {
        move_uploaded_file($file_tmp, '../img/' . $image);
        $update = mysqli_query($con, "UPDATE barang SET nama='$name',harga='$harga',stok='$stok', gambar='$image' WHERE id='$id'");
        if ($update) {
            header('location:edit.php');
        } else {
            echo 'Gagal';
            header('location:edit.php');
        }
    }
}

//Delete barang
if (isset($_POST['deletebarang'])) {
    $id = $_POST['id'];

    $gambar = mysqli_query($con, "SELECT from barang WHERE id ='$id'");
    $get = mysqli_fetch_array($gambar);
    $img = 'img/' . $get['image'];
    unlink($img);

    $hapus = mysqli_query($con, "DELETE from barang WHERE id ='$id'");
    if ($hapus) {
        header('location:edit.php');
    } else {
        echo 'Gagal';
        header('location:edit.php');
    }
}

//Update pesanan
if (isset($_POST['updatepesan'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $updatepesan = mysqli_query($con, "UPDATE beli SET status='$status'WHERE id_beli=$id");
    if ($updatepesan) {
        echo "<script type='text/javascript'>alert('Status pesanan diupdate!');</script>";
        echo "<script> window.location.href='pesan.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Status pesanan gagal diupdate!');</script>";
        echo "<script> window.location.href='pesan.php';</script>";
    }
}
