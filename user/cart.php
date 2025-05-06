<?php
    require '../base.php';
    include '../head.php';

    $stm = $_db->prepare("SELECT * FROM user WHERE Email = ?");
    $stm->execute([$email]);
    $user = $stm->fetch();

    $_SESSION['UserFullName'] = $user['UserFullName'];
    $_SESSION['Email'] = $user['Email'];
    $_SESSION['Address'] = $user['Address'];
    $_SESSION['PhoneNo'] = "0".$user['PhoneNo'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Order</title>
        <style>
            html, body {
                overflow-x: hidden;
            }

            body {
                overflow-y: hidden;
            }

            #delete {
                position: absolute;
                top: 20px;
                right: 20px;
                color: red;
                font-size: 18px;
                background: none;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <a href="#" id="cartBack"><img src="../images/back-black.png" alt="Back Button" id="backBtn"></a>
    <h2 id="cartSummary">Order Summary:</h2>
    <main>
        <body>
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    <?php
                        // Fetch cart where OrderStatus is 'InCart'
                        if (isset($_SESSION['Email'])) {
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
                        <input type="hidden" name="targetSpecID" value="<?= $specID ?>">

                        <button class="far fa-trash-alt" id="delete" name="deleteProduct" value="<?= $specID ?>" type="submit"></button>

                        <img src="../images/product/<?= $product['ProductPhoto'] ?>" alt="Product Image">
                        <div class="item-details">
                            <h3 style="margin-top: 10px;"><?= $product['ProductName'] ?></h3>
                            <p>Specification: <?= $product['Specification'] ?></p>
                            <p>Price: RM <?= $product['Price'] ?> x <?= $qty ?> = RM <?= $price ?></p>
                            <div class="qty-wrapper">
                                <button type="submit" name="deductQuantity" value="<?= $specID ?>">−</button>
                                <input class="product-qty" type="number" name="product-qty" value="<?= $qty ?>" min="0">
                                <button type="submit" name="addQuantity" value="<?= $specID ?>">+</button>
                            </div>
                        </div>
                    </form>
                    <?php
                                }
                            } 
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
                <div class="details-box">
                    <form id="checkoutForm">
                        <h2>Contact Information</h2>
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" value="<?= $_SESSION['UserFullName'] ?>" placeholder="TechCafe" maxlength="100" required>

                        <label for="address">Email Address</label>
                        <input type="text" id="address" value="<?= $_SESSION['Email'] ?>" placeholder="techcafe@gmail.com" maxlength="40" required>

                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" value="<?= $_SESSION['PhoneNo'] ?>" placeholder="01234567890" maxlength="11" required>

                        <h2>Shipping Details</h2>

                        <label for="address">Shipping Address</label>
                        <input type="text" id="address" value="<?= $_SESSION['Address'] ?>" placeholder="Shipping Address" maxlength="100" required>

                        <button type="button" id="pay-btn" class="pay-btn">Continue to Payment</button>
                    </form>
                </div>
                <div class="payment-box">
                    <form id="paymentForm" method="POST" action="../base.php">
                        <h2>Payment</h2>

                        <label for="cardName">Name on Card</label>
                        <input type="text" id="cardName" placeholder="<?= $_SESSION['Username'] ?>" maxlength="15" required>

                        <label for="cardNumber">Card Number</label>
                        <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="16" required>

                        <div class="card-info">
                            <div>
                                <label for="expiry">Expiry</label>
                                <input type="text" id="expiry" placeholder="MM/YY" maxlength="5" required>
                            </div>
                            <div>
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" placeholder="123" maxlength="3" required>
                            </div>
                        </div>

                        <hr>
                        <p style="font-size: 17px; font-weight: 600;">Total Items: <span id="totalQty"><?= $totalQty ?></span></p>
                        <p style="font-size: 17px; font-weight: 600;">Total: RM <span id="paymentTotal"><?= $subtotal ?></span></p>
                        
                        <button type="submit" class="pay-btn" name="paid">Pay Now</button>
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
                const detailsBox = document.querySelector('.details-box');
                const cartContainer = document.querySelector('.cart-container');
                const backBtn = document.getElementById('cartBack');
                const orderSum = document.getElementById('cartSummary');
                const paymentBox = document.querySelector('.payment-box');
                const payBtn = document.getElementById('pay-btn');
                const form = document.getElementById("paymentForm");

                checkout.addEventListener("click", () => {
                    detailsBox.classList.add('translated');
                    document.body.classList.add('checkout-mode');
                    document.body.classList.remove('checkout-mode-revert');
                    cartContainer.classList.add('translated');
                    backBtn.style.opacity = 1;
                    orderSum.style.opacity = 1;
                });

                backBtn.addEventListener("click", () => {
                    detailsBox.classList.remove('translated');
                    document.body.classList.remove('checkout-mode');
                    document.body.classList.add('checkout-mode-revert');
                    cartContainer.classList.remove('translated');
                    paymentBox.classList.remove('translated');
                    backBtn.style.opacity = 0;
                    orderSum.style.opacity = 0;
                });

                payBtn.addEventListener("click", () => {
                    paymentBox.classList.add('translated');
                });

                form.addEventListener("submit", function (e) {
                    // Check if the form is valid
                    if (!form.checkValidity()) {
                        return;
                    }
                });
            });
        </script>
    </main>
</html>
