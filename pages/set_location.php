<?php

if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    setcookie('latitude', $latitude, time() + (10 * 24 * 60 * 60), "/");  
    setcookie('longitude', $longitude, time() + (10 * 24 * 60 * 60), "/");

    // Return a success message
    echo "Location has been saved.";
} else {
    echo "Latitude and longitude not provided.";
}
?>
