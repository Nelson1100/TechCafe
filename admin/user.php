<?php
require '../base.php';
include '../admin_head.php';

// Handle search query
$search = $_GET['search'] ?? '';
$stm = $_db->prepare("SELECT * FROM user WHERE UserFullName LIKE ?");
$stm->execute(["%$search%"]);
$users = $stm->fetchAll();
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
            <button data-get="user_insert.php">Insert</button>
        </p>
        <!-- Search Bar -->
        <form method="get" class="admin-search">
            <input type="text" name="search" placeholder="Search user..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <!-- User List -->
        <table class="admin-table">
            <tr>
                <th>UserFullName</th>
                <th>Username</th>
                <th>PhoneNo</th>
                <th>Email</th>
                <th>Pass</th>
                <th>Address</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['UserFullName'] ?></td>
                    <td><?= $u['Username'] ?></td>
                    <td>0<?= $u['PhoneNo'] ?></td>
                    <td><?= $u['Email'] ?></td>
                    <td><?= $u['Pass'] ?></td>
                    <td><?= $u['Address'] ?></td>
                    <td><?= $u['Roles'] ?></td>
                    <td>
                        <button data-get="user_update.php?UserFullName=<?= $u['UserFullName'] ?>">Update</button>
                        <button data-confirm="Confirm Delete Record?" data-post="user_delete.php?UserFullName=<?= $u['UserFullName'] ?>">Delete</button>
                        <img src="/images/user/<?= htmlspecialchars($u['ProfilePic']) ?>" alt="ProfilePic" class="popup" width="150">
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