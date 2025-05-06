<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $ProductID = req('ProductID');

    // Delete photo thumbnail photo
    $stm = $_db->prepare('SELECT ProductThumb FROM product WHERE ProductID = ?');
    $stm->execute([$ProductID]);
    $thumb = $stm->fetchColumn();
    // Remove photo from the physical folder
    if ($thumb && file_exists("../images/product/$thumb")) {
        unlink("../images/product/$thumb");
    }

    // Delete each specification photo linked to this product
    $stm = $_db->prepare('SELECT ProductPhoto FROM specification WHERE ProductID = ?');
    $stm->execute([$ProductID]);
    $photos = $stm->fetchAll(PDO::FETCH_COLUMN);
    foreach ($photos as $photo) {
        if ($photo && file_exists("../images/product/$photo")) {
            unlink("../images/product/$photo");
        }
    }

    // Delete specification records for this product
    $stm = $_db->prepare('DELETE FROM specification WHERE ProductID = ?');
    $stm->execute([$ProductID]);

    // Delete product record from DB
    $stm = $_db->prepare('DELETE FROM product WHERE ProductID = ?');
    $stm->execute([$ProductID]);

    temp('info', 'Product and its specifications deleted successfully');
}

redirect('product.php');
