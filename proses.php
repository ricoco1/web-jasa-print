<?php
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];

// menyeleksi data user dengan username yang sesuai
$login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    // cek peran (level) user
    if (password_verify($_POST['password'], $data['password'])) {
        if ($data['level'] == "Admin") {
            // buat session login dan username
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = "Admin";
            // alihkan ke halaman dashboard admin
            header("location:admin");
        } elseif ($data['level'] == "User") {
            // buat session login dan username
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = "User";
            // alihkan ke halaman dashboard user
            header("location:user");
        } elseif ($data['level'] == "Admin Ruangan") {
            // buat session login dan username untuk Admin Ruangan
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = "Admin Ruangan";
            // alihkan ke halaman dashboard admin ruangan
            header("location:admin_ruangan");
        } else {
            header("location:login.php?pesan=gagal");
        }
    } else {
        header("location:login.php?pesan=gagal");
    }
} else {
    header("location:login.php?pesan=gagal");
}
?>
