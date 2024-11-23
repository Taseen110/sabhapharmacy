<?php
require("./connection/connect.php");
session_start();

// Initialize the search query variable
$searchQuery = '';
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchQuery = htmlspecialchars($_POST['search']);
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "ayuruveda";

$con = mysqli_connect($host, $user, $password, $dbname);

if (!$con) {
    echo mysqli_connect_error($con);
}

// SQL query to search for products
$sql = "SELECT * FROM product WHERE product_name LIKE '%$searchQuery%'";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Ayurvedic Pharmacy</title>
    <?php require('includes/head.php'); ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        header {
            width: 100%;
            height: 40px;
            background-color: #07660a;
        }
   </style>
</head>
<body>
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
    <?php require('includes/navbar.php'); ?>
    <section>
        <div class="container">
            <div class="" id="message"></div>
            <div class="row mt-4 pb-3 justify-content-center">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4" style="text-align: center;">
                    <div class="card" style="width: 18rem;">
                        <img src="<?= $row['product_image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title bold"><b><?= $row['product_name']; ?></b></h6>
                            <h6 class="card-title bold">Rs. <?= $row['product_price']; ?> /=</h6>
                            <form action="" method="post" class="form-submit">
                                <input type="hidden" class="pid" value="<?= $row['id']; ?>">
                                <input type="hidden" class="pname" value="<?= $row['product_name']; ?>">
                                <input type="hidden" class="pprice" value="<?= $row['product_price']; ?>">
                                <input type="hidden" class="pimage" value="<?= $row['product_image']; ?>">
                                <input type="hidden" class="pcode" value="<?= $row['product_code']; ?>">

                                <div class="btnrow"> 
                                    <input class="btn btn-primary addItemBtn" type="button" value="Add to cart">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".addItemBtn").click(function() {
                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {pid: pid, pname: pname, pprice: pprice, pimage: pimage, pcode: pcode},
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                        load_cart_item_number();
                        // Redirect to index.php after adding to cart
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 1000); // Redirect after 1 second
                    }
                });
            });

            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {cartItem: "cart_item"},
                    success: function(response) {
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>

    <footer>
        <?php require('includes/footer.php'); ?>
    </footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
