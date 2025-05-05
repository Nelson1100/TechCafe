<?php
require '../base.php';
include '../admin_head.php';

// Handle search query and service filter
$search = $_GET['search'] ?? '';
$service = $_GET['service'] ?? '';

$sort = $_GET['sort'] ?? 'id';
$dir = $_GET['dir'] ?? 'asc';
$open = req('open'); // Remember the open id

if (!in_array($sort, ['id', 'first_name', 'last_name', 'phone', 'email', 'service', 'problem_description', 'appointment_date', 'appointment_time', 'created_at', 'status'])) $sort = 'id';
if (!in_array($dir, ['asc', 'desc'])) $dir = 'asc';

// Prepare SQL query based on search and service filters
if (!empty($service)) {
    $stm = $_db->prepare("
        SELECT * FROM appointment 
        WHERE 
            (first_name LIKE ? OR last_name LIKE ? OR phone LIKE ? OR email LIKE ? OR status LIKE ?) 
            AND service = ? 
        ORDER BY $sort $dir
    ");
    $stm->execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%", $service]);
} else {
    $stm = $_db->prepare("
        SELECT * FROM appointment 
        WHERE 
            first_name LIKE ? OR last_name LIKE ? OR phone LIKE ? OR email LIKE ? OR status LIKE ?
        ORDER BY $sort $dir
    ");
    $stm->execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);
}
$appointments = $stm->fetchAll();

// Get all unique services for the dropdown
$stm = $_db->prepare("SELECT DISTINCT service FROM appointment ORDER BY service");
$stm->execute();
$services = $stm->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Appointment</title>
</head>

<body>
    <main class="admin">
        <h1>Admin | Appointment</h1>

        <!-- Search Bar -->
        <form method="get" class="admin-search">
            <input type="search" name="search" placeholder="Search appointment..." value="<?= htmlspecialchars($search) ?>">
            <select name="service">
                <option value="">All Services</option>
                <?php foreach ($services as $c): ?>
                    <option value="<?= htmlspecialchars($c['service']) ?>" <?= $service === $c['service'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['service']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="admin-btn btn-search">Search</button>
        </form>

        <p><?= count($appointments) ?> appointment(s)</p>

        <!-- Appointment List -->
        <table class="admin-table">
            <tr>
                <th>
                    <a href="?sort=id&dir=<?= $sort === 'id' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        ID <?= $sort === 'id' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=first_name&dir=<?= $sort === 'first_name' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        FirstName <?= $sort === 'first_name' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=last_name&dir=<?= $sort === 'last_name' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        LastName <?= $sort === 'last_name' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=phone&dir=<?= $sort === 'phone' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Phone <?= $sort === 'phone' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=email&dir=<?= $sort === 'email' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Email <?= $sort === 'email' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=service&dir=<?= $sort === 'service' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Service <?= $sort === 'service' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=problem_description&dir=<?= $sort === 'problem_description' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Description <?= $sort === 'problem_description' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=appointment_date&dir=<?= $sort === 'appointment_date' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Date <?= $sort === 'appointment_date' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=appointment_time&dir=<?= $sort === 'appointment_time' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Time <?= $sort === 'appointment_time' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=created_at&dir=<?= $sort === 'created_at' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Created <?= $sort === 'created_at' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=status&dir=<?= $sort === 'status' && $dir === 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($search) ?>&service=<?= urlencode($service) ?>">
                        Status <?= $sort === 'status' ? (strtoupper($dir) === 'ASC' ? '▲' : '▼') : '' ?>
                    </a>
                </th>
                <th>Actions</th>
            </tr>
            <?php foreach ($appointments as $a): ?>
                <tr class="admin-row">
                    <td><?= $a['id'] ?></td>
                    <td><?= $a['first_name'] ?></td>
                    <td><?= $a['last_name'] ?></td>
                    <td><?= $a['phone'] ?></td>
                    <td><?= empty($a['email']) ? '-' : $a['email'] ?></td>
                    <td><?= $a['service'] ?></td>
                    <td class="description-cell" onclick="toggleDescription(this)">
                    <?php if (empty($a['problem_description'])): ?>
                        -
                    <?php else: ?>
                        <div class="description-truncated">
                            <?= substr($a['problem_description'], 0, 10) ?><?= strlen($a['problem_description']) > 10 ? '...' : '' ?>
                        </div>
                        <?php if (strlen($a['problem_description']) > 10): ?>
                            <div class="description-full">
                                <?= htmlspecialchars($a['problem_description']) ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    </td>
                    <td><?= $a['appointment_date'] ?></td>
                    <td><?= $a['appointment_time'] ?></td>
                    <td><?= $a['created_at'] ?></td>
                    <td><?= $a['status'] ?></td>
                    <td style="text-align: center;">
                        <button data-confirm="Confirm Delete Record?" data-post="appointment_delete.php?id=<?= $a['id'] ?>" class="admin-btn btn-delete">Delete</button>
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