<?php

    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $vendorId = $_POST['vendorId'];
        $orderId = $_POST['orderId'];
        $user_email = $_POST['email'];
        
        date_default_timezone_set('Asia/Kolkata');
        $orderAcceptDate = date('d-m-Y h:i:s A');

        $sql = "UPDATE orders SET Status = 'accept', date = '$orderAcceptDate' WHERE order_id = '$orderId' AND vendor_id = '$vendorId'";
        $query = mysqli_query($con, $sql);

        include '../pages/mail.php';

        if ($query) {
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
                $mail->Subject = "Order Confirmed - #$order_id (Vendor Accepted)";
                $mail->Body = "<html>
                                <head>
                                <title>Order Confirmed - Vendor Accepted</title>
                                </head>
                                <body>
                                <p>Dear $username,</p>
                                <p>Good news! Your order has been accepted by the vendor, and your order is now confirmed. Thank you for your patience. Below are the details of your confirmed order:</p>
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
                                <p><strong>Estimated Delivery Time:</strong> $travelTime Min</p>

                                <!-- Travel Time Section -->
                                <div style='border: 1px solid #4CAF50; padding: 10px; background-color: #f2f2f2; margin-top: 20px;'>
                                    <h4>Estimated Delivery Time:</h4>
                                    <p>Your order is expected to be delivered by <strong>$travelTime</strong>.</p>
                                </div>

                                <p>Your order has been confirmed, and the vendor has accepted your request.</p>
                                <p>If you have any questions or need further assistance, please feel free to reach out to us.</p>
                                <p>Thank you for choosing shopNest. We appreciate your business and look forward to serving you again soon!</p>
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

    }

?>