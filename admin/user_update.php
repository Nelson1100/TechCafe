<?php
require '../base.php';
include '../admin_head.php';

$default_photo = 'photo.jpg';

if (is_get()) {
    $Email = req('Email');

    $stm = $_db->prepare('SELECT * FROM user WHERE Email = ?');
    $stm->execute([$Email]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('user.php');
    }

    extract((array)$u);
    // store profile pic into session
    $_SESSION['ProfilePic'] = $ProfilePic ?? $default_photo;
    $photo = $ProfilePic ?? $default_photo;
}

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
    $photo = $_SESSION['ProfilePic'] ?? $default_photo;

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

    // Pass Validation - only validate if password is provided
    $changePassword = false;
    if ($Pass != '') {
        $changePassword = true;
        if (strlen($Pass) > 20) {
            $_err['Pass'] = 'Maximum 20 characters';
        } else if (strlen($Pass) < 8) {
            $_err['Pass'] = 'Minimum 8 characters required';
        }
    
        // Confirm Password Validation - only if password is provided
        if ($ConfirmPass == '') {
            $_err['ConfirmPass'] = 'Required when changing password';
        } else if ($Pass != $ConfirmPass) {
            $_err['ConfirmPass'] = 'Passwords do not match';
        }
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
        if ($f && $f->size > 0) {
            // new photo selected
            if ($photo != $default_photo) {
                // Only delete if it's not the default photo
                unlink("../images/profilePic/$photo");
            }
            $photo = save_photo($f, '../images/profilePic');
        }
        
        // Prepare the SQL based on whether password is being updated
        if ($changePassword) {
            $stm = $_db->prepare('
                UPDATE user 
                SET UserFullName = ?, Username = ?, PhoneNo = ?, Pass = SHA1(?), Address = ?, Roles = ?, ProfilePic = ?
                WHERE Email = ?
            ');
            $stm->execute([$UserFullName, $Username, $PhoneNo, $Pass, $Address ?: null, $Roles, $photo, $Email]);
        } else {
            $stm = $_db->prepare('
                UPDATE user 
                SET UserFullName = ?, Username = ?, PhoneNo = ?, Address = ?, Roles = ?, ProfilePic = ?
                WHERE Email = ?
            ');
            $stm->execute([$UserFullName, $Username, $PhoneNo, $Address ?: null, $Roles, $photo, $Email]);
        }

        temp('info', 'User record updated');
        redirect('user.php');
    }

    if (!isset($photo)) {
        $photo = $_SESSION['ProfilePic'] ?? $default_photo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Update</title>
</head>

<body>
    <main class="admin">
        <h1>User | Update</h1>
        <form method="post" class="admin-form" enctype="multipart/form-data" novalidate>
            <label for="Email">Email</label>
            <b><?= $Email ?></b>
            <br>

            <label for="UserFullName">UserFullName</label>
            <input type="text" id="UserFullName" name="UserFullName" maxlength="100" pattern="^[A-Za-z\s]+$" title="Only letters are allowed." value="<?= htmlentities($UserFullName) ?>" required>
            <?= err('UserFullName') ?>

            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" maxlength="15" value="<?= htmlentities($Username) ?>" required>
            <?= err('Username') ?>

            <label for="PhoneNo">PhoneNo (+60)</label>
            <input type="tel" id="PhoneNo" name="PhoneNo" pattern="1[0-46-9][0-9]{7,8}" maxlength="10" placeholder="1XXXXXXXXX" title="Start with 1 without -" value="<?= htmlentities($PhoneNo) ?>" required>
            <?= err('PhoneNo') ?>

            <label for="Pass">Pass</label>
            <input type="password" id="Pass" name="Pass" maxlength="20" pattern=".{8,}" title="Eight or more characters but less than twenty.">
            <?= err('Pass') ?>

            <label for="ConfirmPass">Confirm Pass</label>
            <input type="password" id="ConfirmPass" name="ConfirmPass" maxlength="20" pattern=".{8,}" title="Eight or more characters but less than twenty.">
            <?= err('ConfirmPass') ?>

            <label for="Address">Address</label>
            <input type="text" id="Address" name="Address" maxlength="100" value="<?= htmlentities($Address) ?>">
            <?= err('Address') ?>

            <label>Roles</label>
            <div class="roles-container">
                <div class="role-option">
                    <input type="radio" id="role-user" name="Roles" value="User" <?= $Roles != 'Admin' ? 'checked' : '' ?>>
                    <label for="role-user">User</label>
                </div>
                <div class="role-option">
                    <input type="radio" id="role-admin" name="Roles" value="Admin" <?= $Roles == 'Admin' ? 'checked' : '' ?>>
                    <label for="role-admin">Admin</label>
                </div>
            </div>
            <?= err('Roles') ?>

            <label for="ProfilePic">ProfilePic</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProfilePic" name="ProfilePic" accept="image/*" hidden>
                <img src="../images/profilePic/<?= htmlentities($photo) ?>" alt="Current Photo" onerror="this.src='../images/photo.jpg'">
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