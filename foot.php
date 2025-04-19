<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <footer id="foot">
                <div class="container">
                    <div class="row">
                        <div class="footer-col">
                            <h4>follow us</h4>
                            <div class="social-links">
                                <a href="https://www.facebook.com/profile.php?id=100013608120484"><i class="fab fa-facebook-f"></i></a>
                                <!-- <a href="#"><i class="fab fa-twitter"></i></a> -->
                                <a href="https://www.instagram.com/song_____chen/?utm_source=ig_web_button_share_sheet&igshid=OGQ5ZDc2ODk2ZA=="><i class="fab fa-instagram"></i></a>
                                <!-- <a href="#"><i class="fab fa-linkedin-in"></i></a> -->
                            </div>
                        </div>
                        <div class="footer-col">
                            <h4>company</h4>
                            <ul>
                                <li><a href="/user/about.php">about</a></li>
                                <li><a href="/user/services.php">services</a></li>
                                <?php
                                    if (!isset($_SESSION['Email'])){
                                        echo "<li><a href='/user/login.php'>login</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="footer-col">
                            <h4>online shop</h4>
                            <ul>
                                <li><a href="shop.php?category=Computer">computer</a></li>
                                <li><a href="shop.php?category=Keyboard">keyboard</a></li>
                                <li><a href="shop.php?category=Accessories">accessories</a></li>
                            </ul>
                        </div>
                        <div class="footer-col">
                            <h4>build your dream here</h4>
                            <p>Connect with us at Tech Café and test out your ideal computer setup here with a simple plug and test. Tech Café, not just a digital paradise, but also for coffee lovers. Join us! Build and enjoy your own customization computer and keyboard while savoring a good taste of coffee.</p>
                        </div>
                    </div>
                </div>
                <div class="bottom-footer">
                    <p>&copy; 2025 Tech Café.</p>
                </div>    
        </footer>
        <script src="../js/header.js"></script>
        <script src="../js/fadeEffect.js"></script>
        <script src="../js/products.js"></script>
    </body>
</html>