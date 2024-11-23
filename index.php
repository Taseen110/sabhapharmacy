<?php
require("./connection/connect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sabha Pharmacy</title>
    <!-- Common Tags -->
    <?php require('includes/head.php'); ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        header {
            width: 100%;
            height: 40px;
            background-color: #07660a;
        }

        header .col-11 {
            text-align: end;
        }

        header .account-bar {
            display: flex;
            align-items: center;
        }

        header .account-bar a {
            color: white;
            margin: 4px;
            display: flex;
            align-items: center;
        }

        header .account-bar a i {
            margin-top: 4px;
        }

        /* Search Input Styles */
        .search-bar {
            width: 300px; /* Adjust width as needed */
        }

        /* Carousel Styles */
        .carousel-indicators .active {
            background-color: #2980b9;
        }

        .carousel-inner img {
            width: 100%;
            max-height: 460px;
        }

        .header-text {
            position: absolute;
            top: 20%;
            left: 1.8%;
            color: #fff;
        }

        .header-text h2 {
            font-size: 40px;
        }

        .header-text h2 span,
        .header-text h3 span {
            padding: 10px;
        }

        .header-text h3 span {
            background-color: #000;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="social d-flex pt-2 pb-2">
                        <i class="fa-brands fa-facebook pr-4" style="font-size:22px; color: white;"></i>
                        <i class="fa-brands fa-instagram pr-4" style="font-size:22px; color: white;"></i>
                        <i class="fa-brands fa-twitter pr-4" style="font-size:22px; color: white;"></i>
                        <i class="fa-brands fa-youtube pr-4" style="font-size:22px; color: white;"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="search.php" method="POST" class="d-flex justify-content-center">
                        <input type="text" name="search" class="form-control search-bar" placeholder="Search for medicines..." required>
                        <button type="submit" class="btn btn-success ml-2">Search</button>
                    </form>
                </div>
                <div class="col-lg-3">
                    <div class="account-bar">
                        <?php if (isset($_SESSION['email'])): ?>
                            <a class="account text-light" href="account.php">
                                <i class="fa-solid fa-circle-user"></i>
                                My Account
                                <span class="disabled" style="font-size: 30px; margin-left: 10px;">|</span>
                            </a>
                            <a class="btn btn-outline-light btn-sm" href="logout.php">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                            </a>
                        <?php else: ?>
                            <a class="btn btn-outline-light btn-sm" href="login.php">
                                <i class="fa-solid fa-user"></i> Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navbar and Header -->
    <?php require('includes/navbar.php'); ?>

    <section>
        <!-- Slide -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="assets/slide (1).jpg" alt="First slide">
                    <div class="header-text hidden-xs text-center">
                        <h4 class="font-weight-bold">Welcome to</h4>
                        <h1 class="font-weight-bold">Sabha Pharmacy</h1>
                        <p class="font-weight-bold">Ayurveda Products. The Oldest Medical System Which Comprises Thousands Of Medical Concepts & Hypothesis.</p>
                        <a href="product.php" class="btn btn-success rounded-5">Shop Now <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/slide (2).jpg" alt="Second slide">
                    <div class="header-text hidden-xs text-right">
                        <h4 class="font-weight-bold">Make Your Own</h4>
                        <h1 class="font-weight-bold">HEALTH</h1>
                        <p class="font-weight-bold">The Best Investment You Have Ever Made Is Your Own Health.</p>
                        <a href="product.php" class="btn btn-success rounded-5">Shop Now <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/slide (3).jpg" alt="Third slide">
                    <div class="header-text hidden-xs text-right">
                        <h4 class="font-weight-bold">It Is An</h4>
                        <h1 class="font-weight-bold">INVESTMENT</h1>
                        <p class="font-weight-bold">Your Health Is An Investment Not An EXPENSE.</p>
                        <a href="product.php" class="btn btn-success rounded-5">Shop Now <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row" style="background-color: #07660a; height: 90px;">
                <div class="col-lg-3">
                    <div class="d-flex p-3 text-white">
                        <i class="fa-solid fa-truck-fast p-3" style="font-size:26px;"></i>
                        <div class="details">
                            <p class="m-0 text-capitalize font-weight-bold" style="font-size:18px;">Free Shipping</p>
                            <p class="p-0">Free Shipping All Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex p-3 text-white">
                        <i class="fa-regular fa-circle-check p-3" style="font-size:26px;"></i>
                        <div class="details">
                            <p class="m-0 text-capitalize font-weight-bold" style="font-size:18px;">PAYMENT METHOD</p>
                            <p class="p-0">Secure Payment</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex p-3 text-white">
                        <i class="fa-solid fa-arrow-rotate-left p-3" style="font-size:26px;"></i>
                        <div class="details">
                            <p class="m-0 text-capitalize font-weight-bold" style="font-size:18px;">30 DAY RETURNS</p>
                            <p class="p-0">30-Day Return Policy</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex p-3 text-white">
                        <i class="fa-solid fa-user-gear p-3" style="font-size:26px;"></i>
                        <div class="details">
                            <p class="m-0 text-capitalize font-weight-bold" style="font-size:18px;">HELP CENTER</p>
                            <p class="p-0">24/7 Support System</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require('includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
