<?php
require '../base.php';
include '../admin_head.php';

// Handle search query and role filter
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';

$sort = $_GET['sort'] ?? 'UserFullName'; // default sort
$dir = strtolower($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
$allowedSort = ['UserFullName', 'Username', 'PhoneNo', 'Email', 'Address', 'Roles'];

// Validate column name
$sortCol = in_array($sort, $allowedSort) ? $sort : 'UserFullName';

// Prepare SQL query based on search and role filters
if (!empty($role)) {
    $stm = $_db->prepare("SELECT * FROM user WHERE UserFullName LIKE ? AND Roles = ? ORDER BY $sortCol $dir");
    $stm->execute(["%$search%", $role]);
} else {
    $stm = $_db->prepare("SELECT * FROM user WHERE UserFullName LIKE ? ORDER BY $sortCol $dir");
    $stm->execute(["%$search%"]);
}
$users = $stm->fetchAll();

// Get all unique roles for the dropdown
$stm = $_db->prepare("SELECT DISTINCT Roles FROM user ORDER BY Roles");
$stm->execute();
$roles = $stm->fetchAll();
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
                <th>
                    <a href="?sort=UserFullName&dir=<?= $sort === 'UserFullName' && $dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        UserFullName <?= $sort === 'UserFullName' ? ($dir === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=Username&dir=<?= $sort === 'Username' && $dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Username <?= $sort === 'Username' ? ($dir === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=PhoneNo&dir=<?= $sort === 'PhoneNo' && $dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        PhoneNo (+60) <?= $sort === 'PhoneNo' ? ($dir === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=Email&dir=<?= $sort === 'Email' && $dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Email <?= $sort === 'Email' ? ($dir === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=Address&dir=<?= $sort === 'Address' && $dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Address <?= $sort === 'Address' ? ($dir === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=Roles&dir=<?= $sort === 'Roles' && $dir === 'ASC' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>">
                        Roles <?= $sort === 'Roles' ? ($dir === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr class="admin-row">
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
            <?php endforeach; ?>
        </table>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>