<?php
// hello testing
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();

function is_get() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Is POST request?
function is_post() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_unique($value, $table, $field) {
    global $_db;
    $stm = $_db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
    $stm->execute([$value]);
    return $stm->fetchColumn() == 0;
}

$_db = new PDO('mysql:dbname=techcafe', 'root','', [
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
]);

if (isset($_GET['ProductID'])) {
	$ProductID = urldecode($_GET['ProductID']);

	$stm = $_db->prepare("SELECT SpecID, Specification, Price, Descr, ProductPhoto FROM specification WHERE ProductID = ?");
	$stm->execute([$ProductID]);
	$specifications = $stm->fetchAll();
}

if (is_post()) {
	if (isset($_POST['login'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$stm = $_db->prepare("SELECT UserFullName, Username, PhoneNo, Email, Pass, Roles FROM user WHERE Email = ?");
		$stm->execute([$email]);
		$user = $stm->fetch();

		if (!$user) {
			echo "<script>alert('No user found. Please sign up.');
			window.location='/pages/register.php'</script>";
		} else if (($password != $user['Pass'])) {
				echo "<script>alert('Wrong password. Please try again.');
				window.location='/pages/login.php'</script>";
		} else {
			$_SESSION['UserFullName'] = $user['UserFullName'];
			$username = $_SESSION['Username'] = $user['Username'];
			$_SESSION['Email'] = $user['Email'];
			$_SESSION['Role'] = $user['Roles'];
			
			echo "<script>alert('Welcome back! $username');
			window.location='/pages/home.php'</script>";
		}
		
	} else if (isset($_POST['register'])) {
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		$password = $_POST['password'];

		if (!is_unique($fullname, 'user', 'UserFullName')) {
			echo "<script>alert('Duplicated name is found! Please try to login.');
			window.location='/pages/login.php'</script>";
		} else if (!is_unique($email, 'user', 'Email')) {
			echo "<script>alert('Duplicated email is found! Please try to login.');
			window.location='/pages/login.php'</script>";
		} else if (!is_unique($phonenumber, 'user', 'PhoneNo')) {
			echo "<script>alert('Duplicated phone number is found! Please try to login.');
			window.location='/pages/login.php'</script>";
		} else {
			$stm = $_db->prepare("INSERT INTO user (UserFullName, Username, PhoneNo, Email, Pass, Roles) VALUES ('$fullname', '$username', '$phonenumber', '$email', '$password', 'User')");
			$stm->execute();
			echo "<script>alert('Welcome, $username! Your account has been created successfully.');
			window.location='/pages/home.php'</script>";
		}
	}
} else if (is_get()) {
	$category = $_GET['category'] ?? 'All';

	if ($category == 'All') {
		$stm = $_db->prepare("SELECT ProductID, ProductName, Category, ProductThumb FROM product");
		$stm->execute();
	} else {
		$stm = $_db->prepare("SELECT ProductID, ProductName, Category, ProductThumb FROM product WHERE Category = ?");
		$stm->execute([$category]);
	}
	$products = $stm->fetchAll();
}

function printProduct($products){
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
		? 'RM '.$product["MinPrice"]
		: 'RM '.$product["MinPrice"].' - RM '.$product["MaxPrice"];
		echo '
			<th>
				<div>
					<div>
						<img src="../images/product/'.$product["ProductThumb"]. '" alt="'.$product["ProductName"]. '">
						<div class="name">'.$product["ProductName"]. '</div>
						<p class="price">'.$priceDisplay.'</p>
					</div>
					<div>
						<a class="button" href="product.php?ProductID='.urlencode($product["ProductID"]).'">Click Here</a>
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
?>
