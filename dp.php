<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "funpack_db"; // اسم دیتابیست رو بزار همین اگه اینه

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("خطا در اتصال به دیتابیس: " . $conn->connect_error);
}
?>