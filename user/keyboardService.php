<!DOCTYPE php>
<php lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Café</title>
    </head>
    <?php
        require '../base.php';
        include '../head.php';
    ?>
    <main>
        <body>
            <section id="services2">
                <h2 class="title">Keys, Caffeine, and Clacks! Tech Cafe's Keyboard Clinic is Live! ⌨️</h2>
                <p class="intro">
                    Keys feeling down? Don't let your keyboard blues dim your coding mood! Tech Cafe isn't just your java joint, it's keyboard rehab HQ. We speak fluent clack and cure ailments from sticky spacebars to ghosting whispers. Cleaning, fixing, modding – we'll turn your clunkers into symphony singers. <br><br>
                    Local heroes, not keyboard bots. We've built more boards than lines of code, so your precious plastic is in pro hands. Ditch the dull, grab a latte, and let's make your keyboard the star of your setup. Tech Cafe, where keys get their happily ever after. ⚡️
                </p>
                <video style="width:100%;" controls>
                <source src="../images/services/keyboardclinic.mp4" type="video/mp4">
                Your browser does not support the video tag.
                </video>
                
                <div class="team">
                <h3>Meet the Tech Crew</h3>
                <div class="team-member">
                    <img src="../images/services/people4.jpg" alt="Loki">
                    <p><b>Loki</b> - Keyboard Maestro (aka Switch Whisperer)</p>
                </div>
                <div class="team-member">
                    <img src="../images/services/people5.jpg" alt="Emily">
                    <p><b>Emily</b> - Support Guru (aka Problem Solver Extraordinaire)</p>
                </div>
                <div class="team-member">
                    <img src="../images/services/people6.jpg" alt="Chris">
                    <p><b>Chris</b> - Mod Mastermind (aka Customization King)</p>
                </div>
                </div>
                <div class="services-grid">
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/diassembly.jpg" alt="Disassembly">
                    <h3>Keyboard Disassembly Service</h3>
                    <p class="service-price">
                    RM 40.00 - RM 70.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/cleaning.jpg" alt="Cleaning">
                    <h3>Keyboard Cleaning Service</h3>
                    <p class="service-price">
                    RM 30.00 - RM 90.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/whole.jpg" alt="Whole Desoldering/Soldering">
                    <h3>Whole Keyboard Desoldering/Soldering Service</h3>
                    <p class="service-price">
                    RM 60.00 - RM 200.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/hotswap.jpg" alt="Building">
                    <h3>Keyboard Building Service (Hotswap)</h3>
                    <p class="service-price">
                    RM 50.00 - RM 70.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/switch.jpg" alt="Swtich Desoldering/Soldering">
                    <h3>Repairing Switch Desoldering/Soldering Service</h3>
                    <p class="service-price">
                    RM 60.00 - RM 200.00
                    </p>
                </a>
                </div>
                <p class="ps">
                P.S. Your keys deserve a powerful backup band!  Gear up your PC with <a href="repair&upgrade.php">Tech Café's Repair & Upgrade</a>. Crush lag, banish bugs, and unlock the full potential of your keyboard's clicky chorus. Let the music play!⚡️
                </p>
            </section>
            
            <?php
                include "../foot.php";
            ?>

        </body>
    </main>
</php>