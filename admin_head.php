<?php
// Restrict access to admins only
if ($_SESSION['Role'] !== 'Admin') {
    echo "<script>alert('Access denied. Admins only.'); window.location='/user/home.php'</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/images/TechCafe.png"> <!-- Favicon for the Page -->
</head>

<body>
    <!-- Flash message -->
    <div id="info"><?= temp('info') ?></div>

    <header>
        <div class="header-container" id="header">
            <div id="header-icons-left" class="header-icons">
                <a href="/admin/product.php"><img src="/images/TechCafe.png" alt="Tech Café"></a>
                <h3 id="greeting">Welcome to the Admin Page</h3>
            </div>
            <div id="header-icons-right" class="header-icons">
                <?php
                if (isset($_SESSION['Email'])) {
                ?>
                    <a href="../userProfile.php">
                        <img src="<?= $user['ProfilePic'] ? '/images/profilePic/' . $user['ProfilePic'] : '/images/user.png' ?>" alt="User Profile" style="border-radius: 50%; object-fit: cover;">
                    </a>
                <?php
                } else {
                ?>
                    <img src="/images/user.png" alt="User Profile" style="border-radius: 50%;">
                    </a>
                <?php
                }
                ?>
            </div>

            <nav id="navigationBar">
                <ul>
                    <li><a href="/admin/product.php">Product</a></li>
                    <li><a href="/admin/user.php">User</a></li>
                    <li><a href="/admin/appointment.php">Appointment</a></li>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>