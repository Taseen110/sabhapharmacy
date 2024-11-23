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
<?php
$name = $numbr = $email = $message = '';
$conn = new mysqli('localhost','root','','ayuruveda');
if($_SERVER["REQUEST_METHOD"]=='POST')
{
  $name = htmlspecialchars($_POST['name']);
  $numbr = htmlspecialchars($_POST['numbr']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);
}

$sql = "INSERT INTO `contactus` (`Name`, `Phone_Number`, `Email`, `Message`) VALUES ('$name', '$numbr', '$email', '$message');";



?>
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
        <div class="container mt-5 mb-5">
     <?php
        if(mysqli_query($conn,$sql))
         {
    echo "";
          }
else {
    echo "Try Again";
     }
     ?>
            <h3>WE'D LOVE TO</h3>
            <h1 class="text-info">HEAR FROM YOU</h1>
            <p>Send us a message and we'll respond as soon as possible</p>
            <div class="row">
                <div class="col-lg-6 p-3 border shadow-sm">
                    <form action = "" method="post" >
                        <!-- Name input -->
                        <div class="form-outline mb-4 input-group-lg">
                            <input type="text" id="form4Example1" name = "name" class="form-control bg-light" placeholder="Name"
                                required />
                        </div>

                        <!-- Number input -->
                        <div class="form-outline mb-4 input-group-lg">
                            <input type="text"  min="1" step="1" required id="form4Example1"  name="numbr" class="form-control bg-light"
                                placeholder="Phone Number" required />
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4 input-group-lg">
                            <input type="email" id="form4Example2"  name = "email" class="form-control bg-light" placeholder="Eamil"
                                required />
                        </div>

                        <!-- Message input -->
                        <div class="form-outline mb-4 input-group-lg">
                            <textarea class="form-control bg-light" name = "message" id="form4Example3" rows="4" placeholder="Message"
                                required></textarea>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-success btn-block mb-2">Send</button>
                    </form>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4 p-2">
                    <div class="border-bottom border-success shadow-lg d-flex">
                        <i class="fa-solid fa-envelope p-3 text-success" style="font-size:26px;"></i>
                        <a class="p-3 pl-1" style="font-size: 18px;">contact@sabhapharmacy@gmail.com</a>
                    </div>
                    <div class="border-bottom border-success shadow-lg d-flex mt-4">
                        <i class="fa-solid fa-location-dot p-3 text-success" style="font-size:26px;"></i>
                        <a class="p-3 pl-1" style="font-size: 18px;">Main Street,<br /> Phase-1 <br />
                            Sindh University ,<br /> Jamshoro.</a>
                    </div>
                    <div class="border-bottom border-success shadow-lg d-flex mt-4">
                        <i class="fa-solid fa-phone p-3 text-success" style="font-size:26px;"></i>
                        <a class="p-3 pl-1" style="font-size: 18px;">0303-9655308</a>
                    </div>
                    <div class=" border-success d-flex mt-4">
                        <i class="fa-brands fa-facebook p-3 ml-3" style="font-size:40px;"></i>
                        <i class="fa-brands fa-instagram p-3 ml-3" style="font-size:40px;"></i>
                        <i class="fa-brands fa-twitter p-3 ml-3" style="font-size:40px;"></i>
                        <i class="fa-brands fa-youtube p-3 ml-3" style="font-size:40px;"></i>
                    </div>
                </div>
            </div>
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
<?php
mysqli_close($conn);
?>
</body>

</html>