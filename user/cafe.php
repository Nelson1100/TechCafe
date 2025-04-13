<!DOCTYPE html>
<html lang="en" id="backgroundColor">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <Title>Café Menu</Title>
    </head>

    <?php
        require '../base.php';
        include '../head.php';
    ?>

    <main>
        <body>
            <div class="menus-area">
                <div class="hidden2">
                    <div class="container">
                        <div class="section-cafeTitle">
                            <div class="container1">
                                <img src="../../images/cafe/background.jpg" alt="Background Image">
                                <div id="word">
                                    <h3>Café Menu</h3>
                                    <p>Have a great taste of coffee.</p>
                                </div>
                            </div><hr>
                        </div>
                        <div class="menus">
                            <div class="menu-items">
                                <div class="cafeTitle">traditional coffee</div>
                                <div class="single-menu">
                                    <span>rm10.90</span>
                                    <div class="display"><img src="../../images/cafe/americano.jpg" alt="Americano"></div>
                                    <h4>americano</h4>
                                    <p>A shot of espresso by adding water and be served 1/2 and 1/2 or 1/3 espresso to 2/3 water.</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm13.90</span>
                                    <div class="display"><img src="../../images/cafe/latte.jpg" alt="Latte"></div>
                                    <h4>latte</h4>
                                    <p>One or two shots of espresso, steamed milk and a final, thin layer of frothed milk on top.</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm13.90</span>
                                    <div class="display"><img src="../../images/cafe/cappuccino.jpg" alt="Cappuccino"></div>
                                    <h4>cappuccino</h4>
                                    <p>A freshly pulled shot of espresso layered with steamed whole milk and thick rich foam.</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm14.90</span>
                                    <div class="display"><img src="../../images/cafe/mocha.jpg" alt="Mocha"></div>
                                    <h4>mocha</h4>
                                    <p>A shot of espresso is combined with a chocolate powder or syrup, followed by milk or cream</p>
                                </div>
                            </div>
                            <div class="menu-items">
                                <div class="cafeTitle">signature coffee</div>
                                <div class="single-menu">
                                    <span>rm18.00</span>
                                    <div class="display"><img src="../../images/cafe/caramel.jpg" alt="Caramel"></div>
                                    <h4>caramel macchiato</h4>
                                    <p>A shot of espresso, creamy steamed milk,vanilla syrup and caramel.</p><br>
                                </div>
                                <div class="single-menu">
                                    <span>rm12.00</span>
                                    <div class="display"><img src="../../images/cafe/spanishlatte.jpg" alt="Spanish Latte"></div>
                                    <h4>spanish latte</h4>
                                    <p>A shot of espresso is mixed with milk, and sweetened by condensed milk.</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm19.60</span>
                                    <div class="display"><img src="../../images/cafe/javachip.jpg" alt="Java Chip"></div>
                                    <h4>java chip frappucino</h4>
                                    <p>A blend of "Frappuccino chips with coffee, milk and ice" that is topped off "with whipped cream and a mocha drizzle.</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm18.00</span>
                                    <div class="display"><img src="../../images/cafe/matchalatte.jpg" alt="Matcha Latte"></div>
                                    <h4>matcha latte</h4>
                                    <p> Consists of matcha powder (made from the finely-ground leaves of certain green tea plants), water, and milk.</p>
                                </div>
                            </div>
                            <div class="menu-items">
                                <div class="cafeTitle">meals</div>
                                <div class="single-menu">
                                    <span>rm13.00</span>
                                    <div class="display"><img src="../../images/cafe/sandwich.jpg" alt="Sandwish"></div>
                                    <h4>sandwich</h4>
                                    <p>2 slice of bread,mayo,a slice of tomato,bacon,deli sliced chicken or turkey,iceberg lettuce.</p>
                                </div>  
                                <div class="single-menu">
                                    <span>rm10.00</span>
                                    <div class="display"><img src="../../images/cafe/croissant.jpg" alt="Croissant"></div>
                                    <h4>croissant</h4>
                                    <p>A buttery, flaky, viennoiserie pastry inspired by the shape of the Austrian kipferl but using the French yeast-leavened laminated dough.</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm12.00</span>
                                    <div class="display"><img src="../../images/cafe/pancake.jpg" alt="Pancake"></div>
                                    <h4>pancake</h4>
                                    <p>A flat cake, often thin and round, prepared from a starch-based batter that may contain eggs, milk and butter and cooked on a hot surface</p>
                                </div>
                                <div class="single-menu">
                                    <span>rm9.50</span>
                                    <div class="display"><img src="../../images/cafe/waffle.jpg" alt="Waffle"></div>
                                    <h4>waffle</h4>
                                    <p>A leavened batter or dough cooked between two hot plates of a waffle iron, patterned to give a characteristic size, shape, and grid-like surface impression.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                include '../foot.php';
            ?>

            <script src="../js/header.js"></script>
            <script src="../js/fadeEffect.js"></script>
        </body>
    </main>
</html>