<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>سفارش‌های من | FUN PACK</title>
</head>
<body>
  <h1>سفارش‌های شما به‌زودی اینجا نمایش داده می‌شود :smile:</h1>
</body>
</html>