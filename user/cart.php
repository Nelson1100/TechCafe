<?php
    require '../base.php';
    include '../head.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            html, body {
                overflow-x: hidden;
            }

            body {
                overflow-y: hidden;
            }
        </style>
    </head>
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

                        if ($cartData) {
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
                    <?php
                            }
                        } else {
                            $totalQty = "-";
                            $subtotal = "-";
                        }
                    ?>
                </div>

                <!-- Checkout Box -->
                <div class="checkout-box">
                    <form>
                        <h2>Order Summary</h2>
                        <p>Total Items: <span id="totalQty"><?= $totalQty ?></span></p>
                        <p>Subtotal: RM <span id="subtotal"><?= $subtotal ?></span></p>
                        <hr>
                        <button class="checkout-btn" type="button">Checkout</button>
                    </form>
                </div>
                <div class="payment-box">
                    <form>
                        <h2>Payment</h2>
                        <label for="cardName">Name on Card</label>
                        <input type="text" id="cardName" placeholder="John Doe" required>

                        <label for="cardNumber">Card Number</label>
                        <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" required>

                        <div class="card-info">
                            <div>
                                <label for="expiry">Expiry</label>
                                <input type="text" id="expiry" placeholder="MM/YY" required>
                            </div>
                            <div>
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" placeholder="123" required>
                            </div>
                        </div>

                        <button type="submit" class="pay-btn">Pay Now</button>
                    </form>
                </div>
            </div>
            <?php
                include '../foot.php';
            ?>
        </body>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const checkout = document.querySelector('.checkout-btn');
                const paymentBox = document.querySelector('.payment-box');
                const cartContainer = document.querySelector('.cart-container');

                checkout.addEventListener("click", () => {
                    paymentBox.classList.add('translated');
                    document.body.classList.add('checkout-mode');
                    cartContainer.classList.add('translated');
                });
            });
        </script>
    </main>
</html>
