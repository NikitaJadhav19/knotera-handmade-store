<?php

session_start();
require_once "config.php";

$category = trim($_GET["category"] ?? "");

if ($category !== "") {

    $stmt = $conn->prepare(
        "SELECT * FROM products WHERE category = ? ORDER BY id DESC"
    );

    $stmt->bind_param("s", $category);
    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query(
        "SELECT * FROM products ORDER BY id DESC"
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Knotera | Shop</title>


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

            color: #44342d;

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    #dce9df 0,
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 85%,
                    #f3dce4 0,
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #faf7f3,
                    #eee7e1
                );
        }


        /* HEADER */

        header {

            width: calc(100% - 40px);

            max-width: 1250px;

            margin: 20px auto;

            padding: 16px 25px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            border-radius: 22px;

            background:
                rgba(255,255,255,0.55);

            border:
                1px solid
                rgba(255,255,255,0.8);

            backdrop-filter:
                blur(20px);

            box-shadow:
                0 15px 40px
                rgba(70,50,40,0.10);
        }


        .logo {

            font-family: Georgia, serif;

            font-size: 25px;

            font-weight: bold;

            color: #4a362d;

            white-space: nowrap;
        }


        nav {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 17px;

            flex-wrap: wrap;
        }


        nav a {

            text-decoration: none;

            color: #5f4b41;

            font-size: 14px;

            font-weight: 600;

            transition: 0.2s;
        }


        nav a:hover {

            color: #9b6855;
        }


        nav span {

            font-size: 14px;

            font-weight: 600;

            color: #6d5549;
        }


        /* MAIN */

        .shop-container {

            max-width: 1250px;

            margin: auto;

            padding:
                35px 20px 80px;
        }


        /* HEADING */

        .shop-heading {

            text-align: center;

            margin-bottom: 35px;
        }


        .small-title {

            margin-bottom: 12px;

            font-size: 11px;

            font-weight: bold;

            letter-spacing: 3px;

            color: #8b776b;
        }


        .shop-heading h1 {

            margin: 0;

            font-family: Georgia, serif;

            font-size:
                clamp(40px, 6vw, 64px);

            letter-spacing: -2px;

            color: #3e2d25;
        }


        .shop-heading p:last-child {

            max-width: 600px;

            margin: 18px auto;

            line-height: 1.7;

            color: #78665c;

            font-size: 16px;
        }


        /* FILTER */

        .category-filter {

            display: flex;

            justify-content: center;

            gap: 12px;

            flex-wrap: wrap;

            margin-bottom: 40px;
        }


        .category-btn {

            text-decoration: none;

            padding: 11px 20px;

            border-radius: 30px;

            color: #5b463c;

            background:
                rgba(255,255,255,0.55);

            border:
                1px solid
                rgba(255,255,255,0.8);

            backdrop-filter:
                blur(15px);

            font-size: 13px;

            font-weight: bold;

            transition: 0.25s;
        }


        .category-btn:hover {

            transform:
                translateY(-2px);

            background:
                rgba(255,255,255,0.85);
        }


        .category-btn.active {

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #58745d,
                    #78937b
                );
        }


        /* CATEGORY INTRO */

        .category-intro {

            max-width: 1100px;

            margin:
                0 auto 40px;

            padding: 28px;

            display: flex;

            align-items: center;

            gap: 22px;

            border-radius: 28px;

            border:
                1px solid
                rgba(255,255,255,0.8);

            backdrop-filter:
                blur(20px);

            box-shadow:
                0 15px 40px
                rgba(70,50,40,0.08);
        }


        .category-intro.macrame {

            background:
                linear-gradient(
                    135deg,
                    rgba(214,228,215,0.85),
                    rgba(250,248,240,0.65)
                );
        }


        .category-intro.crochet {

            background:
                linear-gradient(
                    135deg,
                    rgba(244,215,224,0.85),
                    rgba(255,249,246,0.65)
                );
        }


        .category-icon {

            width: 75px;

            height: 75px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 22px;

            background:
                rgba(255,255,255,0.6);

            font-size: 34px;
        }


        .category-text small {

            display: block;

            margin-bottom: 6px;

            text-transform: uppercase;

            letter-spacing: 2px;

            font-size: 10px;

            font-weight: bold;

            color: #89766b;
        }


        .category-text h2 {

            margin: 0;

            font-family: Georgia, serif;

            font-size: 32px;

            color: #443129;
        }


        .category-text p {

            margin:
                8px 0 0;

            color: #756259;

            font-size: 14px;

            line-height: 1.6;
        }


        /* PRODUCTS */

        .products-grid {

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 28px;
        }


        .product-card {

            overflow: hidden;

            border-radius: 27px;

            background:
                rgba(255,255,255,0.52);

            border:
                1px solid
                rgba(255,255,255,0.85);

            backdrop-filter:
                blur(20px);

            box-shadow:
                0 18px 45px
                rgba(70,50,40,0.10);

            transition:
                transform 0.3s,
                box-shadow 0.3s;
        }


        .product-card:hover {

            transform:
                translateY(-8px);

            box-shadow:
                0 25px 55px
                rgba(70,50,40,0.17);
        }


        /* IMAGE */

        .product-image {

            width: 100%;

            height: 300px;

            overflow: hidden;

            background: #eee7e1;
        }


        .product-image img {

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

            transition:
                transform 0.4s;
        }


        .product-card:hover
        .product-image img {

            transform:
                scale(1.06);
        }


        .no-image {

            width: 100%;

            height: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 60px;

            color: #a18c80;
        }


        /* INFO */

        .product-info {

            padding: 23px;
        }


        .category {

            display: inline-block;

            padding: 6px 11px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            background: #e0eadf;

            color: #55705b;
        }


        .product-card:nth-child(even)
        .category {

            background: #f2dce4;

            color: #966475;
        }


        .product-info h2 {

            margin:
                13px 0 8px;

            font-family: Georgia, serif;

            font-size: 23px;

            color: #402e26;
        }


        .product-info p {

            margin: 0;

            min-height: 45px;

            color: #78665c;

            font-size: 14px;

            line-height: 1.6;
        }


        /* BOTTOM */

        .product-bottom {

            margin-top: 20px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;
        }


        .product-bottom strong {

            font-size: 21px;

            color: #4b3429;
        }


        /* CART */

        .cart-btn {

            border: none;

            padding:
                11px 15px;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #5a4034,
                    #87604e
                );

            color: white;

            font-weight: bold;

            cursor: pointer;

            transition: 0.25s;
        }


        .cart-btn:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 20px
                rgba(70,45,35,0.20);
        }


        .cart-btn.disabled {

            background: #aaa09a;

            cursor: not-allowed;
        }


        /* MOBILE */

        @media(max-width: 950px) {

            .products-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }
        }


        @media(max-width: 650px) {

            header {

                width:
                    calc(100% - 24px);

                flex-direction: column;

                align-items: flex-start;
            }


            nav {

                justify-content:
                    flex-start;

                gap: 12px;
            }


            .products-grid {

                grid-template-columns: 1fr;
            }


            .category-intro {

                flex-direction: column;

                text-align: center;
            }


            .category-text h2 {

                font-size: 27px;
            }


            .product-image {

                height: 320px;
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

        <a href="shop.php?category=Macramé">
            Macramé
        </a>

        <a href="shop.php?category=Crochet">
            Crochet
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

        <?php else: ?>

            <a href="auth/login.php">
                Login
            </a>

            <a href="auth/register.php">
                Register
            </a>

        <?php endif; ?>

    </nav>

</header>


<main class="shop-container">


    <section class="shop-heading">

        <p class="small-title">
            HANDMADE COLLECTION
        </p>

        <h1>
            Shop Our Collection 🧶
        </h1>

        <p>
            Discover thoughtfully handcrafted
            Macramé & Crochet pieces made
            to bring warmth, charm and beauty
            into your everyday space.
        </p>

    </section>


    <!-- FILTER -->

    <div class="category-filter">

        <a
            href="shop.php"
            class="category-btn <?= $category === "" ? "active" : "" ?>"
        >
            ✨ All Creations
        </a>


        <a
            href="shop.php?category=Macramé"
            class="category-btn <?= $category === "Macramé" ? "active" : "" ?>"
        >
            🪢 Macramé
        </a>


        <a
            href="shop.php?category=Crochet"
            class="category-btn <?= $category === "Crochet" ? "active" : "" ?>"
        >
            🧶 Crochet
        </a>

    </div>


    <!-- MACRAME -->

    <?php if ($category === "Macramé"): ?>

        <div class="category-intro macrame">

            <div class="category-icon">
                🪢
            </div>

            <div class="category-text">

                <small>
                    Natural • Timeless • Handwoven
                </small>

                <h2>
                    Woven Elegance
                </h2>

                <p>
                    Handcrafted Macramé pieces
                    designed with natural textures
                    and timeless charm.
                </p>

            </div>

        </div>

    <?php endif; ?>


    <!-- CROCHET -->

    <?php if ($category === "Crochet"): ?>

        <div class="category-intro crochet">

            <div class="category-icon">
                🧶
            </div>

            <div class="category-text">

                <small>
                    Soft • Cozy • Handmade
                </small>

                <h2>
                    Softly Crafted
                </h2>

                <p>
                    Charming Crochet creations
                    carefully made stitch by stitch
                    with warmth and love.
                </p>

            </div>

        </div>

    <?php endif; ?>


    <!-- PRODUCTS -->

    <section class="products-grid">


        <?php if ($result && $result->num_rows > 0): ?>


            <?php while ($product = $result->fetch_assoc()): ?>


                <div class="product-card">


                    <div class="product-image">


                        <?php if (!empty($product["image"])): ?>

                            <!-- IMPORTANT:
                                 Your images are inside assets/
                                 so path is assets/filename
                            -->

                            <img
                                src="assets/<?= htmlspecialchars($product["image"]) ?>"
                                alt="<?= htmlspecialchars($product["name"]) ?>"
                                onerror="this.style.display='none';"
                            >

                        <?php else: ?>

                            <div class="no-image">
                                🧶
                            </div>

                        <?php endif; ?>


                    </div>


                    <div class="product-info">


                        <span class="category">

                            <?= htmlspecialchars(
                                $product["category"]
                            ) ?>

                        </span>


                        <h2>

                            <?= htmlspecialchars(
                                $product["name"]
                            ) ?>

                        </h2>


                        <p>

                            <?= htmlspecialchars(
                                $product["description"]
                            ) ?>

                        </p>


                        <div class="product-bottom">


                            <strong>

                                ₹<?= number_format(
                                    $product["price"],
                                    2
                                ) ?>

                            </strong>


                            <?php if ($product["stock"] > 0): ?>


                                <form
                                    action="add_to_cart.php"
                                    method="POST"
                                >

                                    <input
                                        type="hidden"
                                        name="product_id"
                                        value="<?= (int)$product["id"] ?>"
                                    >


                                    <button
                                        type="submit"
                                        class="cart-btn"
                                    >

                                        Add to Cart 🛒

                                    </button>

                                </form>


                            <?php else: ?>


                                <button
                                    class="cart-btn disabled"
                                    disabled
                                >

                                    Out of Stock

                                </button>


                            <?php endif; ?>


                        </div>


                    </div>

                </div>


            <?php endwhile; ?>


        <?php else: ?>


            <div
                style="
                    grid-column:1/-1;
                    text-align:center;
                    padding:60px;
                    background:rgba(255,255,255,.55);
                    border-radius:25px;
                "
            >

                <h2>
                    No creations found 🧶
                </h2>

                <p>
                    Try another collection.
                </p>

            </div>


        <?php endif; ?>


    </section>


</main>


</body>

</html>