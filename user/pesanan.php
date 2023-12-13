<?php
include '../koneksi.php';

session_start();
if (isset($_SESSION['username']) != 'Admin') {
    header('location:../index.php');
} elseif (!isset($_SESSION['username'])) {
    header('location:../index.php');
}

if ($koneksi->connect_error) {
    die('Koneksi database gagal: ' . $koneksi->connect_error);
}
$user_id = $_SESSION['user_id'];

$query = "SELECT transaction_details.*, users.full_name
          FROM transaction_details
          INNER JOIN transactions ON transaction_details.transaction_id = transactions.transaction_id
          INNER JOIN users ON transactions.user_id = users.user_id
          WHERE users.user_id = '$user_id'";
$result = $koneksi->query($query);

// Inisialisasi array untuk menampung data transaction details
$transactionDetails = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactionDetails[] = $row;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include 'user_sidebar.php'; ?>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="container mt-5">
                        <h2>Data Detail Transaksi</h2>
                        <ul class="list-group">
                            <?php foreach ($transactionDetails as $detail) : ?>
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Transaksi ID: <?php echo $detail['transaction_id']; ?></h5>
                                    <small>Tanggal: <?php echo $detail['created_at']; ?></small>
                                </div>
                                <p class="mb-1">Produk: <?php echo $detail['product_name']; ?></p>
                                <p class="mb-1">Jumlah: <?php echo $detail['quantity']; ?></p>
                                <p class="mb-1">Harga Produk: <?php echo $detail['unit_price']; ?></p>
                                <p class="mb-1">Total Harga: <?php echo $detail['subtotal']; ?></p>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
