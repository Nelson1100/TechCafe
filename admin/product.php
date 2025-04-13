<?php
require '../base.php';
include '../admin_head.php';

// Handle create/edit/delete/search in POST
// if (is_post()) {
//     if (isset($_POST['create']) || isset($_POST['edit'])) {
//         $ProductName = $_POST['ProductName'];
//         $Category = $_POST['Category'];

//         // File Upload
//         $target_dir = "../images/products/";
//         $target_file = $target_dir . basename($_FILES["ProductThumb"]["name"]);
//         move_uploaded_file($_FILES["ProductThumb"]["tmp_name"], $target_file);

//         if (isset($_POST['edit'])) {
//             $ProductID = $_POST['ProductID'];
//             $stm = $_db->prepare("UPDATE product SET ProductName=?, Category=?, ProductThumb=? WHERE ProductID=?");
//             $stm->execute([$ProductName, $Category, $target_file, $ProductID]);
//         } else {
//             $stm = $_db->prepare("INSERT INTO product (ProductName, Category, ProductThumb) VALUES (?, ?, ?)");
//             $stm->execute([$ProductName, $Category, $target_file]);
//         }
//     } else if (isset($_POST['delete'])) {
//         $ProductID = $_POST['ProductID'];
//         $_db->prepare("DELETE FROM product WHERE ProductID = ?")->execute([$ProductID]);
//     }
// }

// Restrict access to admins only
if ($_SESSION['Role'] !== 'Admin') {
    echo "<script>alert('Access denied. Admins only.'); window.location='/user/home.php'</script>";
    exit;
}

// Handle search query
$search = $_GET['search'] ?? '';
$stm = $_db->prepare("SELECT * FROM product WHERE ProductName LIKE ?");
$stm->execute(["%$search%"]);
$products = $stm->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Product</title>
</head>

<body>
    <main id="admin">

        <p>
            <button data-get="product_insert.php">Insert</button>
        </p>
        <!-- Search Bar -->
        <form method="get">
            <input type="text" name="search" placeholder="Search product..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Product List -->
        <table class="product-table">
            <tr>
                <th>ProductID</th>
                <th>ProductName</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['ProductID'] ?></td>
                    <td><?= $p['ProductName'] ?></td>
                    <td><?= $p['Category'] ?></td>
                    <td>
                        <button data-get="product_update.php?ProductID=<?= $p['ProductID'] ?>">Edit</button>
                        <button data-confirm="Testing Confirmation Delete" data-post="product_delete.php?ProductID=<?= $p['ProductID'] ?>">Delete</button>
                        <img src="/images/product/<?= htmlspecialchars($p['ProductThumb']) ?>" alt="Thumbnail" class="popup" width="150">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>