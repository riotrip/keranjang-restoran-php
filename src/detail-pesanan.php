<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'restoran');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script>
        function prosesPesan() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("cariPsn");
            filter = input.value.toUpperCase();
            table = document.getElementById("daftarPesan");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>

<body>

    <?php
    include('navpesan.php');
    ?>

    <div class="container py-5">
        <h3 class="text-center">Pesanan Masuk</h3>
        <div class="my-5">
            <form class="d-flex mb-3" role="search">
                <input class="form-control me-2" onkeyup="prosesPesan()" id="cariPsn" type="text" placeholder="Search" aria-label="Search">
            </form>
            <table class="table table-bordered border-dark" id="daftarPesan">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $ambil = $con->query("SELECT * FROM beli JOIN pembelian ON beli.id_beli=pembelian.id_beli
                    JOIN barang ON pembelian.id_produk=barang.id WHERE beli.id_beli='$_GET[id]'"); ?>
                    <tr>
                        <?php $dapat = $con->query("SELECT * FROM beli JOIN pembelian ON beli.id_beli=pembelian.id_beli WHERE beli.id_beli='$_GET[id]'"); ?>
                        <?php while ($fetch = $dapat->fetch_assoc()) { ?>
                            <td><?php echo $fetch['nama'] ?></td>
                        <?php } ?>
                        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                            <td><?php echo $pecah['tanggal'] ?></td>
                            <td><?php echo $pecah['nama'] ?></td>
                            <td><?php echo $pecah['jumlah'] ?></td>
                            <td><?php echo $pecah['harga'] * $pecah['jumlah'] ?></td>
                    </tr>
                <?php
                        }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</html>