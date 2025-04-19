<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $UserFullName = req('UserFullName');
    $Username = req('Username');
    $PhoneNo = req('PhoneNo');
    $Email = req('Email');
    $Pass = req('Pass');
    $Address = req('Address');
    $Roles = req('Roles');
    $f = get_file('ProfilePic');

    // UserFullName Validation
    if ($UserFullName == '') {
        $_err['UserFullName'] = 'Required';
    } else if (strlen($UserFullName) > 100) {
        $_err['UserFullName'] = 'Maximum 100 characters';
    }

    // Username Validation
    if ($Username == '') {
        $_err['Username'] = 'Required';
    } else if (strlen($Username) > 15) {
        $_err['Username'] = 'Maximum 100 characters';
    }

    //PhoneNo Validation
    if ($PhoneNo == '') {
        $_err['PhoneNo'] = 'Required';
    } else if (!preg_match('/^01[0-46-9][0-9]{7,8}$/', $PhoneNo)) {
        $_err['PhoneNo'] = 'Must be a valid Malaysian mobile number (e.g., 010–014, 016–019; 10–11 digits)';
    }

    // Email Validation
    if ($Email == '') {
        $_err['Email'] = 'Required';
    } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $_err['Email'] = 'Please enter a valid email address (e.g., user@example.com)';
    } else if (!is_unique($Email, 'user', 'Email')) {
        $_err['Email'] = 'Email already registered';
    }

    // Pass Validation
    if ($Pass == '') {
        $_err['Pass'] = 'Required';
    }  // To be continue ... (use SHA1 ba)

    // Address Validation
    // To be continue ... (can be null)

    // Roles Validation
    $valid_roles = ['User', 'Admin'];

    if ($Roles == '') {
        $_err['Roles'] = 'Required';
    } else if (!in_array($Category, $valid_roles)) {
        $_err['Roles'] = 'Invalid category selected';
    } 

    // ProfilePic Validation
    // To be continue ... (can be null)
    
    // DB operation
    // save photo then continue with DB operation
    if (!$_err) {
        // Save photo
        $photo = save_photo($f, '../images/profilePic');

        $stm = $_db->prepare('
            INSERT INTO user (UserFullName, Username, PhoneNo, Email, Pass, Address, Roles, ProfilePic)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $stm->execute([$UserFullName, $Username, $PhoneNo, $Email, $Pass, $Address, $Roles, $photo]);

        temp('info', 'User record inserted');
        redirect('user.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Insert</title>
</head>

<body>
<main class="admin">
        <h1>User | Insert</h1>
        <form method="post" class="admin-form" enctype="multipart/form-data" novalidate>
            <label for="UserFullName">UserFullName</label>
            <input type="text" id="UserFullName" name="UserFullName" maxlength="100">
            <?= err('UserFullName') ?>

            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" maxlength="15">
            <?= err('UserFullName') ?>

            <label for="PhoneNo">PhoneNo</label>
            <input type="text">

            <label for="ProfilePic">ProfilePic</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProfilePic" name="ProfilePic" accept="image/*" hidden>
                <img src="../images/photo.jpg" alt="Photo">
            </label>
            <?= err('ProfilePic') ?>

            <section>
                <button>Submit</button>
                <button type="reset">Reset</button>
            </section>
        </form>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>