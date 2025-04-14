<?php
require '../base.php';
include '../admin_head.php';

if (is_post()) {
    $ProductID = req('ProductID');
    $ProductName = req('ProductName');
    $Category = req('Category');
    $ProductThumb = get_file('ProductThumb');

    // ProductID Validation
    if ($ProductID == '') {
        $_err['ProductID'] = 'Required';
    } else if (!preg_match('/^P\d{3}$/', $ProductID)) {
        $_err['ProductID'] = 'Invalid format';
    } else if (!is_unique($ProductID, 'product', 'ProductID')) {
        $_err['ProductID'] = 'Duplicated';
    }

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
    if (!$ProductThumb) {
        $_err['ProductThumb'] = 'Required';
    } else if (!str_starts_with($ProductThumb->type, 'image/')) {
        $_err['ProductThumb'] = 'Must be image';
    } else if ($ProductThumb->size > 1 * 1024 * 1024) {
        $_err['ProductThumb'] = 'Maximum 1MB';
    }

    // DB operation
    // save photo then continue with DB operation
    if (!$_err) {
        // Save photo
        $photo = save_photo($ProductThumb, '../images/product');

        $stm = $_db->prepare('
            INSERT INTO product (ProductID, ProductName, Category, ProductThumb)
            VALUES (?, ?, ?, ?)
        ');
        $stm->execute([$ProductID, $ProductName, $Category, $photo]);

        temp('info', 'Record inserted');
        redirect('product.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product | Insert</title>
</head>

<body>
    <main id="admin">
        <h1>Product | Insert</h1>
        <form method="post" class="product-form" enctype="multipart/form-data">
            <label for="ProductID">ProductID</label>
            <input type="text" id="ProductID" name="ProductID" maxlength="4" placeholder="P999" data-upper>
            <?= err('ProductID') ?>
            
            <label for="ProductName">ProductName</label>
            <input type="text" id="ProductName" name="ProductName" maxlength="100">
            <?= err('ProductName') ?>
            
            <label for="Category">Category</label>
            <select id="Category" name="Category">
                <option value="">- Select One -</option>
                <option value="Computer">Computer</option>
                <option value="Keyboard">Keyboard</option>
                <option value="Accessories">Accessories</option>
            </select>
            <?= err('Category') ?>

            <label for="ProductThumb">ProductThumb</label>
            <label class="upload" tabindex="0">
                <input type="file" id="ProductThumb" name="ProductThumb" accept="image/*" hidden>
                <img src="../images/photo.jpg" alt="photo">
            </label>
            <?= err('ProductThumb') ?>

            <section>
                <button>Submit</button>
                <button type="reset">Reset</button>
            </section>
        </form>
    </main>

    <?php
    include '../admin_foot.php';
    ?>
</body>

</html>