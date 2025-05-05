<?php
require '../base.php';
include '../admin_head.php';

// Handle search query and category filter
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$sort1 = $_GET['sort1'] ?? 'ProductID';
$dir1 = $_GET['dir1'] ?? 'asc';
$sort2 = $_GET['sort2'] ?? 'SpecID';
$dir2 = $_GET['dir2'] ?? 'asc';
$open = req('open'); // Remember the open product ID

if (!in_array($sort1, ['ProductID', 'ProductName', 'Category'])) $sort1 = 'ProductID';
if (!in_array($dir1, ['asc', 'desc'])) $dir1 = 'asc';
if (!in_array($sort2, ['SpecID', 'Specification', 'Price', 'Descr'])) $sort2 = 'SpecID';
if (!in_array($dir2, ['asc', 'desc'])) $dir2 = 'asc';

// Prepare SQL query based on search and category filters
if (!empty($category)) {
    $stm = $_db->prepare("
        SELECT * FROM product 
        WHERE 
            (ProductName LIKE ? OR ProductID LIKE ?) 
            AND Category = ? 
        ORDER BY $sort1 $dir1
    ");
    $stm->execute(["%$search%", "%$search%", $category]);
} else {
    $stm = $_db->prepare("
        SELECT * FROM product 
        WHERE 
            ProductName LIKE ? OR ProductID LIKE ? 
        ORDER BY $sort1 $dir1
    ");
    $stm->execute(["%$search%", "%$search%"]);
}
$products = $stm->fetchAll();

// Get specifications for all products with filters
if (!empty($category)) {
    $stm = $_db->prepare("SELECT * FROM specification WHERE ProductID IN (SELECT ProductID FROM product WHERE ProductName LIKE ? AND Category = ?) ORDER BY $sort2 $dir2");
    $stm->execute(["%$search%", $category]);
} else {
    $stm = $_db->prepare("SELECT * FROM specification WHERE ProductID IN (SELECT ProductID FROM product WHERE ProductName LIKE ?) ORDER BY $sort2 $dir2");
    $stm->execute(["%$search%"]);
}
$all_specs = $stm->fetchAll();

// Get all unique categories for the dropdown
$stm = $_db->prepare("SELECT DISTINCT Category FROM product ORDER BY Category");
$stm->execute();
$categories = $stm->fetchAll();

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
            <button data-get="product_insert.php" class="admin-btn btn-insert">Insert</button>
        </p>
        <!-- Search Bar -->
        <form method="get" class="admin-search">
            <input type="search" name="search" placeholder="Search product..." value="<?= htmlspecialchars($search) ?>">
            <select name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= htmlspecialchars($c['Category']) ?>" <?= $category === $c['Category'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['Category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="admin-btn btn-search">Search</button>
        </form>

        <p><?= count($products) ?> product(s)</p>

        <!-- Product List -->
        <table class="admin-table">
            <tr>
                <th width="20px"></th>
                <th>
                    <a href="?sort1=ProductID&dir1=<?= $sort1 === 'ProductID' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>">
                        ProductID <?= $sort1 === 'ProductID' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=ProductName&dir1=<?= $sort1 === 'ProductName' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>">
                        ProductName <?= $sort1 === 'ProductName' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=Category&dir1=<?= $sort1 === 'Category' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>">
                        Category <?= $sort1 === 'Category' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $p): ?>
                <tr class="admin-row" data-product-id="<?= $p['ProductID'] ?>">
                    <td>
                        <span class="toggle-arrow" onclick="toggleTable('<?= $p['ProductID'] ?>', event)">
                            <?= $open == $p['ProductID'] ? '&#9660;' : '&#9658;' ?>
                        </span>
                    </td>
                    <td><?= $p['ProductID'] ?></td>
                    <td><?= $p['ProductName'] ?></td>
                    <td><?= $p['Category'] ?></td>
                    <td style="text-align: center;">
                        <button data-get="product_update.php?ProductID=<?= $p['ProductID'] ?>" class="admin-btn btn-update">Update</button>
                        <button data-confirm="Confirm Delete Record?" data-post="product_delete.php?ProductID=<?= $p['ProductID'] ?>" class="admin-btn btn-delete">Delete</button>
                        <img src="../images/product/<?= htmlspecialchars($p['ProductThumb']) ?>" alt="Product Thumbnail" class="popup-photo popup" width="150">
                    </td>
                </tr>
                <!-- Specifications container -->
                <tr class="toggle-row" id="toggle-<?= $p['ProductID'] ?>" style="display: <?= ($open == $p['ProductID']) ? 'table-row' : 'none' ?>;">
                    <td colspan="5">
                        <div class="toggle-container">
                            <h3>Specifications for <?= $p['ProductName'] ?></h3>
                            <?php if (isset($specs_by_product[$p['ProductID']])): ?>
                                <table class="toggle-table">
                                    <tr>
                                        <th>
                                            <a href="?sort2=SpecID&dir2=<?= $sort2 === 'SpecID' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $p['ProductID'] ?>">
                                                SpecID <?= $sort2 === 'SpecID' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="?sort2=Specification&dir2=<?= $sort2 === 'Specification' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $p['ProductID'] ?>">
                                                Specification <?= $sort2 === 'Specification' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="?sort2=Price&dir2=<?= $sort2 === 'Price' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $p['ProductID'] ?>">
                                                Price (RM) <?= $sort2 === 'Price' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="?sort2=Descr&dir2=<?= $sort2 === 'Descr' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $p['ProductID'] ?>">
                                                Description <?= $sort2 === 'Descr' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                    <?php foreach ($specs_by_product[$p['ProductID']] as $spec): ?>
                                        <tr>
                                            <td><?= $spec['SpecID'] ?></td>
                                            <td><?= $spec['Specification'] ?></td>
                                            <td><?= number_format($spec['Price'], 2) ?></td>
                                            <td class="description-cell" onclick="toggleDescription(this)">
                                                <div class="description-truncated">
                                                    <?= substr($spec['Descr'], 0, 50) ?><?= strlen($spec['Descr']) > 50 ? '...' : '' ?>
                                                </div>
                                                <?php if (strlen($spec['Descr']) > 50): ?>
                                                    <div class="description-full">
                                                        <?= htmlspecialchars($spec['Descr']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <button data-get="spec_update.php?SpecID=<?= $spec['SpecID'] ?>" class="admin-btn btn-update">Update</button>
                                                <button data-confirm="Confirm Delete Specification?" data-post="spec_delete.php?SpecID=<?= $spec['SpecID'] ?>" class="admin-btn btn-delete">Delete</button>
                                                <img src="../images/product/<?= htmlspecialchars($spec['ProductPhoto']) ?>" alt="Product Photo" class="popup-photo popup">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <p>
                                    <button data-get="spec_insert.php?ProductID=<?= $p['ProductID'] ?>" class="admin-btn btn-insert">Add Specification</button>
                                </p>
                            <?php else: ?>
                                <p>No specification found for this product.</p>
                                <p>
                                    <button data-get="spec_insert.php?ProductID=<?= $p['ProductID'] ?>" class="admin-btn btn-insert">Add Specification</button>
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