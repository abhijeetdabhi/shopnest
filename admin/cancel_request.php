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
        }

        $deleteRequestData = "DELETE FROM vendor_request WHERE request_id = '$vendorId'";
        $deleteQuery = mysqli_query($con, $deleteRequestData);
    }

?>