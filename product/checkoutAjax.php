<?php

include "../include/connect.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $order_title = $_POST['title'];
        $order_image = $_POST['image'];
        $order_price = $_POST['totalPriceWithQty'];
        $order_color = $_POST['color'];
        $order_size = $_POST['size'];
        $product_qty = $_POST['qty'];

        $shipping = $_POST['shipping'];
        $formattedTotal = $_POST['formattedTotal'];

        $product_id = $_POST['product_id'];
        $vendor_id = $_POST['vendor_id'];
        $user_id = $_POST['user_id'];

        $FirstName = $_POST['FirstName'];
        $lastName = $_POST['lastName'];
        $Phone_number = $_POST['Phone_number'];
        $user_email = $_POST['user_email'];
        $Address = $_POST['Address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pin = $_POST['pin'];
        $paymentType = $_POST['paymentType'];


        $bac = str_replace(",", "", $order_price);
        $bac = (int)$bac;

        $totalProductPrice = number_format($bac + $shipping);

        $orders_prices = str_replace(",", "", $order_price);

        $admin_profit = 20 + $shipping;
        $vendor_profit = number_format($orders_prices - $admin_profit);

        $order_place_date = date('d-m-Y');

        $get_qty = "SELECT * FROM products WHERE product_id = '$product_id'";
        $get_qty_query = mysqli_query($con, $get_qty);

        $qty = mysqli_fetch_assoc($get_qty_query);
        $product_quty = $qty['Quantity'];

        $qty_replace = str_replace(",", "", $product_quty);

        $remove_quty = $qty_replace - $product_qty;

        $order_insert_sql = "INSERT INTO orders (order_title, order_image, order_price, order_color, order_size, qty, user_id, product_id, vendor_id, user_first_name, user_last_name, user_email, user_mobile, user_address, user_state, user_city, user_pin, payment_type, total_price, vendor_profit, admin_profit, date) VALUES ('$order_title', '$order_image', '$order_price', '$order_color', '$order_size', '$product_qty', '$user_id', '$product_id', '$vendor_id', '$FirstName', '$lastName', '$user_email', '$Phone_number', '$Address', '$state', '$city', '$pin', '$paymentType', '$totalProductPrice', '$vendor_profit', '$admin_profit', '$order_place_date')";
        $order_insert_query = mysqli_query($con, $order_insert_sql);

        $update_qty = "UPDATE products SET Quantity='$remove_quty' WHERE product_id = '$product_id'";
        $update_qty_quary = mysqli_query($con, $update_qty);
    }
    ?>
    
    <?php
?>