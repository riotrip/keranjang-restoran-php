    <?php
    require 'function.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>List Barang</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <script>
            function prosesBarang() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("cariBar");
                filter = input.value.toUpperCase();
                table = document.getElementById("daftarBarang");
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
            <h3 class="text-center">List Barang</h3>
            <div class="my-5">
                <form class="d-flex mb-3" role="search">
                    <input class="form-control me-2" onkeyup="prosesBarang()" id="cariBar" type="text" placeholder="Search" aria-label="Search">
                </form>
                <table class="table table-bordered border-dark" id="daftarBarang">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Gambar</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $query = mysqli_query($con, "SELECT * from barang");
                            while ($data = mysqli_fetch_array($query)) {
                                $id = $data['id'];
                                $nama = $data['nama'];
                                $harga = $data['harga'];
                                $stok = $data['stok'];

                                $gambar = $data['gambar'];
                                if ($gambar == null) {
                                    $img = 'No Photo';
                                } else {
                                    $img = '<img src="../img/' . $gambar . '" width="150" height="auto">';
                                }
                            ?>
                        <tr>
                            <td><?= $nama; ?></td>
                            <td><?= $img; ?></td>
                            <td><?= $harga; ?></td>
                            <td><?= $stok; ?></td>
                            <td>
                                <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#edit<?= $id; ?>">Edit</button>
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete<?= $id; ?>">Delete</button>
                            </td>
                        </tr>
                        <!-- The Modal Edit -->
                        <div class="modal" id="edit<?= $id; ?>">
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
                                            <input type="text" name="produk" placeholder="Jenis Produk" value="<?= $nama; ?>" class="form-control mb-2" required>
                                            <br>
                                            <input type="number" name="harga" placeholder="Harga Produk" value="<?= $harga; ?>" class="form-control mb-2" required>
                                            <br>
                                            <input type="number" name="stok" placeholder="Stok Produk" value="<?= $stok; ?>" class="form-control mb-2" required>
                                            <br>
                                            <input type="file" id="gambar" name="gambar" class="form-control mb-2">
                                            <br>
                                            <input type="hidden" name="id" value="<?= $id; ?>">
                                            <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                        </div>
                                    </form>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- The Modal Delete -->
                        <div class="modal" id="delete<?= $id; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus Barang</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="post" action="function.php">
                                        <div class="modal-body">
                                            Apakah anda ingin menghapus <br>"<?= $nama; ?>"
                                            <input type="hidden" name="id" value="<?= $id; ?>">
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-danger" name="deletebarang">Hapus</button>
                                        </div>
                                    </form>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php
                            };
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

    </html>