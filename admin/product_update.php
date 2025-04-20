<?php
require '../base.php';
include '../admin_head.php';

$default_photo = 'photo.jpg';

if (is_get()) {
    $ProductID = req('ProductID');

    $stm = $_db->prepare('SELECT * FROM product WHERE ProductID = ?');
    $stm->execute([$ProductID]);
    $p = $stm->fetch();

    if (!$p) {
        redirect('product.php');
    }

    extract((array)$p);
    // store product photo into session
    $_SESSION['ProductThumb'] = $ProductThumb ?? $default_photo;
    $photo = $ProductThumb ?? $default_photo;
}

if (is_post()) {
    $ProductID = req('ProductID');
    $ProductName = req('ProductName');
    $Category = req('Category');
    $f = get_file('ProductThumb');  // when the user choose a NEW photo
    $photo = $_SESSION['ProductThumb'] ?? $default_photo;  // user use back existing photo

    // ProductName Validation
    if ($ProductName == '') {
        $_err['ProductName'] = 'Required';
    } else if (strlen($ProductName) > 100) {
        $_err['ProductName'] = 'Maximum 100 characters';
    }

    // Category Validation
    $valid_categories = ['Computer', 'Accessories', 'Keyboard'];

    if ($Category == '') {
        $_err['Category'] = 'Required';
    } else if (!in_array($Category, $valid_categories)) {
        $_err['Category'] = 'Invalid category selected';
    }

    // ProductThumb Validation
    // ** Only if a file is selected **
    if ($f) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['ProductThumb'] = 'Must be image';
        } else if ($f->size > 1 * 1024 * 1024) {
            $_err['ProductThumb'] = 'Maximum 1 MB';
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
            UPDATE product
            SET ProductName = ?, Category = ?, ProductThumb = ?
            WHERE ProductID = ?
        ');
        $stm->execute([$ProductName, $Category, $photo, $ProductID]);

        temp('info', 'Product record updated');
        redirect('product.php');
    }

    if (!isset($photo)) {
        $photo = $_SESSION['ProductThumb'] ?? $default_photo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product | Update</title>
</head>

<body>
    <main class="admin">
        <h1>Product | Update</h1>
        <form method="post" class="admin-form" enctype="multipart/form-data" novalidate>
            <label for="ProductID">ProductID</label>
            <b><?= $ProductID ?></b>
            <br>

            <label for="ProductName">ProductName</label>
            <input type="text" id="ProductName" name="ProductName" value='<?= htmlentities($ProductName) ?>' maxlength="100">
            <?= err('ProductName') ?>

            <label for="Category">Category</label>
            <select id="Category" name="Category">
                <option value="">- Select One -</option>
                <option value="Computer" <?= $Category == 'Computer' ? 'selected' : '' ?>>Computer</option>
                <option value="Keyboard" <?= $Category == 'Keyboard' ? 'selected' : '' ?>>Keyboard</option>
                <option value="Accessories" <?= $Category == 'Accessories' ? 'selected' : '' ?>>Accessories</option>
            </select>
            <?= err('Category') ?>

            <label for="ProductThumb">ProductThumb</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProductThumb" name="ProductThumb" accept="image/*" hidden>
                <img src="../images/product/<?= htmlentities($photo) ?>" alt="Current Photo" onerror="this.src='../images/photo.jpg'">
            </label>
            <?= err('ProductThumb') ?>

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