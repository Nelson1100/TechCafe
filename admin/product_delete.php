<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $ProductID = req('ProductID');

    // Delete photo
    $stm = $_db->prepare('SELECT ProductThumb FROM product WHERE ProductID = ?');
    $stm->execute([$ProductID]);
    $photo = $stm->fetchColumn();

    // Remove photo from the physical folder
    unlink("../images/product/$photo");

    // Delete record from DB
    $stm = $_db->prepare('DELETE FROM product WHERE ProductID = ?');
    $stm->execute([$ProductID]);
    temp('info', 'Record deleted');
}

redirect('product.php');
