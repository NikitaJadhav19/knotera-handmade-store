<?php

session_start();

$cart = $_SESSION["cart"] ?? [];

$total = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Your Cart | Knotera</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <div class="logo">
        🧶 Knotera
    </div>

    <nav>

        <a href="index.php">Home</a>

        <a href="shop.php">Shop</a>

        <a href="cart.php">🛒 Cart</a>

        <?php if (isset($_SESSION["user_id"])): ?>

            <span>
                Hi, <?= htmlspecialchars($_SESSION["user_name"]) ?> 👋
            </span>

            <a href="auth/logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="auth/login.php">
                Login
            </a>

        <?php endif; ?>

    </nav>

</header>


<main class="shop-container">

    <section class="shop-heading">

        <p class="small-title">
            YOUR SHOPPING BAG
        </p>

        <h1>
            Your Cart 🛒
        </h1>

    </section>


    <?php if (empty($cart)): ?>

        <div style="
            text-align:center;
            background:white;
            padding:50px;
            border-radius:20px;
        ">

            <h2>
                Your cart is empty 🧶
            </h2>

            <br>

            <a
                href="shop.php"
                class="cart-btn"
                style="text-decoration:none;"
            >
                Continue Shopping
            </a>

        </div>


    <?php else: ?>


        <?php foreach ($cart as $item): ?>

            <?php

            $subtotal =
                $item["price"] * $item["quantity"];

            $total += $subtotal;

            ?>


            <div style="
                background:white;
                padding:22px;
                margin-bottom:15px;
                border-radius:18px;
                display:flex;
                align-items:center;
                justify-content:space-between;
                gap:20px;
                flex-wrap:wrap;
                border:1px solid #eadfd5;
            ">


                <div>

                    <span class="category">
                        Handmade
                    </span>

                    <h2>
                        <?= htmlspecialchars($item["name"]) ?>
                    </h2>

                    <p>
                        ₹<?= number_format($item["price"], 2) ?>
                        each
                    </p>

                </div>


                <div style="
                    display:flex;
                    align-items:center;
                    gap:10px;
                ">

                    <form
                        action="update_cart.php"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= $item["id"] ?>"
                        >

                        <input
                            type="hidden"
                            name="action"
                            value="decrease"
                        >

                        <button
                            type="submit"
                            style="
                                width:38px;
                                height:38px;
                                border:none;
                                border-radius:10px;
                                cursor:pointer;
                                font-size:20px;
                            "
                        >
                            −
                        </button>

                    </form>


                    <strong style="
                        min-width:30px;
                        text-align:center;
                    ">

                        <?= $item["quantity"] ?>

                    </strong>


                    <form
                        action="update_cart.php"
                        method="POST"
                    >

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= $item["id"] ?>"
                        >

                        <input
                            type="hidden"
                            name="action"
                            value="increase"
                        >

                        <button
                            type="submit"
                            style="
                                width:38px;
                                height:38px;
                                border:none;
                                border-radius:10px;
                                cursor:pointer;
                                font-size:20px;
                            "
                        >
                            +
                        </button>

                    </form>

                </div>


                <strong style="
                    font-size:20px;
                ">

                    ₹<?= number_format($subtotal, 2) ?>

                </strong>


                <a
                    href="remove_from_cart.php?id=<?= $item["id"] ?>"
                    class="cart-btn"
                >
                    Remove
                </a>

            </div>

        <?php endforeach; ?>


        <div style="
            background:white;
            padding:30px;
            border-radius:20px;
            text-align:right;
            border:1px solid #eadfd5;
        ">

            <p style="
                color:#78665b;
                margin-bottom:8px;
            ">
                Order Total
            </p>


            <h2 style="
                font-size:30px;
                margin-bottom:20px;
            ">

                ₹<?= number_format($total, 2) ?>

            </h2>


            <a
                href="checkout.php"
                class="cart-btn"
                style="
                    display:inline-block;
                    text-decoration:none;
                "
            >

                Proceed to Checkout →

            </a>

        </div>


    <?php endif; ?>


</main>

</body>

</html>