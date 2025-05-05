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
            <form action="#" method="post" class="appointment-form">
                <h2>Book Your Appointment at Tech Cafe</h2>
                <div class="form-row">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" required style="flex: 1;">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" required style="flex: 1;">
                </div>
                <div class="form-row">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" name="phone" id="phone" required style="flex: 1;">
                </div>
                <div class="form-row">
                    <label for="email">Email (Optional):</label>
                    <input type="email" name="email" id="email" style="flex: 1;">
                </div>
                <div class="form-row">
                    <label for="service">Please Choose Your Service:</label>
                    <select name="service" id="service" required style="flex: 1;">
                        <option value="">Select Service</option>
                        <option value="coworking">Co-working Space</option>
                        <option value="keyboard_disassembly">Keyboard Disassembly Service</option>
                        <option value="keyboard_cleaning">Keyboard Cleaning Service</option>
                        <option value="keyboard_desoldering">Whole Keyboard Desoldering/Soldering Service</option>
                        <option value="keyboard_building">Keyboard Building Service (Hotswap)</option>
                        <option value="switch_desoldering">Repairing Switch Desoldering/Soldering Service</option>
                        <option value="turbocharge">Turbocharge Performance Service</option>
                        <option value="virus_removal">Conquer Virus Service</option>
                        <option value="data_recovery">Rescue Lost Data Service</option>
                        <option value="fix_glitch">Fix Any Glitch Service</option>
                        <option value="pc_building">PC Building Service</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="problem_description">Problem Description (Optional):</label>
                    <textarea name="problem_description" id="problem_description" style="resize: vertical; width: 76%; min-height: 80px;"></textarea>
                </div>
                <div class="form-row">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="date" name="appointment_date" id="appointment_date" required style="flex: 1;">
                    <label for="appointment_time">Appointment Time:</label>
                    <input type="time" name="appointment_time" id="appointment_time" required style="flex: 1;">
                </div>
                <button type="submit">Book Appointment</button>
            </form><br>

            <?php
                include "../foot.php";
            ?>

        </body>
    </main>
</php>