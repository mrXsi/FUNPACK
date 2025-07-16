<?php
session_start();

$conn = new mysqli("localhost", "root", "", "funpack_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>