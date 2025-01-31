<?php

    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $vendorId = $_POST['vendorId'];

        $sql = "UPDATE vendor_registration SET action = 'Accept' WHERE vendor_id = '$vendorId'";
        $query = mysqli_query($con, $sql);
    }

?>