<?php
// فقط درخواست POST قبول بشه
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // گرفتن اطلاعات از فرم
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $cartData = json_decode($_POST['cartData'], true);

    // بررسی اعتبار اطلاعات ورودی
    if (empty($name)  empty($phone)  empty($address) || empty($cartData)) {
        die("اطلاعات ناقص ارسال شده است.");
    }

    // محاسبه جمع کل سفارش
    $totalAmount = 0;
    foreach ($cartData as $item) {
        if (isset($item['price']) && isset($item['quantity'])) {
            $totalAmount += intval($item['price']) * intval($item['quantity']);
        }
    }

    // ✅ جای مرچنت کد خودتو اینجا وارد کن
    $merchant_id = "اینجا-مرچنت-کد-خودتو-بذار";
    // آدرس برگشت پس از پرداخت موفق (در آینده می‌سازیمش)
    $callback_url = "http://localhost/verify.php"; // بعداً این رو روی دامنه واقعی تغییر بده

    // ساختن درخواست پرداخت به زرین‌پال
    $data = [
        "merchant_id" => $merchant_id,
        "amount" => $totalAmount,
        "callback_url" => $callback_url,
        "description" => "سفارش از فروشگاه FUN PACK توسط $name",
        "metadata" => [
            "mobile" => $phone,
            "address" => $address
        ]
    ];

    $jsonData = json_encode($data);

    // ارسال درخواست به API زرین‌پال
    $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    $response = json_decode($result, true);

    if (!empty($response['data']) && empty($response['errors'])) {
        $authority = $response['data']['authority'];

        // ✅ در آینده می‌تونیم اینجا اطلاعات سفارش رو تو دیتابیس ذخیره کنیم
        /*
        // نمونه اتصال به دیتابیس (در آینده فعال کن)
        include 'config.php'; // اطلاعات اتصال به دیتابیس
        $stmt = $conn->prepare("INSERT INTO orders (name, phone, address, amount, authority, cart_json) VALUES (?, ?, ?, ?, ?, ?)");
        $cart_json = json_encode($cartData, JSON_UNESCAPED_UNICODE);
        $stmt->bind_param("sssiss", $name, $phone, $address, $totalAmount, $authority, $cart_json);
        $stmt->execute();
        */

        // هدایت کاربر به صفحه پرداخت زرین‌پال
        header("Location: https://www.zarinpal.com/pg/StartPay/$authority");
        exit();
    } else {
        $errorMsg = $response['errors']['message'] ?? 'خطای نامشخص در اتصال به درگاه';
        echo "❌ خطا در ایجاد تراکنش: " . $errorMsg;
    }

} else {
    echo "⛔️ دسترسی غیرمجاز!";
}
?>