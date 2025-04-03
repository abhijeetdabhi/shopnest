<?php

    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $vendorId = $_POST['vendorId'];

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
            $vendorRegiDate = date('d-m-Y');

            $insert_data = "INSERT INTO vendor_cancel_request(name, email, password, username, phone, Bio, GST, cover_image, dp_image, latitude, longitude, date) VALUES ('$vendorName','$vendorEmail','$vendorPassword','$vendorUsername','$vendorPhone','$vendorBio','$vendorGST','$vendorCover_image','$vendorDp_image','$vendorLatitude','$vendorLongitude','$vendorRegiDate')";
            $insert_sql = mysqli_query($con, $insert_data);

            include '../pages/mail.php';

            if ($insert_sql) {
                $vendor_data = "SELECT * FROM vendor_request WHERE request_id = '$vendorId'";
                $vendor_query = mysqli_query($con, $vendor_data);
                $res = mysqli_fetch_assoc($vendor_query);
            
                $mail->addAddress($vendorEmail);
                $mail->isHTML(true);
            
                if ($res) {
                    $cancelDate = date('d-m-Y h:i:s A');
                    $mail->Subject = "Your Vendor Account Has Been Canceled";
                    $mail->Body = "<html>
                    <head>
                    <title>Vendor Account Canceled</title>
                    </head>
                    <body>
                    <p>Dear $vendorName,</p>

                    <p>We regret to inform you that your vendor account with shopNest has been canceled by our admin team. As a result, you will no longer have access to the vendor dashboard, and you will not be able to list or manage products on the platform.</p>

                    <h3>Account Cancellation Details:</h3>
                    <p><strong>Vendor Name:</strong> $vendorName<br>
                    <strong>Vendor Email:</strong> $vendorEmail<br>
                    <strong>Cancellation Date:</strong> $cancelDate</p>

                    <p>If you believe this action was taken in error or if you wish to discuss the situation further, please contact our support team at shopnest2603@gmail.com. We will be happy to assist you and provide further clarification.</p>

                    <p>We understand that this may be disappointing, and we appreciate your understanding. If you decide to reapply for a vendor account in the future, please reach out to us for guidance on how to proceed.</p>

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