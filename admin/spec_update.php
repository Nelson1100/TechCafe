<?php
require '../base.php';
include '../admin_head.php';

$default_photo = 'photo.jpg';

if (is_get()) {
    $SpecID = req('SpecID');

    $stm = $_db->prepare('SELECT * FROM specification WHERE SpecID = ?');
    $stm->execute([$SpecID]);
    $s = $stm->fetch();

    if (!$s) {
        redirect('product.php');
    }

    extract((array)$s);
    // store specification photo into session
    $_SESSION['ProductPhoto'] = $ProductPhoto ?? $default_photo;
    $photo = $ProductPhoto ?? $default_photo;
}

if (is_post()) {
    $SpecID = req('SpecID');
    $Specification = req('Specification');
    $Price = req('Price');
    $Descr = req('Descr');
    $f = get_file('ProductPhoto');
    $photo = $_SESSION['ProductPhoto'] ?? $default_photo;

    // Specification Validation
    if ($Specification == '') {
        $_err['Specification'] = 'Required';
    } else if (strlen($Specification) > 100) {
        $_err['Specification'] = 'Maximum 100 characters';
    }

    // Price Validation
    if ($Price == '') {
        $_err['Price'] = 'Required';
    } else if (!preg_match('/^\d+(?:\.\d{1,2})?$/', $Price)) {
        $_err['Price'] = 'Must be money';
    } else if ($Price < 0.01 || $Price > 99999.99) {
        $_err['Price'] = 'Must between 0.01 - 99999.99';
    }

    // Descr Validation
    if ($Descr == '') {
        $_err['Descr'] = 'Required';
    }

    // ProductPhoto Validation
    // ** Only if a file is selected **
    if ($f) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['ProductPhoto'] = 'Must be image';
        } else if ($f->size > 1 * 1024 * 1024) {
            $_err['ProductPhoto'] = 'Maximum 1 MB';
        }
    }

    // DB operation
    // save photo then continue with DB operation
    if (!$_err) {
        // Delete photo + save photo
        if ($f) {
            // new photo selected
            if ($photo != $default_photo) {
                // Only delete if it's not the default photo
                unlink("../images/product/$photo");
            }
            $photo = save_photo($f, '../images/product');
        }

        $stm = $_db->prepare('
            UPDATE specification
            SET Specification = ?, Price = ?, Descr = ?, ProductPhoto = ?
            WHERE SpecID = ?
        ');
        $stm->execute([$Specification, $Price, $Descr, $photo, $SpecID]);

        temp('info', 'Specification record updated');
        redirect('product.php');
    }

    if (!isset($photo)) {
        $photo = $_SESSION['ProductPhoto'] ?? $default_photo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specification | Update</title>
</head>

<body>
    <main class="admin">
        <h1>Specification | Update</h1>
        <form method="post" class="admin-form" enctype="multipart/form-data" novalidate>
            <label for="SpecID">SpecID</label>
            <b><?= $SpecID ?></b>
            <br>

            <label for="Specification">Specification</label>
            <input type="text" id="Specification" name="Specification" value="<?= htmlentities($Specification) ?>" maxlength="100">
            <?= err('Specification') ?>

            <label for="Price">Price</label>
            <input type="number" id="Price" name="Price" value="<?= htmlentities($Price) ?>" min="0.01" max="99999.99" step="0.01">
            <?= err('Price') ?>

            <label for="Descr">Description</label>
            <textarea id="Descr" name="Descr" rows="7" cols="30"><?= htmlentities($Descr) ?></textarea>
            <?= err('Descr') ?>

            <label for="ProductPhoto">ProductPhoto</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProductPhoto" name="ProductPhoto" accept="image/*" hidden>
                <img src="../images/product/<?= htmlentities($photo) ?>" alt="Current Photo" onerror="this.src='../images/photo.jpg'">
            </label>
            <?= err('ProductPhoto') ?>

            <section>
                <button class="admin-btn btn-submit">Submit</button>
                <button type="reset" class="admin-btn btn-reset">Reset</button>
            </section>
        </form>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>