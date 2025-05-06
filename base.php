<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();

if (isset($_SERVER['HTTP_REFERER']) &&
    $_SERVER['HTTP_REFERER'] != "http://localhost:8000/user/register.php" &&
    $_SERVER['HTTP_REFERER'] != "http://localhost:8000/user/login.php" &&
	$_SERVER['HTTP_REFERER'] != "http://localhost:8000/user/userProfile.php" &&
	$_SERVER['HTTP_REFERER'] != "http://localhost:8000/base.php") {
    
    $_SESSION['previousPage'] = $_SERVER['HTTP_REFERER']; // Store in session
}

$_db = new PDO('mysql:dbname=techcafe', 'root', '', [
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

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

// function to check availability FROM DB
function is_exists($value, $table, $field) {
    global $_db;
    $stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
    $stm->execute([$value]);
    return $stm->fetchColumn() > 0;
}

function is_email($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

//Encoding function for passwords
function encode($value) {
    return htmlentities($value);
}

function get_mail() {
    require_once 'PHPMailer.php';
    require_once 'SMTP.php';

    $m = new PHPMailer(true);
    $m->isSMTP();
    $m->SMTPAuth = true;
    $m->Host = 'smtp.gmail.com';
    $m->Port = 587;
	// Haven't created an account to use yet
    $m->Username = 'desmund.demo@gmail.com';
    $m->Password = 'ivtm oili ftsb rbxf';
    $m->CharSet = 'utf-8';
    $m->setFrom($m->Username, 'Tech Cafe');

    return $m;
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

function base($path = '') {
    return "http://$_SERVER[SERVER_NAME]:$_SERVER[SERVER_PORT]/$path";
}

// Is unique?
function is_unique($value, $table, $field)
{
	global $_db;
	$stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
	$stm->execute([$value]);
	return $stm->fetchColumn() == 0;
}

if (isset($_SESSION['Email'])) {
	$email=$_SESSION['Email'];
	$stm = $_db->prepare("SELECT * FROM user WHERE Email = ?");
	$stm->execute([$email]);
	$user = $stm->fetch();
}

if (isset($_GET['ProductID'])) {
	$ProductID = urldecode($_GET['ProductID']);

	$stm = $_db->prepare("SELECT * FROM specification WHERE ProductID = ?");
	$stm->execute([$ProductID]);
	$specifications = $stm->fetchAll();
}

if (is_post()) {
	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$password = SHA1($_POST['password']);

		$stm = $_db->prepare("SELECT * FROM user WHERE Email = ?");
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
				window.location='/admin/product.php'</script>";
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
			$stm = $_db->prepare("INSERT INTO user (UserFullName, Username, PhoneNo, Email, Pass, Roles) VALUES ('$fullname', '$username', '$phonenumber', '$email', SHA1('$password'), 'User')");
			$stm->execute();
			$_SESSION['Email'] = $email;
			$_SESSION['Username'] = $username;
			echo "<script>alert('Welcome, $username! Your account has been created successfully.');
			window.location='/user/home.php'</script>";
		}
	} else if (isset($_POST['logout'])) {
		session_destroy();
		header("Location: user/home.php");
		exit();
	} else if (isset($_POST['updateProfile'])) {
		// Get new values
		$new_fullname = trim($_POST['UserFullName'] ?? '');
		$new_username = trim($_POST['Username'] ?? '');
		$new_phone    = trim($_POST['PhoneNo'] ?? '');
		$new_address  = trim($_POST['Address'] ?? '');
		$profilePic = isset($_FILES['updatePic']) ? $_FILES['updatePic'] : '';
	
		// Get current user
		$stmt = $_db->prepare("SELECT * FROM user WHERE Email = ?");
		$stmt->execute([$_SESSION['Email']]);
		$currentUser = $stmt->fetch();
	
		// Use current values if empty
		$fullname = $new_fullname ?: $currentUser['UserFullName'];
		$username = $new_username ?: $currentUser['Username'];
		$phone    = $new_phone    ?: $currentUser['PhoneNo'];
		$address  = $new_address  ?: $currentUser['Address'];	
		$noImageUploaded = !($profilePic && $profilePic['error'] === 0);

		if (
			$fullname == $currentUser['UserFullName'] &&
			$username == $currentUser['Username'] &&
			$phone == $currentUser['PhoneNo'] &&
			$address == $currentUser['Address'] &&
			$noImageUploaded) {
			echo "<script>alert('No changes detected in your profile.'); window.location.href='/user/userProfile.php';</script>";
			return;
		} else {
		// Update profile
			$stm = $_db->prepare("UPDATE user SET UserFullName=?, Username=?, PhoneNo=?, Address=? WHERE Email=?");
			$stm->execute([$fullname, $username, $phone, $address, $_SESSION['Email']]);
				
			// Handle image upload
			if ($profilePic && $profilePic['error'] === 0) {
				$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
				if (in_array($profilePic['type'], $allowedTypes)) {
					$filename = uniqid() . "_" . basename($profilePic['name']);
					$targetDir = 'images/profilePic/';
					$targetFile = $targetDir . $filename;
			
					if (move_uploaded_file($profilePic['tmp_name'], $targetFile)) {
						$photo = 'profilePic/' . $filename;
			
						$stm = $_db->prepare("UPDATE user SET ProfilePic = ? WHERE Email = ?");
						$stm->execute([$photo, $_SESSION['Email']]);
					} else {
						echo "<script>alert('Failed to upload image.');
						window.location='/user/userProfile.php'</script>";
						return;
					}
				}
			}
			echo "<script>alert('Profile updated successfully.'); window.location.href='/user/userProfile.php';</script>";
		}
	} else if (isset($_POST['addCart'])) {
		$previousPage = $_SERVER['HTTP_REFERER'];
	
		if (isset($_SESSION['Email'])) {
			$stm = $_db->prepare("SELECT * FROM cart WHERE Email = ? AND OrderStatus = 'InCart'");
			$stm->execute([$_SESSION['Email']]);
			$cartItems = $stm->fetch();
	
			$specID = $_POST['selectedSpecID'];
			$quantity = $_POST['product-qty'];
	
			if (!$cartItems) {
				$stm = $_db->prepare("INSERT INTO cart (Email, ItemsAdded, Quantity, OrderStatus) VALUES (?, ?, ?, ?)");
				$stm->execute([$_SESSION['Email'], $specID, $quantity, 'InCart']);
				echo "<script>alert('Successfully Added'); window.location='$previousPage'</script>";
			} else if (trim($cartItems['ItemsAdded']) === '') {
				$stm = $_db->prepare("UPDATE cart SET ItemsAdded = ?, Quantity = ?, OrderStatus = 'InCart' WHERE Email = ?");
				$stm->execute([$specID, $quantity, $_SESSION['Email']]);
				echo "<script>alert('Successfully Added'); window.location='$previousPage'</script>";
			} else {
				$currentItemAdded = explode(',', $cartItems['ItemsAdded']);
				$currentQuantity = explode(',', $cartItems['Quantity']);
	
				if (in_array($specID, $currentItemAdded)) {
					echo "<script>alert('This item is already in your cart.');
					window.location='$previousPage'</script>";
				} else {
					// Append the new item
					$currentItemAdded[] = $specID;
					$currentQuantity[] = $quantity;
	
					$newItems = implode(',', $currentItemAdded);
					$newQuantities = implode(',', $currentQuantity);
	
					$stm = $_db->prepare("UPDATE cart SET ItemsAdded = ?, Quantity = ? WHERE Email = ? AND OrderStatus = 'InCart'");
					$stm->execute([$newItems, $newQuantities, $_SESSION['Email']]);
	
					echo "<script>alert('Successfully Added'); window.location='$previousPage'</script>";
				}
			}
		} else {
			echo "<script>alert('Please login to continue adding your cart.');
			window.location='$previousPage'</script>";
		}	
	} else if (
		isset($_POST['addQuantity']) ||
		isset($_POST['deductQuantity']) ||
		isset($_POST['product-qty']) ||
		isset($_POST['deleteProduct'])
	) {
		$stm = $_db->prepare("SELECT * FROM cart WHERE Email = ? AND OrderStatus = 'InCart'");
		$stm->execute([$_SESSION['Email']]);
		$cartData = $stm->fetch();
		$specIDs = explode(',', $cartData['ItemsAdded']);
		$quantities = explode(',', $cartData['Quantity']);
	
		$targetSpecID = $_POST['targetSpecID'] ?? $_POST['addQuantity'] ?? $_POST['deductQuantity'] ?? $_POST['updateQty'] ?? $_POST['deleteProduct'];
		
		if (isset($_POST['deleteProduct']) && !(isset($_POST['addQuantity']) || isset($_POST['deductQuantity']) || isset($_POST['product-qty']))) {
			for ($i = 0; $i < count($specIDs); $i++) {
				if ($specIDs[$i] == $targetSpecID) {
					array_splice($specIDs, $i, 1);
					array_splice($quantities, $i, 1);
					break;
				}
			}
		} elseif (isset($_POST['product-qty']) && !(isset($_POST['addQuantity']) || isset($_POST['deductQuantity']))) {
			$qty = (int) $_POST['product-qty'];
			if ($qty > 0) {
				for ($i = 0; $i < count($specIDs); $i++) {
					if ($specIDs[$i] == $targetSpecID) {
						$quantities[$i] = $qty;
						break;
					}
				}
			} elseif ($qty == 0) {
				for ($i = 0; $i < count($specIDs); $i++) {
					if ($specIDs[$i] == $targetSpecID) {
						array_splice($specIDs, $i, 1);
						array_splice($quantities, $i, 1);
						break;
					}
				}
			} else {
				echo "<script>alert('Quantity must be a positive number.'); window.location.href = window.location.href;</script>";
				exit;
			}
		} elseif (isset($_POST['addQuantity']) || isset($_POST['deductQuantity'])) {
			$operation = isset($_POST['addQuantity']) ? 'add' : 'deduct';
	
			for ($i = 0; $i < count($specIDs); $i++) {
				if ($specIDs[$i] == $targetSpecID) {
					if ($operation == 'add') {
						$quantities[$i]++;
					} elseif ($operation == 'deduct' && $quantities[$i] > 1) {
						$quantities[$i]--;
					}
					break;
				}
			}
		}
	
		// Update the cart
		$newItems = implode(',', $specIDs);
		$newQuantity = implode(',', $quantities);
	
		$stm = $_db->prepare("UPDATE cart SET ItemsAdded = ?, Quantity = ? WHERE Email = ? AND OrderStatus = 'InCart'");
		$stm->execute([$newItems, $newQuantity, $_SESSION['Email']]);
	
		if (count($specIDs) == 0) {
			echo "<script>alert('Cart is empty. Redirecting...'); window.location='home.php';</script>";
		} else {
			echo "<script>window.location.href = window.location.href;</script>";
		}
		exit;
	} else if (isset($_POST['paid'])){
		$stm = $_db->prepare("UPDATE cart SET OrderStatus = 'Purchased' WHERE Email = ?");
		$stm->execute([$_SESSION['Email']]);
		echo "<script>alert('Payment Successful! Thank you for your purchase. Your order has been received and is now being processed.');
        window.location.href = '/user/home.php';</script>";
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

function printProduct($products){
	if (empty($products)){
		echo "<p style='text-align:center; font-size: 1.5em; color: #666; margin-top: 100px; margin-bottom: 100px;'>No product found.";
		return;
	}
			
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
		echo "<span class='err'>$_err[$key]</span>";
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