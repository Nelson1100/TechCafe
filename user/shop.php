<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Café Shop</title>
    </head>
    
    <?php
        require '../base.php';
        include '../head.php';
    ?>

    <main id="demo">
        <body>
            <div class="hidden2">
                <div id="filter">
                    <ul>
                        <li><img src="../images/filter.png" alt="Filter"></li>
                        <li>|</li>
                        <li><a class="grey" href="?category=Computer">Computer</a></li>
                        <li><a class="grey" href="?category=Keyboard">Keyboard</a></li>
                        <li><a class="grey" href="?category=Accessories">Accessories</a></li>
                        <li>|</li>
                        <li><a id="all" href="?category=All"><img src="../images/cancel.png" alt="Cancel Filter"></a></li>
                    </ul>
                </div>

                <?php
                    echo "<div><table class='productbox'><tr>"; // Start the table and first row

                    printProduct($products);

                    include '../foot.php';
                ?>

            </div>
        </body>
    </main>
</html>