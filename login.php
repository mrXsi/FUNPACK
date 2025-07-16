<?php
session_start();

// اتصال به دیتابیس
$conn = new mysqli("localhost", "root", "", "funpack_db");
if ($conn->connect_error) {
  die("اتصال ناموفق: " . $conn->connect_error);
}

// دریافت شماره و رمز
$phone = $_POST['phone'];
$password = $_POST['password'];

// جستجو در جدول
$sql = "SELECT * FROM users WHERE phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // بررسی رمز (رمز هش شده با SHA2)
  if (hash("sha256", $password) === $user['password']) {
    // ورود موفق
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['phone'] = $user['phone'];
    header("Location: panel.php");
    exit();
  } else {
    echo ":x: رمز عبور اشتباه است.";
  }
} else {
  echo ":x: شماره پیدا نشد.";
}
?>