<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$nama_lengkap = $_POST['nama_lengkap'] ?? '';
$email = $_POST['email'] ?? '';
$pesan = $_POST['pesan'] ?? '';
$user_id = $_SESSION['user_id'];

$file_upload = null;

if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    $max_size = 2 * 1024 * 1024; // 2MB

    $file = $_FILES['file_upload'];
    $filename = $file['name'];
    $filesize = $file['size'];
    $tmp_name = $file['tmp_name'];

    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        die("Ekstensi file tidak diizinkan. Hanya: jpg, jpeg, png, gif, pdf");
    }

    if ($filesize > $max_size) {
        die("Ukuran file maksimal 2MB");
    }

    $new_filename = uniqid() . '.' . $ext;
    $upload_dir = 'uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
        $file_upload = $new_filename;
    } else {
        die("Gagal mengupload file");
    }
}

$stmt = $conn->prepare("INSERT INTO responses (user_id, nama_lengkap, email, pesan, file_upload) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $user_id, $nama_lengkap, $email, $pesan, $file_upload);

if ($stmt->execute()) {
    header("Location: form.php?sukses=1");
    exit;
} else {
    die("Gagal menyimpan data: " . $conn->error);
}
?>
