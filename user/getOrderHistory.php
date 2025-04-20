<?php
    session_start();

    $_db = new PDO('mysql:dbname=techcafe', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $email = $_SESSION['Email'] ?? '';

    if (!$email) {
        echo "<p style='font-size: 16px;'>Please log in to view your order history.</p>";
        exit;
    } else {
        $stm = $_db->prepare("SELECT * FROM cart WHERE Email = ? AND OrderStatus = 'Purchased'");
        $stm->execute([$email]);
        $orders = $stm->fetchAll();

        if (!$orders) {
            echo "<p style='font-size: 16px;'>No purchase history found.</p>";
        } else {
            foreach ($orders as $order) {
                $specIDs = explode(',', $order['ItemsAdded']);
                $quantities = explode(',', $order['Quantity']);

                // Validate equal count
                if (count($specIDs) === count($quantities)) {
                    for ($i = 0; $i < count($specIDs); $i++) {
                        $specID = trim($specIDs[$i]);
                        $qty = (int) trim($quantities[$i]);

                        // Fetch product, spec name, and price
                        $stm = $_db->prepare("
                            SELECT 
                                p.ProductName,
                                s.Specification,
                                s.Price AS UnitPrice,
                                s.ProductPhoto
                            FROM specification s
                            JOIN product p ON s.ProductID = p.ProductID
                            WHERE s.SpecID = ?");
                        $stm->execute([$specID]);
                        $detail = $stm->fetch();

                        if ($detail) {
                            $unitPrice = (float) $detail['UnitPrice'];
                            $totalPrice = $qty * $unitPrice;
                            $imagePath = "../images/product/" . $detail['ProductPhoto'];

                            echo "
                            <div style='display: flex; margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 10px;'>
                                <div style='margin-right: 15px;'>
                                    <img src='{$imagePath}' alt='{$detail['ProductName']}' style='width: 117px; height: 117px; object-fit: cover; border-radius: 8px; border: 1px grey solid'>
                                </div>
                                <div style='font-size: 17px; line-height: 25px;'>
                                    <b>{$detail['ProductName']}</b><br>
                                    Specification: {$detail['Specification']}<br>
                                    Quantity: {$qty}<br>
                                    Unit Price: RM {$unitPrice}<br>
                                    Total: RM {$totalPrice}
                                </div>
                            </div>";
                        }
                    }
                }
            }
        }
    }
?>