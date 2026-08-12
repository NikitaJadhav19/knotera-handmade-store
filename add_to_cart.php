<?php

session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: shop.php");
    exit;
}

$product_id = intval($_POST["product_id"]);

$stmt = $conn->prepare(
    "SELECT id, name, price, stock, image FROM products WHERE id = ?"
);

$stmt->bind_param("i", $product_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: shop.php");
    exit;
}

$product = $result->fetch_assoc();

if ($product["stock"] <= 0) {
    header("Location: shop.php");
    exit;
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (isset($_SESSION["cart"][$product_id])) {

    if ($_SESSION["cart"][$product_id]["quantity"] < $product["stock"]) {
        $_SESSION["cart"][$product_id]["quantity"]++;
    }

} else {

    $_SESSION["cart"][$product_id] = [
        "id" => $product["id"],
        "name" => $product["name"],
        "price" => $product["price"],
        "image" => $product["image"],
        "quantity" => 1
    ];
}

header("Location: cart.php");
exit;