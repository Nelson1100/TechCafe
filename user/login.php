<?php
    require '../base.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In Here.</title>
        <link rel="stylesheet" href="../css/app.css">
        <link rel="icon" type="image/x-icon" href="../images/TechCafe.png">
    </head>
    <body class="signBackground">
    <a href="/pages/home.php"><img src="../images/back.png" alt="Back Button"></a>
        <main class="signPage">
        <h2>Sign In</h2>
            <div class="loginForm">
                <form method="POST" action="../base.php">	
                    <div class="inputBox">
                        <input type="email" name="email" maxlength="40" size="35" required>
                        <span>Email</span>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" maxLength='20' size="35" required>
                        <span>Password</span>
                    </div><br>
                    <div>
                        <button name="login" type="submit" class="button">Sign In</button>
                    </div><br>
                Don't have an account ?<a href="register.php"><b>&nbsp;&nbsp; Register</b></a>
                </form>
            </div>
        </main>
    </body>
</html>