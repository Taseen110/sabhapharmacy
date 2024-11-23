<?php
    require("./connection/connect.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sabah Pharmacy</title>

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

    <section style="height: 50vh;">
        <div class="container mt-4 mb-4">
            <?php
                $sql = "SELECT * from customer where email = '".$_SESSION['email']."'";
                $result=mysqli_query($con,$sql);
                if($result){
                    while($row=mysqli_fetch_assoc($result)){
                        $name=$row['name'];
                        $email=$row['email'];
                        $number=$row['number'];
                        $address=$row['address'];
                        $password=$row['password'];
                            echo    '
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <h1>'.$name.'</h1>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <hr class="pb-2" style="width:90%;margin:0;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h4>Email Address </h4>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <h4>: '.$email.'</h4>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h4>Phone Number </h4>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <h4>: '.$number.'</h4>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h4>Home Address </h4>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <h4>: '.$address.'</h4>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h4>Password </h4>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <h4>: '.$password.'</h4>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    '
                            ;
                    }
                }
            ?>
            <a href="orders.php" class="btn btn-success mt-4">My Orders</a>
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