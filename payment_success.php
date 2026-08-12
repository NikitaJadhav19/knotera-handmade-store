<?php

session_start();
require_once "config.php";

/* ORDER DATA */

$order_id = $_SESSION["pending_order_id"] ?? 0;

$order_total = $_SESSION["pending_order_total"] ?? 0;


/* LOGIN CHECK */

if (!isset($_SESSION["user_id"])) {

    header("Location: auth/login.php");
    exit;

}


/* NO ORDER */

if (!$order_id) {

    header("Location: shop.php");
    exit;

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Payment Successful | Knotera</title>


<style>

/* =========================
   RESET
========================= */

* {
    box-sizing: border-box;
}


body {

    margin: 0;

    min-height: 100vh;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color: #49372f;

    background:

        radial-gradient(
            circle at 8% 15%,
            rgba(214, 231, 218, 0.9),
            transparent 30%
        ),

        radial-gradient(
            circle at 92% 82%,
            rgba(245, 211, 222, 0.9),
            transparent 32%
        ),

        linear-gradient(
            135deg,
            #fbf8f4,
            #f1eae5
        );

    display: flex;

    flex-direction: column;

}


/* =========================
   HEADER
========================= */

header {

    width: calc(100% - 40px);

    max-width: 1250px;

    margin: 20px auto;

    padding: 17px 27px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    border-radius: 22px;

    background:
        rgba(255,255,255,0.76);

    border:
        1px solid
        rgba(255,255,255,0.92);

    box-shadow:
        0 15px 40px
        rgba(70,50,40,0.10);

}


.logo {

    font-family: Georgia, serif;

    font-size: 26px;

    font-weight: bold;

    color: #49352d;

    white-space: nowrap;

}


nav {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 18px;

    flex-wrap: wrap;

}


nav a {

    color: #5d4940;

    text-decoration: none;

    font-size: 14px;

    font-weight: 600;

    transition: 0.25s;

}


nav a:hover {

    color: #3f8f62;

}


/* =========================
   MAIN
========================= */

.success-container {

    width: 100%;

    max-width: 900px;

    margin: auto;

    padding:
        45px 20px 80px;

    display: flex;

    justify-content: center;

}


/* =========================
   SUCCESS CARD
========================= */

.success-card {

    width: 100%;

    max-width: 680px;

    padding:
        52px 45px;

    text-align: center;

    border-radius: 34px;

    background:
        rgba(255,255,255,0.78);

    border:
        1px solid
        rgba(255,255,255,0.95);

    box-shadow:
        0 30px 80px
        rgba(70,50,40,0.15);

}


/* =========================
   GREEN SUCCESS ICON
========================= */

.success-icon {

    width: 96px;

    height: 96px;

    margin:
        0 auto 25px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    font-size: 45px;

    font-weight: bold;

    color: #ffffff;

    background:

        linear-gradient(
            135deg,
            #36865a,
            #69b985
        );

    box-shadow:

        0 12px 30px
        rgba(63,143,98,0.30),

        inset 0 2px 5px
        rgba(255,255,255,0.35);

}


/* =========================
   TITLE
========================= */

.small-title {

    margin-bottom: 12px;

    font-size: 10px;

    font-weight: bold;

    letter-spacing: 4px;

    color: #927b6e;

}


h1 {

    margin: 0;

    font-family: Georgia, serif;

    font-size:
        clamp(38px, 6vw, 58px);

    letter-spacing: -1.5px;

    color: #3f2d25;

}


.message {

    max-width: 500px;

    margin:
        18px auto 32px;

    line-height: 1.7;

    font-size: 15px;

    color: #766258;

}


/* =========================
   ORDER BOX
========================= */

.order-box {

    max-width: 480px;

    margin:
        0 auto 32px;

    padding: 23px;

    border-radius: 22px;

    background:

        linear-gradient(
            135deg,
            rgba(236,247,239,0.85),
            rgba(250,240,244,0.75)
        );

    border:
        1px solid
        rgba(255,255,255,0.9);

    box-shadow:

        0 10px 30px
        rgba(70,50,40,0.07);

}


/* =========================
   ORDER ROW
========================= */

.order-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    padding: 12px 0;

    border-bottom:
        1px solid
        rgba(120,95,80,0.12);

    font-size: 14px;

}


.order-row:last-child {

    border-bottom: none;

}


.order-row span {

    color: #806c61;

}


