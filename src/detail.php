<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'restoran');

$id_produk = $_GET["id"];

$ambil = $con->query("SELECT * FROM barang WHERE id=$id_produk");
$detail = $ambil->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSP - Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <?php
    include 'navpesan.php';
    ?>
    <div class="container my-5">
        <h2 class="text-center mb-4">Pesan Sekarang</h2>
        <div class="row">
            <div class="col-3 mb-3">
                <div class="d-flex">
                    <div class="justify-content-center">

                        <div class="card p-1">
                            <div class="d-flex justify-content-center mt-2">
                                <img src="img/<?php echo $detail["gambar"] ?>" width="250" height="auto" class="rounded">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $detail["nama"] ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Rp. <?php echo $detail["harga"] ?></li>
                                <li class="list-group-item">Stok : <?php echo $detail['stok']; ?></li>
                            </ul>
                            <div class="card-body">
                                <form method="post" class="d-flex">
                                    <div class="input-group">
                                        <input type="number" min="1" max="<?php echo $detail['stok']; ?>" class="form-control me-3" name="jumlah">
                                        <div class="input-group-btn">
                                            <button name="beli" class="btn btn-outline-primary"><i class="bi bi-cart4"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                if (isset($_POST['beli'])) {
                                    $jumlah = $_POST['jumlah'];

                                    $_SESSION['keranjang'][$id_produk] += $jumlah;

                                    echo "<script>alert('Menu telah masuk dikeranjang');</script>";
                                    echo "<script>location='keranjang.php';</script>";
                                }
                                ?>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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