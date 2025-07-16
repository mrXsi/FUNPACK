<?php
require 'database.php';

$phone = $_POST['phone'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // بررسی رمز (استفاده از sha256 چون در دیتابیس همینجوریه)
    if (hash('sha256', $password) === $row['password']) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['phone'] = $phone;
        header("Location: panel.php");
        exit;
    }
}

header("Location: login.php?error=1");