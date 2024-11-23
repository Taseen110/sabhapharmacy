<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sabha Pharmacy</title>
    <!-- Common Tags -->
    <?php require('includes/head.php') ?>
</head>

<body>
    <!-- Navbar and Header -->
    <?php require('includes/navbar.php') ?>

    <section style="height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div style="display:<?php if(isset($_SESSION['showAlert'])){echo $_SESSION['showAlert'];}else {echo 'none';} unset($_SESSION['showAlert']); ?>"
                        class="alert alert-success alert-dismissible mt-4" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} unset($_SESSION['showAlert']); ?></strong>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="text-center text-info m-0">
                                            Products in your cart!
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>
                                        <a href="action.php?clear=all" class="badge bg-danger text-white p-1"
                                            onclick="return confirm('Are you sure want to clear your cart?');">
                                            Clear Cart
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include './connection/connect.php';
                                    $stmt = $con->prepare("SELECT * FROM cart");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $grand_total = 0;
                                    while($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                    <td><img src="<?= $row['product_image'] ?>" height="50" width="50"></td>
                                    <td><?= $row['product_name'] ?></td>
                                    <td>Rs. <?= number_format($row['product_price'],2); ?></td>
                                    <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                    <td><input type="number" class="from-control itemQty" value="<?= $row['qty'] ?>"
                                            style="width: 55px;"></td>
                                    <td class="total-price">Rs. <?= number_format($row['total_price'],2); ?></td>
                                    <td>
                                        <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead"
                                            onclick="return confirm('Are you sure want to remove this item?');">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $grand_total +=$row['total_price']; ?>
                                <?php endwhile; ?>
                                <tr>
                                    <td colspan="2">
                                        <a href="product.php" class="btn btn-success">
                                            <i class="fa-solid fa-cart-plus"></i>&nbsp;&nbsp;Continue Shopping
                                        </a>
                                    </td>
                                    <td colspan="2"><b>Grand Total</b></td>
                                    <td class="grand-total">Rs. <?= number_format($grand_total,2); ?></td>
                                    <td>
                                        <a href="checkout.php"
                                            class="btn btn-info <?= ($grand_total>1)?"":"disabled"; ?>">
                                            <i class=" fa-solid fa-credit-card"></i>&nbsp;&nbsp;Checkout
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Navbar and Header -->
    <?php require('includes/footer.php') ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".itemQty").on('change', function() {
            var $el = $(this).closest('tr');
            var pid = $el.find(".pid").val();
            var pprice = parseFloat($el.find(".pprice").val());
            var qty = parseInt($(this).val());

            // Calculate new total price for this item
            var newTotalPrice = (pprice * qty).toFixed(2);
            $el.find(".total-price").text("Rs. " + newTotalPrice);

            // Update grand total
            updateGrandTotal();

            // Send AJAX request to update quantity in the backend
            $.ajax({
                url: 'action.php',
                method: 'post',
                data: { qty: qty, pid: pid },
                success: function(response) {
                    console.log(response);
                }
            });
        });

        function updateGrandTotal() {
            var grandTotal = 0;
            $("tbody tr").each(function() {
                var totalPrice = parseFloat($(this).find(".total-price").text().replace("Rs. ", ""));
                grandTotal += totalPrice;
            });
            // Update grand total in the table
            $(".grand-total").text("Rs. " + grandTotal.toFixed(2));
        }

        load_cart_item_number();

        function load_cart_item_number() {
            $.ajax({
                url: 'action.php',
                method: 'get',
                data: { cartItem: "cart_item" },
                success: function(response) {
                    $("#cart-item").html(response);
                }
            });
        }
    });
    </script>
</body>

</html>
