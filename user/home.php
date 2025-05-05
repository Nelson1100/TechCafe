<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Café</title>
    </head>
    <?php
        require '../base.php';
        include '../head.php';
    ?>
    <main id="demo">
        <section class="hidden1">
            <div class="banner">
                <div class="banner-image">
                    <img src="../images/banners/computer.png" alt="banner-Computer">
                </div>
                <div class="banner-content">
                    <h2>Computer</h2>
                    <p>Your computer needs</p>
                    <a class="button" href="shop.php?category=Computer">Shop Here</a>
                </div>
            </div>
            </section>
            <section class="hidden1">
                <div class="banner">
                    <div class="banner-content">
                        <h2>Keyboard</h2>
                        <p>Your keyboard needs</p>
                        <a class="button" href="shop.php?category=Keyboard">Shop Here</a>
                    </div>
                    <div class="banner-image">
                        <img src="../images/banners/keyboard.png" alt="banner-Keyboard">
                    </div>
                </div>
            </section>
            <section class="hidden1">
            <div class="banner">
                <div class="banner-image">
                    <img src="../images/banners/Accessories.png" alt="banner-Accessories">
                </div>
                <div class="banner-content">
                    <h2>Accessories</h2>
                    <p>Your accessories needs</p>
                    <a class="button" href="shop.php?category=Accessories">Shop Here</a>
                </div>
            </div>
            </section>
        <section class="hidden1">
            <div class="banner">
                <div class="banner-content">
                    <h2>Cafe</h2>
                    <p>All things coffee</p>
                    <a class="button" href="cafe.php">Explore</a>
                </div>
                <div class="banner-image">
                    <img src="../images/banners/CafeBanner.jpg" alt="banner-CPU">
                </div>
            </div>
        </section>
        <body>
            <?php
                $stm = $_db->prepare("SELECT ProductID, ProductName, Category, ProductThumb FROM product WHERE Category = ? LIMIT 4");
                $stm->execute(["computer"]);
                $computers = $stm->fetchAll();
                $stm->execute(["keyboard"]);
                $keyboards = $stm->fetchAll();
                $stm->execute(["accessories"]);
                $accessories = $stm->fetchAll();
                $categories = ["Computer" => $computers, "Keyboard" => $keyboards, "Accessories" => $accessories];

                foreach ($categories as $categoryName => $products) {
                    echo "<div class='hidden2'><p class='title'>";
                    echo $categoryName == "Accessories" ? "Select your " . $categoryName . "..." : "Customize your " . $categoryName . "...";
                    echo "</p><table class='productbox' id='productboxHome'>";
                    
                    printProduct($products);
                }

                include '../foot.php';
            ?>

        </body>
    </main>
</html>