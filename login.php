<?php
    require("./connection/connect.php");
    if(isset($_POST['submitreg'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $number=$_POST['number'];
        $address=$_POST['address'];
        $password=$_POST['password'];


        $sql="insert into `customer` (name,email,number,address,password) values('$name','$email','$number','$address','$password')";
        $result=mysqli_query($con,$sql);
        if($result){
            header('location:index.php');
        }
        else{
            die(mysqli_error($con));
        }
    }

    if(isset($_POST['submit'])){

        $sql = "select * from `customer` where `email`='$_POST[email]' and `password`='$_POST[password]'";
        $result=mysqli_query($con,$sql);
        if(mysqli_num_rows($result)==1){
            session_start();
            $_SESSION['email'] = $_POST['email'];
            header('location:index.php');
        }
        else{
            echo "<script>alert('Incorrect Password! Try again.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sabha Pharmacy</title>

    <!-- Common Tags -->
    <?php require('includes/head.php') ?>
</head>

<body>

    <section class="login-panel">
        <div class="container mt-5 mb-5">
            <div class="form-modal">

                <div class="form-toggle">
                    <button id="login-toggle" onclick="toggleLogin()">log in</button>
                    <button id="signup-toggle" onclick="toggleSignup()">sign up</button>
                </div>

                <div id="login-form">
                    <form method="post">
                        <input type="text" placeholder="Enter email or username" name="email" />
                        <input type="password" placeholder="Enter password" name="password" />
                        <button  type="submit" name="submit" class="btn login">login</button>
                        <hr />

                    </form>
                </div>

                <div id="signup-form">
                    <form method="post">
                        <input type="text" placeholder="Full Name" name="name" />
                        <input type="email" placeholder="Email Address" name="email" />
                        <input type="text" placeholder="Phone Number" name="number" />
                        <input type="text" placeholder="Address" name="address" />
                        <input type="password" placeholder="password" name="password" />
                        <button type="submitreg" name="submitreg" class="btn signup">create account</button>
                        <hr />

                    </form>
                </div>

            </div>

        </div>
    </section>
    <!-- Footer -->
    <?php require('includes/footer.php') ?>
    <script>
    function toggleSignup() {
        document.getElementById("login-toggle").style.backgroundColor = "#fff";
        document.getElementById("login-toggle").style.color = "#222";
        document.getElementById("signup-toggle").style.backgroundColor = "#57b846";
        document.getElementById("signup-toggle").style.color = "#fff";
        document.getElementById("login-form").style.display = "none";
        document.getElementById("signup-form").style.display = "block";
    }

    function toggleLogin() {
        document.getElementById("login-toggle").style.backgroundColor = "#57B846";
        document.getElementById("login-toggle").style.color = "#fff";
        document.getElementById("signup-toggle").style.backgroundColor = "#fff";
        document.getElementById("signup-toggle").style.color = "#222";
        document.getElementById("signup-form").style.display = "none";
        document.getElementById("login-form").style.display = "block";
    }
    </script>
</body>

</html>