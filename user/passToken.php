<?php
require '../base.php';

if (isset($_SESSION['previousPage'])) {
    $previousPage = $_SESSION['previousPage'];
}

$_db->query('DELETE FROM token WHERE expire < NOW()');

$id = req('id'); //check current token id

// Check if token exist or is valid before passing going further

if (!is_exists($id , 'token', 'id')) {
    temp('info', 'Invalid token. Try again');
    redirect('/user/home.php');
}

if (is_post()) {
    $password = req('password'); 
    $confirm  = req('confirm');

    if ($password == '') {
        $_err['password'] = 'Required<br><br>';
    }
    else if (strlen($password) < 8 || strlen($password) > 20) {
        $_err['password'] = 'Between 8-20 characters<br><br>';
    }

    if ($confirm == '') {
        $_err['confirm'] = 'Required<br><br>';
    }
    else if (strlen($confirm) < 8 || strlen($confirm) > 20) {
        $_err['confirm'] = 'Between 8-20 characters<br><br>';
    }
    else if ($confirm != $password) {
        $_err['confirm'] = 'Not matched<br><br>';
    }

    // DB operation
    if (is_post() && !$_err) {
        // Update password into DB and delete this token
        $stm = $_db->prepare('
    UPDATE user SET Pass = SHA1(?) WHERE email = (SELECT email FROM token WHERE id = ?);
    DELETE FROM token WHERE id = ?;
');
    $stm->execute([$password, $id, $id]);
    echo "<script>alert('Password Successful Changed! Please login again.');
        window.location.href = '/user/login.php';</script>";
    }
}

// ----------------------------------------------------------------------------

$_title = 'Reset Password';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset your password</title>
        <link rel="stylesheet" href="../css/app.css">
        <link rel="icon" type="image/x-icon" href="../images/TechCafe.png">
        <style>
        p {
            color: red;
        }
    </style>
    </head>
    <body class="signBackground">
    <a href="<?= $previousPage ?>" style="width: fit-content;"><img src="../images/back.png" alt="Back Button"></a>
        <main class="signPage">
        <h2>Enter a new password</h2>
            <div class="loginForm">
                <form method="POST">	
                    <div class="inputBox">
                        <input type="password" id="password" name="password" maxLength='20' size="35" placeholder=" " required autofocus>
                        <span>New Password</span>
                    </div>
                    <?= err('password') ?>
                    <div class="inputBox">
                        <input type="password" id="confirm" name="confirm" maxLength='20' size="35" placeholder=" " required>
                        <span>Confirm Password</span>
                    </div>
                        <?= err('confirm') ?>                 
                        <button name="resetPassword" type="submit" class="button">Reset Password</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>