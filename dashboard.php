<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$last_login = isset($_COOKIE['last_login']) ? $_COOKIE['last_login'] : '-';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .navbar { background: #333; padding: 10px; color: white; }
        .navbar a { color: white; text-decoration: none; margin-left: 10px; }
        .info-box { border: 1px solid #ddd; padding: 15px; margin: 20px 0; }
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
</body>
</html>
