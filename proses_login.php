<?php
session_start();

// Pastikan skrip ini hanya diakses setelah pengguna mengirimkan formulir login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simpan data login ke database (contoh menggunakan MySQLi)
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "db_jasa_print";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Tambahkan kolom full_name pada kueri
    $stmt = $conn->prepare("SELECT user_id, username, password, full_name, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $db_password, $db_full_name, $user_role);
        $stmt->fetch();

        // Verifikasi kata sandi
        if (password_verify($password, $db_password)) {
            // Kata sandi cocok, masukkan informasi pengguna ke sesi
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['role'] = $user_role;
            $_SESSION['full_name'] = $db_full_name;

            // Tentukan halaman berdasarkan peran (role)
            if ($user_role === 'Admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
            exit();
        } else {
            // Kata sandi tidak cocok
            header("Location: login.php?error=invalid_password");
            exit();
        }
    } else {
        // Pengguna tidak ditemukan
        header("Location: login.php?error=user_not_found");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Jika skrip diakses secara langsung tanpa melalui formulir, alihkan ke halaman login
    header("Location: login.php");
    exit();
}
?>
