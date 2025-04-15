<?php
require '../base.php';
include '../admin_head.php';

// Handle search query
$search = $_GET['search'] ?? '';
$stm = $_db->prepare("SELECT * FROM product WHERE ProductName LIKE ?");
$stm->execute(["%$search%"]);
$products = $stm->fetchAll();

// Get specifications for all products at once
$stm = $_db->prepare("SELECT * FROM specification WHERE ProductID IN (SELECT ProductID FROM product where ProductName LIKE ?)");
$stm->execute(["%$search%"]);
$all_specs = $stm->fetchAll();

// Organize specifications by ProductID
$specs_by_product = [];
foreach ($all_specs as $spec) {
    $specs_by_product[$spec['ProductID']][] = $spec;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Product</title>
</head>

<body>
    <main class="admin">
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
                        <img src="/images/product/<?= htmlspecialchars($p['ProductThumb']) ?>" alt="Product Thumbnail" class="popup-photo popup" width="150">
                    </td>
                </tr>
                <!-- Specifications container -->
                <tr class="spec-row" id="specs-<?= $p['ProductID'] ?>" style="display: none;">
                    <td colspan="5">
                        <div class="spec-container">
                            <h3>Specifications for <?= $p['ProductName'] ?></h3>
                            <?php if (isset($specs_by_product[$p['ProductID']])): ?>
                                <table class="spec-table">
                                    <tr>
                                        <th>SpecID</th>
                                        <th>Specification</th>
                                        <th>Price (RM)</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    <?php foreach ($specs_by_product[$p['ProductID']] as $spec): ?>
                                        <tr>
                                            <td><?= $spec['SpecID'] ?></td>
                                            <td><?= $spec['Specification'] ?></td>
                                            <td><?= number_format($spec['Price'], 2) ?></td>
                                            <td><?= substr($spec['Descr'], 0, 50) ?><?= strlen($spec['Descr']) > 50 ? '...' : '' ?></td>
                                            <td>
                                                <button data-get="spec_update.php?SpecID=<?= $spec['SpecID'] ?>">Update</button>
                                                <button data-confirm="Confirm Delete Specification?" data-post="spec_delete.php?SpecID=<?= $spec['SpecID'] ?>">Delete</button>
                                                <img src="../images/product/<?= htmlspecialchars($spec['ProductPhoto']) ?>" alt="Product Photo" class="popup-photo popup">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <p>
                                    <button data-get="spec_insert.php?ProductID=<?= $p['ProductID'] ?>">Add Specification</button>
                                </p>
                            <?php else: ?>
                                <p>No specification found for this product.</p>
                                <p>
                                    <button data-get="spec_insert.php?ProductID=<?= $p['ProductID'] ?>">Add Specification</button>
                                </p>
                            <?php endif; ?>
                        </div>
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