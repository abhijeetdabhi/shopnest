<?php

    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $vendorId = $_POST['vendorId'];

        $sql = "UPDATE vendor_request SET status = 'Accept' WHERE request_id = '$vendorId'";
        $query = mysqli_query($con, $sql);

        $vendor_data = "SELECT * FROM vendor_request WHERE request_id = '$vendorId'";
        $vendor_query = mysqli_query($con, $vendor_data);

        while($res = mysqli_fetch_assoc($vendor_query)){
            $vendorName = $res['name'];
            $vendorEmail = $res['email'];
            $vendorPassword = $res['password'];
            $vendorUsername = $res['username'];
            $vendorPhone = $res['phone'];
            $vendorBio = $res['Bio'];
            $vendorGST = $res['GST'];
            $vendorCover_image = $res['cover_image'];
            $vendorDp_image = $res['dp_image'];
            $vendorLatitude = $res['latitude'];
            $vendorLongitude = $res['longitude'];
            $vendorRegiDate = $res['date'];

            $insert_data = "INSERT INTO vendor_registration(name, email, password, username, phone, Bio, GST, cover_image, dp_image, latitude, longitude, date) VALUES ('$vendorName','$vendorEmail','$vendorPassword','$vendorUsername','$vendorPhone','$vendorBio','$vendorGST','$vendorCover_image','$vendorDp_image','$vendorLatitude','$vendorLongitude','$vendorRegiDate')";
            $insert_sql = mysqli_query($con, $insert_data);

            include '../pages/mail.php';

            if ($insert_sql) {
                $vendor_data = "SELECT * FROM vendor_request WHERE request_id = '$vendorId'";
                $vendor_query = mysqli_query($con, $vendor_data);
                $res = mysqli_fetch_assoc($vendor_query);
            
                $mail->addAddress($vendorEmail);
                $mail->isHTML(true);
            
                if ($res) {
                    $mail->Subject = "Your Vendor Account Has Been Approved";
                    $mail->Body = "<html>
                    <head>
                    <title>Vendor Account Approved</title>
                    </head>
                    <body>
                    <p>Dear $vendorName,</p>

                    <p>We are excited to inform you that your vendor account with shopNest has been successfully approved! You are now able to start listing your products and manage your store.</p>

                    <h3>Your Account Details:</h3>
                    <p><strong>Vendor Name:</strong> $vendorName<br>
                    <strong>Vendor Email:</strong> $vendorEmail<br>

                    <h3>Next Steps:</h3>
                    <p>Now that your account has been approved, here are some next steps to help you get started:</p>
                    <ul>
                        <li><strong>Login to Your Account:</strong> Use your email and password to log in to your vendor dashboard.</li>
                        <li><strong>List Your Products:</strong> Start adding your products to the platform to reach a larger audience.</li>
                        <li><strong>Manage Orders:</strong> You can now view, process, and manage orders from customers.</li>
                    </ul>
                    <p>We look forward to a successful partnership with you and are excited to see the products you bring to shopNest!</p>

                    <p>Best regards,<br>
                    The shopNest Team<br>
                    shopnest2603@gmail.com</p>

                    </body>
                    </html>";

                
                    $mail->send();
                }
            }
        }

        $deleteRequestData = "DELETE FROM vendor_request WHERE request_id = '$vendorId'";
        $deleteQuery = mysqli_query($con, $deleteRequestData);
    }

?>