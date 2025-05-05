<?php
require '../base.php';
include '../admin_head.php';

// Handle search query and role filter
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';

$sort1 = $_GET['sort1'] ?? 'UserFullName';
$dir1 = $_GET['dir1'] ?? 'asc';
$sort2 = $_GET['sort2'] ?? 'CartID';
$dir2 = $_GET['dir2'] ?? 'asc';
$open = req('open'); // Remember the open Email

if (!in_array($sort1, ['UserFullName', 'Username', 'PhoneNo', 'Email', 'Address', 'Roles'])) $sort1 = 'UserFullName';
if (!in_array($dir1, ['asc', 'desc'])) $dir1 = 'asc';
if (!in_array($sort2, ['CartID', 'ItemsAdded', 'Quantity'])) $sort2 = 'CartID';
if (!in_array($dir2, ['asc', 'desc'])) $dir2 = 'asc';

// Prepare SQL query based on search and role filters
if (!empty($role)) {
    $stm = $_db->prepare("
        SELECT * FROM user 
        WHERE 
            (UserFullName LIKE ? OR Username LIKE ? OR PhoneNo LIKE ? OR Email LIKE ?) 
            AND Roles = ? 
        ORDER BY $sort1 $dir1
    ");
    $stm->execute(["%$search%", "%$search%", "%$search%", "%$search%", $role]);
} else {
    $stm = $_db->prepare("
        SELECT * FROM user 
        WHERE 
            UserFullName LIKE ? OR Username LIKE ? OR PhoneNo LIKE ? OR Email LIKE ? 
        ORDER BY $sort1 $dir1
    ");
    $stm->execute(["%$search%", "%$search%", "%$search%", "%$search%"]);
}
$users = $stm->fetchAll();

// Get order history for all users with filters
if (!empty($role)) {
    $stm = $_db->prepare("SELECT * FROM cart WHERE Email IN (SELECT Email FROM user WHERE UserFullName LIKE ? AND Roles = ?) ORDER BY $sort2 $dir2");
    $stm->execute(["%$search%", $role]);
} else {
    $stm = $_db->prepare("SELECT * FROM cart WHERE Email IN (SELECT Email FROM user WHERE UserFullName LIKE ?) ORDER BY $sort2 $dir2");
    $stm->execute(["%$search%"]);
}
$all_orders = $stm->fetchAll();

// Get all unique roles for the dropdown
$stm = $_db->prepare("SELECT DISTINCT Roles FROM user ORDER BY Roles");
$stm->execute();
$roles = $stm->fetchAll();

// Organize order history by Email
$orders_by_email = [];
foreach ($all_orders as $order) {
    $orders_by_email[$order['Email']][] = $order;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | User</title>
</head>

<body>
    <main class="admin">
        <h1>Admin | User</h1>

        <p>
            <button data-get="user_insert.php" class="admin-btn btn-insert">Insert</button>
        </p>
        <!-- Search Bar -->
        <form method="get" class="admin-search">
            <input type="search" name="search" placeholder="Search user..." value="<?= htmlspecialchars($search) ?>">
            <select name="role">
                <option value="">All Roles</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= htmlspecialchars($r['Roles']) ?>" <?= $role === $r['Roles'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['Roles']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="admin-btn btn-search">Search</button>
        </form>

        <p><?= count($users) ?> user(s)</p>

        <!-- User List -->
        <table class="admin-table">
            <tr>
                <th width="20px"></th>
                <th>
                    <a href="?sort1=UserFullName&dir1=<?= $sort1 === 'UserFullName' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        UserFullName <?= $sort1 === 'UserFullName' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=Username&dir1=<?= $sort1 === 'Username' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Username <?= $sort1 === 'Username' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=PhoneNo&dir1=<?= $sort1 === 'PhoneNo' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        PhoneNo (+60) <?= $sort1 === 'PhoneNo' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=Email&dir1=<?= $sort1 === 'Email' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Email <?= $sort1 === 'Email' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=Address&dir1=<?= $sort1 === 'Address' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Address <?= $sort1 === 'Address' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort1=Roles&dir1=<?= $sort1 === 'Roles' && $dir1 === 'asc' ? 'desc' : 'asc' ?>&sort2=<?= $sort2 ?>&dir2=<?= $dir2 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Roles <?= $sort1 === 'Roles' ? (strtoupper($dir1) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr class="admin-row">
                    <td>
                        <span class="toggle-arrow" onclick="toggleTable('<?= $u['Email'] ?>', event)">
                            <?= $open == $u['Email'] ? '&#9660;' : '&#9658;' ?>
                        </span>
                    </td>
                    <td><?= $u['UserFullName'] ?></td>
                    <td><?= $u['Username'] ?></td>
                    <td><?= '0' . $u['PhoneNo'] ?></td>
                    <td><?= $u['Email'] ?></td>
                    <td><?= empty($u['Address']) ? '-' : $u['Address'] ?></td>
                    <td><?= $u['Roles'] ?></td>
                    <td style="text-align: center;">
                        <button data-get="user_update.php?Email=<?= $u['Email'] ?>" class="admin-btn btn-update">Update</button>
                        <button data-confirm="Confirm Delete Record?" data-post="user_delete.php?Email=<?= $u['Email'] ?>" class="admin-btn btn-delete">Delete</button>
                        <img src="../images/profilePic/<?= htmlspecialchars($u['ProfilePic']) ?? 'user.png' ?>" alt="Profile Picture" class="popup-photo popup" width="150" onerror="this.src='../images/user.png'">
                    </td>
                </tr>
                <!-- Order history container -->
                <tr class="toggle-row" id="toggle-<?= $u['Email'] ?>" style="display: <?= ($open == $u['Email']) ? 'table-row' : 'none' ?>;">
                    <td colspan="8">
                        <div class="toggle-container">
                            <h3>Orders for <?= $u['UserFullName'] ?></h3>
                            <?php if (isset($orders_by_email[$u['Email']])): ?>
                                <table class="toggle-table">
                                    <tr>
                                        <th>
                                            <a href="?sort2=CartID&dir2=<?= $sort2 === 'CartID' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $u['Email'] ?>">
                                                CartID <?= $sort2 === 'CartID' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="?sort2=ItemsAdded&dir2=<?= $sort2 === 'ItemsAdded' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $u['Email'] ?>">
                                                ItemsAdded <?= $sort2 === 'ItemsAdded' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="?sort2=Quantity&dir2=<?= $sort2 === 'Quantity' && $dir2 === 'asc' ? 'desc' : 'asc' ?>&sort1=<?= $sort1 ?>&dir1=<?= $dir1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>&open=<?= $u['Email'] ?>">
                                                Quantity <?= $sort2 === 'Quantity' ? (strtoupper($dir2) === 'ASC' ? '▲' : '▼') : '' ?>
                                            </a>
                                        </th>
                                    </tr>
                                    <?php foreach ($orders_by_email[$u['Email']] as $order): ?>
                                        <tr>
                                            <td><?= $order['CartID'] ?></td>
                                            <td><?= $order['ItemsAdded'] ?></td>
                                            <td><?= $order['Quantity'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php else: ?>
                                <p>No order found for this user.</p>
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