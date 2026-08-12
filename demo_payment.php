```php
<?php

session_start();

require_once "config.php";


/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: auth/login.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| PENDING ORDER CHECK
|--------------------------------------------------------------------------
*/

$order_id =
    $_SESSION["pending_order_id"] ?? 0;

$total =
    $_SESSION["pending_order_total"] ?? 0;


if (!$order_id || !$total) {

    header("Location: cart.php");
    exit;

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Online Payment | Knotera</title>

<link rel="stylesheet" href="style.css">


<style>

.payment-container {

    max-width:600px;

    margin:70px auto;

    padding:20px;

}


.payment-card {

    background:white;

    padding:40px;

    border-radius:25px;

    border:1px solid #eadfd5;

    box-shadow:
        0 8px 30px rgba(0,0,0,0.05);

    text-align:center;

}


.payment-icon {

    font-size:60px;

    margin-bottom:15px;

}


.payment-label {

    color:#8b776a;

    font-size:14px;

}


.order-number {

    font-size:18px;

    font-weight:600;

    margin-top:8px;

}


.amount {

    font-size:36px;

    font-weight:bold;

    color:#5b4033;

    margin:20px 0 30px;

}


.demo-box {

    background:#fff8e8;

    border:1px solid #f0dfae;

    padding:15px;

    border-radius:12px;

    margin-bottom:25px;

    color:#735b20;

    font-size:14px;

}


.pay-button {

    display:block;

    width:100%;

    padding:15px;

    border:none;

    border-radius:12px;

    background:#5b4033;

    color:white;

    font-size:17px;

    font-weight:600;

    cursor:pointer;

}


.back-link {

    display:block;

    margin-top:20px;

    color:#5b4033;

    text-decoration:none;

}

</style>

</head>


<body>


<header>

    <div class="logo">

        🧶 Knotera

    </div>


    <nav>

        <a href="index.php">
            Home
        </a>

        <a href="shop.php">
            Shop
        </a>

        <a href="cart.php">
            🛒 Cart
        </a>

        <a href="auth/logout.php">
            Logout
        </a>

    </nav>

</header>


<main class="payment-container">


<div class="payment-card">


<div class="payment-icon">

    💳

</div>


<h1>

    Secure Online Payment

</h1>


<p class="payment-label">

    Knotera Demo Payment

</p>


<div class="order-number">

    Order #<?= (int)$order_id ?>

</div>


<div class="amount">

    ₹<?= number_format(
        $total,
        2
    ) ?>

</div>


<div class="demo-box">

    🧪 <strong>Demo Mode</strong><br>

    This is a test payment.
    No real money will be charged.

</div>


<form
    action="payment_success.php"
    method="POST"
>


    <input
        type="hidden"
        name="order_id"
        value="<?= (int)$order_id ?>"
    >


    <button
        type="submit"
        class="pay-button"
    >

        Pay Now 💳

    </button>


</form>


<a
    href="cart.php"
    class="back-link"
>

    ← Back to Cart

</a>


</div>


</main>


</body>

</html>
```
