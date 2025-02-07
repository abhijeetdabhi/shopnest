<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}

include "../include/connect.php";
if (isset($_COOKIE['vendor_id'])) {
    $vendor_id = $_COOKIE['vendor_id'];

    $retrieve_data = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);
}
?>

<?php
function getAddressFromLatLng($lat, $lng, $apiKey)
{
    $url = "https://api.tomtom.com/search/2/reverseGeocode/{$lat},{$lng}.json?key={$apiKey}";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "cURL Error: " . curl_error($ch);
        return null;
    }

    $data = json_decode($response, true);

    curl_close($ch);

    if (isset($data['addresses'][0]['address'])) {
        $address = $data['addresses'][0]['address'];
        $formAddress = isset($address['freeformAddress']) ? $address['freeformAddress'] : 'Not available';

        return [
            'formAddress' => $formAddress
        ];
    }

    return null;
}


$lat = $row['latitude'];
$lng = $row['longitude'];
$apiKey = 'hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw';

$address = getAddressFromLatLng($lat, $lng, $apiKey);

if ($address) {
    $formAddress = $address['formAddress'];
} else {
    $formAddress = "";
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

    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>


    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Vendor Deshboard</title>

    <style>
        #map {
            width: 60vw;
            height: 60vh;
            display: none;
        }

        .tt-search-box {
            width: 100%;
            margin: auto;
        }

        .tt-search-box input {
            font-size: 16px;
            width: 100%;
            height: 50px;
        }

        .tt-search-box input:focus {
            outline: none;
            box-shadow: none;
        }

        .tt-search-box-input-container {
            width: 100%;
            height: 50px;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            margin: auto;
        }

        /* width */
        .scrollBar::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e6e6e6;
        }

        .scrollBar::-webkit-scrollbar {
            width: 10px;
            height: 7px;
            background-color: #F5F5F5;
        }

        .scrollBar::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #bfbfbf;
        }

        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
        }

        #logoutPopUp {
            display: none;
        }

        [x-cloak] {
            display: none;
        }

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


    <div>
        <?php
        include "vendor_logout.php";
        ?>
    </div>

    <div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0" x-cloak>
                <div class="flex items-center justify-center mt-8 mr-2">
                    <a class="flex w-fit" href="">
                        <!-- icon logo div -->
                        <div>
                            <img class="w-12 sm:w-14 mt-0.5" src="../src/logo/white_cart_logo.svg" alt="">
                        </div>
                        <!-- text logo -->
                        <div>
                            <img class="w-28 sm:w-36" src="../src/logo/white_text_logo.svg" alt="">
                        </div>
                    </a>
                </div>
                <nav class="mt-10">
                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 " href="vendor_dashboard.php">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <span class="mx-3">Dashboard</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="vendor_profile.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M210.352 246.633c33.882 0 63.218-12.153 87.195-36.13 23.969-23.972 36.125-53.304 36.125-87.19 0-33.876-12.152-63.211-36.129-87.192C273.566 12.152 244.23 0 210.352 0c-33.887 0-63.22 12.152-87.192 36.125s-36.129 53.309-36.129 87.188c0 33.886 12.156 63.222 36.13 87.195 23.98 23.969 53.316 36.125 87.19 36.125zM144.379 57.34c18.394-18.395 39.973-27.336 65.973-27.336 25.996 0 47.578 8.941 65.976 27.336 18.395 18.398 27.34 39.98 27.34 65.972 0 26-8.945 47.579-27.34 65.977-18.398 18.399-39.98 27.34-65.976 27.34-25.993 0-47.57-8.945-65.973-27.34-18.399-18.394-27.344-39.976-27.344-65.976 0-25.993 8.945-47.575 27.344-65.973zM426.129 393.703c-.692-9.976-2.09-20.86-4.149-32.351-2.078-11.579-4.753-22.524-7.957-32.528-3.312-10.34-7.808-20.55-13.375-30.336-5.77-10.156-12.55-19-20.16-26.277-7.957-7.613-17.699-13.734-28.965-18.2-11.226-4.44-23.668-6.69-36.976-6.69-5.227 0-10.281 2.144-20.043 8.5a2711.03 2711.03 0 0 1-20.879 13.46c-6.707 4.274-15.793 8.278-27.016 11.903-10.949 3.543-22.066 5.34-33.043 5.34-10.968 0-22.086-1.797-33.043-5.34-11.21-3.622-20.3-7.625-26.996-11.899-7.77-4.965-14.8-9.496-20.898-13.469-9.754-6.355-14.809-8.5-20.035-8.5-13.313 0-25.75 2.254-36.973 6.7-11.258 4.457-21.004 10.578-28.969 18.199-7.609 7.281-14.39 16.12-20.156 26.273-5.558 9.785-10.058 19.992-13.371 30.34-3.2 10.004-5.875 20.945-7.953 32.524-2.063 11.476-3.457 22.363-4.149 32.363C.343 403.492 0 413.668 0 423.949c0 26.727 8.496 48.363 25.25 64.32C41.797 504.017 63.688 512 90.316 512h246.532c26.62 0 48.511-7.984 65.062-23.73 16.758-15.946 25.254-37.59 25.254-64.325-.004-10.316-.351-20.492-1.035-30.242zm-44.906 72.828c-10.934 10.406-25.45 15.465-44.38 15.465H90.317c-18.933 0-33.449-5.059-44.379-15.46-10.722-10.208-15.933-24.141-15.933-42.587 0-9.594.316-19.066.95-28.16.616-8.922 1.878-18.723 3.75-29.137 1.847-10.285 4.198-19.937 6.995-28.675 2.684-8.38 6.344-16.676 10.883-24.668 4.332-7.618 9.316-14.153 14.816-19.418 5.145-4.926 11.63-8.957 19.27-11.98 7.066-2.798 15.008-4.329 23.629-4.56 1.05.56 2.922 1.626 5.953 3.602 6.168 4.02 13.277 8.606 21.137 13.625 8.86 5.649 20.273 10.75 33.91 15.152 13.941 4.508 28.16 6.797 42.273 6.797 14.114 0 28.336-2.289 42.27-6.793 13.648-4.41 25.058-9.507 33.93-15.164 8.043-5.14 14.953-9.593 21.12-13.617 3.032-1.973 4.903-3.043 5.954-3.601 8.625.23 16.566 1.761 23.636 4.558 7.637 3.024 14.122 7.059 19.266 11.98 5.5 5.262 10.484 11.798 14.816 19.423 4.543 7.988 8.208 16.289 10.887 24.66 2.801 8.75 5.156 18.398 7 28.675 1.867 10.434 3.133 20.239 3.75 29.145v.008c.637 9.058.957 18.527.961 28.148-.004 18.45-5.215 32.38-15.937 42.582zm0 0" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Profile</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="vendor_account.php">
                        <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                            <g>
                                <path d="M11.5 20.263H2.95a.2.2 0 0 1-.2-.2v-1.451c0-.83.593-1.562 1.507-2.184 1.632-1.114 4.273-1.816 7.243-1.816a.75.75 0 0 0 0-1.5c-3.322 0-6.263.831-8.089 2.076-1.393.95-2.161 2.157-2.161 3.424v1.451a1.7 1.7 0 0 0 1.7 1.7h8.55a.75.75 0 1 0 0-1.5zM11.5 1.25C8.464 1.25 6 3.714 6 6.75s2.464 5.5 5.5 5.5S17 9.786 17 6.75s-2.464-5.5-5.5-5.5zm0 1.5c2.208 0 4 1.792 4 4s-1.792 4-4 4-4-1.792-4-4 1.792-4 4-4zM17.5 13.938a3.564 3.564 0 0 0 0 7.125c1.966 0 3.563-1.597 3.563-3.563s-1.597-3.562-3.563-3.562zm0 1.5c1.138 0 2.063.924 2.063 2.062s-.925 2.063-2.063 2.063-2.063-.925-2.063-2.063.925-2.062 2.063-2.062z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M18.25 14.687V13a.75.75 0 0 0-1.5 0v1.688a.75.75 0 0 0 1.5-.001zM20.019 16.042l1.193-1.194a.749.749 0 1 0-1.06-1.06l-1.194 1.193a.752.752 0 0 0 0 1.061.752.752 0 0 0 1.061 0zM20.312 18.25H22a.75.75 0 0 0 0-1.5h-1.688a.75.75 0 0 0 0 1.5zM18.958 20.019l1.194 1.193a.749.749 0 1 0 1.06-1.06l-1.193-1.194a.752.752 0 0 0-1.061 0 .752.752 0 0 0 0 1.061zM16.75 20.312V22a.75.75 0 0 0 1.5 0v-1.688a.75.75 0 0 0-1.5 0zM14.981 18.958l-1.193 1.194a.749.749 0 1 0 1.06 1.06l1.194-1.193a.752.752 0 0 0 0-1.061.752.752 0 0 0-1.061 0zM14.687 16.75H13a.75.75 0 0 0 0 1.5h1.687a.75.75 0 1 0 0-1.5zM16.042 14.981l-1.194-1.193a.749.749 0 1 0-1.06 1.06l1.193 1.194a.752.752 0 0 0 1.061 0 .752.752 0 0 0 0-1.061z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Account setting</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="choose_product.php">
                        <svg class="w-6 h-6 stroke-gray-500 group-hover:stroke-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="mx-3">Add product</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="productPurchasers.php">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-6">
                                <g>
                                    <path d="M155.166 233.471h106.395c4.056 44.754 41.779 79.939 87.573 79.939 48.49 0 87.939-39.45 87.939-87.939 0-45.793-35.185-83.517-79.939-87.572V31.503a8 8 0 0 0-8-8H155.166a8 8 0 0 0-8 8v193.968a8 8 0 0 0 8 8zm265.907-8c0 39.667-32.271 71.939-71.939 71.939s-71.94-32.272-71.94-71.939c0-39.668 32.272-71.94 71.94-71.94s71.939 32.272 71.939 71.94zM234.531 39.503h35.236v56.585h-35.236zm-71.365 0h55.365v64.585a8 8 0 0 0 8 8h51.236a8 8 0 0 0 8-8V39.503h55.366v98.396c-42.119 3.817-75.756 37.453-79.573 79.572h-98.395V39.503zm185.968 126.322a8 8 0 0 1 8 8v10.135h17.82a8 8 0 0 1 0 16h-38.393c-4.827 0-8.755 3.928-8.755 8.755s3.928 8.755 8.755 8.755h25.144c13.65 0 24.756 11.105 24.756 24.755s-11.105 24.755-24.756 24.755h-4.571v10.135a8 8 0 0 1-16 0V266.98h-17.821a8 8 0 0 1 0-16h38.393c4.828 0 8.756-3.928 8.756-8.755s-3.928-8.755-8.756-8.755h-25.144c-13.649 0-24.755-11.105-24.755-24.755s11.105-24.755 24.755-24.755h4.572v-10.135a8 8 0 0 1 8-8zm134.594 154.153c-5.257-9.106-13.777-15.628-23.992-18.365-10.217-2.736-20.854-1.349-29.959 3.908l-88.799 51.268c-2.345-14.974-13.249-27.928-28.806-32.096l-133.841-35.862c-15.805-4.235-31.003-2.234-45.173 5.947l-31.452 18.159-2.547-4.411a8.006 8.006 0 0 0-4.857-3.728 8.008 8.008 0 0 0-6.07.799l-61.237 35.355a8 8 0 0 0-2.928 10.928l76.565 132.615a8.006 8.006 0 0 0 6.927 4 8 8 0 0 0 4-1.072l61.237-35.355a8 8 0 0 0 2.928-10.928l-3.709-6.425 14.628-8.446 124.218 25.92a39.936 39.936 0 0 0 10.111 1.311c6.833 0 13.565-1.786 19.619-5.28l128.68-74.293c9.105-5.257 15.627-13.777 18.364-23.991 2.738-10.213 1.349-20.853-3.907-29.958zM110.487 469.569 41.922 350.81l47.382-27.355 68.565 118.759zm361.694-123.773c-1.63 6.086-5.505 11.156-10.909 14.276l-128.68 74.293c-5.406 3.12-11.735 3.941-17.819 2.311a8.159 8.159 0 0 0-.437-.104l-127.414-26.587a7.997 7.997 0 0 0-5.634.903l-17.273 9.973-54.309-94.066 31.452-18.159c10.508-6.067 21.312-7.488 33.032-4.349l133.841 35.862c12.51 3.352 19.962 16.254 16.617 28.764l-.004.012c-1.615 6.028-5.509 11.083-10.965 14.233-5.458 3.149-11.782 3.995-17.811 2.38l-69.847-18.715a8 8 0 0 0-4.141 15.455l69.847 18.715a39.468 39.468 0 0 0 10.222 1.353c6.847 0 13.617-1.803 19.729-5.332 8.141-4.7 14.208-11.948 17.367-20.635l98.729-57.002c5.405-3.12 11.731-3.94 17.818-2.31 6.086 1.631 11.156 5.505 14.276 10.91 3.123 5.405 3.944 11.733 2.313 17.819z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                                </g>
                            </svg>
                        </span>
                        <span class="mx-3">Product Purchasers</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_orders.php">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                        </svg>
                        <span class="mx-3">Orders</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_products.php">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="mx-3">Products</span>
                    </a>

                    <a id="logoutButton1" class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="#">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                            <path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path>
                        </svg>
                        <span class="mx-3">Log out</span>
                    </a>
                </nav>
            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-600">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <div class="relative mx-4 lg:mx-0">
                            <h1 class="text-2xl font-semibold">Hello
                                <span><?php echo isset($_COOKIE['vendor_id']) ? $row['name'] . '!' : 'Vendor !' ?></span>
                            </h1>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                <img class="object-cover w-full h-full" src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/vendor_images/vendor_profile_image/' . $row['dp_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png' ?>" alt="Your avatar">
                            </button>
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
                            <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl divide-y-2 divide-gray-300 ring-2 ring-gray-300" style="display: none;">
                                <a href="vendor_profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Profile</a>
                                <a href="view_products.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Products</a>
                                <a id="logoutButton2" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- script for logout popup -->
                <script>
                    // Select elements
                    const logoutPopUp = document.getElementById('logoutPopUp');
                    const logoutButton1 = document.getElementById('logoutButton1');
                    const logoutButton2 = document.getElementById('logoutButton2');

                    // Function to show the logout popup
                    function showLogoutPopup() {
                        logoutPopUp.style.display = 'flex'; // Show the popup
                    }

                    // Function to hide the logout popup
                    function closePopup() {
                        logoutPopUp.style.display = 'none'; // Hide the popup
                    }

                    // Add click event listeners to logout buttons
                    logoutButton1.addEventListener('click', (event) => {
                        event.preventDefault();
                        showLogoutPopup();
                    });

                    logoutButton2.addEventListener('click', (event) => {
                        event.preventDefault();
                        showLogoutPopup();
                    });

                    // Add a global event listener to the Cancel button
                    document.addEventListener('click', (event) => {
                        if (event.target.matches('.cancel-button')) {
                            closePopup();
                        }
                    });
                </script>
                <main class="overflow-y-scroll scrollBar overflow-hidden">
                    <!-- component -->
                    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
                        <div class="container max-w-screen-lg font-medium text-gray-800 mx-auto">
                            <h1 class="text-2xl font-bold mb-6">Settings page</h1>
                            <div class="rounded p-4 px-4 md:p-8 mb-6">
                                <div class="lg:col-span-2">
                                    <form method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-start justify-between gap-4">
                                        <div class="space-y-3 bg-white w-full shadow-lg rounded-md m-auto md:w-max p-4 grid grid-cols-4 gap-3">
                                            <div class="col-span-4 flex flex-col items-center relative mt-3">
                                                <div class="w-full p-5">
                                                    <div class="w-full relative">
                                                        <div class="w-full relative">
                                                            <img id="CoverPreview" class="w-full h-44 z-50 object-cover" src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/vendor_images/vendor_cover_image/' . $row['cover_image'] : "https://t4.ftcdn.net/jpg/07/32/44/11/360_F_732441170_PtWNNaix37yGipnc2uDxLIAXH8VuzBPN.jpg" ?>" alt="">
                                                        </div>
                                                        <input class="hidden" name="CoverImage" type="file" id="Coverimage" onchange="coverImagePreview(event)">
                                                        <label for="Coverimage" class="absolute top-2 right-2 text-white bg-gray-600 flex items-center gap-1 max-w-max px-3 py-1 rounded-tl-lg rounded-br-lg cursor-pointer hover:bg-gray-700 transition duration-300">
                                                            <svg class="w-4 h-4 fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                                <g>
                                                                    <path d="M27.348 7h-4.294l-.5-1.5A3.645 3.645 0 0 0 19.089 3h-6.178a3.646 3.646 0 0 0-3.464 2.5L8.946 7H4.652A3.656 3.656 0 0 0 1 10.652v14.7A3.656 3.656 0 0 0 4.652 29h22.7A3.656 3.656 0 0 0 31 25.348v-14.7A3.656 3.656 0 0 0 27.348 7ZM29 25.348A1.654 1.654 0 0 1 27.348 27H4.652A1.654 1.654 0 0 1 3 25.348v-14.7A1.654 1.654 0 0 1 4.652 9h5.015a1 1 0 0 0 .948-.684l.729-2.187A1.65 1.65 0 0 1 12.911 5h6.178a1.649 1.649 0 0 1 1.567 1.13l.729 2.186a1 1 0 0 0 .948.684h5.015A1.654 1.654 0 0 1 29 10.652Z" fill="" opacity="1" data-original="#000000" class=""></path>
                                                                    <path d="M16 10a7.5 7.5 0 1 0 7.5 7.5A7.508 7.508 0 0 0 16 10Zm0 13a5.5 5.5 0 1 1 5.5-5.5A5.506 5.506 0 0 1 16 23Z" fill="" opacity="1" data-original="#000000" class=""></path>
                                                                    <circle cx="26" cy="12" r="1" fill="" opacity="1" data-original="#000000" class=""></circle>
                                                                </g>
                                                            </svg>
                                                            <h3 class="text-sm md:text-base">Edit</h3>
                                                        </label>
                                                    </div>
                                                    <!-- script for cover image preview and hide text (insert cover image) when cover image is inserted  -->
                                                    <script>
                                                        function coverImagePreview(event) {
                                                            const input = event.target;
                                                            const coverPreview = document.getElementById('CoverPreview');
                                                            const coverText = document.getElementById('coverText');

                                                            if (input.files && input.files[0]) {
                                                                const reader = new FileReader();
                                                                reader.onload = function(e) {
                                                                    coverPreview.src = e.target.result;
                                                                    coverPreview.classList.remove('hidden');
                                                                    coverText.classList.add('hidden');
                                                                };
                                                                reader.readAsDataURL(input.files[0]);
                                                            } else {
                                                                coverPreview.src = '';
                                                                coverPreview.classList.add('hidden');
                                                                coverText.classList.remove('hidden');
                                                            }
                                                        }
                                                    </script>
                                                    <div class="relative flex items-stretch justify-center -mt-10">
                                                        <img id="previewImage" class="w-20 h-20 rounded-full object-cover m-auto bg-white/20 p-2 filter backdrop-blur-2xl ring-1 ring-gray-500" alt="" src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/vendor_images/vendor_profile_image/' . $row['dp_image'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' ?>">
                                                        <input class="hidden" name="ProfileImage" type="file" id="imageInput">
                                                        <label for="imageInput" class="absolute bottom-0 translate-y-3 translate-x-[2px] rounded-full bg-white p-1 cursor-pointer">
                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                                <g>
                                                                    <g data-name="Layer 53">
                                                                        <path d="M22 9.25a.76.76 0 0 0-.75.75v6l-4.18-4.78a2.84 2.84 0 0 0-4.14 0l-2.87 3.28-.94-1.14a2.76 2.76 0 0 0-4.24 0l-2.13 2.57V6A3.26 3.26 0 0 1 6 2.75h8a.75.75 0 0 0 0-1.5H6A4.75 4.75 0 0 0 1.25 6v12a.09.09 0 0 0 0 .05A4.75 4.75 0 0 0 6 22.75h12a4.75 4.75 0 0 0 4.74-4.68V10a.76.76 0 0 0-.74-.75Zm-4 12H6a3.25 3.25 0 0 1-3.23-3L6 14.32a1.29 1.29 0 0 1 1.92 0l1.51 1.82a.74.74 0 0 0 .57.27.86.86 0 0 0 .57-.26l3.44-3.94a1.31 1.31 0 0 1 1.9 0l5.27 6A3.24 3.24 0 0 1 18 21.25Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                                                        <path d="M4.25 7A2.75 2.75 0 1 0 7 4.25 2.75 2.75 0 0 0 4.25 7Zm4 0A1.25 1.25 0 1 1 7 5.75 1.25 1.25 0 0 1 8.25 7ZM16 5.75h2.25V8a.75.75 0 0 0 1.5 0V5.75H22a.75.75 0 0 0 0-1.5h-2.25V2a.75.75 0 0 0-1.5 0v2.25H16a.75.75 0 0 0 0 1.5Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- script for profile image preview -->
                                                <script>
                                                    const imageInput = document.getElementById('imageInput');
                                                    const previewImage = document.getElementById('previewImage');

                                                    function previewSelectedImage() {
                                                        const file = imageInput.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.readAsDataURL(file);
                                                            reader.onload = function(e) {
                                                                previewImage.src = e.target.result;
                                                            }
                                                        }
                                                    }
                                                    imageInput.addEventListener('change', previewSelectedImage);


                                                    const Coverimage = document.getElementById('Coverimage');
                                                    const CoverPreview = document.getElementById('CoverPreview');

                                                    function previewCoverImage() {
                                                        const file = Coverimage.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.readAsDataURL(file);
                                                            reader.onload = function(e) {
                                                                CoverPreview.src = e.target.result;
                                                            }
                                                        }
                                                    }
                                                    Coverimage.addEventListener('change', previewCoverImage);
                                                </script>
                                            </div>
                                            <div class="col-span-full md:col-span-2">
                                                <label for="full_name" class="require">Full name:</label>
                                                <input type="text" name="full_name" id="full_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['name'] : '' ?>" />
                                                <small class="hidden text-red-500">Name is require</small>
                                                <small id="invalid-name-error" class="translate-x-1 text-red-500 inline-flex items-center gap-1 hidden">
                                                    <span>
                                                        <svg class="w-[14px]" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                            <g>
                                                                <path d="M256 0C114.62 0 0 114.62 0 256s114.62 256 256 256 256-114.62 256-256S397.38 0 256 0zm35.83 360.17A35.83 35.83 0 0 1 256 396a35.83 35.83 0 0 1-35.83-35.83A35.83 35.83 0 0 1 256 324.34a35.83 35.83 0 0 1 35.83 35.83zm4.76-206.87-4.73 119.44A35.89 35.89 0 0 1 256 307.2a35.89 35.89 0 0 1-35.86-34.46l-4.73-119.44a35.89 35.89 0 0 1 35.86-37.3h9.46a35.89 35.89 0 0 1 35.86 37.3z" data-name="Layer 2" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span>Invalid name format</span>
                                                </small>
                                            </div>

                                            <div class="col-span-full md:col-span-2">
                                                <label for="phone" class="require">Phone number:</label>
                                                <input type="number" name="phone" id="phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['phone'] : '' ?>" placeholder="" />
                                                <small class="hidden text-red-500">Phone number is require</small>
                                            </div>

                                            <div class="col-span-4">
                                                <label for="email" class="require">Email:</label>
                                                <input type="text" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['email'] : '' ?>" placeholder="" />
                                                <small class="hidden text-red-500">Email is require</small>
                                                <small id="invalid-email-error" class="text-red-500 inline-flex items-center gap-1 hidden">
                                                    <span>
                                                        <svg class="w-[14px]" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                            <g>
                                                                <path d="M256 0C114.62 0 0 114.62 0 256s114.62 256 256 256 256-114.62 256-256S397.38 0 256 0zm35.83 360.17A35.83 35.83 0 0 1 256 396a35.83 35.83 0 0 1-35.83-35.83A35.83 35.83 0 0 1 256 324.34a35.83 35.83 0 0 1 35.83 35.83zm4.76-206.87-4.73 119.44A35.89 35.89 0 0 1 256 307.2a35.89 35.89 0 0 1-35.86-34.46l-4.73-119.44a35.89 35.89 0 0 1 35.86-37.3h9.46a35.89 35.89 0 0 1 35.86 37.3z" data-name="Layer 2" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span>Invalid email format.</span>
                                                </small>
                                            </div>

                                            <div class="col-span-full md:col-span-2">
                                                <label for="userName" class="require">Store Name:</label>
                                                <input type="text" name="userName" id="userName" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['username'] : '' ?>" placeholder="" />
                                                <small class="hidden text-red-500">Username is require</small>
                                            </div>

                                            <div class="col-span-full md:col-span-2">
                                                <label for="gst" class="require">GST:</label>
                                                <input type="text" name="gst" id="gst" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['GST'] : '' ?>" placeholder="" />
                                                <small class="hidden text-red-500">GST no is require</small>
                                            </div>
                                            <div class="col-span-4">
                                                <div class="flex flex-col gap-1">
                                                    <label for="location" class="require font-semibold">Enter Location :</label>
                                                    <div id="map" class="map"></div>
                                                    <div id="searchBox"></div>
                                                    <input type="text" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['latitude'] : '' ?>" name="lat" id="lat" class="hidden">
                                                    <input type="text" value="<?php echo isset($_COOKIE['vendor_id']) ? $row['longitude'] : '' ?>" name="lng" id="lng" class="hidden">
                                                </div>
                                                <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
                                                <script>
                                                    tt.setProductInfo("hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw", "6.25.0");
                                                    let map = tt.map({
                                                        key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                                                        container: "map",
                                                    });

                                                    var options = {
                                                        searchOptions: {
                                                            key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                                                            language: "en-GB",
                                                            limit: 5,
                                                        },
                                                        autocompleteOptions: {
                                                            key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                                                            language: "en-GB",
                                                        },
                                                    };

                                                    let searchBox = document.getElementById('searchBox');
                                                    var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
                                                    var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
                                                    searchBox.append(searchBoxHTML);

                                                    let formAddress = <?php echo json_encode($formAddress); ?>;
                                                    let inputField = searchBox.querySelector('input');
                                                    if (inputField) {
                                                        inputField.value = formAddress;

                                                        let initialValue = formAddress;

                                                        inputField.addEventListener('blur', function() {
                                                            if (inputField.value === '') {
                                                                inputField.value = initialValue;
                                                            }
                                                        });
                                                    }

                                                    // // Handle search result selection
                                                    ttSearchBox.on('tomtom.searchbox.resultselected', function(event) {
                                                        const selectedResult = event.data.result;
                                                        const coordinates = selectedResult.position;

                                                        let clat = coordinates.lat;
                                                        let clng = coordinates.lng;

                                                        document.getElementById('lat').value = clat;
                                                        document.getElementById('lng').value = clng;
                                                    });
                                                </script>
                                            </div>

                                            <div class="col-span-4">
                                                <label for="bio" class="require">Bio:</label>
                                                <textarea name="bio" id="bio" class="h-32 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600 resize-none"><?php echo isset($_COOKIE['vendor_id']) ? $row['Bio'] : '' ?></textarea>
                                                <small class="hidden text-red-500">Bio is require</small>
                                            </div>

                                            <div class="col-span-4 text-right mt-7">
                                                <div class="inline-flex items-end">
                                                    <button type="submit" value="Update" name="updateBtn" class="bg-green-600 hover:bg-green-700 text-white w-28 py-2 px-4 rounded-tl-lg rounded-br-lg cursor-pointer">Update</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-white max-h-max rounded-md shadow-lg p-8">
                                            <div>
                                                <h1 class="font-semibold text-2xl">Password</h1>
                                            </div>
                                            <div class="mt-12">
                                                <div class="flex flex-col gap-1 relative" x-data="{ showPassword: false }">
                                                    <label for="current_pass" class="require">Current password:</label>
                                                    <input name="current_pass" id="current_pass" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:border-gray-500 focus:ring-2 focus:ring-gray-500" :type="showPassword ? 'text' : 'password'">
                                                    <span class="absolute top-[2.5rem] right-2.5 cursor-pointer" @click="showPassword = !showPassword">
                                                        <!-- Show Icon (when password is hidden) -->
                                                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                            <g>
                                                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" fill="#000000" opacity="1" data-original="#000000"></path>
                                                            </g>
                                                        </svg>

                                                        <!-- Hide Icon (when password is visible) -->
                                                        <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 128 128" style="fill: rgba(0, 0, 0, 1);">
                                                            <path d="m79.891 65.078 7.27-7.27C87.69 59.787 88 61.856 88 64c0 13.234-10.766 24-24 24-2.144 0-4.213-.31-6.192-.839l7.27-7.27a15.929 15.929 0 0 0 14.813-14.813zm47.605-3.021c-.492-.885-7.47-13.112-21.11-23.474l-5.821 5.821c9.946 7.313 16.248 15.842 18.729 19.602C114.553 71.225 95.955 96 64 96c-4.792 0-9.248-.613-13.441-1.591l-6.573 6.573C50.029 102.835 56.671 104 64 104c41.873 0 62.633-36.504 63.496-38.057a3.997 3.997 0 0 0 0-3.886zm-16.668-39.229-88 88C22.047 111.609 21.023 112 20 112s-2.047-.391-2.828-1.172a3.997 3.997 0 0 1 0-5.656l11.196-11.196C10.268 83.049 1.071 66.964.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24c10.827 0 20.205 2.47 28.222 6.122l12.95-12.95c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656zM34.333 88.011 44.46 77.884C41.663 73.96 40 69.175 40 64c0-13.234 10.766-24 24-24 5.175 0 9.96 1.663 13.884 4.459l8.189-8.189C79.603 33.679 72.251 32 64 32 32.045 32 13.447 56.775 8.707 63.994c3.01 4.562 11.662 16.11 25.626 24.017zm15.934-15.935 21.809-21.809C69.697 48.862 66.958 48 64 48c-8.822 0-16 7.178-16 16 0 2.958.862 5.697 2.267 8.076z"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="mt-4 relative" x-data="{ showPassword: false }">
                                                    <label for="new_pass" class="require">New password:</label>
                                                    <input name="new_pass" id="new_pass" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:border-gray-500 focus:ring-2 focus:ring-gray-500" x-bind:type="showPassword ? 'text' : 'password'">
                                                    <span class="absolute top-[2.3rem] right-2.5 cursor-pointer" @click="showPassword = !showPassword">
                                                        <!-- Show Icon (when password is hidden) -->
                                                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                            <g>
                                                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" fill="#000000" opacity="1" data-original="#000000"></path>
                                                            </g>
                                                        </svg>

                                                        <!-- Hide Icon (when password is visible) -->
                                                        <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 128 128" style="fill: rgba(0, 0, 0, 1);">
                                                            <path d="m79.891 65.078 7.27-7.27C87.69 59.787 88 61.856 88 64c0 13.234-10.766 24-24 24-2.144 0-4.213-.31-6.192-.839l7.27-7.27a15.929 15.929 0 0 0 14.813-14.813zm47.605-3.021c-.492-.885-7.47-13.112-21.11-23.474l-5.821 5.821c9.946 7.313 16.248 15.842 18.729 19.602C114.553 71.225 95.955 96 64 96c-4.792 0-9.248-.613-13.441-1.591l-6.573 6.573C50.029 102.835 56.671 104 64 104c41.873 0 62.633-36.504 63.496-38.057a3.997 3.997 0 0 0 0-3.886zm-16.668-39.229-88 88C22.047 111.609 21.023 112 20 112s-2.047-.391-2.828-1.172a3.997 3.997 0 0 1 0-5.656l11.196-11.196C10.268 83.049 1.071 66.964.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24c10.827 0 20.205 2.47 28.222 6.122l12.95-12.95c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656zM34.333 88.011 44.46 77.884C41.663 73.96 40 69.175 40 64c0-13.234 10.766-24 24-24 5.175 0 9.96 1.663 13.884 4.459l8.189-8.189C79.603 33.679 72.251 32 64 32 32.045 32 13.447 56.775 8.707 63.994c3.01 4.562 11.662 16.11 25.626 24.017zm15.934-15.935 21.809-21.809C69.697 48.862 66.958 48 64 48c-8.822 0-16 7.178-16 16 0 2.958.862 5.697 2.267 8.076z"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="mt-4 relative" x-data="{ showPassword: false }">
                                                    <label for="re_pass" class="require">Confirm password:</label>
                                                    <input name="re_pass" id="re_pass" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:border-gray-500 focus:ring-2 focus:ring-gray-500" x-bind:type="showPassword ? 'text' : 'password'">
                                                    <span class="absolute top-[2.3rem] right-2.5 cursor-pointer" @click="showPassword = !showPassword">
                                                        <!-- Show Icon (when password is hidden) -->
                                                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                                            <g>
                                                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" fill="#000000" opacity="1" data-original="#000000"></path>
                                                            </g>
                                                        </svg>

                                                        <!-- Hide Icon (when password is visible) -->
                                                        <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 128 128" style="fill: rgba(0, 0, 0, 1);">
                                                            <path d="m79.891 65.078 7.27-7.27C87.69 59.787 88 61.856 88 64c0 13.234-10.766 24-24 24-2.144 0-4.213-.31-6.192-.839l7.27-7.27a15.929 15.929 0 0 0 14.813-14.813zm47.605-3.021c-.492-.885-7.47-13.112-21.11-23.474l-5.821 5.821c9.946 7.313 16.248 15.842 18.729 19.602C114.553 71.225 95.955 96 64 96c-4.792 0-9.248-.613-13.441-1.591l-6.573 6.573C50.029 102.835 56.671 104 64 104c41.873 0 62.633-36.504 63.496-38.057a3.997 3.997 0 0 0 0-3.886zm-16.668-39.229-88 88C22.047 111.609 21.023 112 20 112s-2.047-.391-2.828-1.172a3.997 3.997 0 0 1 0-5.656l11.196-11.196C10.268 83.049 1.071 66.964.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24c10.827 0 20.205 2.47 28.222 6.122l12.95-12.95c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656zM34.333 88.011 44.46 77.884C41.663 73.96 40 69.175 40 64c0-13.234 10.766-24 24-24 5.175 0 9.96 1.663 13.884 4.459l8.189-8.189C79.603 33.679 72.251 32 64 32 32.045 32 13.447 56.775 8.707 63.994c3.01 4.562 11.662 16.11 25.626 24.017zm15.934-15.935 21.809-21.809C69.697 48.862 66.958 48 64 48c-8.822 0-16 7.178-16 16 0 2.958.862 5.697 2.267 8.076z"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="mt-5 flex justify-end">
                                                    <input type="submit" name="changePass" value="Update" class="bg-green-600 hover:bg-green-700 text-white w-28 py-2 px-4 rounded-tl-lg rounded-br-lg cursor-pointer">
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        function validateForm() {
                                            // Get input fields and error messages
                                            const fullName = document.getElementById("full_name");
                                            const phone = document.getElementById("phone");
                                            const email = document.getElementById("email");
                                            const userName = document.getElementById("userName");
                                            const gst = document.getElementById("gst");
                                            const bio = document.getElementById("bio");

                                            const fullNameError = fullName.nextElementSibling;
                                            const fullNameFormatError = fullNameError.nextElementSibling;
                                            const phoneError = phone.nextElementSibling;
                                            const emailError = email.nextElementSibling;
                                            const emailFormatError = emailError.nextElementSibling;
                                            const userNameError = userName.nextElementSibling;
                                            const gstError = gst.nextElementSibling;
                                            const bioError = bio.nextElementSibling;

                                            // Regular expressions for validation
                                            const nameRegex = /^[A-Za-z\s]+$/; // Full name format (letters and spaces)
                                            const phoneRegex = /^[0-9]{10}$/; // Phone format (10 digits)
                                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email format
                                            const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}[Z]{1}[A-Z0-9]{1}$/; // GST format

                                            let isValid = true;

                                            // Helper function to validate a field and show/hide error messages
                                            function validateField(input, errorElement, formatErrorElement, regex = null) {
                                                if (input.value.trim() === "") {
                                                    errorElement.classList.remove("hidden");
                                                    if (formatErrorElement) formatErrorElement.classList.add("hidden");
                                                    isValid = false;
                                                } else if (regex && !regex.test(input.value.trim())) {
                                                    errorElement.classList.add("hidden");
                                                    if (formatErrorElement) formatErrorElement.classList.remove("hidden");
                                                    isValid = false;
                                                } else {
                                                    errorElement.classList.add("hidden");
                                                    if (formatErrorElement) formatErrorElement.classList.add("hidden");
                                                }
                                            }

                                            // Validate each field
                                            validateField(fullName, fullNameError, fullNameFormatError, nameRegex);
                                            validateField(phone, phoneError, null, phoneRegex);
                                            validateField(email, emailError, emailFormatError, emailRegex);
                                            validateField(userName, userNameError, null);
                                            validateField(gst, gstError, null, gstRegex);
                                            validateField(bio, bioError, null);

                                            return isValid;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

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
            }, 1800);
        }

        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');

            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = "vendor_account.php";
            }, 2000);
        }
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>

