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
    <title>LSP - Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>

    <?php
    include('navpesan.php');
    ?>
    <div class="container my-5">
        <h2 class="text-center mb-4">Pesan Sekarang</h2>
        <div class="row">
            <?php
            $query = mysqli_query($con, "SELECT * from barang");
            while ($data = mysqli_fetch_array($query)) {
                $nama = $data['nama'];
                $harga = $data['harga'];
                $stok = $data['stok'];

                $gambar = $data['gambar'];
                if ($gambar == null) {
                    $img = 'No Photo';
                } else {
                    $img = '<img src="img/' . $gambar . '" width="250" height="auto" class="rounded">';
                }
            ?>
                <div class="col-3 mb-3">
                    <div class="card p-1">
                        <div class="d-flex justify-content-center mt-2">
                            <?= $img; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $nama; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Rp. <?= $harga; ?></li>
                            <li class="list-group-item">Stok : <?= $stok; ?></li>
                        </ul>
                        <div class="card-body">
                            <a href="beli.php?id=<?php echo $data['id']; ?>"><button name="beli" class="btn btn-primary">Beli!</button></a>
                            <a href="detail.php?id=<?php echo $data['id']; ?>"><button name="beli" class="btn btn-outline-primary">Detail</button></a>
                        </div>
                    </div>
                </div>
            <?php



            };
            ?>
        </div>
    </div>
</body>
<script>
    function increaseValue() {
        var value = parseInt(document.getElementById('number-input').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('number-input').value = value;
    }

    function decreaseValue() {
        var value = parseInt(document.getElementById('number-input').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById('number-input').value = value;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</html>