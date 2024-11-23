<?php
    session_start();
    require("./connection/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sabha Pharmacy</title>

    <!-- Common Tags -->
    <?php require('includes/head.php') ?>
</head>
<!-- Header Style -->
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
                        <div class="col-lg-6">
                             <div class="col-lg-6">
                    <form action="search.php" method="POST" class="d-flex justify-content-center">
                        <input type="text" name="search" class="form-control search-bar" placeholder="Search for medicines..." required>
                        <button type="submit" class="btn btn-success ml-2">Search</button>
                    </form>
                    </div></div>
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
                        echo '  <div class="col-lg-3">
                                    <div class="social d-flex pt-2 pb-2">
                                        <i class="fa-brands fa-facebook pr-4" style="font-size:22px; color: white;"></i>
                                        <i class="fa-brands fa-instagram pr-4" style="font-size:22px; color: white;"></i>
                                        <i class="fa-brands fa-twitter pr-4" style="font-size:22px; color: white;"></i>
                                        <i class="fa-brands fa-youtube pr-4" style="font-size:22px; color: white;"></i>
                                    </div>
                                </div>
                                
                                <div class="col-lg-8">
                              <div class="col-lg-6">
                       <form action="search.php" method="POST" class="d-flex justify-content-center">
                        <input type="text" name="search" class="form-control search-bar" placeholder="Search for medicines..." required>
                        <button type="submit" class="btn btn-success ml-2">Search</button>
                    </form>
                    </div> 
                                </div>
                                <div class="col-lg-1">
                                    <div class="account-bar">
                                        <a class="btn btn-outline-light btn-sm" href="login.php">
                                            <i class="fa-solid fa-user"></i>
                                            &nbsp;&nbsp;Login
                                        </a>
                                    </div>
                                </div>
                            '
                        ;
                    }
                ?>
                 
            </div>
        </div>
       
    </header>
    <!-- Navbar and Header -->
    <?php require('includes/navbar.php') ?>
    <section>
        <div class="container">
            <div class="" id="message"></div>
            <div class="row mt-4 pb-3 justify-content-center">
                <?php
                    include './connection/connect.php';
                    $stmt = $con->prepare("SELECT * FROM product");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()):
                ?>
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
                                        <input class="btn btn-primary addItemBtn" onclick="submit()" value="Add to cart">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile;?>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".addItemBtn").click(function(e){
                e.preventDefault();
                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},
                    success:function(response){
                        $("#message").html(response);
                        window.scrollTo(0,0);
                        load_cart_item_number();
                    }
                });
            });

            load_cart_item_number();

            function load_cart_item_number(){
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {cartItem:"cart_item"},
                    success:function(response){
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>                    

    <!-- Footer -->
    <?php require('includes/footer.php') ?>
</body>

</html>