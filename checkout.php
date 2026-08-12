<?php

session_start();
require_once "config.php";

/* LOGIN CHECK */
if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}

/* CART */
$cart = $_SESSION["cart"] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

/* TOTAL */
$total = 0;

foreach ($cart as $item) {
    $total += $item["price"] * $item["quantity"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Checkout | Knotera</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #4b382f;

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 8% 15%,
                    rgba(211, 230, 215, 0.85),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 92% 80%,
                    rgba(244, 211, 222, 0.9),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #fbf8f4,
                    #f3ece7
                );

        }


        /* HEADER */

        header {

            width: calc(100% - 40px);

            max-width: 1250px;

            margin: 20px auto;

            padding: 16px 26px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            border-radius: 22px;

            background:
                rgba(255,255,255,0.72);

            border:
                1px solid
                rgba(255,255,255,0.9);

            box-shadow:
                0 15px 40px
                rgba(70,50,40,0.10);

        }


        .logo {

            font-family: Georgia, serif;

            font-size: 26px;

            font-weight: bold;

            color: #4b362d;

            white-space: nowrap;

        }


        nav {

            display: flex;

            align-items: center;

            gap: 20px;

            flex-wrap: wrap;

        }


        nav a {

            text-decoration: none;

            color: #5c493f;

            font-size: 14px;

            font-weight: 600;

            transition: 0.2s;

        }


        nav a:hover {

            color: #9a6755;

        }


        nav span {

            font-size: 14px;

            color: #6d564b;

            font-weight: 600;

        }


        /* MAIN */

        .checkout-container {

            max-width: 1120px;

            margin: auto;

            padding:
                45px 20px 80px;

        }


        /* TITLE */

        .checkout-heading {

            text-align: center;

            margin-bottom: 45px;

        }


        .checkout-heading small {

            display: block;

            margin-bottom: 12px;

            font-size: 11px;

            font-weight: bold;

            letter-spacing: 4px;

            color: #8b7568;

        }


        .checkout-heading h1 {

            margin: 0;

            font-family: Georgia, serif;

            font-size:
                clamp(44px, 6vw, 68px);

            letter-spacing: -2px;

            color: #3f2d25;

        }


        .checkout-heading p {

            margin: 15px auto 0;

            color: #7a675d;

            font-size: 16px;

        }


        /* LAYOUT */

        .checkout-grid {

            display: grid;

            grid-template-columns:
                1.35fr
                0.85fr;

            gap: 28px;

            align-items: start;

        }


        /* GLASS CARD */

        .glass-card {

            background:
                rgba(255,255,255,0.68);

            border:
                1px solid
                rgba(255,255,255,0.9);

            border-radius: 30px;

            box-shadow:
                0 22px 60px
                rgba(70,50,40,0.12);

        }


        /* FORM */

        .details-card {

            padding: 34px;

        }


        .card-title {

            margin-bottom: 27px;

        }


        .card-title small {

            display: block;

            margin-bottom: 6px;

            text-transform: uppercase;

            letter-spacing: 2px;

            font-size: 10px;

            color: #957e70;

            font-weight: bold;

        }


        .card-title h2 {

            margin: 0;

            font-family: Georgia, serif;

            font-size: 30px;

            color: #49342b;

        }


        .form-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 18px;

        }


        .field {

            display: flex;

            flex-direction: column;

            gap: 8px;

        }


        .field.full {

            grid-column: 1 / -1;

        }


        label {

            font-size: 12px;

            font-weight: bold;

            color: #624d43;

        }


        input,
        textarea {

            width: 100%;

            padding: 14px 15px;

            border-radius: 14px;

            border:
                1px solid
                #e7dcd5;

            background:
                rgba(255,255,255,0.72);

            color: #44332b;

            font-size: 14px;

            outline: none;

            transition: 0.2s;

            font-family: inherit;

        }


        input:focus,
        textarea:focus {

            border-color:
                #c89b8b;

            box-shadow:
                0 0 0 4px
                rgba(200,155,139,0.12);

        }


        textarea {

            min-height: 105px;

            resize: vertical;

        }


        /* PAYMENT */

        .payment-section {

            margin-top: 28px;

            padding-top: 25px;

            border-top:
                1px solid
                #eadfd9;

        }


        .payment-box {

            margin-top: 12px;

            padding: 17px;

            display: flex;

            align-items: center;

            gap: 13px;

            border-radius: 17px;

            background:
                linear-gradient(
                    135deg,
                    rgba(244,220,228,0.72),
                    rgba(255,255,255,0.72)
                );

            border:
                1px solid
                rgba(226,196,205,0.8);

        }


        .payment-icon {

            width: 44px;

            height: 44px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 13px;

            background:
                #fff7f9;

            font-size: 21px;

        }


        .payment-text strong {

            display: block;

            font-size: 14px;

            color: #4b362e;

        }


        .payment-text span {

            display: block;

            margin-top: 4px;

            font-size: 12px;

            color: #806d63;

        }


        /* ORDER SUMMARY */

        .summary-card {

            padding: 30px;

            position: sticky;

            top: 20px;

        }


        .summary-title {

            margin-bottom: 23px;

        }


        .summary-title small {

            display: block;

            margin-bottom: 6px;

            text-transform: uppercase;

            letter-spacing: 2px;

            font-size: 10px;

            color: #957e70;

            font-weight: bold;

        }


        .summary-title h2 {

            margin: 0;

            font-family: Georgia, serif;

            font-size: 29px;

            color: #49342b;

        }


        /* ITEMS */

        .order-item {

            display: flex;

            align-items: center;

            gap: 13px;

            padding: 14px 0;

            border-bottom:
                1px solid
                #eadfd8;

        }


        .order-image {

            width: 64px;

            height: 64px;

            flex-shrink: 0;

            overflow: hidden;

            border-radius: 15px;

            background: #eee6e1;

        }


        .order-image img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;

        }


        .order-info {

            flex: 1;

        }


        .order-info strong {

            display: block;

            font-family: Georgia, serif;

            font-size: 16px;

            color: #49352c;

        }


        .order-info span {

            display: block;

            margin-top: 5px;

            font-size: 12px;

            color: #806d63;

        }


        .order-price {

            font-weight: bold;

            font-size: 14px;

            color: #4c382f;

        }


        /* TOTAL */

        .summary-lines {

            margin-top: 20px;

        }


        .summary-row {

            display: flex;

            justify-content: space-between;

            margin-bottom: 12px;

            font-size: 14px;

            color: #756158;

        }


        .summary-row strong {

            color: #4d392f;

        }


        .summary-total {

            margin-top: 20px;

            padding-top: 20px;

            border-top:
                1px solid
                #dfd1c9;

            display: flex;

            align-items: center;

            justify-content: space-between;

        }


        .summary-total span {

            font-size: 14px;

            font-weight: bold;

            color: #6c564c;

        }


        .summary-total strong {

            font-family: Georgia, serif;

            font-size: 28px;

            color: #49332a;

        }


        /* BUTTON */

        .place-order {

            width: 100%;

            margin-top: 25px;

            padding: 16px 20px;

            border: none;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #5c4034,
                    #8b6250
                );

            color: white;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            box-shadow:
                0 12px 25px
                rgba(76,52,43,0.20);

            transition: 0.25s;

        }


        .place-order:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 18px 30px
                rgba(76,52,43,0.25);

        }


        .secure-text {

            margin-top: 14px;

            text-align: center;

            font-size: 11px;

            color: #8b776d;

        }


        .back-cart {

            display: block;

            margin-top: 18px;

            text-align: center;

            text-decoration: none;

            color: #795c4e;

            font-size: 13px;

            font-weight: bold;

        }


        .back-cart:hover {

            text-decoration: underline;

        }


        /* RESPONSIVE */

        @media(max-width: 850px) {

            .checkout-grid {

                grid-template-columns: 1fr;

            }

            .summary-card {

                position: static;

            }

        }


        @media(max-width: 600px) {

            header {

                width:
                    calc(100% - 24px);

                flex-direction: column;

                align-items: flex-start;

            }


            nav {

                gap: 12px;

            }


            .checkout-container {

                padding:
                    30px 14px 60px;

            }


            .details-card,
            .summary-card {

                padding: 23px;

                border-radius: 24px;

            }


            .form-grid {

                grid-template-columns: 1fr;

            }


            .field.full {

                grid-column: auto;

            }


            .checkout-heading h1 {

                font-size: 46px;

            }

        }

    </style>

