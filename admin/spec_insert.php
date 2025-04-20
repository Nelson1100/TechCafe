<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $SpecID = req('SpecID');
    $ProductID = req('ProductID');
    $Specification = req('Specification');
    $Price = req('Price');
    $Descr = req('Descr');
    $f = get_file('ProductPhoto');

    // SpecID Validation
    if ($SpecID == '') {
        $_err['SpecID'] = 'Required';
    } else if (!preg_match('/^S\d{3}$/', $SpecID)) {
        $_err['SpecID'] = 'Invalid format';
    } else if (!is_unique($SpecID, 'specification', 'SpecID')) {
        $_err['SpecID'] = 'Duplicated';
    }

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
    // THE DATABASE THE PRICE NEED RANGE CHECK BA

    // Descr Validation
    if ($Descr == '') {
        $_err['Descr'] = 'Required';
    }

    // ProductPhoto Validation
    if (!$f) {
        $_err['ProductPhoto'] = 'Required';
    } else if (!str_starts_with($f->type, 'image/')) {
        $_err['ProductPhoto'] = 'Must be image';
    } else if ($f->size > 1 * 1024 * 1024) {
        $_err['ProductPhoto'] = 'Maximum 1 MB';
    }

    // DB operation
    // save photo then continue with DB operation
    if (!$_err) {
        // Save photo
        $photo = save_photo($f, '../images/product');

        $stm = $_db->prepare('
            INSERT INTO specification (SpecID, ProductID, Specification, Price, Descr, ProductPhoto)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
        $stm->execute([$SpecID, $ProductID, $Specification, $Price, $Descr, $photo]);

        temp('info', 'Specification record inserted');
        redirect('product.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specification | Insert</title>
</head>

<body>
    <main class="admin">
        <h1>Specification | Insert</h1>
        <form method="post" class="admin-form" enctype="multipart/form-data" novalidate>
            <label for="SpecID">SpecID</label>
            <input type="text" id="SpecID" name="SpecID" maxlength="4" placeholder="S999" value="<?= old('SpecID') ?>" data-upper required>
            <?= err('SpecID') ?>

            <label for="Specification">Specification</label>
            <input type="text" id="Specification" name="Specification" maxlength="100" value="<?= old('Specification') ?>" required>
            <?= err('Specification') ?>

            <label for="Price">Price</label>
            <input type="number" id="Price" name="Price" min="0.01" max="99999.99" step="0.01" value="<?= old('Price') ?>">
            <?= err('Price') ?>

            <label for="Descr">Description</label>
            <textarea id="Descr" name="Descr" rows="7" cols="30" value="<?= old('Descr') ?>" required></textarea>
            <?= err('Descr') ?>

            <label for="ProductPhoto">ProductPhoto</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProductPhoto" name="ProductPhoto" accept="image/*" hidden required>
                <img src="../images/photo.jpg" alt="Photo">
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