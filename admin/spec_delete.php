<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $SpecID = req('SpecID');

    // Delete photo
    $stm = $_db->prepare('SELECT ProductPhoto FROM specification WHERE SpecID = ?');
    $stm->execute([$SpecID]);
    $photo = $stm->fetchColumn();

    // Remove photo from the physical folder
    unlink("../images/product/$photo");

    // Delete record from DB
    $stm = $_db->prepare('DELETE FROM specification WHERE SpecID = ?');
    $stm->execute([$SpecID]);
    temp('info', 'Record deleted');
}

redirect('product.php');