</head>


<body>


<!-- HEADER -->

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


        <?php if (isset($_SESSION["user_id"])): ?>

            <span>
                Hi,
                <?= htmlspecialchars($_SESSION["user_name"]) ?>
                👋
            </span>

            <a href="auth/logout.php">
                Logout
            </a>

        <?php endif; ?>

    </nav>

</header>


<!-- MAIN -->

<main class="checkout-container">


    <section class="checkout-heading">

        <small>
            KNOTERA • HANDMADE WITH LOVE
        </small>

        <h1>
            Checkout
        </h1>

        <p>
            Complete your details and place your order.
        </p>

    </section>


    <form
        action="place_order.php"
        method="POST"
    >

        <div class="checkout-grid">


            <!-- CUSTOMER DETAILS -->

            <section class="glass-card details-card">


                <div class="card-title">

                    <small>
                        Your information
                    </small>

                    <h2>
                        Delivery Details
                    </h2>

                </div>


                <div class="form-grid">


                    <!-- NAME -->

                    <div class="field">

                        <label>
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="customer_name"
                            placeholder="Enter your full name"
                            required
                        >

                    </div>


                    <!-- EMAIL -->

                    <div class="field">

                        <label>
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            placeholder="you@example.com"
                            required
                        >

                    </div>


                    <!-- MOBILE -->

                    <div class="field">

                        <label>
                            Mobile Number
                        </label>

                        <input
                            type="tel"
                            name="mobile"
                            placeholder="10 digit mobile number"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            required
                        >

                    </div>


                    <!-- CITY -->

                    <div class="field">

                        <label>
                            City
                        </label>

                        <input
                            type="text"
                            name="city"
                            placeholder="Your city"
                            required
                        >

                    </div>


                    <!-- STATE -->

                    <div class="field">

                        <label>
                            State
                        </label>

                        <input
                            type="text"
                            name="state"
                            placeholder="Your state"
                            required
                        >

                    </div>


                    <!-- PINCODE -->

                    <div class="field">

                        <label>
                            PIN Code
                        </label>

                        <input
                            type="text"
                            name="pincode"
                            placeholder="6 digit PIN code"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            required
                        >

                    </div>


                    <!-- ADDRESS -->

                    <div class="field full">

                        <label>
                            Full Address
                        </label>

                        <textarea
                            name="address"
                            placeholder="House no., street, area, landmark..."
                            required
                        ></textarea>

                    </div>

                </div>


                <!-- PAYMENT -->

                <div class="payment-section">

                    <div class="card-title">

                        <small>
                            Payment
                        </small>

                        <h2>
                            Choose Payment
                        </h2>

                    </div>


                    <div class="payment-box">

                        <div class="payment-icon">
                            💳
                        </div>


                        <div class="payment-text">

                            <strong>
                                Online Payment
                            </strong>

                            <span>
                                Secure demo payment will open after placing your order.
                            </span>

                        </div>

                    </div>


                    <!-- IMPORTANT -->

                    <input
                        type="hidden"
                        name="payment_method"
                        value="ONLINE"
                    >

                </div>


            </section>


            <!-- ORDER SUMMARY -->

            <aside class="glass-card summary-card">


                <div class="summary-title">

                    <small>
                        Your order
                    </small>

                    <h2>
                        Order Summary
                    </h2>

                </div>


                <!-- PRODUCTS -->

                <?php foreach ($cart as $item): ?>


                    <?php

                    $subtotal =
                        $item["price"] *
                        $item["quantity"];

                    ?>


                    <div class="order-item">


                        <div class="order-image">

                            <?php if (!empty($item["image"])): ?>

                                <img
                                    src="assets/<?= htmlspecialchars($item["image"]) ?>"
                                    alt="<?= htmlspecialchars($item["name"]) ?>"
                                    onerror="this.style.display='none';"
                                >

                            <?php else: ?>

                                <div style="
                                    width:100%;
                                    height:100%;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:27px;
                                ">
                                    🧶
                                </div>

                            <?php endif; ?>

                        </div>


                        <div class="order-info">

                            <strong>
                                <?= htmlspecialchars($item["name"]) ?>
                            </strong>

                            <span>
                                Qty: <?= (int)$item["quantity"] ?>
                            </span>

                        </div>


                        <div class="order-price">

                            ₹<?= number_format($subtotal, 2) ?>

                        </div>


                    </div>


                <?php endforeach; ?>


                <!-- SUMMARY -->

                <div class="summary-lines">


                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            ₹<?= number_format($total, 2) ?>
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Delivery
                        </span>

                        <strong>
                            Free
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Payment
                        </span>

                        <strong>
                            Online
                        </strong>

                    </div>


                </div>


                <!-- TOTAL -->

                <div class="summary-total">

                    <span>
                        Total
                    </span>

                    <strong>
                        ₹<?= number_format($total, 2) ?>
                    </strong>

                </div>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="place-order"
                >

                    Place Order →
                    
                </button>


                <p class="secure-text">
                    🔒 Your order details are securely processed.
                </p>


                <a
                    href="cart.php"
                    class="back-cart"
                >
                    ← Back to Cart
                </a>


            </aside>


        </div>

    </form>


</main>


</body>

</html>