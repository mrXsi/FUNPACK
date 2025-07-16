<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // بررسی اینکه شماره قبلاً ثبت نشده باشه
    $check = $conn->prepare("SELECT id FROM users WHERE phone = ?");
    $check->bind_param("s", $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo ":warning:️ این شماره قبلاً ثبت شده است.";
    } else {
        // ذخیره در دیتابیس
        $stmt = $conn->prepare("INSERT INTO users (phone, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $phone, $password);

        if ($stmt->execute()) {
            echo ":white_check_mark: ثبت‌نام با موفقیت انجام شد. اکنون می‌توانید وارد شوید.";
            // می‌تونی اینجا ریدایرکت هم بزنی:
            // header("Location: login.html");
        } else {
            echo ":no_entry: خطا در ثبت‌نام: " . $stmt->error;
        }
    }
}
?>