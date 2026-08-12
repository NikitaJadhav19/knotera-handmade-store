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
| CART CHECK
|--------------------------------------------------------------------------
*/

$cart = $_SESSION["cart"] ?? [];


if (empty($cart)) {

    die("Your cart is empty.");

}


/*
|--------------------------------------------------------------------------
| GET CHECKOUT DATA
|--------------------------------------------------------------------------
*/

$customer_name = trim(
    $_POST["customer_name"] ?? ""
);

$email = trim(
    $_POST["email"] ?? ""
);

$mobile = trim(
    $_POST["mobile"] ?? ""
);

$address = trim(
    $_POST["address"] ?? ""
);

$city = trim(
    $_POST["city"] ?? ""
);

$state = trim(
    $_POST["state"] ?? ""
);

$pincode = trim(
    $_POST["pincode"] ?? ""
);

$payment_method = $_POST["payment_method"] ?? "";


/*
|--------------------------------------------------------------------------
| VALIDATION
|--------------------------------------------------------------------------
*/

if (
    $customer_name === "" ||
    $email === "" ||
    $mobile === "" ||
    $address === "" ||
    $city === "" ||
    $state === "" ||
    $pincode === ""
) {

    die("Please fill all fields.");

}


/*
|--------------------------------------------------------------------------
| ONLINE PAYMENT ONLY
|--------------------------------------------------------------------------
*/

if ($payment_method !== "ONLINE") {

    die("Online payment is required.");

}


/*
|--------------------------------------------------------------------------
| CALCULATE TOTAL
|--------------------------------------------------------------------------
*/

$total = 0;


foreach ($cart as $item) {

    $total +=
        $item["price"] *
        $item["quantity"];

}


$user_id = (int) $_SESSION["user_id"];


/*
|--------------------------------------------------------------------------
| CREATE ORDER
|--------------------------------------------------------------------------
*/

$conn->begin_transaction();


try {


    $sql = "INSERT INTO orders
    (
        user_id,
        customer_name,
        email,
        mobile,
        address,
        city,
        state,
        pincode,
        total_amount,
        payment_status,
        order_status
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        throw new Exception(
            $conn->error
        );

    }


    $payment_status = "Pending";

    $order_status = "Placed";


    $stmt->bind_param(
        "isssssssdss",
        $user_id,
        $customer_name,
        $email,
        $mobile,
        $address,
        $city,
        $state,
        $pincode,
        $total,
        $payment_status,
        $order_status
    );


    if (!$stmt->execute()) {

        throw new Exception(
            $stmt->error
        );

    }


    $order_id = $conn->insert_id;


    /*
    |--------------------------------------------------------------------------
    | SAVE ORDER ITEMS
    |--------------------------------------------------------------------------
    */

    $item_sql = "INSERT INTO order_items
    (
        order_id,
        product_id,
        product_name,
        price,
        quantity,
        subtotal
    )
    VALUES (?, ?, ?, ?, ?, ?)";


    $item_stmt = $conn->prepare(
        $item_sql
    );


    if (!$item_stmt) {

        throw new Exception(
            $conn->error
        );

    }


    foreach ($cart as $item) {


        $subtotal =
            $item["price"] *
            $item["quantity"];


        $item_stmt->bind_param(
            "iisdid",
            $order_id,
            $item["id"],
            $item["name"],
            $item["price"],
            $item["quantity"],
            $subtotal
        );


        if (!$item_stmt->execute()) {

            throw new Exception(
                $item_stmt->error
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    $conn->commit();


    /*
    |--------------------------------------------------------------------------
    | SAVE PENDING PAYMENT ORDER
    |--------------------------------------------------------------------------
    */

    $_SESSION["pending_order_id"] = $order_id;

    $_SESSION["pending_order_total"] = $total;


    /*
    |--------------------------------------------------------------------------
    | GO TO DEMO PAYMENT
    |--------------------------------------------------------------------------
    */

    header(
        "Location: demo_payment.php"
    );

    exit;


} catch (Exception $e) {


    $conn->rollback();


    die(
        "Order Error: " .
        htmlspecialchars(
            $e->getMessage()
        )
    );

}

?>
```
