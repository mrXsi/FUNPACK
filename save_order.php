<?php
session_start();
include 'db.php'; // اتصال به دیتابیس

if (!isset($_SESSION['user_id'])) {
    die("شما وارد نشده‌اید.");
}

// دریافت داده‌های JSON ارسال‌شده از جاوااسکریپت
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['orders'])) {
    $orders = $data['orders'];
    $user_id = $_SESSION['user_id'];

    foreach ($orders as $order) {
        $name = $order['name'];
        $model = $order['model'];
        $color = $order['color'];
        $price = $order['price'];
        $image = $order['image'];

        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_name, model, color, price, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $user_id, $name, $model, $color, $price, $image);
        $stmt->execute();
    }

    echo ":white_check_mark: سفارش‌ها با موفقیت ذخیره شدند!";
} else {
    echo ":no_entry: هیچ سفارشی دریافت نشد.";
}
?>