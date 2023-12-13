<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    // Validasi data
    if ($password !== $confirmPassword) {
        // Kata sandi dan konfirmasi kata sandi tidak cocok
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    // Hash kata sandi sebelum menyimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Koneksi ke database
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "db_jasa_print";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Validasi nama pengguna
    $checkUsernameQuery = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUsernameQuery->bind_param("s", $username);
    $checkUsernameQuery->execute();
    $checkUsernameResult = $checkUsernameQuery->get_result();

    if ($checkUsernameResult->num_rows > 0) {
        // Nama pengguna sudah ada
        header("Location: register.php?error=username_exists");
        exit();
    }

    // Validasi email
    $checkEmailQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $checkEmailResult = $checkEmailQuery->get_result();

    if ($checkEmailResult->num_rows > 0) {
        // Email sudah terdaftar
        header("Location: register.php?error=email_exists");
        exit();
    }

    // Jika nama pengguna dan email unik, lanjutkan dengan registrasi
    $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, email, phone, address, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $hashedPassword, $fullName, $email, $phone, $address, $role);

    if ($stmt->execute()) {
        // Registrasi berhasil
        header("Location: login.php?success=registration_successful");
        exit();
    } else {
        // Gagal menyimpan data ke database
        header("Location: register.php?error=registration_failed");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: register.php");
    exit();
}
?>
