<?php
	require 'base.php';
	
	if (isset($_SESSION['previousPage'])) {
        $previousPage = $_SESSION['previousPage'];
    }
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
			padding: 5px 0;
			font-family: 'Lexend', sans-serif;
		}

		span {
			font-size: large;
			letter-spacing: 2px;
		}

		.editPencil {
			background: none;
			cursor: pointer;
			color: white;
		}

		form input {
			width: 75%;
		}
	</style>
</head>
<a href="<?= $previousPage ?>" style="width: fit-content;"><img src="../images/back.png" alt="Back Button"></a>
	<main class="signPage" style="width: 450px;">
		<body class="signBackground">
			<?php
				$address = isset($user['Address']) && $user['Address'] !== null && $user['Address'] !== "" ? $user['Address'] : "-";
				$profilePic = (isset($user['ProfilePic']) && !empty($user['ProfilePic'])) ? "profilePic/" . $user['ProfilePic'] : "user.png";
				$email = $user['Email'];
			?>
			<form method="POST" action="../base.php" enctype="multipart/form-data">
				<label for="profileInput" style=" padding-right: 0; text-align: center;" onclick="editField('profilePic')">
					<img id="profilePreview" src="../images/<?= $profilePic ?>" style="margin: 0px; height: 100px; width: 100px; border-radius: 50%; object-fit: cover;">
					<br><span class="editPencil">&#9998;</span>
					Profile Picture
				</label>

				<input type="file" name="updatePic" id="profileInput" accept="image/*" onchange="loadProfile(event)" hidden>
				<h1 style="text-decoration: underline; font-family: 'Lexend', sans-serif;">User Information</h1>
				<h3>USERNAME:</h3>
				<span class="editPencil" onclick="editField('Username')">&#9998;</span>
				<span id="UsernameDisplay"><?php echo $user['Username']; ?></span>
				<input type="text" name="Username" id="UsernameInput" maxlength="15" value="<?php echo $user['Username']; ?>" style="display:none;"><br>
				
				<h3>FULL NAME: </h3>
				<span class="editPencil" onclick="editField('UserFullName')">&#9998;</span>
				<span id="UserFullNameDisplay"><?php echo $user['UserFullName']; ?></span>
				<input type="text" name="UserFullName" id="UserFullNameInput" maxlength="100" value="<?php echo $user['UserFullName']; ?>" style="display:none;"><br>
				
				<h3>EMAIL ADDRESS: </h3>
				<span><?php echo $email; ?></span>

				<h3>PHONE NUMBER: </h3>
				<span class="editPencil" onclick="editField('PhoneNo')">&#9998;</span>
				<span id="PhoneNoDisplay">0<?php echo $user['PhoneNo']; ?></span>
				<input type="text" name="PhoneNo" id="PhoneNoInput" maxlength="11" value="0<?php echo $user['PhoneNo']; ?>" style="display:none;"><br>

				<?php 
					$stm = $_db->prepare("SELECT Roles FROM user WHERE Email = ?");
					$stm->execute([$email]);
					$role = $stm->fetchColumn();

					if ($role != "Admin") {
				?>
				<h3>SHIPPING ADDRESS: </h3>
				<span class="editPencil" onclick="editField('Address')">&#9998;</span>
				<span id="AddressDisplay"><?php echo $address ?></span>
				<input type="text" name="Address" id="AddressInput" maxlength="100" value="<?php echo $address ?>" style="display:none;">
				<?php
					}
				?>
				<br>
				<div style="display: flex; align-items: center; justify-content: center; height: 60px; margin-top: 20px;">
					<button name="updateProfile" type="submit" class="button" id="update">Update</button>
					<button name="logout" type="submit" class="button" id="logout">Log Out</button>
				</div>
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

			function editField(fieldName){
				if (fieldName != "profilePic") {
					document.getElementById(fieldName + 'Display').style.display = 'none';
					document.getElementById(fieldName + 'Input').style.display = 'inline';
				}

				document.getElementById('update').classList.add('translated');
				document.getElementById('logout').classList.add('translated');

				let span = document.getElementById(fieldName);
				let currentValue = span.textContent.trim();
				let input = `<input type="text" name="${fieldName}" value="${currentValue}" style="width: 250px;">`;
				span.outerHTML = input;
			}
		</script>
	</main>
</html>