<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Remove Vendor</title>

    <style>
        @keyframes clock-wise {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes anti-clock-wise {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .outer-line {
            animation: clock-wise 1s linear infinite;
        }

        .inner-line {
            animation: anti-clock-wise 1.3s linear infinite;
        }
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">


    <!-- Successfully message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-[18rem] min-[410px]:w-[22rem] min-[760px]:w-max border-2 m-auto rounded-lg border-green-500 py-3 px-6 bg-green-100 z-50" id="SpopUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-green-500" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 21 21" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                <g>
                    <path fill="currentColor" d="M10.504 1.318a9.189 9.189 0 0 1 0 18.375 9.189 9.189 0 0 1 0-18.375zM8.596 13.49l-2.25-2.252a.986.986 0 0 1 0-1.392.988.988 0 0 1 1.393 0l1.585 1.587 3.945-3.945a.986.986 0 0 1 1.392 0 .987.987 0 0 1 0 1.392l-4.642 4.642a.987.987 0 0 1-1.423-.032z" opacity="1" data-original="currentColor"></path>
                </g>
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium text-center" id="Successfully"></div>
        </div>
    </div>


    <!-- Error message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-[18rem] min-[410px]:w-[22rem] min-[760px]:w-max border-2 rounded-lg border-red-500 py-3 px-6 bg-red-100 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-red-500">
            <svg class="flex-shrink-0 inline w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                    <path d="M12 1a11 11 0 1 0 11 11A11.013 11.013 0 0 0 12 1zm4.242 13.829a1 1 0 1 1-1.414 1.414L12 13.414l-2.828 2.829a1 1 0 0 1-1.414-1.414L10.586 12 7.758 9.171a1 1 0 1 1 1.414-1.414L12 10.586l2.828-2.829a1 1 0 1 1 1.414 1.414L13.414 12z" data-name="Layer 2" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                </g>
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium text-center" id="errorMessage"></div>
        </div>
    </div>

    <!-- loader  -->
    <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm z-40" style="display: none;">
        <div class="w-24 h-24 border-4 border-transparent outer-line border-t-gray-700 rounded-full flex items-center justify-center"></div>
        <div class="w-20 h-20 border-4 border-transparent rotate-180 inner-line border-t-gray-900 rounded-full absolute"> </div>
        <img class="w-10 absolute" src="../src/logo/black_cart_logo.svg" alt="Cart Logo">
    </div>

    <script>
        function loader() {
            let loader = document.getElementById('loader');
            let body = document.body;

            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
        }

        function displayErrorMessage(message) {
            let popUp = document.getElementById('popUp');
            let errorMessage = document.getElementById('errorMessage');

            errorMessage.innerHTML = '<span class="font-medium">' + message + '</span>';
            popUp.style.display = 'flex';
            popUp.style.opacity = '100';

            setTimeout(() => {
                popUp.style.display = 'none';
                popUp.style.opacity = '0';
                window.location.href = 'view_vendors.php';
            }, 1800);
        }

        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');

            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = 'view_vendors.php';
            }, 2000);
        }
    </script>

    <?php

    include "../include/connect.php";

    $vendor_id = $_GET['id'];

    $get_vendor = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $get_query = mysqli_query($con, $get_vendor);
    $res = mysqli_fetch_assoc($get_query);

    // remove vendor
    $remove_vendor = "DELETE FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $remove_query = mysqli_query($con, $remove_vendor);

    if ($remove_query) {
        echo '<script>loader()</script>';
        echo '<script>displaySuccessMessage("Vendor Remove Successfully.");</script>';
    } else {
        echo '<script>displayErrorMessage("Please Try Again Later.");</script>';
    }
    ?>

</body>

</html>