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
                        <p style="height: 500px; margin-bottom: -50px;"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15886.964471486686!2d100.28517873972841!3d5.456206442170408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ac2c0305a5483%3A0xfeb1c7560c785259!2sTAR%20UMT%20Penang%20Branch!5e0!3m2!1sen!2smy!4v1745160883111!5m2!1sen!2smy" style="border:0; width:94%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" preload></iframe></p>
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