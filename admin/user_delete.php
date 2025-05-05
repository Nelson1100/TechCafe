<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $Email = req('Email');

    // Delete photo
    $stm = $_db->prepare('SELECT ProfilePic FROM user WHERE Email = ?');
    $stm->execute([$Email]);
    $photo = $stm->fetchColumn();

    // Remove photo from the physical folder
    unlink("../images/user/$photo");

    // Delete record from DB
    $stm = $_db->prepare('DELETE FROM cart WHERE Email = ?');
    $stm->execute([$Email]);
    $stm = $_db->prepare('DELETE FROM user WHERE Email = ?');
    $stm->execute([$Email]);
    temp('info', 'User record deleted');
}

redirect('user.php');