.order-row strong {

    color: #49352d;

}


/* GREEN PAID */

.payment-paid {

    color: #328052 !important;

    font-weight: 700;

}


/* GREEN CONFIRMED */

.order-confirmed {

    color: #328052 !important;

    font-weight: 700;

}


/* TOTAL */

.total {

    font-family: Georgia, serif;

    font-size: 24px;

    color: #49352d !important;

}


/* =========================
   BUTTONS
========================= */

.buttons {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 12px;

    flex-wrap: wrap;

}


.btn {

    display: inline-block;

    padding:
        14px 22px;

    border-radius: 15px;

    text-decoration: none;

    font-size: 14px;

    font-weight: bold;

    transition: 0.25s;

}


/* GREEN BUTTON */

.primary {

    color: white;

    background:

        linear-gradient(
            135deg,
            #3d8d60,
            #67ad80
        );

    box-shadow:

        0 10px 25px
        rgba(63,143,98,0.25);

}


.primary:hover {

    transform:
        translateY(-3px);

    box-shadow:

        0 15px 30px
        rgba(63,143,98,0.32);

}


/* SECOND BUTTON */

.secondary {

    color: #5c463b;

    background:
        rgba(255,255,255,0.75);

    border:
        1px solid
        #e5d8d0;

}


.secondary:hover {

    transform:
        translateY(-3px);

    background: white;

}


/* =========================
   FOOTER NOTE
========================= */

.footer-note {

    margin-top: 26px;

    font-size: 11px;

    color: #907b70;

}


/* =========================
   MOBILE
========================= */

@media(max-width:650px) {

    header {

        width:
            calc(100% - 24px);

        flex-direction: column;

        align-items: flex-start;

        padding: 16px 20px;

    }


    nav {

        justify-content: flex-start;

        gap: 12px;

    }


    .success-container {

        padding:
            25px 14px 60px;

    }


    .success-card {

        padding:
            38px 22px;

        border-radius: 27px;

    }


    .success-icon {

        width: 80px;

        height: 80px;

        font-size: 37px;

    }


    h1 {

        font-size: 40px;

    }


    .order-box {

        padding: 17px;

    }


    .order-row {

        font-size: 13px;

    }


    .btn {

        width: 100%;

    }

}

</style>

</head>


<body>


<!-- =========================
     HEADER
========================= -->

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


        <a href="shop.php?category=Macramé">
            Macramé
        </a>


        <a href="shop.php?category=Crochet">
            Crochet
        </a>


        <a href="cart.php">
            🛒 Cart
        </a>


        <a href="my_orders.php">
            📦 My Orders
        </a>


        <a href="auth/logout.php">
            Logout
        </a>


    </nav>


</header>



<!-- =========================
     SUCCESS
========================= -->

<main class="success-container">


    <section class="success-card">


        <!-- GREEN CHECK -->

        <div class="success-icon">

            ✓

        </div>



        <div class="small-title">

            KNOTERA • PAYMENT COMPLETE

        </div>



        <h1>

            Payment Successful

        </h1>



        <p class="message">

            Your payment has been received successfully.
            Your handmade Knotera order is confirmed
            and will be prepared with love. 🧶✨

        </p>



        <!-- ORDER DETAILS -->

        <div class="order-box">


            <div class="order-row">

                <span>
                    Order ID
                </span>

                <strong>
                    #<?= (int)$order_id ?>
                </strong>

            </div>



            <div class="order-row">

                <span>
                    Payment Status
                </span>

                <strong class="payment-paid">

                    ✓ Paid

                </strong>

            </div>



            <div class="order-row">

                <span>
                    Order Status
                </span>

                <strong class="order-confirmed">

                    ✓ Confirmed

                </strong>

            </div>



            <div class="order-row">

                <span>
                    Total Amount
                </span>

                <strong class="total">

                    ₹<?= number_format(
                        (float)$order_total,
                        2
                    ) ?>

                </strong>

            </div>


        </div>



        <!-- BUTTONS -->

        <div class="buttons">


            <a
                href="my_orders.php"
                class="btn primary"
            >

                📦 View My Orders

            </a>



            <a
                href="shop.php"
                class="btn secondary"
            >

                🛍️ Continue Shopping

            </a>


        </div>



        <p class="footer-note">

            ✓ Secure payment completed
            • Thank you for supporting handmade creations 🤍

        </p>


    </section>


</main>


</body>

</html>