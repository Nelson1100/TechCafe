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
                    <a href="cart.php"><img src="/images/cart.png" alt="Cart"></a>
                    <a href="<?= isset($_SESSION['Email']) ? 'userProfile.php' : 'login.php' ?>"><img src="/images/user.png" alt="User Profile"></a>
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
    </body>
</html>