<?php

    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $vendorId = $_POST['vendorId'];
        $orderId = $_POST['orderId'];
        $user_email = $_POST['email'];

        $vendor_data = "SELECT * FROM orders WHERE order_id = '$orderId'";
        $vendor_query = mysqli_query($con, $vendor_data);

        while($res = mysqli_fetch_assoc($vendor_query)){
            $order_id = $res['order_id'];
            $order_title = $res['order_title'];
            $order_image = $res['order_image'];
            $order_price = $res['order_price'];
            $order_color = $res['order_color'];
            $order_size = $res['order_size'];
            $qty = $res['qty'];
            $travelTime = $res['travelTime'];
            $user_id = $res['user_id'];
            $product_id = $res['product_id'];
            $vendor_id = $res['vendor_id'];
            $user_first_name = $res['user_first_name'];
            $user_last_name = $res['user_last_name'];
            $user_email = $res['user_email'];
            $user_mobile = $res['user_mobile'];
            $user_address = $res['user_address'];
            $user_state = $res['user_state'];
            $user_city = $res['user_city'];
            $user_pin = $res['user_pin'];
            $payment_type = $res['payment_type'];
            $Status = $res['Status'];
            $total_price = $res['total_price'];
            
            date_default_timezone_set('Asia/Kolkata');
            $order_deny_date = date('d-m-Y h:i:s A');

            $insert_data = "INSERT INTO deny_orders(order_id, order_title, order_image, order_price, order_color, order_size, qty, travelTime, user_id, product_id, vendor_id, user_first_name, user_last_name, user_email, user_mobile, user_address, user_state, user_city, user_pin, payment_type, Status, total_price, date) VALUES ('$order_id','$order_title','$order_image','$order_price','$order_color','$order_size','$qty','$travelTime','$user_id','$product_id','$vendor_id','$user_first_name','$user_last_name','$user_email','$user_mobile','$user_address','$user_state','$user_city','$user_pin','$payment_type','$Status','$total_price','$order_deny_date')";
            $insert_sql = mysqli_query($con, $insert_data);
        }

        include '../pages/mail.php';

        if ($vendor_query) {
            $retrieve_order = "SELECT * FROM orders WHERE order_id = '$orderId' AND vendor_id = '$vendorId'";
            $retrieve_order_query = mysqli_query($con, $retrieve_order);
            $res = mysqli_fetch_assoc($retrieve_order_query);

            if ($res) {
                // Fetch order details
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
                $travelTime = $res['travelTime'];
                $today = date('d-m-Y', strtotime($res['date']));
                $delivery_date = date('d-m-Y', strtotime('+5 days', strtotime($today)));

                // Setup email
                $mail->addAddress($user_email);
                $mail->isHTML(true);
                $mail->Subject = "Order Denied - #$order_id (Vendor Declined)";
                $mail->Body = "<html>
                <head>
                <title>Order Denied - Vendor Declined</title>
                </head>
                <body>
                <p>Dear $username,</p>
                <p>We regret to inform you that your order #$order_id has been declined by the vendor. Unfortunately, the vendor was unable to fulfill your order at this time. We understand this may be disappointing, and we sincerely apologize for any inconvenience this may cause.</p>
                <p>Below are the details of the order you placed:</p>
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

                <p>Since the vendor has declined to fulfill the order, we suggest checking other available vendors or alternative products. If you'd like, you can place a new order for different items or products from other vendors.</p>

                <p>If you have any questions, concerns, or need assistance, please do not hesitate to contact us. We are here to help!</p>

                <p>We apologize again for the inconvenience and thank you for your understanding.</p>
                <p>Best regards,<br>
                shopNest<br>
                shopnest2603@gmail.com</p>
                </body>
                </html>";

                // Send email and handle errors
                if ($mail->send()) {
                    echo "Email sent successfully.";
                } else {
                    echo "Error sending email: " . $mail->ErrorInfo;
                }
            } else {
                echo "No order found with the given orderId and vendorId.";
            }
        }

        $deleteRequestData = "DELETE FROM orders WHERE order_id = '$orderId'";
        $deleteQuery = mysqli_query($con, $deleteRequestData);

        
        
    }

?>