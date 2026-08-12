
<?php

session_start();

require_once "config.php";


/*
|--------------------------------------------------------------------------
| CUSTOMER LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: auth/login.php");
    exit;

}

$user_id = (int) $_SESSION["user_id"];


/*
|--------------------------------------------------------------------------
| GET CUSTOMER EMAIL
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT email FROM users WHERE id = ?"
);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$user_result = $stmt->get_result();


if ($user_result->num_rows !== 1) {

    header("Location: auth/logout.php");
    exit;

}


$user = $user_result->fetch_assoc();

$customer_email = $user["email"];

$stmt->close();


/*
|--------------------------------------------------------------------------
| GET CUSTOMER ORDERS
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT
        o.id,
        o.total_amount,
        o.payment_status,
        o.order_status,
        o.created_at,

        GROUP_CONCAT(
            CONCAT(
                oi.product_name,
                ' × ',
                oi.quantity
            )
            SEPARATOR ', '
        ) AS products

    FROM orders o

    LEFT JOIN order_items oi
        ON o.id = oi.order_id

    WHERE o.email = ?

    GROUP BY o.id

    ORDER BY o.id DESC"
);


$stmt->bind_param("s", $customer_email);

$stmt->execute();

$result = $stmt->get_result();


/*
|--------------------------------------------------------------------------
| ORDER STATUS STEPS
|--------------------------------------------------------------------------
*/

$status_steps = [
    "Placed",
    "Confirmed",
    "Processing",
    "Shipped",
    "Delivered"
];

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>My Orders | Knotera</title>

<link rel="stylesheet" href="style.css">


<style>

/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

.orders-container {

    max-width:1000px;

    margin:50px auto;

    padding:20px;

}


/*
|--------------------------------------------------------------------------
| ORDER CARD
|--------------------------------------------------------------------------
*/

.order-card {

    background:white;

    padding:28px;

    margin-bottom:25px;

    border-radius:20px;

    border:1px solid #eadfd5;

    box-shadow:
        0 5px 20px rgba(0,0,0,0.04);

}


/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.order-header {

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:15px;

    flex-wrap:wrap;

}


.order-number {

    font-size:22px;

    font-weight:bold;

}


.order-date {

    color:#8b776a;

    margin-top:5px;

}


.status {

    display:inline-block;

    padding:8px 16px;

    border-radius:20px;

    background:#f2e7dc;

    font-weight:600;

}


/*
|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

.products {

    background:#faf7f3;

    padding:15px;

    border-radius:12px;

    margin-top:20px;

}


/*
|--------------------------------------------------------------------------
| ORDER INFORMATION
|--------------------------------------------------------------------------
*/

.order-info {

    display:grid;

    grid-template-columns:
        repeat(auto-fit,minmax(180px,1fr));

    gap:20px;

    margin-top:20px;

}


.info-title {

    font-size:12px;

    color:#8b776a;

    text-transform:uppercase;

    margin-bottom:5px;

}


.info-value {

    font-weight:600;

}


.total {

    font-size:22px;

    font-weight:bold;

}


/*
|--------------------------------------------------------------------------
| TRACKING
|--------------------------------------------------------------------------
*/

.tracking-title {

    margin-top:30px;

    margin-bottom:20px;

    font-size:18px;

    font-weight:bold;

}


.tracking {

    display:flex;

    justify-content:space-between;

    position:relative;

    margin:25px 5px 10px;

}


.tracking::before {

    content:"";

    position:absolute;

    top:17px;

    left:30px;

    right:30px;

    height:4px;

    background:#e5d9d0;

    z-index:0;

}


.step {

    position:relative;

    z-index:1;

    text-align:center;

    width:20%;

}


.step-circle {

    width:34px;

    height:34px;

    margin:auto;

    border-radius:50%;

    background:#e5d9d0;

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

    font-weight:bold;

}


.step.active .step-circle,
.step.completed .step-circle {

    background:#5b4033;

}


.step-label {

    margin-top:10px;

    font-size:12px;

    color:#8b776a;

}


.step.active .step-label,
.step.completed .step-label {

    color:#5b4033;

    font-weight:bold;

}


/*
|--------------------------------------------------------------------------
| CANCELLED
|--------------------------------------------------------------------------
*/

