<?php
require '../base.php';
include '../admin_head.php';

// Handle search query and service filter
$search = $_GET['search'] ?? '';
$service = $_GET['service'] ?? '';

$sort = $_GET['sort'] ?? 'id';
$dir = $_GET['dir'] ?? 'asc';
$open = req('open'); // Remember the open id

if (!in_array($sort, ['id', 'first_name', 'last_name', 'phone', 'email', 'service', 'problem_description', 'appointment_date', 'appointment_time', 'created_at'])) $sort = 'id';
if (!in_array($dir, ['asc', 'desc'])) $dir = 'asc';

// Prepare SQL query based on search and service filters
if (!empty($service)) {
    $stm = $_db->prepare("
        SELECT * FROM appointment 
        WHERE 
            (first_name LIKE ? OR last_name LIKE ? OR phone LIKE ? OR email LIKE ?) 
            AND service = ? 
        ORDER BY $sort $dir
    ");
    $stm->execute(["%$search%", "%$search%", "%$search%", "%$search%", $service]);
} else {
    $stm = $_db->prepare("
        SELECT * FROM appointment 
        WHERE 
            first_name LIKE ? OR last_name LIKE ? OR phone LIKE ? OR email LIKE ?
        ORDER BY $sort $dir
    ");
    $stm->execute(["%$search%", "%$search%", "%$search%", "%$search%"]);
}
$appointments = $stm->fetchAll();

// Get all unique services for the dropdown
$stm = $_db->prepare("SELECT DISTINCT service FROM appointment ORDER BY service");
$stm->execute();
$services = $stm->fetchAll();
?>