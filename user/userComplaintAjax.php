<?php
    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $usersId = $_POST['usersId'];
        $vendorsId = $_POST['vendorsId'];
        $productsId = $_POST['productsId'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $vendorStore = $_POST['vendorStore'];
        $vendorProduct = $_POST['vendorProduct'];
        $complaint = $_POST['complaint'];

        $date = date('d-m-Y');

        $insert = "INSERT INTO complaint(user_id, vendor_id, product_id, user_name, user_email, vendor_store, product_name, user_complaint, date) VALUES ('$usersId','$vendorsId','$productsId','$name','$email','$vendorStore','$vendorProduct','$complaint', '$date')";
        $query = mysqli_query($con, $insert);

        if ($query) {
            echo 'success';
        }
    }
?>