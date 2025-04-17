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
    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>