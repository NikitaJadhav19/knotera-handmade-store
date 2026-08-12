<?php

session_start();
require_once "../config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $message = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1"
        );

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: ../index.php");
                exit;

            } else {

                $message = "Incorrect password.";

            }

        } else {

            $message = "No account found with this email.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Knotera | Login</title>


<style>

/* ================= RESET ================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* ================= BODY ================= */

body {

    min-height: 100vh;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 25px;

    color: #493a33;

    background:

        radial-gradient(
            circle at 10% 15%,
            #dce9df 0,
            transparent 32%
        ),

        radial-gradient(
            circle at 90% 85%,
            #f3d8e2 0,
            transparent 34%
        ),

        linear-gradient(
            135deg,
            #faf7f3,
            #eee5df
        );

    position: relative;

    overflow: hidden;
}


/* ================= DECORATIVE CIRCLES ================= */

body::before {

    content: "";

    position: fixed;

    width: 260px;
    height: 260px;

    border-radius: 50%;

    background:
        rgba(214, 184, 198, 0.28);

    top: -90px;
    right: -80px;

    filter: blur(5px);

}


body::after {

    content: "";

    position: fixed;

    width: 220px;
    height: 220px;

    border-radius: 50%;

    background:
        rgba(185, 207, 190, 0.28);

    bottom: -80px;
    left: -70px;

    filter: blur(5px);

}


/* ================= MAIN CARD ================= */

.login-wrapper {

    width: 100%;

    max-width: 430px;

    position: relative;

    z-index: 2;

    padding: 42px 38px 36px;

    border-radius: 32px;

    background:
        rgba(255,255,255,0.55);

    border:
        1px solid
        rgba(255,255,255,0.85);

    backdrop-filter:
        blur(22px);

    -webkit-backdrop-filter:
        blur(22px);

    box-shadow:

        0 30px 70px
        rgba(70,50,40,0.14),

        inset 0 1px 0
        rgba(255,255,255,0.8);

}


/* ================= LOGO ================= */

.logo {

    text-align: center;

    margin-bottom: 28px;
}


.logo-icon {

    width: 58px;

    height: 58px;

    margin: 0 auto 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 20px;

    background:
        linear-gradient(
            135deg,
            #dce9df,
            #f2dce4
        );

    box-shadow:
        0 10px 25px
        rgba(70,50,40,0.10);

    font-size: 28px;
}


.logo h1 {

    font-family:
        Georgia,
        serif;

    font-size: 29px;

    color: #493a33;

    letter-spacing: -0.5px;
}


.logo p {

    margin-top: 6px;

    font-size: 12px;

    letter-spacing: 2px;

    text-transform: uppercase;

    color: #927c70;
}


/* ================= HEADING ================= */

.login-heading {

    text-align: center;

    margin-bottom: 28px;
}


.login-heading h2 {

    font-family:
        Georgia,
        serif;

    font-size: 32px;

    color: #44342d;

    margin-bottom: 8px;
}


.login-heading p {

    font-size: 14px;

    color: #806e64;

    line-height: 1.6;
}


/* ================= MESSAGE ================= */

.message {

    margin-bottom: 18px;

    padding: 12px 14px;

    border-radius: 12px;

    background:
        rgba(244,215,224,0.75);

    color: #8c5267;

    font-size: 13px;

    text-align: center;
}


/* ================= FORM ================= */

.form-group {

    margin-bottom: 18px;
}


.form-group label {

    display: block;

    margin-bottom: 8px;

    font-size: 12px;

    font-weight: bold;

    color: #655148;

    letter-spacing: .3px;
}


.form-group input {

    width: 100%;

    padding: 14px 16px;

    border-radius: 14px;

    border:
        1px solid
        rgba(150,130,120,0.20);

    background:
        rgba(255,255,255,0.62);

    color: #493a33;

    font-size: 14px;

    outline: none;

    transition: .25s;
}


.form-group input::placeholder {

    color: #aa9990;
}


.form-group input:focus {

    border-color:
        rgba(150,105,120,.55);

    background:
        rgba(255,255,255,.85);

    box-shadow:
        0 0 0 4px
        rgba(232,202,214,.35);
}


/* ================= LOGIN BUTTON ================= */

.login-btn {

    width: 100%;

    border: none;

    padding: 15px;

    margin-top: 7px;

    border-radius: 15px;

    cursor: pointer;

    color: white;

    font-size: 14px;

    font-weight: bold;

    letter-spacing: .3px;

    background:

        linear-gradient(
            135deg,
            #5a4034,
            #87604e
        );

    box-shadow:
        0 12px 25px
        rgba(70,45,35,.18);

    transition: .3s;
}


.login-btn:hover {

    transform:
        translateY(-3px);

    box-shadow:
        0 17px 32px
        rgba(70,45,35,.24);
}


/* ================= REGISTER ================= */

.register {

    margin-top: 25px;

    padding-top: 22px;

    border-top:
        1px solid
        rgba(130,110,100,.15);

    text-align: center;

    font-size: 13px;

    color: #806e64;
}


.register a {

    color: #966575;

    font-weight: bold;

    text-decoration: none;
}


.register a:hover {

    text-decoration: underline;
}


/* ================= HOME LINK ================= */

.home-link {

    display: block;

    margin-top: 18px;

    text-align: center;

    text-decoration: none;

    font-size: 12px;

    color: #8b776b;

    transition: .2s;
}


.home-link:hover {

    color: #5a4034;
}


/* ================= MOBILE ================= */

@media(max-width:500px) {

    body {

        padding: 16px;
    }

    .login-wrapper {

        padding:
            32px 24px 28px;

        border-radius: 26px;
    }

    .login-heading h2 {

        font-size: 28px;
    }

}

</style>

</head>


<body>


<div class="login-wrapper">


    <!-- LOGO -->

    <div class="logo">

        <div class="logo-icon">
            🧶
        </div>

        <h1>
            Knotera
        </h1>

        <p>
            Handmade • With Love
        </p>

    </div>


    <!-- HEADING -->

    <div class="login-heading">

        <h2>
            Welcome Back
        </h2>

        <p>
            Sign in to continue your handmade journey.
        </p>

    </div>


    <!-- MESSAGE -->

    <?php if ($message !== ""): ?>

        <div class="message">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


    <!-- LOGIN FORM -->

    <form
        method="POST"
        action=""
    >


        <div class="form-group">

            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >

        </div>


        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

        </div>


        <button
            type="submit"
            class="login-btn"
        >

            Login →

        </button>


    </form>


    <!-- REGISTER -->

    <div class="register">

        Don't have an account?

        <a href="register.php">
            Create Account
        </a>

    </div>


    <!-- HOME -->

    <a
        href="../index.php"
        class="home-link"
    >
        ← Back to Knotera
    </a>


</div>


</body>

</html>