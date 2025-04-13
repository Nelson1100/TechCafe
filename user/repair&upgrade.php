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
                <h2 class="title">Power Up Your Potential: Expert PC Repair & Upgrade at Tech Cafe ⚡️</h2>
                <p class="intro">
                    Is your computer dragging you down? Clogged with software crud? Don't let tech troubles dim your shine! <br><br>
                    Tech Cafe isn't just your average coffee shop, it's the ultimate PC performance pit stop. We're staffed by a crack team of certified technicians who speak fluent hardware and software, not to mention the language of lagging load times and frustrating freezes.
                </p>
                <iframe src="https://www.youtube.com/embed/Mw5WzVh99GA?si=aj2EPXGRGGSI6_TF" 
                title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; 
                gyroscope; picture-in-picture; web-share" allowfullscreen style="width: 100%; height: 500px"></iframe>

                <div class="team">
                <h3>Meet the Tech Crew</h3>
                <div class="team-member">
                    <img src="../images/services/people1.jpg" alt="Redd">
                    <p><b>Redd</b> - Hardware Guru <br><br>He can diagnose your PC's ailments like a doctor reads X-rays. No RAM shortage or overheating escapes his eagle eye.</p>
                </div>
                <div class="team-member">
                    <img src="../images/services/people2.jpg" alt="Ali">
                    <p><b>Ali</b> - Software Slayer <br><br>Bugs and viruses tremble at her approach. He'll vanquish any digital foe and optimize your system for smooth sailing.</p>
                </div>
                <div class="team-member">
                    <img src="../images/services/people3.jpg" alt="John">
                    <p><b>John</b> - Upgrade Architect <br><br>Dreaming of a powerhouse PC? Wei will craft your dream machine, brick by glorious, high-performance brick.</p>
                </div>
                </div>
                <div class="services-grid">
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/meter.jpg" alt="Turbocharge Performance">
                    <h3>Turbocharge Performance Service</h3>
                    <p class="service-price">
                    RM 25.00 - RM 75.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/virus.jpg" alt="Conquer Virus">
                    <h3>Conquer Virus Service</h3>
                    <p class="service-price">
                    RM 50.00 - RM 150.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/data.jpg" alt="Rescue Lost Data">
                    <h3>Rescue Lost Data Service</h3>
                    <p class="service-price">
                    RM 20.00 - RM 120.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/glitch.jpg" alt="Fix Glitch">
                    <h3>Fix Any Glitch Service</h3>
                    <p class="service-price">
                    RM 10.00 - RM 50.00
                    </p>
                </a>
                <a href="appointment.php" class="service-box2">
                    <img src="../images/services/build.jpg" alt="Swtich Desoldering/Soldering">
                    <h3>PC Building Service</h3>
                    <p class="service-price">
                    RM 100.00 - RM 500.00
                    </p>
                </a>
                </div>
                <p class="ps">
                    P.S. Keys feeling down? Don't stop the clack! Fix, mod, or build your dream keyboard at <a href="keyboardService.php">Tech Café's Keyboard Clinic</a>. Your symphony of satisfaction awaits! ✨
                </p>
            </section>

            <?php
                include "../foot.php";
            ?>

        </body>
    </main>
</php>