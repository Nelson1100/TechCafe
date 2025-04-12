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

        $stm = $_db->prepare("SELECT ProductID, ProductName, Category, ProductThumb FROM product WHERE ProductID = ?");
        $stm->execute([$ProductID]);
        $product = $stm->fetch();

        // Handle Add to Cart       
        if (is_post()) {
            $cart_item = [
                "specificationName" => $specification["specificationName"],
                "Price" => $specification["Price"],
                "specificationPhoto" => $specification["specificationPhoto"]
            ];
            
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $_SESSION['cart'][] = $cart_item;
            header("Location: cart.php"); // Redirect to cart page after adding
            exit;
        }
    ?>

    <main id="demo">
        <body>
            <div id="sidebyside">
                <div class="photo"><img src="/images/product/<?= $product["ProductThumb"]?>" alt="<?= $specification["Specification"] ?>"></div>
                    <form method="POST">
                    <div class="text">
                        <h1><?= $product["ProductName"] ?></h1>
                        <h2><?= $specification["Specification"] ?></h2>
                        <p><b>Price:</b> RM <?= $specification["Price"]?></p>
                        <p>Description: <?= $specification["Descr"] ?></p>
                    </div>
                </form>
                </div>
        <?php
            include '../foot.php';
        ?>
    </body>
</html>