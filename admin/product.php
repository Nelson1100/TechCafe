<?php
require '../base.php';
include '../admin_head.php';

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
                        <button data-get="product_update.php?ProductID=<?= $p['ProductID'] ?>">Update</button>
                        <button data-confirm="Confirm Delete Record?" data-post="product_delete.php?ProductID=<?= $p['ProductID'] ?>">Delete</button>
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