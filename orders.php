<?php
    require("./connection/connect.php");
    session_start();

    
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sabha Pharmacy</title>

    <!-- Common Tags -->
    <?php require('includes/head.php') ?>
</head>
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
    flex-direction: end;
}

header .account-bar a {
    color: white;
    margin: 4px;
    display: flex;
}

header .account-bar a i {
    margin-top: 4px;
}

header .account-bar .account {
    margin-top: 7px;
}

header .account-bar .account:hover {
    text-decoration: none;
    cursor: pointer;
}
</style>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <?php
                    if(isset($_SESSION['email'])){
                        echo '<div class="col-lg-3">
                        <div class="social d-flex pt-2 pb-2">
                  <i class="fa-brands fa-facebook pr-4" style="font-size:22px; color: white;"></i>
                  <i class="fa-brands fa-instagram pr-4" style="font-size:22px; color: white;"></i>
                  <i class="fa-brands fa-twitter pr-4" style="font-size:22px; color: white;"></i>
                  <i class="fa-brands fa-youtube pr-4" style="font-size:22px; color: white;"></i>
                </div></div>
                        <div class="col-lg-6"></div>
                        <div class="col-lg-3">
                            <div class="account-bar">
                                <a class="account text-light" href="account.php">
                                    <i class="fa-solid fa-circle-user"></i>
                                        &nbsp;&nbsp;My Account&nbsp;&nbsp;
                                    <span class="disabled" style="font-size: 30px; margin-top: -10px;">|</span>
                                </a>
                                <form method="post">
                                    <a class="btn btn-outline-light btn-sm" href="logout.php"><i
                                    class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;&nbsp;Logout</a>
                                </form>
                            </div>
                        </div>';
                    }else{
                    echo '<div class="col-lg-3">
                    <div class="social d-flex pt-2 pb-2">
              <i class="fa-brands fa-facebook pr-4" style="font-size:22px; color: white;"></i>
              <i class="fa-brands fa-instagram pr-4" style="font-size:22px; color: white;"></i>
              <i class="fa-brands fa-twitter pr-4" style="font-size:22px; color: white;"></i>
              <i class="fa-brands fa-youtube pr-4" style="font-size:22px; color: white;"></i>
            </div></div>
                    <div class="col-lg-8"></div>
                    <div class="col-lg-1">
                        <div class="account-bar">
                            <a class="btn btn-outline-light btn-sm" href="login.php">
                                <i class="fa-solid fa-user"></i>
                                &nbsp;&nbsp;Login
                            </a>
                        </div>
                    </div>';
                    }
                ?>
            </div>
        </div>
    </header>
    <!-- Navbar and Header -->
    <?php require('includes/navbar.php') ?>

    <section>
        <div class="container mt-4 mb-4">
            <?php
                if(isset($_SESSION['email'])){
                    $sql = "SELECT * from orders where email = '".$_SESSION['email']."'";
                    $result=mysqli_query($con,$sql);
                    if($result){
                        while($row=mysqli_fetch_assoc($result)){
                            $id=$row['id'];
                            $products=$row['products'];
                            $amount_paid=$row['amount_paid'];
                            $mode=$row['mode'];
                            echo '
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 border mb-4 rounded card">
                                            <div class="row card-body mb-1">
                                                <div class="col-md-6">
                                                    <h5 class="text-secondary">Products</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <h5 class="text-secondary">Price</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="action.php?order='.$row['id'].'"  type="submit" class="btn btn-danger">Cancel</a>
                                                </div>
                                            </div>
                                            <hr class="pb-2" style="width:60%;margin:0;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="text-success">'.$products.'</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <h5 class="text-danger">Rs. '.$amount_paid.'</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            ';
                        }
                    }
                    else{

                    }
                }else{
                    echo '<div class="row justify-content-center">
			                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 border rounded p-4">
                                <div class="text-center">
                                    <i class="fa-solid fa-circle-exclamation fa-3x" aria-hidden="true"></i>
                                    <div class="title mt-2">
							            <h4>You are not logged in.</h4>
						            </div>
                                    <div class="text mb-2">
							            <span>Please logged in and try again.</span>
						            </div>
                                    <a class="btn btn-warning" href="login.php">Login</a>
                                </div>
                            </div>
				        </div>';
                }
            ?>
        </div>
    </section>
    <!-- Footer -->
    <?php require('includes/footer.php') ?>
<script type="text/javascript">
    $(document).ready(function() {

        $(".itemQty").on('change', function(){
            var $el = $(this).closest('tr');

            var pid = $el.find(".pid").val();
            var pprice = $el.find(".pprice").val();
            var qty = $el.find(".itemQty").val();
            location.reload(true);

            $.ajax({
                url: 'action.php',
                method: 'post',
                cache: false,
                data: {qty:qty,pid:pid,pprice:pprice},
                success: function(response){
                    console.log(response);
                }
            })
        });

        load_cart_item_number();

        function load_cart_item_number() {
            $.ajax({
                url: 'action.php',
                method: 'get',
                data: {
                    cartItem: "cart_item"
                },
                success: function(response) {
                    $("#cart-item").html(response);
                }
            });
        }
    });
</script>
</body>

</html>