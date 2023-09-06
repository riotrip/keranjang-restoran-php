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
    <title>LSP - Checkout</title>
    <link rel="stylesheet" href="fontawesome-free-6.2.0-web/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    include('navpesan.php');
    ?>
    <br>
    <section class="konten">
    <h4 class="text-center mb-3">Checkout</h4>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php $totalbelanja = 0; ?>
                    <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) : ?>
                        <?php
                        $ambil = $conn->query("SELECT * FROM barang WHERE id='$id_produk'");
                        $pecah = $ambil->fetch_assoc();
                        $subharga = $pecah["harga"] * $jumlah;
                        if (isset($_POST['beli'])) {
                            // mendapatkan jumlah yg dibeli
                            $jumlah = $_POST['jumlah'];
                            // masukkan ke keranjang belanja
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
                        </tr>
                        <?php $nomor++; ?>
                        <?php $totalbelanja += $subharga; ?>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total belanja</th>
                        <th>Rp. <?php echo number_format($totalbelanja) ?></th>
                    </tr>
                </tfoot>

            </table>
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select id="alamat" class="form-control" name="makan_dimana" required>
                                <option value="">Dine In atau Delivery Order?</option>
                                <option value="DineIn">
                                    Dine In
                                </option>
                                <option value="DeliveryOrder">
                                    Delivery Order
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" id="nama">Atas Nama :</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama"></input>
                    </div>
                    <div class="col-6">
                        <label class="form-label" id="nohp">No Telepon :</label>
                        <input type="number" class="form-control" name="nohp" placeholder="Masukkan No Telepon"></input>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="form-label" id="alamat">Alamat Pengiriman :</label>
                        <textarea class="form-control" name="alamat_pengiriman" rows="3" placeholder="Masukkan Alamat"></textarea>
                    </div>
                </div>
                <div class="mt-3">
                    <button name="checkout" class="btn btn-outline-primary">Checkout</button>
                </div>
            </form>
            

            <?php
            if (isset($_POST["checkout"])) {
                $pelanggan = $_POST["nama"];
                $nohp = $_POST["nohp"];
                $jenis = $_POST["makan_dimana"];
                $alamat_pengiriman = $_POST['alamat_pengiriman'];
                $status = "Diproses";
                $tanggal = date("Y-m-d");

                $conn->query("INSERT INTO beli (nama,nohp,alamat,jenis,status,tanggal,total) VALUES ('$pelanggan','$nohp','$alamat_pengiriman','$jenis','$status','$tanggal','$totalbelanja') ");

                    $id_pembelian_barusan = mysqli_insert_id($conn);

                foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) {
                    $conn->query("INSERT INTO pembelian (id_beli,id_produk,jumlah) VALUES ('$id_pembelian_barusan','$id_produk','$jumlah') ");
                    mysqli_query($conn, "UPDATE barang SET stok=stok-$jumlah WHERE id='$id_produk'");
                }

                unset($_SESSION["keranjang"]);

                echo "<script>alert('Pembelian Sukses');</script>";
                echo "<script> window.location.href='pesanan.php;</script>";
            }

            ?>

        </div>
        </div>
    </section>
</body>
<script>
    const selectElement = document.getElementById('alamat');

    selectElement.addEventListener('change', (event) => {
        const textareaElement = document.getElementsByName('alamat_pengiriman')[0];
        const hp = document.getElementsByName('nohp')[0];

        if (event.target.value === 'DineIn') {
            textareaElement.disabled = true;
            hp.disabled = true;
        } else {
            textareaElement.disabled = false;
            hp.disabled = false;
        }
    });
</script>

</html>