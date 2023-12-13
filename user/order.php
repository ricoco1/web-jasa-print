<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$harga = 500;
$produk = 'Jasa Print Kertas A4 Hitam';
$ukurankertas = 'A4';
$jumlah;
$jenis_print = 'Hitam';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>

<body>
    <?php include 'user_sidebar.php'; ?>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="../images/kertasa4.png" alt="" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <h2><?php echo $produk; ?></h2>
                                <h6>Rp. <?php echo $harga; ?></h6>

                                <div class="container mt-5">
                                    <h2 class="mb-4">Form Pemesanan Jasa Print</h2>
                                    <form action="order_proses.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="quantity">Jumlah Salinan:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity"
                                                min="1" required onchange="updateTotal()">
                                        </div>
                                        <div class="form-group">
                                            <label for="pickup-date">Tanggal Pengambilan:</label>
                                            <input type="date" class="form-control" id="pickup-date"
                                                name="pickup_date" required>
                                        </div>

                                        <input type="hidden" id="harga-produk" name="harga_produk" value="500">
                                        <div class="form-group">
                                            <label for="payment-method">Metode Pembayaran:</label>
                                            <select class="form-control" id="payment-method" name="payment_method"
                                                onchange="togglePaymentForm(this.value)" required>
                                                <option value="COD">Bayar COD</option>
                                                </option>
                                                <option value="e-wallet">E-Wallet - Gopay,Dana,Shopeepay (0895620543225)
                                                </option>
                                            </select>
                                        </div>
                                        <div id="upload-form" style="display: none;">
                                            <div class="form-group">
                                                <label for="proof-of-payment">Unggah Bukti Pembayaran:</label>
                                                <input type="file" class="form-control" id="proof-of-payment"
                                                    name="proof_of_payment">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="file">Unggah Berkas (PDF, DOC, JPEG, dsb.):</label>
                                            <input type="file" class="form-control" id="file" name="file"
                                                accept=".pdf, .doc, .jpeg, .jpg, .png" required>
                                        </div>
                                        <div id="total-biaya">Total Biaya: Rp 0</div>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function togglePaymentForm(paymentMethod) {
                var uploadForm = document.getElementById('upload-form');

                if (paymentMethod === 'e-wallet') {
                    uploadForm.style.display = 'block';
                } else {
                    uploadForm.style.display = 'none';
                }
            }

            function updateTotal() {
                var quantity = document.getElementById('quantity').value;
                var hargaProduk = document.getElementById('harga-produk').value;

                var totalBiaya = quantity * hargaProduk;
                document.getElementById('total-biaya').innerText = 'Total Biaya: Rp ' + totalBiaya.toLocaleString();
            }
        </script>
</body>

</html>
