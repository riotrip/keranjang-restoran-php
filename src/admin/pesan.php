<?php
require 'function.php';
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
    include('navbar.php');
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
                        <th>Status Pembelian</th>
                        <th>Nama Pelanggan</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                        <th>Jenis Layanan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $ambil = mysqli_query($con, "SELECT * FROM beli"); ?>
                    <?php while ($pecah = mysqli_fetch_assoc($ambil)) { ?>
                        <?php
                        $nohp = $pecah['nohp'];
                        if ($nohp == 0) {
                            $hp = 'Tidak Ada No HP';
                        } else {
                            $hp = $nohp;
                        }
                        $alamat = $pecah['alamat'];
                        if ($alamat == null) {
                            $address = 'Tidak Ada Alamat';
                        } else {
                            $address = $alamat;
                        }
                        ?>
                        <tr>
                            <td><?php echo $pecah['status']; ?></td>
                            <td><?php echo $pecah['nama']; ?></td>
                            <td><?= $hp ?></td>
                            <td><?= $address ?></td>
                            <td><?php echo $pecah['tanggal']; ?></td>
                            <td><?php echo $pecah['jenis']; ?></td>
                            <td><?php echo $pecah['total']; ?></td>
                            <td>
                                <a href="detail.php?halaman=detail&id=<?php echo $pecah['id_beli']; ?>" class="btn btn-info">Detail </a>
                                <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $pecah['id_beli']; ?>">Edit</button>
                            </td>
                        </tr>
                        <!-- The Modal Edit -->
                        <div class="modal" id="edit<?php echo $pecah['id_beli']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Barang</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="post" action="function.php" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <label>Ubah Status Pesanan: </label>
                                            <select name="status" class="form-control my-3">
                                                <option value="Diproses">Diproses</option>
                                                <option value="Selesai">Selesai</option>
                                            </select>
                                            <input type="hidden" name="id" value="<?php echo $pecah['id_beli']; ?>">
                                            <button type="submit" class="btn btn-primary" name="updatepesan">Submit</button>
                                        </div>
                                    </form>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</html>