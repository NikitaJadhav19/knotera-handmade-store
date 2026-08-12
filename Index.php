<?php

session_start();
require_once "config.php";

$result = $conn->query(
    "SELECT * FROM products ORDER BY id DESC LIMIT 6"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Knotera | Handmade Macramé & Crochet</title>


<style>

*{
    box-sizing:border-box;
}

body{

    margin:0;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color:#44342d;

    min-height:100vh;

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


/* ================= HEADER ================= */

header{

    width:calc(100% - 40px);

    max-width:1250px;

    margin:20px auto;

    padding:16px 25px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    border-radius:22px;

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


.logo{

    font-family:
        Georgia,
        serif;

    font-size:25px;

    font-weight:bold;

    color:#4a362d;

    white-space:nowrap;
}


nav{

    display:flex;

    align-items:center;

    justify-content:flex-end;

    gap:17px;

    flex-wrap:wrap;
}


nav a{

    text-decoration:none;

    color:#5f4b41;

    font-size:14px;

    font-weight:600;

    transition:.2s;
}


nav a:hover{

    color:#9b6855;
}


nav span{

    font-size:14px;

    font-weight:600;

    color:#6d5549;
}


/* MY ORDERS */

.my-orders-link{

    color:#58745d !important;

}


/* ================= HERO ================= */

.hero{

    max-width:1250px;

    min-height:510px;

    margin:0 auto;

    padding:70px 25px;

    display:flex;

    align-items:center;

    justify-content:center;

    text-align:center;

    border-radius:35px;

    background:

        linear-gradient(
            135deg,
            rgba(225,239,228,.92),
            rgba(255,246,242,.90),
            rgba(244,222,231,.90)
        );

    box-shadow:
        0 25px 60px
        rgba(70,50,40,.10);
}


.hero-content{

    max-width:800px;
}


.hero-small{

    margin-bottom:15px;

    font-size:11px;

    font-weight:bold;

    letter-spacing:3px;

    color:#8b776b;
}


.hero h1{

    margin:0;

    font-family:
        Georgia,
        serif;

    font-size:
        clamp(48px,7vw,82px);

    line-height:1.05;

    color:#3e2d25;
}


.hero h1 span{

    color:#966575;
}


.hero p{

    max-width:650px;

    margin:22px auto 0;

    color:#78665c;

    font-size:17px;

    line-height:1.8;
}


.hero-button{

    margin-top:32px;
}


.primary-btn{

    display:inline-block;

    padding:15px 32px;

    border-radius:30px;

    background:
        linear-gradient(
            135deg,
            #5a4034,
            #87604e
        );

    color:white;

    text-decoration:none;

    font-size:14px;

    font-weight:bold;

    box-shadow:
        0 10px 25px
        rgba(70,45,35,.18);

    transition:.25s;
}


.primary-btn:hover{

    transform:
        translateY(-3px);

    box-shadow:
        0 15px 30px
        rgba(70,45,35,.25);
}


/* ================= CATEGORY ================= */

.categories{

    max-width:1250px;

    margin:auto;

    padding:75px 20px 35px;

    text-align:center;
}


.section-label{

    margin-bottom:10px;

    font-size:11px;

    font-weight:bold;

    letter-spacing:3px;

    color:#8b776b;
}


.categories h2,
.featured h2{

    margin:0 0 35px;

    font-family:
        Georgia,
        serif;

    font-size:40px;

    color:#3e2d25;
}


.category-grid{

    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:25px;
}


.category-card{

    min-height:190px;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    border-radius:28px;

    text-decoration:none;

    transition:.3s;

    border:
        1px solid
        rgba(255,255,255,.85);

    box-shadow:
        0 15px 40px
        rgba(70,50,40,.08);
}


.category-card:hover{

    transform:
        translateY(-7px);
}


.macrame-card{

    background:

        linear-gradient(
            135deg,
            #d5e4d7,
            #f4f1e8
        );
}


.crochet-card{

    background:

        linear-gradient(
            135deg,
            #f2d8e1,
            #fff4f0
        );
}


.category-card .icon{

    font-size:43px;

    margin-bottom:12px;
}


.category-card h3{

    margin:0 0 7px;

    font-family:
        Georgia,
        serif;

    font-size:27px;

    color:#49362e;
}


.category-card p{

    margin:0;

    color:#756259;

    font-size:14px;
}


/* ================= FEATURED ================= */

.featured{

    max-width:1250px;

    margin:auto;

    padding:75px 20px 90px;

    text-align:center;
}


.products-grid{

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:28px;

    text-align:left;
}


/* ================= PRODUCT CARD ================= */

.product-card{

    overflow:hidden;

    border-radius:27px;

    background:
        rgba(255,255,255,.58);

    border:
        1px solid
        rgba(255,255,255,.85);

    backdrop-filter:
        blur(20px);

    box-shadow:
        0 18px 45px
        rgba(70,50,40,.10);

    transition:
        transform .3s,
        box-shadow .3s;
}


.product-card:hover{

    transform:
        translateY(-8px);

    box-shadow:
        0 25px 55px
        rgba(70,50,40,.17);
}


/* ================= IMAGE ================= */

.product-image{

    width:100%;

    height:300px;

    overflow:hidden;

    background:#eee7e1;
}


.product-image img{

    width:100%;

    height:100%;

    display:block;

    object-fit:cover;

    transition:
        transform .4s;
}


.product-card:hover
.product-image img{

    transform:
        scale(1.06);
}


.no-image{

    width:100%;

    height:100%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:60px;

    color:#a18c80;
}


/* ================= PRODUCT INFO ================= */

.product-info{

    padding:23px;
}


.category{

    display:inline-block;

    padding:6px 11px;

    border-radius:20px;

    font-size:10px;

    font-weight:bold;

    letter-spacing:1.5px;

    text-transform:uppercase;

    background:#e0eadf;

    color:#55705b;
}


.product-card:nth-child(even)
.category{

    background:#f2dce4;

    color:#966475;
}


.product-info h2{

    margin:
        13px 0 8px;

    font-family:
        Georgia,
        serif;

    font-size:23px;

    color:#402e26;
}


.product-info p{

    margin:0;

    min-height:45px;

    color:#78665c;

    font-size:14px;

    line-height:1.6;
}


.product-bottom{

    margin-top:20px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:10px;
}


.product-bottom strong{

    font-size:21px;

    color:#4b3429;
}


.view-btn{

    padding:
        10px 15px;

    border-radius:12px;

    background:
        linear-gradient(
            135deg,
            #5a4034,
            #87604e
        );

    color:white;

    text-decoration:none;

    font-size:12px;

    font-weight:bold;

    transition:.25s;
}


.view-btn:hover{

    transform:
        translateY(-2px);
}


/* ================= CTA ================= */

.bottom-cta{

    max-width:1250px;

    margin:0 auto 50px;

    padding:65px 20px;

    text-align:center;

    border-radius:30px;

    background:

        linear-gradient(
            135deg,
            #dce9df,
            #f4dce5
        );

    box-shadow:
        0 20px 50px
        rgba(70,50,40,.09);
}


.bottom-cta h2{

    margin:0 0 12px;

    font-family:
        Georgia,
        serif;

    font-size:38px;

    color:#49362e;
}


.bottom-cta p{

    margin:0 0 25px;

    color:#756259;
}


.bottom-cta a{

    display:inline-block;

    padding:
        13px 27px;

    border-radius:25px;

    background:#5a4034;

    color:white;

    text-decoration:none;

    font-weight:bold;
}


/* ================= FOOTER ================= */

footer{

    padding:25px;

    text-align:center;

    background:#44342d;

    color:#ddd0c8;

    font-size:13px;
}


/* ================= MOBILE ================= */

@media(max-width:950px){

    .products-grid{

        grid-template-columns:
            repeat(2,1fr);
    }
}


@media(max-width:650px){

    header{

        width:
            calc(100% - 24px);

        flex-direction:column;

        align-items:flex-start;
    }


    nav{

        justify-content:flex-start;

        gap:12px;
    }


    .hero{

        margin:
            0 12px;

        min-height:450px;

        padding:50px 20px;
    }


    .category-grid{

        grid-template-columns:1fr;
    }


    .products-grid{

        grid-template-columns:1fr;
    }


    .product-image{

        height:320px;
    }


    .categories h2,
    .featured h2{

        font-size:32px;
    }

}

</style>

</head>


<body>


<!-- ================= HEADER ================= -->

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


            <!-- MY ORDERS -->

            <a
                href="my_orders.php"
                class="my-orders-link"
            >

                📦 My Orders

            </a>


            <span>

                Hi,
                <?= htmlspecialchars(
                    $_SESSION["user_name"]
                ) ?>

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


<!-- ================= HERO ================= -->

<section class="hero">

    <div class="hero-content">

        <div class="hero-small">
            HANDMADE • UNIQUE • WITH LOVE
        </div>


        <h1>

            Handmade
            <span>With Love</span> 🧶

        </h1>


        <p>

            Discover beautiful Macramé &
            Crochet creations, thoughtfully
            handcrafted to bring warmth,
            charm and creativity into your
            everyday space.

        </p>


        <div class="hero-button">

            <a
                href="shop.php"
                class="primary-btn"
            >

                Explore Collection →

            </a>

        </div>

    </div>

</section>


<!-- ================= CATEGORIES ================= -->

<section class="categories">

    <div class="section-label">
        SHOP BY CATEGORY
    </div>


    <h2>
        Made For Your Space
    </h2>


    <div class="category-grid">


        <a
            href="shop.php?category=Macramé"
            class="category-card macrame-card"
        >

            <div class="icon">
                🪢
            </div>


            <h3>
                Macramé
            </h3>


            <p>
                Elegant handmade knotwork
            </p>

        </a>


        <a
            href="shop.php?category=Crochet"
            class="category-card crochet-card"
        >

            <div class="icon">
                🧶
            </div>


            <h3>
                Crochet
            </h3>


            <p>
                Cute handmade creations
            </p>

        </a>


    </div>

</section>


<!-- ================= PRODUCTS ================= -->

<section class="featured">

    <div class="section-label">
        OUR COLLECTION
    </div>


    <h2>
        Featured Creations ✨
    </h2>


    <div class="products-grid">


        <?php if ($result && $result->num_rows > 0): ?>


            <?php while (
                $product = $result->fetch_assoc()
            ): ?>


                <div class="product-card">


                    <div class="product-image">


                        <?php if (
                            !empty($product["image"])
                        ): ?>


                            <img

                                src="assets/<?= htmlspecialchars(
                                    $product["image"]
                                ) ?>"

                                alt="<?= htmlspecialchars(
                                    $product["name"]
                                ) ?>"

                                onerror="
                                    this.style.display='none';
                                    this.parentElement.innerHTML +=
                                    '<div class=\'no-image\'>🧶</div>';
                                "

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


                            <a
                                href="shop.php"
                                class="view-btn"
                            >

                                View Product →

                            </a>


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
                "
            >

                <h2>
                    No creations found 🧶
                </h2>

            </div>


        <?php endif; ?>


    </div>

</section>


<!-- ================= CTA ================= -->

<section class="bottom-cta">

    <h2>
        Find Something Handmade 🤍
    </h2>


    <p>
        Explore our complete collection
        of Macramé & Crochet creations.
    </p>


    <a href="shop.php">
        View All Products →
    </a>

</section>


<!-- ================= FOOTER ================= -->

<footer>

    © <?= date("Y") ?> Knotera.
    Handmade with love 🧶

</footer>


</body>

</html>