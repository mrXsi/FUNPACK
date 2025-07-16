<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}

// اطلاعات کاربر لاگین شده
$phone = $_SESSION['phone'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>پنل کاربری | FUN PACK</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css" rel="stylesheet" />
  <style>
    body {
      font-family: Vazir, sans-serif;
      background-color: #f9fafb;
    }
  </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-4">

  <div class="bg-white shadow-lg rounded-2xl p-8 max-w-md w-full text-center">
    <h1 class="text-2xl font-bold mb-4 text-yellow-500">سلام! خوش آمدید :tada:</h1>
    <p class="text-gray-700 mb-6">شماره شما: <span class="font-semibold text-blue-600"><?= htmlspecialchars($phone) ?></span></p>

    <div class="flex flex-col gap-4">
      <a href="cart.php" class="bg-green-500 hover:bg-green-600 text-white py-2 rounded-xl">🛒 مشاهده سبد خرید</a>
      <a href="orders.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-xl">:package: مشاهده سفارش‌ها</a>
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl">:door: خروج از حساب</a>
    </div>
  </div>

</body>
</html>