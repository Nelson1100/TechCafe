<?php
    require '../base.php';
    include '../admin_head.php';

    // Restrict access to admins only
    if ($_SESSION['Role'] !== 'Admin') {
        echo "<script>alert('Access denied. Admins only.'); window.location='/pages/home.php'</script>";
        exit;
    }

    // Get current product data
    $stm = $_db->prepare("SELECT * FROM product WHERE ProductID = ?");
    $stm->execute([$ProductID]);
    $product = $stm->fetch();

    $stm = $_db->prepare("SELECT * FROM specification WHERE ProductID = ?");
    $stm->execute([$ProductID]);
    $spec = $stm->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ProductName = $_POST['ProductName'];
        $Category = $_POST['Category'];
        $Specification = $_POST['Specification'];
        $Price = $_POST['Price'];
        $Descr = $_POST['Descr'];
    
        // Handle file upload for ProductThumb
        $thumbName = $product['ProductThumb'];
        if (!empty($_FILES['ProductThumb']['name'])) {
            $thumbName = uniqid() . '_' . $_FILES['ProductThumb']['name'];
            move_uploaded_file($_FILES['ProductThumb']['tmp_name'], "../images/product/" . $thumbName);
        }
    
        // Handle file upload for ProductPhoto
        $photoName = $spec['ProductPhoto'];
        if (!empty($_FILES['ProductPhoto']['name'])) {
            $photoName = uniqid() . '_' . $_FILES['ProductPhoto']['name'];
            move_uploaded_file($_FILES['ProductPhoto']['tmp_name'], "../images/product/" . $photoName);
        }
    
        // Update product table
        $stm = $_db->prepare("UPDATE product SET ProductName = ?, Category = ?, ProductThumb = ? WHERE ProductID = ?");
        $stm->execute([$ProductName, $Category, $thumbName, $ProductID]);
    
        // Update specification table
        $stm = $_db->prepare("UPDATE specification SET Specification = ?, Price = ?, Descr = ?, ProductPhoto = ? WHERE ProductID = ?");
        $stm->execute([$Specification, $Price, $Descr, $photoName, $ProductID]);
    
        echo "<script>alert('Product updated successfully'); window.location='admin.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product | Edit</title>
</head>
<body>
    <main>
        <h2>Edit Product</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Product Name
                <input type="text" name="ProductName" value="<?= htmlspecialchars($product['ProductName']) ?>" required>
            </label>

            <label>Category
                <input type="text" name="Category" value="<?= htmlspecialchars($product['Category']) ?>" required>
            </label>

            <label>Product Thumb
                <input type="file" name="ProductThumb" accept="image/*">
                <img src="../images/product/<?= $product['ProductThumb'] ?>" alt="Current Thumbnail">
            </label>

            <label>Specification
                <input type="text" name="Specification" value="<?= htmlspecialchars($spec['Specification']) ?>" required>
            </label>

            <label>Price (RM)
                <input type="number" name="Price" value="<?= htmlspecialchars($spec['Price']) ?>" step="0.01" required>
            </label>

            <label>Description
                <textarea name="Descr" rows="5"><?= htmlspecialchars($spec['Descr']) ?></textarea>
            </label>

            <label>Product Photo
                <input type="file" name="ProductPhoto" accept="image/*">
                <img src="../images/product/<?= $spec['ProductPhoto'] ?>" alt="Current Product Photo">
            </label>

            <br>
            <button type="submit">Update Product</button>
            <button type="reset">Reset</button>
            <a href="admin.php"><button type="button">Cancel</button></a>
        </form>
    </main>
</body>
</html>