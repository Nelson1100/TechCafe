<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $Email = req('Email');
    $UserFullName = req('UserFullName');
    $Username = req('Username');
    $PhoneNo = req('PhoneNo');
    $Pass = req('Pass');
    $ConfirmPass = req('ConfirmPass');
    $Address = req('Address');
    $Roles = req('Roles');
    $f = get_file('ProfilePic');

    // Email Validation
    if ($Email == '') {
        $_err['Email'] = 'Required';
    } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $_err['Email'] = 'Please enter a valid email address (e.g., user@example.com)';
    } else if (!is_unique($Email, 'user', 'Email')) {
        $_err['Email'] = 'Email already registered';
    } else if (strlen($Email) > 100) {
        $_err['Email'] = 'Maximum 100 characters';
    }

    // UserFullName Validation
    if ($UserFullName == '') {
        $_err['UserFullName'] = 'Required';
    } else if (strlen($UserFullName) > 100) {
        $_err['UserFullName'] = 'Maximum 100 characters';
    } else if (!preg_match('/^[A-Za-z\s]+$/', $UserFullName)) {
        $_err['UserFullName'] = 'Only letters are allowed';
    }

    // Username Validation
    if ($Username == '') {
        $_err['Username'] = 'Required';
    } else if (strlen($Username) > 15) {
        $_err['Username'] = 'Maximum 15 characters';
    }

    //PhoneNo Validation
    if ($PhoneNo == '') {
        $_err['PhoneNo'] = 'Required';
    } else if (!preg_match('/^1[0-46-9][0-9]{7,8}$/', $PhoneNo)) {
        $_err['PhoneNo'] = 'Must be a valid Malaysian mobile number starting with 10-14 or 16-19 (9-10 digits total)';
    }

    // Pass Validation
    if ($Pass == '') {
        $_err['Pass'] = 'Required';
    } else if (strlen($Pass) > 20) {
        $_err['Pass'] = 'Maximum 20 characters';
    } else if (strlen($Pass) < 8) {
        $_err['Pass'] = 'Minimum 8 characters required';
    }

    // Confirm Password Validation
    if ($ConfirmPass == '') {
        $_err['ConfirmPass'] = 'Required when changing password';
    } else if ($Pass != $ConfirmPass) {
        $_err['ConfirmPass'] = 'Passwords do not match';
    }

    // Address Validation (can be null)
    if ($Address != '' && strlen($Address) > 100) {
        $_err['Address'] = 'Maximum 100 characters';
    }

    // Roles Validation
    $valid_roles = ['User', 'Admin'];

    if ($Roles == '') {
        $_err['Roles'] = 'Required';
    } else if (!in_array($Roles, $valid_roles)) {
        $_err['Roles'] = 'Invalid role selected';
    }

    // ProfilePic Validation (can be null)
    if ($f && $f->size > 0) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['ProfilePic'] = 'Must be image';
        } else if ($f->size > 1 * 1024 * 1024) {
            $_err['ProfilePic'] = 'Maximum 1 MB';
        }
    }

    // DB operation
    // save photo then continue with DB operation
    if (!$_err) {
        // Save photo if one was uploaded
        $photo = null;
        if ($f && $f->size > 0) {
            $photo = save_photo($f, '../images/profilePic');
        }

        $stm = $_db->prepare('
            INSERT INTO user (UserFullName, Username, PhoneNo, Email, Pass, Address, Roles, ProfilePic)
            VALUES (?, ?, ?, ?, SHA1(?), ?, ?, ?)
        ');
        $stm->execute([$UserFullName, $Username, $PhoneNo, $Email, $Pass, $Address ?: null, $Roles, $photo]);

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
            <label for="Email">Email</label>
            <input type="email" id="Email" name="Email" placeholder="example@domain.com" value="<?= old('Email') ?>" required>
            <?= err('Email') ?>

            <label for="UserFullName">UserFullName</label>
            <input type="text" id="UserFullName" name="UserFullName" maxlength="100" pattern="^[A-Za-z\s]+$" title="Only letters are allowed." value="<?= old('UserFullName') ?>" required>
            <?= err('UserFullName') ?>

            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" maxlength="15" value="<?= old('Username') ?>" required>
            <?= err('Username') ?>

            <label for="PhoneNo">PhoneNo (+60)</label>
            <input type="tel" id="PhoneNo" name="PhoneNo" pattern="1[0-46-9][0-9]{7,8}" maxlength="10" placeholder="1XXXXXXXXX" title="Start with 1 without -" value="<?= old('PhoneNo') ?>" required>
            <?= err('PhoneNo') ?>

            <label for="Pass">Pass</label>
            <input type="password" id="Pass" name="Pass" maxlength="20" pattern=".{8,}" title="Eight or more characters but less than twenty." required>
            <?= err('Pass') ?>

            <label for="ConfirmPass">Confirm Pass</label>
            <input type="password" id="ConfirmPass" name="ConfirmPass" maxlength="20" pattern=".{8,}" title="Eight or more characters but less than twenty." required>
            <?= err('ConfirmPass') ?>

            <label for="Address">Address</label>
            <input type="text" id="Address" name="Address" maxlength="100" value="<?= old('Address') ?>">
            <?= err('Address') ?>

            <label>Roles</label>
            <div class="roles-container">
                <div class="role-option">
                    <input type="radio" id="role-user" name="Roles" value="User" <?= old('Roles') != 'Admin' ? 'checked' : '' ?>>
                    <label for="role-user">User</label>
                </div>
                <div class="role-option">
                    <input type="radio" id="role-admin" name="Roles" value="Admin" <?= old('Roles') == 'Admin' ? 'checked' : '' ?>>
                    <label for="role-admin">Admin</label>
                </div>
            </div>
            <?= err('Roles') ?>

            <label for="ProfilePic">ProfilePic</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProfilePic" name="ProfilePic" accept="image/*" hidden>
                <img src="../images/photo.jpg" alt="Photo">
            </label>
            <?= err('ProfilePic') ?>

            <section>
                <button class="admin-btn btn-submit">Submit</button>
                <button type="reset" class="admin-btn btn-reset">Reset</button>
            </section>
        </form>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>