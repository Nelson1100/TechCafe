<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Café Services</title>
    </head>

    <?php
        require '../base.php';
        include '../head.php';
    ?>
    
    <main>
        <body>
            <div class="hidden2">
                <section id="services">
                    <div class="service-banner">
                        <h2>Level Up Your Life: Tech Solutions & Cozy Comforts</h2>
                        <p>Discover a unique blend of cutting-edge technology and cozy cafe vibes.</p>
                        <img src="../images/banners/services.png" alt="Banner">
                    </div>
                    <div class="service-boxes">
                        <div class="service-box">
                            <img src="../images/services/repair&upgrade.jpg" alt="Computer repair">
                            <h3>Repair & Upgrade</h3>
                            <p>Computer repairs by certified technicians. Hardware and software upgrades to boost PC performance. Data recovery and virus removal services.</p>
                            <a href="repair&upgrade.php" class="btn">Get Your Tech Fixed</a>
                        </div>
                        <div class="service-box">
                            <img src="../images/services/keyboard.jpg" alt="Keyboard">
                            <h3>Keyboard Clinic</h3>
                            <p>Give your keyboard the TLC it deserves with our expert services: Disassembly/Cleaning, Desoldering/Soldering, Building (Hotswap) and more.</p>
                            <a href="keyboardService.php" class="btn">Revive Your Keys</a>
                        </div>
                        <div class="service-box">
                            <img src="../images/services/coworking.jpg" alt="Coworking space">
                            <h3>Co-working Space</h3>
                            <p>High-speed Wi-Fi, comfortable seating, and power outlets. Ideal place for group assignments and work. Stress-free environment with chill music.</p>
                            <a href="appointment.php" class="btn">Book Your Workspace</a>
                        </div>
                    </div>
                </section>
            </div>
            <?php
                include '../foot.php';
            ?>
        </body>
    </main>
</html>