<?php
// Restrict access to users only
if (isset($_SESSION['Role']) && $_SESSION['Role'] === 'Admin') {
    echo "<script>alert('Access denied. Users only.'); window.location='/admin/product.php'</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="/images/TechCafe.png"> <!-- Favicon for the Page -->
    </head>
    <?php
        if (isset($_SESSION['Email'])) {
            $stm = $_db->prepare("SELECT * FROM cart WHERE Email = ? AND OrderStatus = 'InCart'");
            $stm->execute([$_SESSION['Email']]);
            $cartItems = $stm->fetch();
        }
    ?>
    <body>
        <header style="z-index: 9999;">
            <div class="header-container" id="header">
                <div id="header-icons-left" class="header-icons">
                    <a href="/user/home.php"><img src="/images/TechCafe.png" alt="Tech Café"></a>
                    <h3 id="greeting">Welcome to Tech Café</h3>
                </div>

                <div id="header-icons-right" class="header-icons">
                    <div class="search" id="search-bar">
                        <input id="search" class="search-txt" type="text" placeholder="Search Product">
                        <button class="submit"><i class="fas fa-search"></i></button>
                    </div>
                    <a href="#" id="orderHistoryIcon">
                        <img src="/images/order-history.png" alt="Order History" width="40">
                    </a>

                        <!-- Hidden Chatbox -->
                    <div id="orderHistoryBox" class="chatbox">
                        <div class="chatbox-header">
                            <span>Order History</span>
                            <button id="closeChatbox">×</button>
                        </div>
                        <div class="chatbox-body" id="orderHistoryContent">
                            Loading...
                        </div>
                    </div>

                    <?php
                        if (isset($_SESSION['Email'])) {
                    ?>
                            <a href="#" id="cartLink"><img src="/images/cart.png" alt="Cart"></a>
                            <a href="../userProfile.php">
                                <img src="<?= $user['ProfilePic'] ? '/images/' . $user['ProfilePic'] : '/images/user.png' ?>" alt="User Profile" style="border-radius: 50%; object-fit: cover;">
                            </a>
                    <?php
                        } else {
                    ?>
                            <a href="#" id="cart"><img src="/images/cart.png" alt="Cart"></a>
                            <a href="login.php">
                                <img src="/images/user.png" alt="User Profile" style="border-radius: 50%;">
                            </a>
                    <?php
                        }
                    ?>
                </div>

                <nav id="navigationBar">
                    <ul>
                        <li><a href="/user/home.php">Home</a></li>
                        <li><a href="/user/shop.php">Shop</a></li>
                        <li><a href="/user/cafe.php">Cafe</a></li>
                        <li><a href="/user/services.php">Services</a></li>
                        <li><a href="/user/about.php">About</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <script src="/app/js/header.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cartIcon = document.getElementById("cart");
                const cartLink = document.getElementById('cartLink');
                const hasItems = <?= isset($cartItems['ItemsAdded']) && trim($cartItems['ItemsAdded']) !== '' ? 'true' : 'false' ?>;
                const icon = document.getElementById("orderHistoryIcon");
                const box = document.getElementById("orderHistoryBox");
                const close = document.getElementById("closeChatbox");
                const content = document.getElementById("orderHistoryContent");

                icon.addEventListener("click", (e) => {
                e.preventDefault();
                box.classList.add("active");

                // Load order history from PHP (AJAX)
                fetch("/user/getOrderHistory.php")
                    .then(res => res.text())
                    .then(data => content.innerHTML = data)
                    .catch(err => content.innerHTML = "Unable to load order history.");
                });

                close.addEventListener("click", () => {
                    box.classList.remove("active");
                });

                if (cartIcon) {
                    cartIcon.addEventListener("click", function () {
                        alert("Please sign in to view your cart.");
                    });
                }

                if (cartLink) {
                    cartLink.addEventListener('click', function () {
                        if (hasItems) {
                            window.location.href = 'cart.php';
                        } else {
                            alert('Oops! Nothing in your cart.');
                        }
                    });
                }
            });
        </script>
    </body>
</html>