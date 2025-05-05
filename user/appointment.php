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

        if ($selected < time()) {
            $_err['datetime'] = 'Appointment must be in the future.';
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
</head>

<body>
    <main>
        <form method="post" class="appointment-form" novalidate>
            <h2>Book Your Appointment at Tech Cafe</h2>

            <div class="form-row">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" required style="flex: 1;" value="<?= htmlentities($first_name ?? '') ?>"
                    pattern="[A-Za-z\s\-']{1,50}" 
                    title="Only letters, spaces, hyphens, and apostrophes allowed. Max 50 chars">
                <? err('first_name') ?>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" required style="flex: 1;" value="<?= htmlentities($last_name ?? '') ?>"
                    pattern="[A-Za-z\s\-']{1,50}" 
                    title="Only letters, spaces, hyphens, and apostrophes allowed. Max 50 chars">
                <? err('last_name') ?>
            </div>

            <div class="form-row">
                <label for="phone">Phone Number:</label>
                <input type="tel" name="phone" id="phone" required style="flex: 1;" value="<?= htmlentities($phone ?? '') ?>"
                    pattern="^01[0,1,2,3,4,6-9][0-9]{7,8}$"
                    title="Enter a valid Malaysian phone number (excluding 015)">
                <?= isset($_err['phone']) ? $_err['phone'] : '' ?>
                <? err('phone') ?>
            </div>

            <div class="form-row">
                <label for="email">Email (Optional):</label>
                <input type="email" name="email" id="email" style="flex: 1;" value="<?= htmlentities($email ?? '') ?>">
                <? err('email') ?>
            </div>

            <div class="form-row">
                <label for="service">Please Choose Your Service:</label>
                <select name="service" id="service" required style="flex: 1;">
                <option value="Coworking Space">Co-working Space</option>
                    <option value="Keyboard Disassembly">Keyboard Disassembly Service</option>
                    <option value="Keyboard Cleaning">Keyboard Cleaning Service</option>
                    <option value="Keyboardd Soldering">Whole Keyboard Desoldering/Soldering Service</option>
                    <option value="Keyboard Build">Keyboard Building Service (Hotswap)</option>
                    <option value="Switch Fix">Repairing Switch Desoldering/Soldering Service</option>
                    <option value="Turbocharge">Turbocharge Performance Service</option>
                    <option value="Virus Removal">Conquer Virus Service</option>
                    <option value="Data Recovery">Rescue Lost Data Service</option>
                    <option value="Glitch Fix">Fix Any Glitch Service</option>
                    <option value="PC Build">PC Building Service</option>
                </select>
                <? err('service') ?>
            </div>

            <div class="form-row">
                <label for="problem_description">Problem Description (Optional):</label>
                <textarea name="problem_description" id="problem_description" style="resize: vertical; width: 76%; min-height: 80px;"></textarea>
            </div>

            <div class="form-row">
                <label for="appointment_date">Appointment Date:</label>
                <input type="date" name="appointment_date" id="appointment_date" required style="flex: 1;" min="<?= $today ?>" value="<?= htmlentities($appointment_date ?? '') ?>">

                <label for="appointment_time">Appointment Time:</label>
                <input type="time" name="appointment_time" id="appointment_time" required style="flex: 1;" value="<?= htmlentities($appointment_time ?? '') ?>">
                <? err('datetime') ?>
            </div>

            <button type="submit">Book Appointment</button>
        </form>

        <br>
        <?php include '../foot.php'; ?>
    </main>

</body>

</html>