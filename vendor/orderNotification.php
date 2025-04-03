<?php
session_start();

if (isset($_POST['checkNewOrder'])) {
    $response = 0;
    if (isset($_SESSION['existingOrder']) && isset($_SESSION['currentOrder'])) {
        if ($_SESSION['existingOrder'] < $_SESSION['currentOrder']) {
            $response = 1;
        }
    }
    echo json_encode($response);
    exit;
}
?>
