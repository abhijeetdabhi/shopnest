<?php

include "../include/connect.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $order_title = $_POST['title'];
        $order_image = $_POST['image'];
        $order_price = $_POST['totalPriceWithQty'];
        $order_color = $_POST['color'];
        $order_size = $_POST['size'];
        $order_travelTime = $_POST['travelTime'];
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

        date_default_timezone_set('Asia/Kolkata');
        $order_place_date = date('d-m-Y h:i:s A');

        $get_qty = "SELECT * FROM products WHERE product_id = '$product_id'";
        $get_qty_query = mysqli_query($con, $get_qty);

        $qty = mysqli_fetch_assoc($get_qty_query);
        $product_quty = $qty['Quantity'];

        $qty_replace = str_replace(",", "", $product_quty);

        $remove_quty = $qty_replace - $product_qty;

        $user_order_title = $order_title;
        $user_order_image = $order_image;
        $user_order_price = $order_price;
        $user_order_color = $order_color;
        $user_order_size = $order_size;
        $user_order_qty = $product_qty;
        $user_order_travelTime = $order_travelTime;

        $user_order_user_id = $user_id;
        $user_order_product_id = $product_id ;
        $user_order_vendor_id = $vendor_id;
        
        $order_user_first_name = $FirstName;
        $order_user_last_name = $lastName;
        $order_user_email = $user_email;
        $order_user_mobile = $Phone_number;
        $order_user_address = $Address;
        $order_user_state = $state;
        $order_user_city = $city;
        $order_user_pin = $pin;
        $order_payment_type = $paymentType;
        
        $order_total_price = $totalProductPrice;
        $order_vendor_profit = $vendor_profit;
        $order_admin_profit = $admin_profit;
        $order_date = $order_place_date;

        $order_insert_sql = "INSERT INTO orders(order_title, order_image, order_price, order_color, order_size, qty, travelTime, user_id, product_id, vendor_id, user_first_name, user_last_name, user_email, user_mobile, user_address, user_state, user_city, user_pin, payment_type, Status,total_price, vendor_profit, admin_profit, date) VALUES ('$user_order_title','$user_order_image','$user_order_price','$user_order_color','$user_order_size','$user_order_qty','$user_order_travelTime','$user_order_user_id','$user_order_product_id','$user_order_vendor_id','$order_user_first_name','$order_user_last_name','$order_user_email','$order_user_mobile','$order_user_address','$order_user_state','$order_user_city','$order_user_pin','$order_payment_type', 'pending','$order_total_price','$order_vendor_profit','$order_admin_profit','$order_date')";
        $order_insert_query = mysqli_query($con, $order_insert_sql);

        $update_qty = "UPDATE products SET Quantity='$remove_quty' WHERE product_id = '$product_id'";
        $update_qty_quary = mysqli_query($con, $update_qty);

        include '../pages/mail.php';

        if ($update_qty_quary) {
            $retrieve_order = "SELECT * FROM orders WHERE product_id = '$product_id' AND user_email	= '$user_email' AND payment_type = '$paymentType' AND date = '$order_place_date'";
            $retrieve_order_query = mysqli_query($con, $retrieve_order);
            $res = mysqli_fetch_assoc($retrieve_order_query);

            $mail->addAddress($user_email);
            $mail->isHTML(true);

            if ($res) {
                $username = $res['user_first_name'] . ' ' . $res['user_last_name'];
                $order_id = $res['order_id'];
                $order_date = $res['date'];
                $order_title = $res['order_title'];
                $order_image = '../src/product_image/product_profile/' . $res['order_image'];
                $order_price = $res['order_price'];
                $order_color = $res['order_color'];
                $order_size = $res['order_size'];
                $order_qty = $res['qty'];
                $user_email = $res['user_email'];
                $user_mobile = $res['user_mobile'];
                $user_address = $res['user_address'];
                $total_price = $res['total_price'];
                $today = date('d-m-Y', strtotime($res['date']));
                $delivery_date = date('d-m-Y', strtotime('+5 days', strtotime($today)));

                $mail->Subject = "Order Placed - #$order_id (Pending Confirmation)";
                $mail->Body = "<html>
                <head>
                <title>Order Placed - Pending Confirmation</title>
                </head>
                <body>
                <p>Dear $username,</p>
                <p>Thank you for placing an order with us! We are excited to inform you that your order has been received and is currently pending confirmation. The details of your order are as follows:</p>
                <p><strong>Order Number:</strong> $order_id<br>
                <strong>Order Date:</strong> $order_date</p>
                <h3>Items Ordered:</h3>
                <table border='1' cellpadding='10'>
                    <tr>
                    <td><strong>Product Name:</strong></td>
                    <td>$order_title</td>
                    </tr>
                    <tr>
                    <td><strong>Image:</strong></td>
                    <td><img src='$order_image' alt='Product Image' width='100'></td>
                    </tr>
                    <tr>
                    <td><strong>Price:</strong></td>
                    <td>$order_price</td>
                    </tr>
                    <tr>
                    <td><strong>Quantity:</strong></td>
                    <td>$order_qty</td>
                    </tr>
                    <tr>
                    <td><strong>Color:</strong></td>
                    <td>$order_color</td>
                    </tr>
                    <tr>
                        <td><strong>Size:</strong></td>
                        <td>$order_size</td>
                    </tr>
                </table>
                <p><strong>Mobile Number:</strong> $user_mobile</p>
                <p><strong>Billing E-mail:</strong> $user_email</p>
                <p><strong>Billing Address:</strong> $user_address</p>
                <p><strong>Order Total Price:</strong> $total_price</p>
                <p><strong>Estimated Delivery Date:</strong> $delivery_date</p>
                <p>Your order is currently pending confirmation from the vendor. Once the vendor accepts your order, we will send you a confirmation and update you on the shipping details.</p>
                <p>If you have any questions or need further assistance, please do not hesitate to contact us.</p>
                <p>Thank you for choosing shopNest. We look forward to serving you again!</p>
                <p>Best regards,<br>
                shopNest<br>
                shopnest2603@gmail.com</p>
                </body>
                </html>";

                $mail->send();
            }

        }
    }
?>