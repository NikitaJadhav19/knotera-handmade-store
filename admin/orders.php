
<?php

session_start();

require_once "../config.php";

/*
|--------------------------------------------------------------------------
| ADMIN ONLY SECURITY
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] !== "admin"
) {
    header("Location: ../auth/login.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| GET ORDERS
|--------------------------------------------------------------------------
*/

$sql = "
SELECT
    o.id,
    o.customer_name,
    o.email,
    o.mobile,
    o.city,
    o.state,
    o.pincode,
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

GROUP BY o.id

ORDER BY o.id DESC
";

$result = $conn->query($sql);

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Admin Orders | Knotera</title>

<link rel="stylesheet" href="../style.css">


<style>

body {
    background:#f8f4ef;
}


.admin-container {
    max-width:1200px;
    margin:50px auto;
    padding:20px;
}


.admin-header {
    margin-bottom:30px;
}


.admin-card {
    background:white;
    border-radius:20px;
    padding:25px;
    margin-bottom:20px;
    border:1px solid #eadfd5;
    box-shadow:0 5px 20px rgba(0,0,0,0.04);
}


.order-top {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}


.order-id {
    font-size:22px;
    font-weight:bold;
}


.order-date {
    color:#8b776a;
    margin-top:5px;
}


.order-grid {
    display:grid;
    grid-template-columns:
        repeat(auto-fit,minmax(180px,1fr));

    gap:20px;

    margin-top:25px;
}


.info-title {
    font-size:12px;
    color:#8b776a;
    text-transform:uppercase;
    margin-bottom:6px;
}


.info-value {
    font-weight:600;
}


.products {
    background:#faf7f3;
    padding:15px;
    border-radius:12px;
    margin-top:20px;
}


.total {
    font-size:22px;
    font-weight:bold;
}


.status-form {
    margin-top:25px;
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
}


.status-form select {
    padding:11px 14px;
    border-radius:10px;
    border:1px solid #d9ccc2;
    background:white;
}


.status-form button {
    padding:11px 18px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    background:#5b4033;
    color:white;
    font-weight:600;
}


.updated {
    background:#e9f8ed;
    color:#26733a;
    padding:12px 16px;
    border-radius:10px;
    margin-bottom:20px;
}


.empty {
    text-align:center;
    padding:60px;
    background:white;
    border-radius:20px;
}

</style>

</head>


<body>


<header>

    <div class="logo">
        🧶 Knotera
    </div>


    <nav>

        <a href="../index.php">
            Home
        </a>

        <a href="../shop.php">
            Shop
        </a>

        <a href="../cart.php">
            🛒 Cart
        </a>

        <a href="../auth/logout.php">
            Logout
        </a>

    </nav>

</header>


<main class="admin-container">


<div class="admin-header">

    <p class="small-title">
        KNOTERA ADMIN
    </p>

    <h1>
        Order Dashboard 📦
    </h1>

    <p>
        Manage customer orders and track order activity.
    </p>

</div>


<?php if (isset($_GET["updated"])): ?>

    <div class="updated">

        ✅ Order status updated successfully.

    </div>

<?php endif; ?>


<?php if ($result && $result->num_rows > 0): ?>


<?php while ($order = $result->fetch_assoc()): ?>


<div class="admin-card">


<div class="order-top">

    <div>

        <div class="order-id">

            Order #<?= (int)$order["id"] ?>

        </div>

        <div class="order-date">

            <?= date(
                "d M Y, h:i A",
                strtotime($order["created_at"])
            ) ?>

        </div>

    </div>


    <strong>

        <?= htmlspecialchars(
            $order["order_status"]
        ) ?>

    </strong>

</div>


<div class="products">

    <strong>
        🛍️ Products
    </strong>

    <p>

        <?= htmlspecialchars(
            $order["products"] ?? "No products"
        ) ?>

    </p>

</div>


<div class="order-grid">


<div>

    <div class="info-title">
        Customer
    </div>

    <div class="info-value">

        <?= htmlspecialchars(
            $order["customer_name"]
        ) ?>

    </div>

</div>


<div>

    <div class="info-title">
        Email
    </div>

    <div class="info-value">

        <?= htmlspecialchars(
            $order["email"]
        ) ?>

    </div>

</div>


<div>

    <div class="info-title">
        Mobile
    </div>

    <div class="info-value">

        <?= htmlspecialchars(
            $order["mobile"]
        ) ?>

    </div>

</div>


<div>

    <div class="info-title">
        Location
    </div>

    <div class="info-value">

        <?= htmlspecialchars(
            $order["city"]
        ) ?>,

        <?= htmlspecialchars(
            $order["state"]
        ) ?>

        -

        <?= htmlspecialchars(
            $order["pincode"]
        ) ?>

    </div>

</div>


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
            $order["order_status"]
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


<form
    action="update_order_status.php"
    method="POST"
    class="status-form"
>


    <input
        type="hidden"
        name="order_id"
        value="<?= (int)$order["id"] ?>"
    >


    <label>
        Change Status:
    </label>


    <select name="order_status">

        <?php

        $statuses = [
            "Placed",
            "Confirmed",
            "Processing",
            "Shipped",
            "Delivered",
            "Cancelled"
        ];

        foreach ($statuses as $status):

        ?>

            <option
                value="<?= htmlspecialchars($status) ?>"
                <?= $order["order_status"] === $status
                    ? "selected"
                    : "" ?>
            >

                <?= htmlspecialchars($status) ?>

            </option>

        <?php endforeach; ?>

    </select>


    <button type="submit">

        Update Status

    </button>

</form>


</div>


<?php endwhile; ?>


<?php else: ?>


<div class="empty">

    <h2>
        No Orders Yet 🧶
    </h2>

    <p>
        Customer orders will appear here.
    </p>

</div>


<?php endif; ?>


</main>


</body>

</html>

