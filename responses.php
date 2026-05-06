<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$sql = "SELECT * FROM responses ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Response</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Daftar Response</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Pesan</th>
            <th>File</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['pesan']); ?></td>
            <td>
                <?php if ($row['file_upload']): ?>
                    <a href="download.php?file=<?php echo urlencode($row['file_upload']); ?>">Download</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="dashboard.php"><button>Kembali ke Dashboard</button></a>
</body>
</html>
