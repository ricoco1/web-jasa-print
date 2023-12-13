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

// Query untuk mengambil data dari tabel users
$query = "SELECT * FROM users";
$result = $koneksi->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../gambar/logo1.png" type="image/png">
    <title>Data User</title>
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
                        <h3 align="left" class="pt-4">Data User</h3>
                        <table class="table table-bordered">
                            <tr class="table-light" style="text-align:center;">
                                <th>No</th>
                                <th>ID User</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Nohp</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            // Cek apakah query berhasil dieksekusi
                            if ($result) {
                                // Cek apakah ada data
                                if ($result->num_rows > 0) {
                                    $nomor = 1;
                                    while ($data = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$nomor}</td>";
                                        echo "<td>{$data['user_id']}</td>";
                                        echo "<td>{$data['username']}</td>";
                                        echo "<td>{$data['full_name']}</td>";
                                        echo "<td>{$data['email']}</td>";
                                        echo "<td>{$data['phone']}</td>";
                                        echo "<td>{$data['address']}</td>";
                                        echo "<td>{$data['role']}</td>";
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
                                        echo "</tr>";
                                        $nomor++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Tidak ada data user.</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>Error: " . $conn->error . "</td></tr>";
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
