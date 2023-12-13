<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$transaction_date = $_POST['pickup_date'];
$payment_method = $_POST['payment_method'];
$proof_of_payment = $_FILES['proof_of_payment']['name'];

$quantity = $_POST['quantity'];
$unit_price = 1000;
$product_name = 'Jasa Print Kertas A4 Warna';
$subtotal = $quantity * $unit_price;

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'db_jasa_print';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die('Koneksi database gagal: ' . $conn->connect_error);
}

$sqlTransactions = "INSERT INTO transactions (user_id, transaction_date, total_amount, payment_method)
                   VALUES ('$user_id', '$transaction_date', '$subtotal', '$payment_method')";

if ($conn->query($sqlTransactions) === true) {
    $transaction_id = $conn->insert_id;

    $sqlTransactionDetails = "INSERT INTO transaction_details (transaction_id, product_name, quantity, unit_price, subtotal)
                              VALUES ('$transaction_id', '$product_name', '$quantity', '$unit_price', '$subtotal')";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];

    $uploadDirectory = "../file_print/";

    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = pathinfo($file["name"], PATHINFO_FILENAME);
    $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $randomFileName = uniqid($fileName . '_') . '.' . $fileExtension;
    $targetPath = $uploadDirectory . $randomFileName;

    if (move_uploaded_file($file["tmp_name"], $targetPath)) {
        echo "File berhasil diunggah dengan nama acak: $randomFileName";
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["proof_of_payment"])) {
    $berkas = $_FILES["proof_of_payment"];

    $uploadDirectoryPembayaran = "../bukti_pembayaran/";

    if (!file_exists($uploadDirectoryPembayaran)) {
        mkdir($uploadDirectoryPembayaran, 0777, true);
    }

    $fileExtension = pathinfo($berkas["name"], PATHINFO_EXTENSION);

    $randomFile = uniqid() . '.' . $fileExtension;

    $tujuan = $uploadDirectoryPembayaran . $randomFile;

    if (move_uploaded_file($berkas["tmp_name"], $tujuan)) {
        echo "File berhasil diunggah dengan nama acak: $randomFile";
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}
$metodePembayaran = $_POST['payment_method'];
if ($metodePembayaran === 'e-wallet') {
    // Cek apakah bukti pembayaran sudah ada sebelumnya
    $queryCheck = "SELECT COUNT(*) AS count FROM uploaded_files WHERE user_id = '$user_id' AND transaction_id = '$transaction_id'";
    $resultCheck = $koneksi->query($queryCheck);

    if ($resultCheck->num_rows > 0) {
        $row = $resultCheck->fetch_assoc();
        $count = $row['count'];

        if ($count == 0) {
            // Jika belum ada, lakukan upload
            $query = "INSERT INTO uploaded_files (user_id, transaction_id, file_name, bukti_pembayaran) VALUES ('$user_id', '$transaction_id', '$randomFileName', '$randomFile')";

            if ($koneksi->query($query) === true) {
                echo "File berhasil diunggah dengan nama acak: $randomFileName";
            } else {
                echo 'Error: ' . $query . '<br>' . $koneksi->error;
            }
        } else {
            echo "Bukti pembayaran sudah ada sebelumnya.";
        }
    } else {
        echo 'Error: ' . $queryCheck . '<br>' . $koneksi->error;
    }
} else if ($metodePembayaran === 'COD') {
    $query = "INSERT INTO uploaded_files (user_id, transaction_id, file_name, bukti_pembayaran) VALUES ('$user_id', '$transaction_id', '$randomFileName', 'Bayar COD')";

    if ($koneksi->query($query) === true) {
        echo "File berhasil diunggah dengan nama acak: $randomFileName";
    } else {
        echo 'Error: ' . $query . '<br>' . $koneksi->error;
    }
}

    if ($koneksi->query($query) === true) {
        echo 'berhasil simpan data';
    } else {
        echo 'Error: ' . $query . '<br>' . $koneksi->error;
    }

    if ($conn->query($sqlTransactionDetails) === true) {
        header('Location: ../user/index.php');  // Redirect ke halaman index.php setelah data disimpan
        exit();
    } else {
        echo 'Error: ' . $sqlTransactionDetails . '<br>' . $conn->error;
    }
} else {
    echo 'Error: ' . $sqlTransactions . '<br>' . $conn->error;
}

$conn->close();
?>
