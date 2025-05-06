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
                                            data-product="'.$product["ProductName"].'"
                                            data-stock="'.$specification["InventoryLevel"].'">
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
                                <form id="addToCart" class="textbox" method="POST">
                                    <input type="hidden" name="selectedSpecID" id="selectedSpecID">
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        <div>
                                            <div class="qty-input">
                                                <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                                <input class="product-qty" type="number" name="product-qty">
                                                <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                            </div>
                                            <p class="stock" style="position: absolute; z-index: 999; text-align: center; margin: 10px 42px;"></p>
                                        </div>
                                        <button type="submit" class="cartButton" name="addCart">Add to Cart</button>
                                    </div>
                                </form>
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