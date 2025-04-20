<?php
require '../base.php';
include '../admin_head.php';

// Handle search query and role filter
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';

// Prepare SQL query based on search and role filters
if (!empty($role)) {
    $stm = $_db->prepare("SELECT * FROM user WHERE UserFullName LIKE ? AND Roles = ?");
    $stm->execute(["%$search%", $role]);
} else {
    $stm = $_db->prepare("SELECT * FROM user WHERE UserFullName LIKE ?");
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
                <th>UserFullName</th>
                <th>Username</th>
                <th>PhoneNo (+60)</th>
                <th>Email</th>
                <th>Address</th>
                <th>Roles</th>
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