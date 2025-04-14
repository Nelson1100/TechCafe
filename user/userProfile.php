<?php
	require '../base.php';

	$email=$_SESSION['Email'];
	$stm = $_db->prepare("SELECT * FROM user WHERE Email = ?");
	$stm->execute([$email]);
	$user = $stm->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>User Profile</title>
	<link rel="stylesheet" href="../css/app.css">
	<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="../images/TechCafe.png">
	<style>
		h3 {
			margin-bottom: 0px;
			margin-top: 25px;
			padding: 5px 0;
			font-family: 'Lexend', sans-serif;
		}

		span {
			font-size: large;
			letter-spacing: 2px;
		}
	</style>
</head>
<a href="/user/home.php"><img src="../images/back.png" alt="Back Button"></a>
	<main class="signPage">
		<body class="signBackground">
			<?php
				$address = isset($user['Address']) && $user['Address'] !== null && $user['Address'] !== "" ? $user['Address'] : "-";
				$profilePic = (isset($user['ProfilePic']) && !empty($user['ProfilePic'])) ? $user['ProfilePic'] : "user.png";
			?>
			<form class="profile-upload" action="../base.php" method="POST" enctype="multipart/form-data">
				<label for="profileInput" style=" padding-right: 0; text-align: center;">
				<img id="profilePreview" src="../images/<?= $profilePic ?>" style="margin: 0px; height: 100px; width: 100px; border-radius: 50%;">
					<br>&#9998; Profile Picture
				</label>
				<input type="file" name="updateProfile" id="profileInput" accept="image/*" onchange="loadProfile(event)" hidden>
				<button type="submit" name="updateProfile"></button>
			</form>
			<h1 style="text-decoration: underline; font-family: 'Lexend', sans-serif;">User Information</h1>
			<h3>USERNAME: </h3>
			<span><?php echo $user['Username']; ?></span><br>
			<h3>FULL NAME: </h3>
			<span><?php echo $user['UserFullName']; ?></span><br>
			<h3>EMAIL ADDRESS: </h3>
			<span><?php echo $user['Email']; ?></span><br>
			<h3>PHONE NUMBER: </h3>
			<span><?php echo "0" .$user['PhoneNo']; ?></span><br>
			<h3>SHIPPING ADDRESS: </h3>
			<span><?php echo $address ?></span><br>
			<form method="POST" action="../base.php">
				<button name="logout" type="submit" class="button">Log Out</button>
			</form>
		</body>
		<script>
			function loadProfile(event) {
				const image = document.getElementById('profilePreview');
				image.src = URL.createObjectURL(event.target.files[0]);
				image.onload = function () {
					URL.revokeObjectURL(image.src); // free memory
				};
			}
		</script>
	</main>
</html>