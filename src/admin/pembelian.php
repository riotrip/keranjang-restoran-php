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
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <h2>Data Pembelian</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Tanggal</th>
                <th>Jenis Layanan</th>
                <th>Status Pembelian</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1; ?>
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
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['nama']; ?></td>
                    <td><?=$hp?></td>
                    <td><?=$address?></td>
                    <td><?php echo $pecah['tanggal']; ?></td>
                    <td><?php echo $pecah['jenis']; ?></td>
                    <td><?php echo $pecah['status']; ?></td>
                    <td><?php echo $pecah['total']; ?></td>
                    <td>
                        <a href="index.php?halaman=detail&id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-info">Detail </a>
                    </td>
                </tr>
                <?php $nomor++; ?>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>