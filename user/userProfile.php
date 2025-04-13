<?php
	require '../base.php';

	$email=$_SESSION['Email'];
	$stm = $_db->prepare("SELECT UserFullName, Username, PhoneNo, Email, Pass, Roles FROM user WHERE Email = ?");
	$stm->execute([$email]);
	$user = $stm->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Log Out.</title>
	<link rel="stylesheet" href="../css/app.css">
	<link rel="icon" type="image/x-icon" href="../images/TechCafe.png">
	<style>
		h3 {
			margin-bottom: 0px;
			margin-top: 25px;
			padding: 5px 0;
		}
	</style>
</head>
<a href="/user/home.php"><img src="../images/back.png" alt="Back Button"></a>
	<main class="signPage">
		<body class="signBackground">
			<h2>User Information</h2>
			<h3>USERNAME: </h3>
			<?php echo $user['Username']; ?><br>
			<h3>EMAIL: </h3>
			<?php echo $user['Email']; ?><br>
			<h3>PHONE NUMBER: </h3>
			<?php echo "0" .$user['PhoneNo']; ?><br>
			<form method="POST" action="../base.php">
				<button name="logout" type="submit" class="button">Log Out</button>
			</form>
		</body>
	</main>
</html>