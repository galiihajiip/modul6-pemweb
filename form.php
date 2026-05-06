<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$sukses = isset($_GET['sukses']) && $_GET['sukses'] == '1';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulir</title>
</head>
<body>
    <h2>Formulir Pengisian</h2>

    <?php if ($sukses): ?>
        <p style="color: green;">Data berhasil disimpan!</p>
    <?php endif; ?>

    <form action="aksi_form.php" method="POST" enctype="multipart/form-data">
        <label>Nama Lengkap:</label><br>
        <input type="text" name="nama_lengkap" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Pesan:</label><br>
        <textarea name="pesan" rows="5" cols="30" required></textarea><br><br>

        <label>Upload File/Gambar:</label><br>
        <input type="file" name="file_upload" accept="image/*,.pdf" required><br><br>

        <button type="submit">Kirim</button>
        <a href="dashboard.php"><button type="button">Kembali</button></a>
    </form>
</body>
</html>