.cancelled {

    background:#fdeaea;

    color:#a33a3a;

    padding:14px;

    border-radius:12px;

    margin-top:25px;

    font-weight:600;

}


/*
|--------------------------------------------------------------------------
| EMPTY ORDERS
|--------------------------------------------------------------------------
*/

.empty-orders {

    background:white;

    padding:60px 20px;

    text-align:center;

    border-radius:20px;

}


.shop-button {

    display:inline-block;

    margin-top:15px;

    padding:12px 20px;

    background:#5b4033;

    color:white;

    text-decoration:none;

    border-radius:10px;

}


/*
|--------------------------------------------------------------------------
| MOBILE
|--------------------------------------------------------------------------
*/

@media (max-width:600px) {

    .order-card {

        padding:20px;

    }


    .tracking {

        margin-left:0;

        margin-right:0;

    }


    .step-label {

        font-size:10px;

    }


    .tracking::before {

        left:20px;

        right:20px;

    }

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


        <a href="my_orders.php">
            📦 My Orders
        </a>


        <a href="auth/logout.php">
            Logout
        </a>

    </nav>

</header>


<main class="orders-container">


<p class="small-title">

    YOUR ORDERS

</p>


<h1>

    My Orders 📦

</h1>


<p>

    Track your Knotera orders and delivery status.

</p>


<?php if ($result->num_rows > 0): ?>


<?php while ($order = $result->fetch_assoc()): ?>


<?php

$current_status = $order["order_status"];

$current_index = array_search(
    $current_status,
    $status_steps
);

?>


<div class="order-card">


<!-- ORDER HEADER -->

<div class="order-header">


    <div>

        <div class="order-number">

            Order #<?= (int)$order["id"] ?>

        </div>


        <div class="order-date">

            <?= date(
                "d M Y, h:i A",
                strtotime($order["created_at"])
            ) ?>

        </div>

    </div>


    <div class="status">

        <?= htmlspecialchars(
            $current_status
        ) ?>

    </div>


</div>


<!-- PRODUCTS -->

<div class="products">

    <strong>

        🛍️ Products

    </strong>


    <p>

        <?= htmlspecialchars(
            $order["products"]
            ?? "No products"
        ) ?>

    </p>

</div>


<!-- ORDER INFORMATION -->

<div class="order-info">


<div>

    <div class="info-title">

        Payment

    </div>


    <div class="info-value">

        <?= htmlspecialchars(
            $order["payment_status"]
        ) ?>

    </div>

</div>


<div>

    <div class="info-title">

        Order Status

    </div>


    <div class="info-value">

        <?= htmlspecialchars(
            $current_status
        ) ?>

    </div>

</div>


<div>

    <div class="info-title">

        Order Total

    </div>


    <div class="total">

        ₹<?= number_format(
            $order["total_amount"],
            2
        ) ?>

    </div>

</div>


</div>


<!-- ORDER TRACKING -->

<?php if ($current_status === "Cancelled"): ?>


<div class="cancelled">

    ❌ This order has been cancelled.

</div>


<?php else: ?>


<div class="tracking-title">

    Order Tracking

</div>


<div class="tracking">


<?php foreach (
    $status_steps
    as $index => $step
): ?>


<?php

$is_completed =
    $current_index !== false &&
    $index < $current_index;

$is_active =
    $current_index !== false &&
    $index === $current_index;

?>


<div
    class="
        step
        <?= $is_completed
            ? 'completed'
            : ''
        ?>
        <?= $is_active
            ? 'active'
            : ''
        ?>
    "
>


<div class="step-circle">

    <?php if ($is_completed): ?>

        ✓

    <?php elseif ($is_active): ?>

        ●

    <?php else: ?>

        <?= $index + 1 ?>

    <?php endif; ?>

</div>


<div class="step-label">

    <?= htmlspecialchars($step) ?>

</div>


</div>


<?php endforeach; ?>


</div>


<?php endif; ?>


</div>


<?php endwhile; ?>


<?php else: ?>


<div class="empty-orders">


    <h2>

        No Orders Yet 🧶

    </h2>


    <p>

        You haven't placed any orders yet.

    </p>


    <a
        href="shop.php"
        class="shop-button"
    >

        Start Shopping 🛍️

    </a>


</div>


<?php endif; ?>


</main>


</body>

</html>
