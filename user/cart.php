<?php
    require '../base.php';
    include '../head.php';
?>
<!DOCTYPE html>
<html lang="en">
    <main>
        <body>
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    <?php
                        // Fetch cart where OrderStatus is 'InCart'
                        $stm = $_db->prepare("SELECT * FROM cart WHERE Email = ? AND OrderStatus = 'InCart'");
                        $stm->execute([$_SESSION['Email']]);
                        $cartData = $stm->fetch();

                        $specIDs = explode(',', $cartData['ItemsAdded']);
                        $quantities = explode(',', $cartData['Quantity']);

                        $subtotal = 0;
                        $totalQty = 0;

                        for ($i = 0; $i < count($specIDs); $i++) {
                            $specID = $specIDs[$i];
                            $qty = $quantities[$i];

                            // Get product info from specification ID
                            $stmt = $_db->prepare("SELECT s.Specification, s.Price, s.ProductPhoto, p.ProductName FROM specification s JOIN product p ON s.ProductID = p.ProductID WHERE s.SpecID = ?");
                            $stmt->execute([$specID]);
                            $product = $stmt->fetch();

                            $price = $product['Price'] * $qty;
                            $subtotal += $price;
                            $totalQty += $qty;
                    ?>
                    <form method="POST" class="cart-item">
                        <img src="../images/product/<?= $product['ProductPhoto'] ?>" alt="Product Image">
                        <div class="item-details">
                            <h3><?= $product['ProductName'] ?></h3>
                            <p>Specification: <?= $product['Specification'] ?></p>
                            <p>Price: RM <?= $product['Price'] ?> x <?= $qty ?> = RM <?= $price ?></p>
                            <div class="qty-wrapper">
                                <button type="submit" name="deductQuantity" value="<?= $specID ?>">-</button>
                                <span><?= $qty ?></span>
                                <button type="submit" name="addQuantity" value="<?= $specID ?>">+</button>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </div>

                <!-- Checkout Box -->
                <div class="checkout-box">
                    <h2>Order Summary</h2>
                    <p>Total Items: <span id="totalQty"><?= $totalQty ?></span></p>
                    <p>Subtotal: RM <span id="subtotal"><?= $subtotal ?></span></p>
                    <hr>
                    <button class="checkout-btn">Checkout</button>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script>
                $(document).ready(function() {
                    // Event listener for adding quantity
                    $(".qty-count--add").on('click', function() {
                        var specID = $(this).data('specid'); // Get the spec ID from the button data attribute
                        updateQuantity(specID, 'add');
                    });

                    // Event listener for deducting quantity
                    $(".qty-count--minus").on('click', function() {
                        var specID = $(this).data('specid'); // Get the spec ID from the button data attribute
                        updateQuantity(specID, 'deduct');
                    });

                    // Function to send AJAX request to server
                    function updateQuantity(specID, operation) {
                        $.ajax({
                            url: 'cart_update.php', // Your PHP file that will handle the request
                            type: 'POST',
                            data: {
                                specID: specID,
                                operation: operation
                            },
                            success: function(response) {
                                // Update the quantity on the page without refreshing
                                var data = JSON.parse(response);
                                if (data.success) {
                                    // Update the quantity displayed
                                    $("#qty-" + specID).text(data.newQuantity);
                                    $("#totalQty").text(data.totalQty);
                                    $("#subtotal").text(data.subtotal);
                                } else {
                                    alert(data.message); // Display error if any
                                }
                            },
                            error: function() {
                                alert("Error updating the quantity.");
                            }
                        });
                    }
                });
            </script>
            <?php
                include '../foot.php';
            ?>
        </body>
    </main>
</html>
