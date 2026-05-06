<?php
session_start();
require_once 'koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    
    setcookie('last_login', date('Y-m-d H:i:s'), time() + 3600, '/');
    
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: index.php?error=1");
    exit;
}
?>
