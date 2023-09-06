<?php
session_start();


$conn = new mysqli("localhost", "root", "", "restoran");


if (empty($_SESSION["keranjang"]) or !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong, silahkan belanja dahulu');</script>";
    echo "<script>location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSP - Keranjang</title>
    <link rel="stylesheet" href="fontawesome-free-6.2.0-web/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    include('navpesan.php');
    ?>
    <br>
    <section class="konten">
        <h4 class="text-center mb-3">Keranjang Anda</h4>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) : ?>
                        <?php
                        $ambil = $conn->query("SELECT * FROM barang WHERE id='$id_produk'");
                        $pecah = $ambil->fetch_assoc();
                        $subharga = $pecah["harga"] * $jumlah;
                        if (isset($_POST['beli'])) {
                            $jumlah = $_POST['jumlah'];
                            $_SESSION["keranjang"][$idb] = $jumlah;

                            echo "<script>alert('produk telah dimasukkan ke keranjang belanja')</script>";
                            echo "<script>location='keranjang.php'</script>";
                        }
                        ?>
                        <tr>
                            <td><?php echo $nomor ?></td>
                            <td><?php echo $pecah["nama"]; ?></td>
                            <td>Rp. <?php echo number_format($pecah["harga"]); ?></td>
                            <td><?php echo $jumlah; ?></td>
                            <td>Rp. <?php echo number_format($subharga); ?></td>
                            <td><a href="hapus-menu.php?id=<?php echo $id_produk ?>" class="btn btn-sm btn-danger">Hapus</a></td>
                        </tr>
                        <?php $nomor++; ?>
                    <?php endforeach ?>
                </tbody>

            </table>
            <div class="mt-3">
                <a href="index.php" class="btn btn-primary">Menu</a>
                <a href="checkout.php" class="btn btn-outline-primary">Checkout</a>
            </div>
        </div>
        </div>
    </section>
</body>

</html>