<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$last_login = isset($_COOKIE['last_login']) ? $_COOKIE['last_login'] : '-';

// Query history submissions
$stmt = $conn->prepare("SELECT nama_lengkap, email, pesan, file_upload, created_at FROM responses WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$history = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .navbar { background: #333; padding: 10px; color: white; }
        .navbar a { color: white; text-decoration: none; margin-left: 10px; }
        .info-box { border: 1px solid #ddd; padding: 15px; margin: 20px 0; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="navbar">
        <span>Selamat datang, <?php echo htmlspecialchars($username); ?>!</span>
        <a href="logout.php">Logout</a>
    </div>

    <h2>Dashboard</h2>

    <div class="info-box">
        <h3>Info Session & Cookie</h3>
        <p><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Last Login:</strong> <?php echo htmlspecialchars($last_login); ?></p>
    </div>

    <a href="form.php"><button>Isi Formulir</button></a>
    <a href="responses.php"><button>Lihat Semua Response</button></a>

    <h3>Riwayat Submit Anda</h3>
    <?php if ($history->num_rows > 0): ?>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>File</th>
                <th>Tanggal</th>
            </tr>
            <?php $no = 1; while ($row = $history->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['pesan']); ?></td>
                <td><?php echo $row['file_upload'] ? '<a href="download.php?file='.urlencode($row['file_upload']).'">Download</a>' : '-'; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Belum ada data yang disubmit.</p>
    <?php endif; ?>
</body>
</html>
