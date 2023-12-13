<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$harga = 500;
$produk = 'Jasa Print Kertas A4 Hitam';
$ukurankertas='A4';
$jumlah;
$jenis_print='Hitam';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/kertasa4.png" alt="" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <h2><?php echo $produk; ?></h2>
                                <h6>Rp. <?php echo $harga; ?></h6>

                                <div class="container mt-5">
                                    <h2 class="mb-4">Form Pemesanan Jasa Print</h2>
                                    <form action="" method="post">

                                        <!-- Informasi Pengguna -->
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap:</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Alamat Email:</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon:</label>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                required>
                                        </div>

                                        <!-- Pilihan Produk/Format -->
                                        <div class="form-group">
                                            <label for="paper-type">Jenis Kertas:</label>
                                            <select class="form-control" id="paper-type" name="paper_type" required>
                                                <option value="standard">Standard</option>
                                                <option value="premium">Premium</option>
                                                <!-- Tambahkan opsi kertas lainnya sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="paper-size">Ukuran Kertas:</label>
                                            <select class="form-control" id="paper-size" name="paper_size" required>
                                                <option value="A4">A4</option>
                                                <option value="A3">A3</option>
                                                <!-- Tambahkan opsi ukuran kertas lainnya sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Form Unggah Berkas -->
                                        <div class="form-group">
                                            <label for="file">Unggah Berkas (PDF, DOC, JPEG, dsb.):</label>
                                            <input type="file" class="form-control-file" id="file"
                                                name="file" accept=".pdf, .doc, .jpeg, .jpg, .png" required>
                                        </div>

                                        <!-- Form Spesifikasi Cetak -->
                                        <div class="form-group">
                                            <label for="quantity">Jumlah Salinan:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity"
                                                min="1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="print-type">Jenis Cetakan:</label>
                                            <select class="form-control" id="print-type" name="print_type" required>
                                                <option value="black-white">Hitam Putih</option>
                                                <option value="color">Warna</option>
                                                <!-- Tambahkan opsi jenis cetakan lainnya sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Form Tanggal Pengambilan/Pengiriman -->
                                        <div class="form-group">
                                            <label for="pickup-date">Tanggal Pengambilan:</label>
                                            <input type="date" class="form-control" id="pickup-date"
                                                name="pickup_date" required>
                                        </div>

                                        <!-- Form Pembayaran -->
                                        <div class="form-group">
                                            <label for="payment-method">Metode Pembayaran:</label>
                                            <select class="form-control" id="payment-method" name="payment_method"
                                                required>
                                                <option value="credit-card">Kartu Kredit</option>
                                                <option value="bank-transfer">Transfer Bank</option>
                                                <!-- Tambahkan opsi metode pembayaran lainnya sesuai kebutuhan -->
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
