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

    <main>
        <body>
            <div style="margin: 40px;">
                <div id="productDis">
                    <div id="side">
                        <div id="photo" class="photo">
                            <img id="package" src="<?= '/images/product/'.$product["ProductThumb"] ?>" alt="<?= $product["ProductName"] ?>">
                        </div>
                        <div id="overlap">
                            <div id="textbox">
                                <div class="textbox" style="margin-top:30px;">
                                    <h2><?= $product["ProductName"] ?></h2>
                                    <?php
                                        foreach ($specifications as $specification) {
                                            echo '<button id="'.$specification["SpecID"].'"
                                            class="button spec-btn" 
                                            data-id="'.$specification["SpecID"].'" 
                                            data-name="'.$specification["Specification"].'" 
                                            data-price="'.$specification["Price"].'" 
                                            data-descr="'.$specification["Descr"].'" 
                                            data-photo="'.$specification["ProductPhoto"].'"
                                            data-product="'.$product["ProductName"].'">
                                            '.$specification["Specification"].'
                                            </button>';
                                        }
                                    ?>
                                </div>
                                <div id="descriptionBox">
                                    <?php 
                                        echo '<div class="textbox">
                                            <form method="POST">
                                                <div class="text">
                                                    <h1></h1>
                                                    <h2></h2>
                                                    <p></p>
                                                    <p></p>
                                                </div>
                                            </form>
                                        </div>';
                                    ?>
                                </div>
                                <div id="addToCart" class="textbox">
                                    <div style="display: flex;">
                                        <div class="qty-input">
                                            <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                            <input class="product-qty" type="number" name="product-qty" min="1" max="10" value="1">
                                            <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                        </div>
                                        <button class="cartButton">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                include '../foot.php'; 
            ?>
            
        </body>
    </main>
</html>