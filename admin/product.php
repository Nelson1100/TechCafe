<?php
require '../base.php';
include '../admin_head.php';

// Handle search query
$search = $_GET['search'] ?? '';
$stm = $_db->prepare("SELECT * FROM product WHERE ProductName LIKE ?");
$stm->execute(["%$search%"]);
$products = $stm->fetchAll();

// // Get specifications for all products at once
// $stm = $_db->prepare("SELECT * FROM specifcation WHERE ProductID IN (SELECT ProductID FROM product where ProductName LIKE ?");
// $stm->execute(["%$search%"]);
// $all_specs = $stm->fetchAll();

// // Organize specifications by ProductID
// $specs_by_product = [];
// foreach ($all_specs as $spec) {
//     $specs_by_product[$spec['ProductID']][] = $spec;
// }
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
        <h1>Admin | Product</h1>

        <p>
            <button data-get="product_insert.php">Insert</button>
        </p>
        <!-- Search Bar -->
        <form method="get" class="admin-search">
            <input type="text" name="search" placeholder="Search product..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Product List -->
        <table class="admin-table">
            <tr>
                <th width="20px"></th>
                <th>ProductID</th>
                <th>ProductName</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $p): ?>
                <tr class="product-row" data-product-id="<?= $p['ProductID'] ?>">
                    <td>
                        <span class="toggle-arrow" onclick="toggleSpecs('<?= $p['ProductID'] ?>')">&#9658</span>
                    </td>
                    <td><?= $p['ProductID'] ?></td>
                    <td><?= $p['ProductName'] ?></td>
                    <td><?= $p['Category'] ?></td>
                    <td>
                        <button data-get="product_update.php?ProductID=<?= $p['ProductID'] ?>">Update</button>
                        <button data-confirm="Confirm Delete Record?" data-post="product_delete.php?ProductID=<?= $p['ProductID'] ?>">Delete</button>
                        <img src="/images/product/<?= htmlspecialchars($p['ProductThumb']) ?>" alt="Thumbnail" class="popup" width="150">
                    </td>
                </tr>
                <!-- Specifications container -->
                
            <?php endforeach; ?>
        </table>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>