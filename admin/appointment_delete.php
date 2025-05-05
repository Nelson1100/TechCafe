<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $id = req('id');

    // Delete record from DB
    $stm = $_db->prepare('DELETE FROM appointment WHERE id = ?');
    $stm->execute([$id]);
    temp('info', 'Appointment record deleted');
}

redirect('appointment.php');