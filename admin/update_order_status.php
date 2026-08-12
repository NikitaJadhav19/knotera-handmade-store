<?php

session_start();

require_once "../config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: orders.php");
    exit;
}

$order_id = intval($_POST["order_id"] ?? 0);
$order_status = trim($_POST["order_status"] ?? "");

$allowed_statuses = [
    "Placed",
    "Confirmed",
    "Processing",
    "Shipped",
    "Delivered",
    "Cancelled"
];

if (
    $order_id <= 0 ||
    !in_array($order_status, $allowed_statuses, true)
) {
    die("Invalid order status.");
}

$stmt = $conn->prepare(
    "UPDATE orders
     SET order_status = ?
     WHERE id = ?"
);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param(
    "si",
    $order_status,
    $order_id
);

$stmt->execute();

$stmt->close();

header("Location: orders.php?updated=1");
exit;