<?php
if (isset($_POST['updateBtn'])) {
    $CoverImage = $_FILES['CoverImage']['name'];
    $tempname = $_FILES['CoverImage']['tmp_name'];
    $folder = '../src/vendor_images/vendor_cover_image/' . $CoverImage;

    $ProfileImage = $_FILES['ProfileImage']['name'];
    $tempname2 = $_FILES['ProfileImage']['tmp_name'];
    $folder2 = '../src/vendor_images/vendor_profile_image/' . $ProfileImage;

    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $userName = $_POST['userName'];
    $gst = $_POST['gst'];
    $bio = $_POST['bio'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $updateVenodr = "UPDATE vendor_registration SET name='$full_name', email='$email', username='$userName', phone='$phone', Bio='$bio', GST='$gst', latitude='$lat', longitude='$lng' WHERE vendor_id = '$vendor_id'";
    $update_query = mysqli_query($con, $updateVenodr);

    if ($update_query) {
        // Check for Cover file upload
        if (move_uploaded_file($tempname, $folder)) {
            $vendor_id = $_COOKIE['vendor_id'];
            $update_cover = "UPDATE vendor_registration SET cover_image='$CoverImage' WHERE vendor_id = '$vendor_id'";
            $updatedcover_query = mysqli_query($con, $update_cover);

            if ($updatedcover_query) {
                echo '<script>loader()</script>';
                echo '<script>displaySuccessMessage("Image Updated Properly.");</script>';
            } else {
                echo '<script>displayErrorMessage("Enter Valid Data.");</script>';
            }
        }
        // Check for profile file upload
        else if (move_uploaded_file($tempname2, $folder2)) {
            $vendor_id = $_COOKIE['vendor_id'];
            $update_dp = "UPDATE vendor_registration SET dp_image='$ProfileImage' WHERE vendor_id = '$vendor_id'";
            $updatedp_query = mysqli_query($con, $update_dp);

            if ($updatedp_query) {
                echo '<script>loader()</script>';
                echo '<script>displaySuccessMessage("Image Updated Properly.");</script>';
            } else {
                echo '<script>displayErrorMessage("Enter Valid Data.");</script>';
            }
        }
        // Check for Cover and profile file upload
        else if (move_uploaded_file($tempname, $folder) && move_uploaded_file($tempname2, $folder2)) {
            $vendor_id = $_COOKIE['vendor_id'];
            $update_img = "UPDATE vendor_registration SET cover_image='$CoverImage', dp_image='$ProfileImage' WHERE vendor_id = '$vendor_id'";
            $update_img_query = mysqli_query($con, $update_img);

            if ($update_img_query) {
                echo '<script>loader()</script>';
                echo '<script>displaySuccessMessage("Image Updated Properly.");</script>';
            } else {
                echo '<script>displayErrorMessage("Enter Valid Data.");</script>';
            }
        } else {
            echo '<script>loader()</script>';
            echo '<script>displaySuccessMessage("Data Updated Properly.");</script>';
        }
    } else {
        echo '<script>displayErrorMessage("Data Not Updated Properly.");</script>';
    }
}

// update Password
if (isset($_POST['changePass'])) {

    $dpass = $row['password'];

    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $re_pass = $_POST['re_pass'];

    $decod_pass = password_verify($current_pass, $dpass);

    if ($decod_pass) {
        if ($new_pass === $re_pass) {
            $new_dpass = password_hash($new_pass, PASSWORD_BCRYPT);

            $up_pass = "UPDATE vendor_registration SET password = '$new_dpass' WHERE vendor_id = '$vendor_id'";
            $up_query = mysqli_query($con, $up_pass);

            if ($up_query) {
                echo '<script>loader()</script>';
                echo '<script>displaySuccessMessage("Password Updated Successfully.");</script>';
            } else {
                echo '<script>displayErrorMessage("Password Not Update.");</script>';
            }
        } else {
            echo '<script>displayErrorMessage("The new password and the re-typed password do not match. Please try again.");</script>';
        }
    } else {
        echo '<script>displayErrorMessage("Current password does not match. Please try again.");</script>';
    }
}
?>