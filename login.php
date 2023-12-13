<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">Login Pengguna</div>
                                    <div class="card-body">
                                        <!-- Form Login -->
                                        <form action="proses_login.php" method="POST">
                                            <!-- Nama Pengguna -->
                                            <div class="form-group">
                                                <label for="username">Nama Pengguna:</label>
                                                <input type="text" class="form-control" id="username"
                                                    name="username" required>
                                            </div>

                                            <!-- Kata Sandi -->
                                            <div class="form-group">
                                                <label for="password">Kata Sandi:</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div>

                                            <!-- Tombol Submit -->
                                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>

                                            <!-- Link untuk Registrasi -->
                                            <div class="text-center mt-3">
                                                <small>Belum punya akun? <a href="register.php">Daftar di
                                                        sini</a></small>
                                            </div>
                                        </form>
                                        <!-- Akhir Form Login -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS dan Popper.js (Diperlukan untuk Dropdown, Modal, dsb.) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
