<?php
    include './connection/connect.php';
    session_start();
    $grand_total = 0;
    $allItems = '';
    $items = array();

    $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $grand_total +=$row['total_price'];
        $item[] = $row['ItemQty'];
        $price[] = $row['total_price'];
    }
    $allItems = implode("<br/>", $item);
    $allPrice = implode("<br/>Rs. ", $price);



    $sql = "SELECT * from customer where email = '".$_SESSION['email']."'";
    $result=mysqli_query($con,$sql);
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $name=$row['name'];
            $email=$row['email'];
            $number=$row['number'];
            $address=$row['address'];
        }
    }

    if(isset($_POST['card'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $number=$_POST['number'];
        $address=$_POST['address'];
        $products=$_POST['products'];
        $amount_paid=$_POST['amount_paid'];
        $mode=$_POST['card'];

        $sql="insert into `orders` (name,email,number,address,products,amount_paid,mode) values('$name','$email','$number','$address','$products','$amount_paid','$mode')";
        $result=mysqli_query($con,$sql);
        if($result){
            $stmt = $con->prepare("DELETE FROM cart");
            $stmt->execute();
            header('location:success.php');
        }
        else{
            die(mysqli_error($con));
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Ayuruveda | Checkout</title>

    <!-- Common Tags -->
    <?php require('includes/head.php') ?>
</head>
<style>
.rounded {
    border-radius: 1rem
}

.nav-pills .nav-link {
    color: #555
}

.nav-pills .nav-link.active {
    color: white
}

input[type="radio"] {
    margin-right: 5px
}

.bold {
    font-weight: bold
}
</style>

<body>
    <!-- Navbar and Header -->
    <?php require('includes/navbar.php') ?>

    <section>
        <div class="container mt-4 mb-4">
            <div class="row" id="order">
                <div class="col-lg-5">
                    <div class="row mt-3">
                        <div class="col-lg-8">
                            <h5><b>Products List</b></h5>
                        </div>
                        <div class="col-lg-4">
                            <h5><b>Price</b></h5>
                        </div>
                    </div>
                    <hr class="pb-2" style="width:90%;margin:0;">
                    <div class="row">
                        <div class="col-lg-7">
                            <h6 class="text-success"><?= $allItems; ?></h6>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                            <h6 class="font-end">Rs. <?= $allPrice; ?></h6>
                        </div>
                    </div>
                    <hr class="pb-2" style="width:90%;margin:0;">
                    <div class="row">
                        <div class="col-lg-7">
                            <h5 class="text-secondary"><b>Delivery Charge </b></h5>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                            <p class="font-end">Rs. 0</p>
                        </div>
                    </div>
                    <hr class="pb-2" style="width:90%;margin:0;">
                    <div class="row">
                        <div class="col-lg-7">
                            <h5><b>Total Amount Payable</b></h5>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                            <h5 class="font-end text-danger">Rs. <?= number_format($grand_total) ?></h5>
                        </div>
                    </div>
                    <hr class="pb-2" style="width:90%;margin:0;">
                    <hr style="width:90%;margin:0;">
                </div>

                <div class="col-lg-7">
                    <form action="" method="post" id="placeOrder">
                        <input type="hidden" name="products" value="<?= $allItems; ?>">
                        <input type="hidden" name="amount_paid" value="<?= $grand_total; ?>">
                        <div class="form-group mt-2">
                            <input type="text" name="name" class="form-control" value="<?= $name;?>" required>
                        </div>
                        <div class="form-group mt-2">
                            <input type="email" name="email" class="form-control" value="<?= $email;?>" required>
                        </div>
                        <div class="form-group mt-2">
                            <input type="tel" name="number" class="form-control" value="<?= $number;?>" required>
                        </div>
                        <div class="form-group mt-2">
                            <input type="text" name="address" class="form-control" value="<?=  $address;?>">
                        </div>
                        <h6 class="text-center mt-2">--------- Select Payment Mode ---------</h6>
                        <div class="form-group row mt-2">
                            <div class="row">
                                <div class="col-lg-11 mx-auto">
                                    <div class="card ">
                                        <div class="card-header">
                                            <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                                                <!-- Credit card form tabs -->
                                                <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                                    <li class="nav-item">
                                                        <a data-toggle="pill" href="#credit-card"
                                                            class="nav-link active ">
                                                            <i class="fas fa-credit-card mr-2"></i>
                                                            Credit Card
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a data-toggle="pill" href="#paypal" class="nav-link ">
                                                            <i class="fa-solid fa-truck-fast mr-2"></i>
                                                            Cash on Delivery
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div> <!-- End -->
                                            <!-- Credit card form content -->
                                            <div class="tab-content">
                                                <!-- credit card info-->
                                                <div id="credit-card" class="tab-pane fade show active pt-3">
                                                    <form role="form" onsubmit="event.preventDefault()">
                                                        <div class="form-group"> <label for="username">
                                                                <h6>Card Owner</h6>
                                                            </label> <input type="text" name="username"
                                                                placeholder="Card Owner Name" 
                                                                class="form-control "> </div>
                                                        <div class="form-group"> <label for="cardNumber">
                                                                <h6>Card number</h6>
                                                            </label>
                                                            <div class="input-group"> <input type="text"
                                                                    name="cardNumber" placeholder="Valid card number"
                                                                    class="form-control " >
                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted"> <i
                                                                            class="fab fa-cc-visa mx-1"></i> <i
                                                                            class="fab fa-cc-mastercard mx-1"></i> <i
                                                                            class="fab fa-cc-amex mx-1"></i> </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <div class="form-group"> <label><span class="hidden-xs">
                                                                            <h6>Expiration Date</h6>
                                                                        </span></label>
                                                                    <div class="input-group"> <input type="number"
                                                                            placeholder="MM" name=""
                                                                            class="form-control" > <input
                                                                            type="number" placeholder="YY" name=""
                                                                            class="form-control" > </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group mb-4"> <label
                                                                        data-toggle="tooltip"
                                                                        title="Three digit CV code on the back of your card">
                                                                        <h6>CVV <i
                                                                                class="fa fa-question-circle d-inline"></i>
                                                                        </h6>
                                                                    </label> <input type="text" 
                                                                        class="form-control"> </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer"> 
                                                            <button type="submit" value="card payment" name="card" class="subscribe btn btn-primary btn-block shadow-sm">
                                                                Confirm Payment </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div id="paypal" class="tab-pane fade pt-3">
                                                
                                                <p class="text-muted"> Note: For cash-on-delivery terms, goods are
                                                    shipped before payment is made. For cash-in-advance terms, the
                                                    seller requires the buyer to make the entire payment upfront in
                                                    order to initiate the shipping process. This protects the seller
                                                    from lost money for goods shipped without payment.</p>
                                                    <div class="card-footer"> <button type="submit" value="Cash on delivery" name="card"
                                                                class="subscribe btn btn-primary btn-block shadow-sm">
                                                                Confirm Payment </button>
                                                </div> <!-- End -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Navbar and Header -->
    <?php require('includes/footer.php') ?>

    <!-- Script -->
    <script type="text/javascript">
    $(document).ready(function() {

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
    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
</body>

</html>