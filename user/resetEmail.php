<?php
require '../base.php';

if (isset($_SESSION['previousPage'])) {
    $previousPage = $_SESSION['previousPage'];
}

// Steps => Get Email from submit, validation, select user from db, generate token [id], delete old token, generate token url then send email
if (is_post()) {
    $email = req('email');

    if ($email == '') {
        $_err['email'] = 'Please enter email';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_exists($email, 'user', 'email')) {
        $_err['email'] = 'Email does not exist';
    }

    if (!$_err) {
        $stm = $_db->prepare('SELECT * FROM user WHERE Email = ?');
        $stm->execute([$email]);
        $u = $stm->fetch(PDO::FETCH_OBJ);

        // Token generation + hashing
        $id = SHA1(uniqid() . rand());

        $stm = $_db->prepare('INSERT INTO token (id, expire, email) VALUES (?, ADDTIME(NOW(), "00:30"), ?)');
        $stm->execute([$id,$email]);

        $url = base("user/passToken.php?id=$id");

        $m = get_mail();
        $m -> addAddress($u->Email, $u->UserFullName);
        $m -> isHTML(true);
        $m -> Subject = "Reset Password";

        //Email formatting that contains a link to reset password
        $m->Body =
        "            
            <p>Dear , $u->UserFullName,<p>
            <h1 style='color: blue'>Password Reset Link</h1>
            <p>
                Please click <a href='$url'>here</a>
                to reset your password.
            </p>
            <p>From, Tech Cafe </p>
        ";
        $m -> send();        
        echo "<script>alert('A password reset email has been sent to your Gmail. Please check your inbox (and spam folder) to proceed.');
        window.location.href = '/user/home.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset password</title>
        <link rel="stylesheet" href="../css/app.css">
        <link rel="icon" type="image/x-icon" href="../images/TechCafe.png">
    </head>
    <body class="signBackground">
    <a href="<?= $previousPage ?>" style="width: fit-content;"><img src="../images/back.png" alt="Back Button"></a>
        <main class="signPage">
        <h2>Reset Password</h2>
            <div class="loginForm">
                <form method="POST" class="form">	
                <div class="inputBox">
                    <input type="email" name="email" maxlength="40" size="35" placeholder=" " required autofocus>
                        <span>Email</span>
                        <?= err('email') ?>
                    </div>                    
                        <button type="submit" class="button">Submit</button>                       
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>