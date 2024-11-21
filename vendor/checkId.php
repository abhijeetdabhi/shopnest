<?php

session_start();

include "../include/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sameId = mysqli_real_escape_string($con, $_POST['sameId']); 

    $selectProducts = "SELECT * FROM products WHERE same_id = '$sameId'";
    $result = mysqli_query($con, $selectProducts);

    if (mysqli_num_rows($result) > 0) {
        echo 'taken';
        $_SESSION['productSameId'] = true;
    } else {
        echo 'available';
        unset($_SESSION['productSameId']);
    }

    mysqli_close($con);
}
?>
