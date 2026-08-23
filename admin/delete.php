<?php
include '../base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $id = req('id');

    // Delete photo
    $stm = $_db->prepare('SELECT photo FROM product WHERE id = ?');
    $stm->execute([$id]);
    $photo = $stm->fetchColumn();
    unlink("../photos/$photo");
    

    $stm = $_db->prepare('DELETE FROM product WHERE id = ?');
    $stm->execute([$id]);
    temp('info', 'Record deleted');
}

redirect('index.php');

// ----------------------------------------------------------------------------
