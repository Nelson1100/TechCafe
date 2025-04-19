<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();

function is_get()
{
	return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Is POST request?
function is_post()
{
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Obtain REQUEST (GET and POST) parameter
function req($key, $value = null)
{
	$value = $_REQUEST[$key] ?? $value;
	return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Redirect to URL
function redirect($url = null)
{
	$url ??= $_SERVER['REQUEST_URI'];
	header("Location: $url");
	exit();
}

// Set or get temporary session variable
function temp($key, $value = null)
{
	if ($value !== null) {
		$_SESSION["temp_$key"] = $value;
	} else {
		$value = $_SESSION["temp_$key"] ?? null;
		unset($_SESSION["temp_$key"]);
		return $value;
	}
}

// Obtain uploaded file --> cast to object
function get_file($key)
{
	$f = $_FILES[$key] ?? null;

	if ($f && $f['error'] == 0) {
		return (object)$f;
	}

	return null;
}

// Crop, resize and save photo
function save_photo($f, $folder, $width = 200, $height = 200)
{
	$photo = uniqid() . '.jpg';

	require_once 'lib/SimpleImage.php';
	$img = new SimpleImage();
	$img->fromFile($f->tmp_name)
		->thumbnail($width, $height)
		->toFile("$folder/$photo", 'image/jpeg');

	return $photo;
}

// Is unique?
function is_unique($value, $table, $field)
{
	global $_db;
	$stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
	$stm->execute([$value]);
	return $stm->fetchColumn() == 0;
}

$_db = new PDO('mysql:dbname=techcafe', 'root', '', [
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

if (isset($_GET['ProductID'])) {
	$ProductID = urldecode($_GET['ProductID']);

	$stm = $_db->prepare("SELECT SpecID, Specification, Price, Descr, ProductPhoto FROM specification WHERE ProductID = ?");
	$stm->execute([$ProductID]);
	$specifications = $stm->fetchAll();
}

if (is_post()) {
	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		$stm = $_db->prepare("SELECT UserFullName, Username, PhoneNo, Email, Pass, Roles FROM user WHERE Email = ?");
		$stm->execute([$email]);
		$user = $stm->fetch();

		if (!$user) {
			echo "<script>alert('No user found. Please sign up.');
			window.location='/user/register.php'</script>";
		} else if (($password != $user['Pass'])) {
			echo "<script>alert('Wrong password. Please try again.');
				window.location='/user/login.php'</script>";
		} else {
			$_SESSION['UserFullName'] = $user['UserFullName'];
			$_SESSION['Username'] = $user['Username'];
			$_SESSION['Email'] = $user['Email'];
			$_SESSION['Role'] = $user['Roles'];

			$username = $user['Username'];
			if ($user['Roles'] === 'Admin') {
				echo "<script>alert('Welcome Admin! $username');
				window.location='/admin/home.php'</script>";
			} else {
				echo "<script>alert('Welcome back! $username');
				window.location='/user/home.php'</script>";
			}
		}
	} else if (isset($_POST['register'])) {
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		$password = $_POST['password'];

		if (!is_unique($fullname, 'user', 'UserFullName')) {
			echo "<script>alert('Duplicated name is found! Please try to login.');
			window.location='/user/login.php'</script>";
		} else if (!is_unique($email, 'user', 'Email')) {
			echo "<script>alert('Duplicated email is found! Please try to login.');
			window.location='/user/login.php'</script>";
		} else if (!is_unique($phonenumber, 'user', 'PhoneNo')) {
			echo "<script>alert('Duplicated phone number is found! Please try to login.');
			window.location='/user/login.php'</script>";
		} else {
			$stm = $_db->prepare("INSERT INTO user (UserFullName, Username, PhoneNo, Email, Pass, Roles) VALUES ('$fullname', '$username', '$phonenumber', '$email', '$password', 'User')");
			$stm->execute();
			$_SESSION['Email'] = $email;
			echo "<script>alert('Welcome, $username! Your account has been created successfully.');
			window.location='/user/home.php'</script>";
		}
	} else if (isset($_POST['logout'])) {
		session_destroy();
		header("Location: user/home.php");
		exit();
	} else if (isset($_POST['updateProfile'])) {
		// Get new values from form
		$new_fullname   = isset($_POST['UserFullName']) ? trim($_POST['UserFullName']) : '';
		$new_email      = isset($_POST['Email']) ? trim($_POST['Email']) : '';
		$new_username   = isset($_POST['Username']) ? trim($_POST['Username']) : '';
		$new_phone      = isset($_POST['PhoneNo']) ? trim($_POST['PhoneNo']) : '';
		$new_address    = isset($_POST['Address']) ? trim($_POST['Address']) : '';

		echo "<script>alert('$new_username')</script>";
		// Fetch current user data from database
		$stmt = $_db->prepare("SELECT * FROM user WHERE Email = ?");
		$stmt->execute([$_SESSION['Email']]);
		$currentUser = $stmt->fetch();

		// Use current values if input is empty
		$fullname   = $new_fullname ?: $currentUser['UserFullName'];
		$email      = $new_email ?: $currentUser['Email'];
		$username   = $new_username ?: $currentUser['Username'];
		$phone      = $new_phone ?: $currentUser['PhoneNo'];
		$address    = $new_address ?: $currentUser['Address'];

		// Update DB
		$stm = $_db->prepare("UPDATE user SET UserFullName=?, Email=?, Username=?, PhoneNo=?, Address=? WHERE Email=?");
		$stm->execute([$fullname, $email, $username, $phone, $address, $_SESSION['Email']]);

		// Optional: Update session if email is changed
		$_SESSION['Email'] = $email;

		echo "<script>alert('Profile updated successfully.'); window.location.href='user/userProfile.php';</script>";

		if ($profilePic) {
			// Generate a unique filename
			$filename = uniqid() . "_" . basename($profilePic['name']);
			$targetDir = 'images/profilePic/';
			$targetFile = $targetDir . $filename;

			// Save file to server
			if (move_uploaded_file($profilePic['tmp_name'], $targetFile)) {
				$photo = 'profilePic/' . $filename;

				// Update DB
				$stm = $_db->prepare("UPDATE user SET ProfilePic = ? WHERE Email = ?");
				$stm->execute([$photo, $_SESSION['Email']]);
				echo "<script>alert('You had successfully changed your profile picture.');
				window.location='/user/userProfile.php'</script>";
			} else {
				echo "<script>alert('Failed to upload image.');
				window.location='/user/userProfile.php'</script>";
			}
		}
	} else if (isset($_POST['addCart'])) {
		$stm = $_db->prepare("SELECT * FROM cart WHERE Email = ?");
		$stm->execute([$_SESSION['Email']]);
		$cartItems = $stm->fetch();

		$specID = $_POST['selectedSpecID'];
		$quantity = $_POST['product-qty'];


		if (!$cartItems) {		// For creating cart for first purchase user
			$stm = $_db->prepare("INSERT INTO cart (Email, ItemsAdded, Quantity, OrderStatus) VALUES (?, ?, ?, ?)");
			$stm->execute([$_SESSION['Email'], $specID, $quantity, 'InCart']);
			echo "<script>alert('Successfully Added');
			window.location='/user/cart.php'</script>";
		} else {
			$currentItemAdded = $cartItems['ItemsAdded'];
			$currentQuantity = $cartItems['Quantity'];
			$stm = $_db->prepare("UPDATE cart SET ItemsAdded = ?, Quantity = ? WHERE Email = ? AND OrderStatus = 'InCart'");
			$stm->execute([$currentItemAdded . "," . $specID, $currentQuantity . "," . $quantity, $_SESSION['Email']]);
			echo "<script>alert('Successfully Added');
			window.location='/user/cart.php'</script>";
		}
	} else if (isset($_POST['addQuantity']) || isset($_POST['deductQuantity'])) {
		$targetSpecID = isset($_POST['addQuantity']) ? $_POST['addQuantity'] : $_POST['deductQuantity'];
		$operation = isset($_POST['addQuantity']) ? 'add' : 'deduct';

		// Get current cart
		$stm = $_db->prepare("SELECT * FROM cart WHERE Email = ? AND OrderStatus = 'InCart'");
		$stm->execute([$_SESSION['Email']]);
		$cartData = $stm->fetch();
		$specIDs = explode(',', $cartData['ItemsAdded']);
		$quantities = explode(',', $cartData['Quantity']);

		for ($i = 0; $i < count($specIDs); $i++) {
			if ($specIDs[$i] == $targetSpecID) {
				if ($operation == 'add') {
					$quantities[$i]++;
				} elseif ($operation == 'deduct' && $quantities[$i] > 1) {
					$quantities[$i]--;
				}
				break; // Stop loop once the targetSpecID is found
			}
		}

		// Debugging: Check $quantities and $newQuantity
		$newQuantity = implode(',', $quantities);

		// Update DB with new quantity
		$stm = $_db->prepare("UPDATE cart SET Quantity = ? WHERE Email = ? AND OrderStatus = 'InCart'");
		$stm->execute([$newQuantity, $_SESSION['Email']]);

		// Refresh page
		echo "<script>window.location.href = window.location.href;</script>";
		exit;
	}
} else if (is_get()) {
	$category = $_GET['category'] ?? 'All';
	$search = $_GET['ProductName'] ?? '';

	// Base query
	$sql = "SELECT ProductID, ProductName, Category, ProductThumb FROM product WHERE 1";
	$params = [];

	if ($category !== 'All') {
		$sql .= " AND Category = ?";
		$params[] = $category;
	}

	if (!empty($search)) {
		$sql .= " AND ProductName LIKE ?";
		$params[] = $search;
	}

	$stm = $_db->prepare($sql);
	$stm->execute($params);
	$products = $stm->fetchAll();
}

function printProduct($products)
{
	global $_db;
	$stm = $_db->prepare("SELECT s.ProductID, s.Specification, s.ProductPhoto, s.Descr, MIN(s.Price) AS MinPrice, MAX(s.Price) AS MaxPrice FROM product p JOIN specification s ON p.ProductID = s.ProductID GROUP BY p.ProductID");
	$stm->execute();
	$specPrice = $stm->fetchAll();

	$priceMap = [];
	foreach ($specPrice as $spec) {
		$priceMap[$spec['ProductID']] = [
			'MinPrice' => $spec['MinPrice'],
			'MaxPrice' => $spec['MaxPrice']
		];
	}

	foreach ($products as &$product) {
		$productID = $product['ProductID'];
		if (isset($priceMap[$productID])) {
			$product['MinPrice'] = $priceMap[$productID]['MinPrice'];
			$product['MaxPrice'] = $priceMap[$productID]['MaxPrice'];
		} else {
			$product['MinPrice'] = $product['MaxPrice'] = 'N/A';
		}
	}
	unset($product);

	foreach ($products as $index => $product) {
		$priceDisplay = ($product["MinPrice"] == $product["MaxPrice"])
			? 'RM ' . $product["MinPrice"]
			: 'RM ' . $product["MinPrice"] . ' - RM ' . $product["MaxPrice"];
		echo '
			<th>
				<div>
					<div>
						<img src="../images/product/' . $product["ProductThumb"] . '" alt="' . $product["ProductName"] . '">
						<div class="name">' . $product["ProductName"] . '</div>
						<p class="price">' . $priceDisplay . '</p>
					</div>
					<div>
						<a class="button" href="product.php?ProductID=' . urlencode($product["ProductID"]) . '">Click Here</a>
					</div>
				</div>
			</th>';

		// Close row after 4 products
		if (($index + 1) % 4 == 0 && !is_get()) {
			echo '</tr><tr></table></div>';
		} else if (($index + 1) % 4 == 0) {
			echo '</tr><tr>';
		}
	}

	echo '</tr></table></div>'; // Close last row
}

// ============================================================================
// Error Handlings
// ============================================================================

// Global error array
$_err = [];

// Generate <span class='err'>
function err($key)
{
	global $_err;
	if ($_err[$key] ?? false) {
		echo "<span class='err'>&nbsp;&nbsp;&nbsp;$_err[$key]</span>";
	} else {
		echo '<span></span>';
	}
}

// Preserve form values on error
function old($field) {
    global $_POST;
    if (isset($_POST[$field])) {
        return htmlspecialchars($_POST[$field]);
    }
    return '';
}