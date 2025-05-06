<?php
require '../base.php';
include '../head.php';

// This is to determine today's date for appointment date checking
$today = date('Y-m-d');

// Updates status when page loads, to see if appointment date already passes. Pass = Completed
$_db->query("
    UPDATE appointment 
    SET status = 'Completed' 
    WHERE status = 'Pending' 
    AND CONCAT(appointment_date, ' ', appointment_time) < NOW()"
);

// created_at will be stored automatically on DB to record creation time
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // data fetching, trimming
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? null);
    $service = trim($_POST['service'] ?? '');
    $problem_description = trim($_POST['problem_description'] ?? null);
    $appointment_date = trim($_POST['appointment_date'] ?? '');
    $appointment_time = trim($_POST['appointment_time'] ?? '');

    // Validation
    if (!preg_match("/^[a-zA-Z' -]+$/", $first_name)) {
        $_err['first_name'] = 'Invalid first name format.';
    }

    if (!preg_match("/^[a-zA-Z' -]+$/", $last_name)) {
        $_err['last_name'] = 'Invalid last name format.';
    }

    if (!preg_match('/^01[0,1,2,3,4,6,7,8,9][0-9]{7,8}$/', $phone)) {
        $_err['phone'] = 'Invalid Malaysian phone number (exclude 015).';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_err['email'] = 'Invalid email address.';
    }

    if (empty($service)) {
        $_err['service'] = 'Please select a service.';
    }

    if (empty($appointment_date) || empty($appointment_time)) {
        $_err['datetime'] = 'Date and time are required.';
    } else {
        $selected = strtotime("$appointment_date $appointment_time");
        $time_only = strtotime($appointment_time);
        $opening_time = strtotime('09:00:00');
        $closing_time = strtotime('20:00:00');

        if ($selected < time()) {
            $_err['datetime'] = 'Appointment must be in the future.';
        } elseif ($time_only < $opening_time || $time_only > $closing_time) {
            $_err['datetime'] = 'Appointments must be between 9:00 AM and 8:00 PM.';
        }
    }

    // Slot conflict check
    if (empty($_err)) {
        $conflict = $_db->prepare("
            SELECT COUNT(*) FROM appointment 
            WHERE appointment_date = ? 
            AND appointment_time = ? 
            AND status = 'Pending'
        ");

        $conflict->execute([$appointment_date, $appointment_time]);

        if ($conflict->fetchColumn() > 0) {
            $_err['datetime'] = 'Selected slot is already booked. Choose another time.';
        }
    }

    if (empty($_err)) {
        $stm = $_db->prepare('
            INSERT INTO appointment (
                first_name, last_name, phone, email, service, problem_description, appointment_date, appointment_time
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');

        $stm->execute([
            $first_name,
            $last_name,
            $phone,
            $email,
            $service,
            $problem_description,
            $appointment_date,
            $appointment_time
        ]);

        echo "<script>alert('Appointment booked successfully!');
        window.location.href = '/user/home.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Café</title>
    <style>
        /* Add some additional styling for error placement */
        .input-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 5px;
            width: 100%;
        }

        .form-row {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row label {
            width: 100%;
            text-align: left;
            margin-bottom: 3px;
        }

        .err {
            color: red;
            font-size: 0.85em;
            margin-top: 3px;
        }

        /* Adjust layout for side-by-side inputs */
        .input-group-half {
            flex: 1;
            min-width: 200px;
        }

        /* Style for the date/time inputs */
        .datetime-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .datetime-group .input-group {
            flex: 1;
            min-width: 150px;
        }
    </style>
</head>

<body>
    <main>
        <form method="post" class="appointment-form" novalidate>
            <h2>Book Your Appointment at Tech Cafe</h2>

            <div class="form-row">
                <div class="input-group input-group-half">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" required
                        value="<?= old('first_name') ?>"
                        pattern="[A-Za-z\s\-']{1,50}"
                        title="Only letters, spaces, hyphens, and apostrophes allowed. Max 50 chars">
                    <?php err('first_name') ?>
                </div>

                <div class="input-group input-group-half">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" required
                        value="<?= old('last_name') ?>"
                        pattern="[A-Za-z\s\-']{1,50}"
                        title="Only letters, spaces, hyphens, and apostrophes allowed. Max 50 chars">
                    <?php err('last_name') ?>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" name="phone" id="phone" required
                        value="<?= old('phone') ?>"
                        pattern="^01[0,1,2,3,4,6-9][0-9]{7,8}$"
                        title="Enter a valid Malaysian phone number (excluding 015)">
                    <?php err('phone') ?>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="email">Email (Optional):</label>
                    <input type="email" name="email" id="email"
                        value="<?= old('email') ?>">
                    <?php err('email') ?>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="service">Please Choose Your Service:</label>
                    <select name="service" id="service" required>
                    <option value="">- Select One -</option>
                    <option value="Coworking Space" <?= old('service') == 'Coworking Space' ? 'selected' : '' ?>>Co-working Space</option>
                    <option value="Keyboard Disassembly" <?= old('service') == 'Keyboard Disassembly' ? 'selected' : '' ?>>Keyboard Disassembly Service</option>
                    <option value="Keyboard Cleaning" <?= old('service') == 'Keyboard Cleaning' ? 'selected' : '' ?>>Keyboard Cleaning Service</option>
                    <option value="Keyboardd Soldering" <?= old('service') == 'Keyboardd Soldering' ? 'selected' : '' ?>>Whole Keyboard Desoldering/Soldering Service</option>
                    <option value="Keyboard Build" <?= old('service') == 'Keyboard Build' ? 'selected' : '' ?>>Keyboard Building Service (Hotswap)</option>
                    <option value="Switch Fix" <?= old('service') == 'Switch Fix' ? 'selected' : '' ?>>Repairing Switch Desoldering/Soldering Service</option>
                    <option value="Turbocharge" <?= old('service') == 'Turbocharge' ? 'selected' : '' ?>>Turbocharge Performance Service</option>
                    <option value="Virus Removal" <?= old('service') == 'Virus Removal' ? 'selected' : '' ?>>Conquer Virus Service</option>
                    <option value="Data Recovery" <?= old('service') == 'Data Recovery' ? 'selected' : '' ?>>Rescue Lost Data Service</option>
                    <option value="Glitch Fix" <?= old('service') == 'Glitch Fix' ? 'selected' : '' ?>>Fix Any Glitch Service</option>
                    <option value="PC Build" <?= old('service') == 'PC Build' ? 'selected' : '' ?>>PC Building Service</option>
                    </select>
                    <?php err('service') ?>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="problem_description">Problem Description (Optional):</label>
                    <textarea name="problem_description" id="problem_description" style="resize: vertical; min-height: 80px;"><?= old('problem_description') ?></textarea>
                </div>
            </div>

            <div class="form-row datetime-group">
                <div class="input-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="date" name="appointment_date" id="appointment_date" required
                        min="<?= $today ?>" value="<?= old('appointment_date') ?>">
                </div>

                <div class="input-group">
                    <label for="appointment_time">Appointment Time:</label>
                    <input type="time" name="appointment_time" id="appointment_time" required
                        min="09:00" max="20:00" step="1800" title="Appointments available between 9:00 AM and 8:00 PM" value="<?= old('appointment_time') ?>">
                </div>
            </div>
            <div class="form-row">
                <?php err('datetime') ?>
            </div>

            <button type="submit">Book Appointment</button>
        </form>

        <br>
        <?php
        include '../foot.php';
        ?>
    </main>

</body>

</html>