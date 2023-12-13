<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrasi Pengguna</title>
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
                                    <div class="card-header">Registrasi Pengguna</div>
                                    <div class="card-body">
                                        <!-- Form Registrasi -->
                                        <form action="proses_registrasi.php" method="POST">
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

                                            <!-- Konfirmasi Kata Sandi -->
                                            <div class="form-group">
                                                <label for="confirm_password">Konfirmasi Kata Sandi:</label>
                                                <input type="password" class="form-control" id="confirm_password"
                                                    name="confirm_password" required>
                                            </div>

                                            <!-- Nama Lengkap -->
                                            <div class="form-group">
                                                <label for="full_name">Nama Lengkap:</label>
                                                <input type="text" class="form-control" id="full_name"
                                                    name="full_name" required>
                                            </div>

                                            <!-- Alamat Email -->
                                            <div class="form-group">
                                                <label for="email">Alamat Email:</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>

                                            <!-- Nomor Telepon -->
                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon:</label>
                                                <input type="tel" class="form-control" id="phone"
                                                    name="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Role:</label>
                                                <select class="form-control" id="role" name="role" required>
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Alamat:</label>
                                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                var pesan = '<?php echo $pesan; ?>';
                var classToast = '<?php echo $class; ?>';

                var toast = document.getElementById('pesanToast');
                var toastOption = {
                    animation: true,
                    autohide: true,
                    delay: 4000
                };

                if (pesan !== '') {
                    toast.innerHTML = pesan;
                    toast.classList.add('alert', classToast, 'position-fixed', 'end-0', 'm-1');
                    var bsToast = new bootstrap.Toast(toast, toastOption);
                    bsToast.show();
                }
            });
        </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
