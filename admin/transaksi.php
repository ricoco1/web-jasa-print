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

// Query untuk mengambil data dari tabel users, transactions, details_transactions, dan uploaded_files
$query = "SELECT users.*, transactions.transaction_id, transactions.transaction_date, 
                 transaction_details.product_name, transaction_details.quantity, transaction_details.unit_price,
                 transaction_details.subtotal, transactions.payment_method, uploaded_files.bukti_pembayaran,
                 uploaded_files.file_name
          FROM users
          LEFT JOIN transactions ON users.user_id = transactions.user_id
          LEFT JOIN transaction_details ON transactions.transaction_id = transaction_details.transaction_id
          LEFT JOIN uploaded_files ON transactions.user_id = uploaded_files.user_id AND transactions.transaction_id = uploaded_files.transaction_id";
$result = $koneksi->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../gambar/logo1.png" type="image/png">
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b3f6ad813f.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'admin_sidebar.php'; ?>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive px-4">
                        <h3 align="left" class="pt-4">Data Transaksi</h3>
                        <table class="table table-bordered">
                            <tr class="table-light" style="text-align:center;">
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Nohp</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Transaksi ID</th>
                                <th>Tanggal Transaksi</th>
                                <th>Produk</th>
                                <th>Kuantiti</th>
                                <th>Harga Produk</th>
                                <th>Total</th>
                                <th>Metode Pembayaran</th>
                                <th>Bukti Pembayaran</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            if ($result) {
                                if ($result->num_rows > 0) {
                                    $nomor = 1;
                                    while ($data = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo "<td>{$nomor}</td>";
                                        echo "<td>{$data['full_name']}</td>";
                                        echo "<td>{$data['email']}</td>";
                                        echo "<td>{$data['phone']}</td>";
                                        echo "<td>{$data['address']}</td>";
                                        echo "<td>{$data['role']}</td>";
                                        echo "<td>{$data['transaction_id']}</td>";
                                        echo "<td>{$data['transaction_date']}</td>";
                                        echo "<td>{$data['product_name']}</td>";
                                        echo "<td>{$data['quantity']}</td>";
                                        echo "<td>{$data['unit_price']}</td>";
                                        echo "<td>{$data['subtotal']}</td>";
                                        echo "<td>{$data['payment_method']}</td>";
                                        echo "<td><a href='tampil_data.php?file_type=bukti_pembayaran&file_name={$data['bukti_pembayaran']}' target='_blank'>{$data['bukti_pembayaran']}</a></td>";
                                        echo "<td><a href='tampil_data.php?file_type=file_print&file_name={$data['file_name']}' target='_blank'>{$data['file_name']}</a></td>";
                            
                                        echo "<td>
                                                                                                                                    <a href='datauser_ubah.php?user_id={$data['user_id']}' class='btn btn-info'>
                                                                                                                                        <img src='../assets/images/edit.png' alt='edit'>
                                                                                                                                    </a>
                                                                                                                                    <a href='#' class='btn btn-danger' onclick='setDeleteLink({$data['user_id']})' 
                                                                                                                                        data-bs-toggle='modal' data-bs-target='#deleteModal' 
                                                                                                                                        style='align-content: center; padding-left: 8px; padding-right: 8px;'>
                                                                                                                                        <img src='../assets/images/hapus.png' alt='hapus'>
                                                                                                                                    </a>
                                                                                                                                  </td>";
                                        echo '</tr>';
                                        $nomor++;
                                    }
                                } else {
                                    echo "<tr><td colspan='18'>Tidak ada data user.</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='18'>Error: " . $conn->error . '</td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script>
        function setDeleteLink(idUser) {
            var deleteUrl = "datauser_hapus.php?id_user=" + idUser;
            document.getElementById('deleteLink').setAttribute('href', deleteUrl);
        }
    </script>
</body>

</html>
