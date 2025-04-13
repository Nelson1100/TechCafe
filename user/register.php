<?php
    require '../base.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up Here.</title>
        <link rel="stylesheet" href="../css/app.css">
        <link rel="icon" type="image/x-icon" href="../images/TechCafe.png">
    </head>
    <a href="/user/home.php"><img src="../images/back.png" alt="Back Button"></a>
    <main class="signPage">
        <body class="signBackground">
        <h2>Sign Up</h2>
            <div class="loginForm">
                <form method="POST" action="../base.php">	
                    <div class="inputBox">
                        <input type="text" name="fullname" maxlength="100" size="35" pattern="^[A-Za-z\s]+$" title="Only letters are allowed." required autofocus>
                        <span>Full Name</span>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="username" maxlength="15" size="35" required>
                        <span>Username</span>
                    </div>
                    <div class="inputBox">
                        <input type="email" name="email" maxlength="40" size="35" required>
                        <span>Email</span>
                    </div>
                    <div class="inputBox">
                        <input type="tel" name="phonenumber" maxlength="11" size="35" pattern="[0][1][0-9].{7,}" title="Start with 01 without -" required>
                        <span>Phone Number</span>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" maxLength='20' size="35" pattern=".{8,}" title="Eight or more characters but less than twenty." required>
                        <span>Password</span>
                    </div><br>
                    <div>
                        <button name="register" type="submit" class="button">Sign Up</button>
                    </div><br>
                    Already have an account ?<a href="login.php"><b>&nbsp;&nbsp; Sign In</b></a>
                </form>
            </div>
        </body>
    </main>
</html>