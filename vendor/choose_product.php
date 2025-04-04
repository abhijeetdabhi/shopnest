<?php

session_start();

if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}

if (isset($_SESSION['same_id'])) {
    unset($_SESSION['same_id']);
}

if (isset($_SESSION['full_name'])) {
    unset($_SESSION['full_name']);
}
if (isset($_SESSION['Company_name'])) {
    unset($_SESSION['Company_name']);
}
if (isset($_SESSION['type'])) {
    unset($_SESSION['type']);
}
if (isset($_SESSION['your_price'])) {
    unset($_SESSION['your_price']);
}
if (isset($_SESSION['MRP'])) {
    unset($_SESSION['MRP']);
}
if (isset($_SESSION['quantity'])) {
    unset($_SESSION['quantity']);
}
if (isset($_SESSION['condition'])) {
    unset($_SESSION['condition']);
}
if (isset($_SESSION['description'])) {
    unset($_SESSION['description']);
}
if (isset($_SESSION['color'])) {
    unset($_SESSION['color']);
}
?>

<?php
include "../include/connect.php";

if (isset($_COOKIE['vendor_id'])) {
    $vendor_id = $_COOKIE['vendor_id'];

    $retrieve_data = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);

    if (!isset($_SESSION['existingOrder'])) {
        $_SESSION['existingOrder'] = 0;
    }
    
    $newData = "SELECT * FROM orders WHERE vendor_id = '$vendor_id' AND status = 'pending'";
    $newDataQuery = mysqli_query($con, $newData);
    
    $newCount = mysqli_num_rows($newDataQuery);
    
    $_SESSION['currentOrder'] = $newCount;
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

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Add Products</title>

    <style>
        #logoutPopUp {
            display: none;
        }

        [x-cloak] {
            display: none;
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

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="vendor_account.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                            <g>
                                <path d="M11.5 20.263H2.95a.2.2 0 0 1-.2-.2v-1.451c0-.83.593-1.562 1.507-2.184 1.632-1.114 4.273-1.816 7.243-1.816a.75.75 0 0 0 0-1.5c-3.322 0-6.263.831-8.089 2.076-1.393.95-2.161 2.157-2.161 3.424v1.451a1.7 1.7 0 0 0 1.7 1.7h8.55a.75.75 0 1 0 0-1.5zM11.5 1.25C8.464 1.25 6 3.714 6 6.75s2.464 5.5 5.5 5.5S17 9.786 17 6.75s-2.464-5.5-5.5-5.5zm0 1.5c2.208 0 4 1.792 4 4s-1.792 4-4 4-4-1.792-4-4 1.792-4 4-4zM17.5 13.938a3.564 3.564 0 0 0 0 7.125c1.966 0 3.563-1.597 3.563-3.563s-1.597-3.562-3.563-3.562zm0 1.5c1.138 0 2.063.924 2.063 2.062s-.925 2.063-2.063 2.063-2.063-.925-2.063-2.063.925-2.062 2.063-2.062z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M18.25 14.687V13a.75.75 0 0 0-1.5 0v1.688a.75.75 0 0 0 1.5-.001zM20.019 16.042l1.193-1.194a.749.749 0 1 0-1.06-1.06l-1.194 1.193a.752.752 0 0 0 0 1.061.752.752 0 0 0 1.061 0zM20.312 18.25H22a.75.75 0 0 0 0-1.5h-1.688a.75.75 0 0 0 0 1.5zM18.958 20.019l1.194 1.193a.749.749 0 1 0 1.06-1.06l-1.193-1.194a.752.752 0 0 0-1.061 0 .752.752 0 0 0 0 1.061zM16.75 20.312V22a.75.75 0 0 0 1.5 0v-1.688a.75.75 0 0 0-1.5 0zM14.981 18.958l-1.193 1.194a.749.749 0 1 0 1.06 1.06l1.194-1.193a.752.752 0 0 0 0-1.061.752.752 0 0 0-1.061 0zM14.687 16.75H13a.75.75 0 0 0 0 1.5h1.687a.75.75 0 1 0 0-1.5zM16.042 14.981l-1.194-1.193a.749.749 0 1 0-1.06 1.06l1.193 1.194a.752.752 0 0 0 1.061 0 .752.752 0 0 0 0-1.061z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Account setting</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="choose_product.php">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="order_request.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M124 53h-8a4.004 4.004 0 0 0-4 4v2.068l-2.51.07a1.802 1.802 0 0 0-.145.008 4.268 4.268 0 0 1-4.134-1.46A17.653 17.653 0 0 0 92.17 52l-20.487.126a7.058 7.058 0 0 0-4.982 2.034 5.591 5.591 0 0 0-1.646 3.996c.045 3.272 3.056 5.92 6.724 5.92h.04l9.583-.062H86l5.259 9.303a2 2 0 0 0 3.482-1.968l-5.833-10.32a2 2 0 0 0-1.741-1.015l-15.37.062h-.019c-1.463 0-2.708-.901-2.722-1.972a1.622 1.622 0 0 1 .503-1.144 3.038 3.038 0 0 1 2.152-.834L92.196 56a13.456 13.456 0 0 1 10.081 4.404 8.001 8.001 0 0 0 6.244 2.787q.557 0 1.15-.057l2.329-.065v21.467l-1.98-.074a8.11 8.11 0 0 0-7.364 2.828 13.259 13.259 0 0 1-9.936 4.518l-8.72.055V68.605l-.334-.591h-2.263L80 68.023V98H61.698A5.806 5.806 0 0 0 56 103.896V124H5.999A1.973 1.973 0 0 1 4 122.058V5.942A1.973 1.973 0 0 1 5.999 4h72.002A1.973 1.973 0 0 1 80 5.942v42.133l4-.025V5.942A5.978 5.978 0 0 0 78.001 0H5.999A5.978 5.978 0 0 0 0 5.942v116.116A5.978 5.978 0 0 0 5.999 128h51.076a2 2 0 0 0 1.424-.595l24.925-25.252a2.002 2.002 0 0 0 .576-1.405v-4.885l8.745-.055a17.442 17.442 0 0 0 12.9-5.859 4.16 4.16 0 0 1 4.076-1.498l.101.007 2.178.081V91a4.004 4.004 0 0 0 4 4h8a4.004 4.004 0 0 0 4-4V57a4.004 4.004 0 0 0-4-4Zm-64 67.19v-16.294A1.807 1.807 0 0 1 61.698 102h16.257ZM124 91h-8V57h8Z" fill="CurrentColor" opacity="1" data-original="#000000" class=""></path>
                                <path d="M58 15a2 2 0 0 0 0-4H26a2 2 0 0 0 0 4ZM72 23H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM72 31H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM74 45a2 2 0 0 0-2-2H32a2 2 0 0 0 0 4h40a2 2 0 0 0 2-2ZM72 71H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM72 83H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM74 93a2 2 0 0 0-2-2H32a2 2 0 0 0 0 4h40a2 2 0 0 0 2-2ZM62.464 63H32a2 2 0 0 0 0 4h35.006a10.57 10.57 0 0 1-4.542-4ZM32 55h29.587a9.768 9.768 0 0 1 2.259-3.64c.124-.127.26-.24.391-.36H32a2 2 0 0 0 0 4ZM10 117h28a2 2 0 0 0 0-4H10a2 2 0 0 0 0 4ZM16 37a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4ZM16 57a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4ZM16 77a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4ZM16 97a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4Z" fill="CurrentColor" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Orders Request</span>
                        <span id="order-dot" class="relative flex size-2" style="display: none;">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                        </span>
                        <script>
                            function checkNewOrder() {
                                $.ajax({
                                    url: 'orderNotification.php',
                                    method: 'POST',
                                    data: { checkNewOrder: true },
                                    success: function(response) {
                                        const newOrder = JSON.parse(response);
                                        if (newOrder === 1) {
                                            $('#order-dot').show();
                                        } else {
                                            $('#order-dot').hide();
                                        }
                                    }
                                });
                            }

                            $(document).ready(function() {
                                checkNewOrder();
                                setInterval(checkNewOrder, 5000);
                            });
                        </script>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="rejected_orders.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 511.792 511.792" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M496.085 120.75 120.75 496.085c-10.943 10.943-28.685 10.943-39.629 0l-65.414-65.414c-10.943-10.943-10.943-28.685 0-39.629L391.042 15.707c10.943-10.943 28.685-10.943 39.629 0l65.414 65.414c10.943 10.944 10.943 28.686 0 39.629z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="currentColor" class=""></path>
                                <path d="M97.244 249.153 296.531 49.866c16.666-16.666 43.686-16.666 60.352 0h0L49.866 356.883h0c-16.666-16.666-16.666-43.686 0-60.352l24.459-24.459M392.502 284.685l69.424-69.424c16.666-16.666 16.666-43.686 0-60.352h0L154.909 461.926h0c16.666 16.666 43.686 16.666 60.352 0L366.927 310.26M198.246 345.645s8.962.028 11.126-7.537c1.068-3.733-.054-7.751-2.799-10.497l-29.904-29.904M142.417 332.302l-15.621 15.621 37.073 37.074 15.621-15.622M159.802 351.99l-14.47 14.47M216.957 257.762l-15.621 15.621 37.073 37.074 15.621-15.622M234.342 277.451l-14.47 14.469M343.069 131.65l-15.621 15.621 37.073 37.074 15.621-15.622M360.454 151.339l-14.47 14.469M366.927 108.632l35.681 35.681M409.989 101.803c10.004 10.004 12.368 23.473 3.713 32.436-2.881 2.984-10.431 10.591-10.431 10.591s-13.199-13.104-18.241-18.147c-4.142-4.142-18.141-18.088-18.141-18.088l10.283-10.283c9.663-9.663 22.813-6.513 32.817 3.491zM269.491 211.276a26.33 26.33 0 0 0-13.654 7.265c-10.332 10.332-10.332 27.083 0 37.415s27.083 10.332 37.415 0c4.196-4.196 6.266-9.029 6.553-13.982a21.338 21.338 0 0 0-.048-3.085M285.288 189.089l20.663-20.662M296.772 179.994l36.221 36.221M107.165 406.328l33.574 2.14M83.095 391.282l37.415 37.415M113.048 380.777c5.37 5.37 5.015 14.433-.55 19.998-2.76 2.76-9.83 9.916-9.83 9.916s-7.104-7.015-9.811-9.722c-2.223-2.223-9.749-9.699-9.749-9.699l9.942-9.942c5.565-5.566 14.628-5.921 19.998-.551z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="currentColor" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Rejected Orders</span>
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
                            <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl ring-2 ring-gray-300 divide-y-2 divide-gray-300" style="display: none;">
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
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 px-6 py-8 md:p-8">
                    <h1 class="mb-8 font-semibold text-3xl">Add your products</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-6">
                        <a href="add_product.php?name=Phones" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M366 0H146c-20.678 0-37.5 16.822-37.5 37.5v437c0 20.678 16.822 37.5 37.5 37.5h220c20.678 0 37.5-16.822 37.5-37.5v-437C403.5 16.822 386.678 0 366 0zm22.5 407H176a7.5 7.5 0 0 0 0 15h212.5v52.5c0 12.407-10.093 22.5-22.5 22.5H146c-12.407 0-22.5-10.093-22.5-22.5V422H146a7.5 7.5 0 0 0 0-15h-22.5V75h265v332zm0-347h-265V37.5c0-12.407 10.093-22.5 22.5-22.5h220c12.407 0 22.5 10.093 22.5 22.5V60z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M286 30h-30a7.5 7.5 0 0 0 0 15h30a7.5 7.5 0 0 0 0-15zM256 437c-12.407 0-22.5 10.093-22.5 22.5S243.593 482 256 482s22.5-10.093 22.5-22.5S268.407 437 256 437zm0 30c-4.136 0-7.5-3.364-7.5-7.5s3.364-7.5 7.5-7.5 7.5 3.364 7.5 7.5-3.364 7.5-7.5 7.5z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <circle cx="226" cy="37.5" r="7.5" fill="#000000" opacity="1" data-original="#000000" class=""></circle>
                                </g>
                            </svg>
                            <h1>Phones</h1>
                        </a>
                        <a href="add_product.php?name=Tabs/Ipad" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <defs>
                                        <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                            <path d="M0 512h512V0H0Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        </clipPath>
                                    </defs>
                                    <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                        <path d="M0 0v-367.89c0-20.102 16.296-36.399 36.399-36.399h304.059c20.103 0 36.399 16.297 36.399 36.399V56.4c0 20.103-16.296 36.399-36.399 36.399H36.399C16.296 92.799 0 76.503 0 56.4V30" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(67.571 411.745)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0v283.378h317.13V173.024" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(97.435 167.227)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0v-230.228h-317.13v57.204" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(414.565 310.252)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0c0 8.477-6.872 15.348-15.348 15.348-8.477 0-15.348-6.871-15.348-15.348s6.871-15.348 15.348-15.348C-6.872-15.348 0-8.477 0 0Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(271.348 45.515)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0h34.184" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(254.22 477.727)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0v0" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(225.583 477.727)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                    </g>
                                </g>
                            </svg>
                            <h1>Tabs/Ipad</h1>
                        </a>
                        <a href="add_product.php?name=Laptops/MacBook" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M511.976 416.063c-.005-.075-.004-.149-.011-.224a7.343 7.343 0 0 0-.131-.873c-.006-.028-.015-.056-.022-.084a7.268 7.268 0 0 0-.218-.768c-.023-.067-.048-.132-.073-.198a7.221 7.221 0 0 0-.284-.663c-.018-.038-.03-.077-.049-.115l-40.112-79.118V73.72c0-8.006-6.513-14.519-14.519-14.519H55.441c-8.006 0-14.519 6.513-14.519 14.519v260.298L.811 413.137c-.019.038-.031.077-.049.115a7.618 7.618 0 0 0-.284.662c-.025.066-.05.132-.073.199a7.626 7.626 0 0 0-.218.77l-.021.081a7.391 7.391 0 0 0-.131.874c-.007.074-.007.149-.011.223-.01.156-.024.31-.024.468v19.026c0 9.509 7.735 17.244 17.244 17.244h477.512c9.509 0 17.244-7.735 17.244-17.244v-19.026c0-.158-.014-.312-.024-.466zM55.923 74.203h400.154v254.109H55.923V74.203zm-2.894 269.108H458.97l33.318 65.717h-164.78l-8.271-29.989c-1.684-6.105-7.282-10.369-13.615-10.369h-99.246c-6.333 0-11.932 4.264-13.615 10.368l-8.271 29.99H19.711l33.318-65.717zm258.919 65.718H200.052l6.993-25.358h97.91l6.993 25.358zM497 435.554a2.247 2.247 0 0 1-2.244 2.244H17.244A2.247 2.247 0 0 1 15 435.554v-11.526h482v11.526z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M432.577 213.756a7.499 7.499 0 0 0-7.5 7.5v76.055H86.923v-76.055c0-4.143-3.357-7.5-7.5-7.5a7.499 7.499 0 0 0-7.5 7.5v79.294c0 6.485 5.275 11.761 11.761 11.761h344.633c6.485 0 11.761-5.275 11.761-11.761v-79.294a7.502 7.502 0 0 0-7.501-7.5zM428.316 90.203H83.684c-6.485 0-11.761 5.275-11.761 11.761v79.294c0 4.143 3.357 7.5 7.5 7.5s7.5-3.357 7.5-7.5v-76.055h338.154v76.055c0 4.143 3.357 7.5 7.5 7.5s7.5-3.357 7.5-7.5v-79.294c0-6.487-5.275-11.761-11.761-11.761z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Laptops/MacBook</h1>
                        </a>
                        <a href="add_product.php?name=TV" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <g data-name="Layer 3">
                                        <path d="M61 8H3a3 3 0 0 0-3 3v32a3 3 0 0 0 3 3h25v4h-2a5.006 5.006 0 0 0-5 5 1 1 0 0 0 1 1h20a1 1 0 0 0 1-1 5.006 5.006 0 0 0-5-5h-2v-4h7a1 1 0 0 0 0-2H3a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h58a1 1 0 0 1 1 1v8a1 1 0 0 0 2 0v-8a3 3 0 0 0-3-3zM40.829 54H23.171A3.006 3.006 0 0 1 26 52h12a3.006 3.006 0 0 1 2.829 2zM34 46v4h-4v-4z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M61 56H49a3 3 0 0 1-3-3V25a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v28a3 3 0 0 1-3 3zM49 24a1 1 0 0 0-1 1v28a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V25a1 1 0 0 0-1-1z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M55 48a5 5 0 1 1 5-5 5.006 5.006 0 0 1-5 5zm0-8a3 3 0 1 0 3 3 3 3 0 0 0-3-3z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <circle cx="51" cy="27" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="55" cy="27" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="59" cy="27" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="51" cy="31" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="55" cy="31" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="59" cy="31" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="51" cy="35" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="55" cy="35" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="59" cy="35" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="51" cy="51" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="55" cy="51" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                        <circle cx="59" cy="51" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    </g>
                                </g>
                            </svg>
                            <h1>TV</h1>
                        </a>
                        <a href="add_product.php?name=Headphone" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M256 0c-34.181 0-67.258 6.984-98.315 20.759-29.987 13.3-56.62 32.242-79.16 56.298a7.485 7.485 0 0 0 .344 10.579c3.016 2.829 7.752 2.671 10.579-.344C132.514 41.33 193.221 14.969 256 14.969c125.875 0 228.281 102.407 228.281 228.281 0 55.179-19.918 137.714-50.743 210.268a10.425 10.425 0 0 1-9.608 6.357 10.363 10.363 0 0 1-5.334-1.48l33.904-97.719c2.826-8.15 2.041-17.11-2.029-24.606 8.469-35.276 12.95-67.356 12.95-92.821 0-18.269-2.405-36.44-7.147-54.01a8.753 8.753 0 0 0-.104-.35c-12.269-37.977-38.577-72.145-74.077-96.21C345.602 67.944 302 54.869 256 54.869s-89.602 13.075-126.093 37.812c-35.5 24.065-61.808 58.233-74.077 96.21a8.753 8.753 0 0 0-.104.35 207.334 207.334 0 0 0-7.147 54.01c0 25.493 4.483 57.535 12.953 92.815-4.073 7.496-4.86 16.459-2.033 24.611l33.903 97.719a10.61 10.61 0 0 1-1.262.644c-5.292 2.251-11.429-.228-13.679-5.521-30.824-72.555-50.742-155.09-50.742-210.269 0-47.387 14.448-92.861 41.783-131.508a7.483 7.483 0 0 0-1.788-10.432 7.482 7.482 0 0 0-10.432 1.788C28.148 144.286 12.75 192.751 12.75 243.25c0 57.031 20.386 141.864 51.936 216.122 4.104 9.659 13.524 15.466 23.411 15.466 3.308 0 6.667-.65 9.896-2.022.12-.051.236-.111.355-.164l2.98 8.59a30.614 30.614 0 0 0 20.163 19.269l33.815 10.042a34.698 34.698 0 0 0 9.891 1.447c3.836 0 7.666-.644 11.365-1.928l30.518-10.654c10.898-3.781 17.512-10.765 22.545-21.145 5.032-10.38 5.722-22.098 1.941-32.996l-47.54-137.024c-7.805-22.497-32.462-34.451-54.956-26.647l-28.359 9.839a34.497 34.497 0 0 0-16.986 12.788l-10.658 15.112c-6.24-28.878-9.521-54.943-9.521-76.095 0-16.891 2.214-33.688 6.583-49.93C93.717 120.606 170.12 69.838 256 69.838s162.283 50.768 185.87 123.482a192.275 192.275 0 0 1 6.583 49.93c0 21.126-3.28 47.214-9.519 76.097l-10.658-15.112a34.504 34.504 0 0 0-16.988-12.789l-28.358-9.839c-22.5-7.803-47.15 4.151-54.956 26.647l-47.54 137.024c-3.781 10.898-3.091 22.616 1.941 32.996s13.806 18.179 24.704 21.96l28.357 9.839a34.64 34.64 0 0 0 11.366 1.928 34.738 34.738 0 0 0 9.891-1.447l33.815-10.042a30.616 30.616 0 0 0 20.163-19.269l2.98-8.59c.119.053.235.113.355.164a25.232 25.232 0 0 0 9.925 2.028 25.37 25.37 0 0 0 23.385-15.473c31.549-74.257 51.935-159.091 51.935-216.121C499.25 109.121 390.129 0 256 0zM95.959 312.859a19.62 19.62 0 0 1 9.66-7.271l28.358-9.839a28.108 28.108 0 0 1 9.224-1.561c11.688 0 22.642 7.324 26.684 18.971l47.54 137.024c2.47 7.121 2.02 14.778-1.268 21.56s-9.02 11.878-16.141 14.348l-21.288 7.386-57.038-164.405a7.485 7.485 0 0 0-14.142 4.906l56.558 163.019a19.808 19.808 0 0 1-4.536-.792l-33.815-10.042a15.612 15.612 0 0 1-10.281-9.826l-41.83-120.565a15.616 15.616 0 0 1 1.986-14.084zm300.57 163.477a15.614 15.614 0 0 1-10.281 9.826l-33.815 10.042a19.818 19.818 0 0 1-4.536.792l12.355-35.612a7.485 7.485 0 0 0-14.142-4.906l-12.836 36.999-21.288-7.386c-7.121-2.47-12.853-7.566-16.141-14.348s-3.738-14.439-1.268-21.56l47.54-137.024c4.041-11.649 14.995-18.971 26.684-18.971 3.061 0 6.173.503 9.224 1.561l21.286 7.386-42.616 122.832a7.484 7.484 0 0 0 4.618 9.524 7.486 7.486 0 0 0 9.524-4.618l42.134-121.444a19.802 19.802 0 0 1 3.071 3.431l20.331 28.827a15.616 15.616 0 0 1 1.986 14.084z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Headphone</h1>
                        </a>
                        <a href="add_product.php?name=Earphone" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M348.505 176.067a6 6 0 0 0 6-6 43.129 43.129 0 0 1 24.214-38.752 6 6 0 1 0-5.193-10.817 55.188 55.188 0 0 0-31.021 49.569 6 6 0 0 0 6 6zM342.505 197.373a6 6 0 0 0 12 0v-6.712a6 6 0 1 0-12 0z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M326.16 407.847a33.5 33.5 0 0 0 14.9 7.106v83.4a6 6 0 0 0 12 0v-83.41a30.2 30.2 0 0 0 24.154-29.553V248.656a80.663 80.663 0 0 0 71.461-15.511 30.188 30.188 0 0 0 28.78-30.119V137.81a30.193 30.193 0 0 0-28.624-30.116 80.717 80.717 0 0 0-51.706-18.152c-44.232.354-80.218 37.138-80.218 82v127.875a6 6 0 0 0 12 0V171.541c0-38.3 30.645-69.7 68.314-70a68.644 68.644 0 0 1 44.08 15.5v106.634a68.658 68.658 0 0 1-64.657 12.317 8.867 8.867 0 0 0-3.108-.463 8.623 8.623 0 0 0-8.321 8.657v100.907H328.91v-5.676a6 6 0 0 0-12 0v52.012c0 5.489 3.458 11.627 9.25 16.418zM453.3 120.674a18.186 18.186 0 0 1 12.154 17.136v65.216a18.185 18.185 0 0 1-12.154 17.135zM328.91 357.093h36.308v27.851c0 10.212-8.358 18.813-18.567 18.6-10.276-.219-17.741-8.545-17.741-12.111zM138.474 35.958a6 6 0 1 0-5.193 10.817A43.13 43.13 0 0 1 157.5 85.528a6 6 0 1 0 12 0 55.189 55.189 0 0 0-31.026-49.57zM163.5 100.121a6 6 0 0 0-6 6v6.712a6 6 0 0 0 12 0v-6.712a6 6 0 0 0-6-6z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M63.315 148.6a80.666 80.666 0 0 0 71.467 15.511V201.5a6 6 0 0 0 12 0v-41.766a8.624 8.624 0 0 0-6.718-8.536 9.166 9.166 0 0 0-4.84.3A68.642 68.642 0 0 1 70.7 139.131V32.5A68.87 68.87 0 0 1 114.776 17c37.669.3 68.314 31.7 68.314 70v173.554h-36.308V241.5a6 6 0 0 0-6-6 6 6 0 0 0-6 6v59.354a30.2 30.2 0 0 0 24.154 29.546v29.26a49.376 49.376 0 0 0 49.32 49.319h47.477a37.362 37.362 0 0 1 37.32 37.321V501a6 6 0 0 0 12 0v-54.7a49.376 49.376 0 0 0-49.32-49.321h-47.477a37.362 37.362 0 0 1-37.32-37.319v-29.246a33.526 33.526 0 0 0 14.9-7.106c5.792-4.792 9.25-10.93 9.25-16.419V87c0-44.86-35.986-81.645-80.218-82a80.863 80.863 0 0 0-51.7 18.152A30.192 30.192 0 0 0 34.542 53.27v65.216A30.189 30.189 0 0 0 63.315 148.6zM183.09 306.889c0 3.566-7.465 11.892-17.741 12.111-10.209.217-18.567-8.384-18.567-18.6v-27.846h36.308zM46.542 53.27A18.185 18.185 0 0 1 58.7 36.135v99.487a18.187 18.187 0 0 1-12.154-17.136z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>
                            <h1>Earphone</h1>
                        </a>
                        <a href="add_product.php?name=Shoes" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M475.045 277.048h-20.448c-35.276 0-69.991-9.46-100.39-27.359l-54.997-32.381a171.583 171.583 0 0 1-64.277-66.982l-13.284-24.851c-6.045-11.308-19.987-16.153-31.744-11.028l-16.8 7.324a24.765 24.765 0 0 0-14.872 22.706v13.004c0 5.143-3.041 9.803-7.748 11.875-20.93 9.209-44.897 4.712-61.064-11.456a21.045 21.045 0 0 0-14.979-6.204c-11.681 0-21.184 9.503-21.184 21.183v11.057c0 9.319-3.629 18.081-10.219 24.67-9.423 9.423-14.612 21.951-14.612 35.276v56.094L1.2 342.128c-.036.056-.064.115-.099.171-.086.141-.17.281-.247.428-.045.086-.084.174-.126.261a8.109 8.109 0 0 0-.181.403c-.043.105-.079.212-.116.318-.043.122-.086.243-.123.368-.037.124-.066.249-.096.375-.026.11-.054.22-.075.332-.028.144-.047.288-.066.432-.013.098-.028.195-.037.294-.015.161-.02.323-.024.484-.001.067-.01.134-.01.203l.002.088.003.135c.121 29.34 24.022 53.172 53.389 53.172h373.017c47.194 0 85.589-38.395 85.589-85.589 0-20.377-16.578-36.955-36.955-36.955zM173.232 157.48v-13.004a9.77 9.77 0 0 1 5.866-8.956l16.8-7.324c4.636-2.021 10.137-.11 12.521 4.35l13.284 24.851a186.682 186.682 0 0 0 8.866 14.839l-22.454 8.878a69.66 69.66 0 0 0-36.766-13.559 27.898 27.898 0 0 0 1.883-10.075zM68.258 183.935v-11.057a6.19 6.19 0 0 1 6.184-6.183c1.651 0 3.204.644 4.372 1.811 20.346 20.347 50.398 26.157 76.819 14.952l1.136-.204a54.765 54.765 0 0 1 36.376 6.042l-33.106 20.332c-25.681 15.771-56.963 19.852-85.828 11.196l-17.314-5.192c7.356-8.909 11.361-19.995 11.361-31.697zm-24.831 95.783h9.454c9.759 0 18.081 6.257 21.176 14.968h-30.63v-14.968zm335.681 68.678h48.482c24.088 0 47.35-6.618 67.738-19.165-6.983 31.624-35.222 55.361-68.917 55.361H53.395c-20.46 0-37.231-16.088-38.333-36.278l24.95-38.627h60.701c11.546 0 22.399 4.496 30.563 12.66l3.945 3.945c14.254 14.252 33.204 22.102 53.359 22.102h157.648a7.5 7.5 0 0 0 7.5-7.5 7.5 7.5 0 0 0-7.5-7.5H188.579c-9.051 0-17.798-1.978-25.749-5.724l18.012-47.763a7.5 7.5 0 0 0-14.035-5.293l-16.893 44.795a61.689 61.689 0 0 1-4.088-3.724l-3.944-3.944c-10.997-10.997-25.618-17.053-41.17-17.053H89.594c-3.484-17.078-18.62-29.968-36.713-29.968h-9.454v-20.836a34.723 34.723 0 0 1 3.642-15.536l22.833 6.847c32.953 9.881 68.668 5.223 97.986-12.782l24.213-14.87-14.834 39.333a7.5 7.5 0 0 0 7.017 10.148 7.505 7.505 0 0 0 7.019-4.855l21.396-56.734 26.916-10.641a186.453 186.453 0 0 0 5.017 6.087l-25.447 31.032a7.5 7.5 0 0 0 11.6 9.512l24.156-29.458a186.475 186.475 0 0 0 14.521 12.963l-11.865 35.749a7.498 7.498 0 0 0 4.756 9.48c.784.26 1.58.384 2.363.384a7.503 7.503 0 0 0 7.117-5.139l10.333-31.133a186.703 186.703 0 0 0 9.433 5.966l5.866 3.454-2.22 35.32a7.5 7.5 0 0 0 7.493 7.971 7.501 7.501 0 0 0 7.479-7.03l1.743-27.727 17.585 10.354 1.664 26.955a7.5 7.5 0 1 0 14.971-.925l-1.04-16.849 1.457.858a212.369 212.369 0 0 0 23.763 12.044l.223 10.392a7.5 7.5 0 0 0 7.495 7.339c.055 0 .109 0 .164-.002a7.5 7.5 0 0 0 7.337-7.659l-.091-4.221a212.981 212.981 0 0 0 69.109 11.54h20.448c10.844 0 19.876 7.9 21.642 18.248l-3.849 2.672c-19.251 13.362-41.813 20.425-65.248 20.425h-48.482a7.5 7.5 0 0 0-7.5 7.5 7.5 7.5 0 0 0 7.5 7.5z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <circle cx="106.25" cy="338.849" r="7.706" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    <circle cx="77.63" cy="338.849" r="7.706" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    <circle cx="47.829" cy="338.849" r="7.706" fill="#000000" opacity="1" data-original="#000000"></circle>
                                </g>
                            </svg>
                            <h1>Shoes</h1>
                        </a>
                        <a href="add_product.php?name=Watch" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M240.003 392c74.991 0 136-61.01 136-136s-61.009-136-136-136-136 61.01-136 136 61.009 136 136 136zm-8-255.727V152a8 8 0 0 0 16 0v-15.727c59.806 3.957 107.77 51.92 111.727 111.727h-15.727a8 8 0 0 0 0 16h15.727c-3.957 59.807-51.921 107.771-111.727 111.727V360a8 8 0 0 0-16 0v15.727c-59.806-3.957-107.77-51.92-111.727-111.727h15.727a8 8 0 0 0 0-16h-15.727c3.956-59.807 51.92-107.771 111.727-111.727z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M426.003 216h-14.588a174.275 174.275 0 0 0-5.535-18.826l11.197-6.462c10.505-6.053 14.125-19.531 8.064-30.052l-10.001-17.321c-6.082-10.532-19.522-14.133-30.059-8.047l-11.272 6.511a177.45 177.45 0 0 0-7.589-8.326L353.964 66.07c-1.752-9.644-9.616-16.836-19.158-17.914l-4.684-28.103A23.925 23.925 0 0 0 306.449 0H173.557a23.923 23.923 0 0 0-23.673 20.054L145.2 48.156c-9.542 1.078-17.406 8.27-19.158 17.912l-12.257 67.408c-66.436 68.42-66.331 176.735 0 245.047l12.257 67.406c1.752 9.644 9.616 16.836 19.158 17.914l4.684 28.103A23.923 23.923 0 0 0 173.557 512h132.892a23.923 23.923 0 0 0 23.673-20.054l4.684-28.103c9.542-1.078 17.406-8.27 19.158-17.912l12.257-67.408a177.45 177.45 0 0 0 7.589-8.326c11.26 6.504 14.894 9.472 22.246 9.472 7.593 0 14.987-3.912 19.085-11.009l10.004-17.327c6.057-10.514 2.438-23.992-8.063-30.042l-11.202-6.465A174.275 174.275 0 0 0 411.415 296h14.588c12.131 0 22-9.869 22-22v-36c0-12.131-9.869-22-22-22zm-32.919-66.853a5.996 5.996 0 0 1 8.2 2.192l9.996 17.313c1.653 2.87.67 6.546-2.196 8.198l-9.313 5.375c-4.515-9.738-9.887-19-16.032-27.681zM165.666 22.685A7.976 7.976 0 0 1 173.557 16h132.892a7.975 7.975 0 0 1 7.891 6.685L318.559 48H161.447zM147.683 64h184.64a5.995 5.995 0 0 1 5.899 4.932l8.599 47.292c-63.104-48.34-150.583-48.3-213.636 0l8.599-47.294c.519-2.857 3-4.93 5.899-4.93zm92.32 32c88.224 0 160 71.775 160 160s-71.776 160-160 160-160-71.775-160-160 71.776-160 160-160zm74.337 393.315a7.976 7.976 0 0 1-7.891 6.685H173.557a7.975 7.975 0 0 1-7.891-6.685L161.447 464h157.112zM332.323 448h-184.64a5.995 5.995 0 0 1-5.899-4.932l-8.599-47.292c63.104 48.34 150.583 48.3 213.636 0l-8.599 47.294a5.997 5.997 0 0 1-5.899 4.93zm76.766-112.849c2.862 1.649 3.845 5.325 2.196 8.188l-9.999 17.319a5.995 5.995 0 0 1-8.201 2.193l-9.345-5.398a176.025 176.025 0 0 0 16.032-27.68zM432.003 274c0 3.309-2.691 6-6 6H414.36a176.084 176.084 0 0 0 0-48h11.643c3.309 0 6 2.691 6 6z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M234.346 261.657a8 8 0 0 0 11.313 0l64-64a7.999 7.999 0 0 0 0-11.314 8.001 8.001 0 0 0-11.313 0l-58.343 58.344-34.343-34.344a8.001 8.001 0 0 0-11.313 0 7.999 7.999 0 0 0 0 11.314z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Watch</h1>
                        </a>
                        <a href="add_product.php?name=Electronics Item" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 480 480" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M472 0H264a8 8 0 0 0-8 8v448a8 8 0 0 0 8 8h8v16h16v-16h160v16h16v-16h8a8 8 0 0 0 8-8V8a8 8 0 0 0-8-8zm-8 448H272V168h192zm0-296H272V16h192zm0 0" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M296 56h16v80h-16zM296 184h16v112h-16zM8 464h8v16h16v-16h176v16h16v-16h8a8 8 0 0 0 8-8V176a8 8 0 0 0-8-8H8a8 8 0 0 0-8 8v280a8 8 0 0 0 8 8zm8-280h208v48H16zm0 64h208v200H16zm0 0" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M120 256c-48.602 0-88 39.398-88 88s39.398 88 88 88 88-39.398 88-88c-.059-48.578-39.422-87.941-88-88zm0 160c-31.621.05-59.578-20.535-68.91-50.75-9.332-30.21 2.14-62.98 28.281-80.773 26.14-17.79 60.832-16.442 85.516 3.324l-11.367 11.398c-23.102-17.523-55.75-14.562-75.325 6.836-19.57 21.395-19.62 54.176-.113 75.63 19.508 21.456 52.145 24.515 75.3 7.062l11.505 11.503A71.561 71.561 0 0 1 120 416zm18.344-42.344 3.625 3.625c-16.703 11.098-39.043 8.117-52.246-6.976-13.207-15.094-13.192-37.633.03-52.711s35.567-18.035 52.255-6.914l-3.664 3.664A8.001 8.001 0 0 0 136 320v48c0 2.121.844 4.156 2.344 5.656zm37.855 15.2L152 364.686v-41.375l24.2-24.199c21.066 26.215 21.066 63.559 0 89.774zM32 200h16v16H32zM64 200h16v16H64zM96 200h16v16H96zM160 200h48v16h-48zM8 152h224a8 8 0 0 0 8-8V8a8 8 0 0 0-8-8H8a8 8 0 0 0-8 8v136a8 8 0 0 0 8 8zM176 16h48v120h-48zM16 16h144v120H16zm0 0" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M192 32h16v16h-16zM192 64h16v16h-16zM136 32H40a8 8 0 0 0-8 8v72a8 8 0 0 0 8 8h96a8 8 0 0 0 8-8V40a8 8 0 0 0-8-8zm-8 72H48V48h80zM200 100c-6.629 0-12 5.371-12 12s5.371 12 12 12 12-5.371 12-12-5.371-12-12-12zm0 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm0 0" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>
                            <h1>Electronics item</h1>
                        </a>
                        <a href="add_product.php?name=Tech Accessories" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M15 57h8v2h-8zM19 16.993a8.794 8.794 0 0 1 6.289 2.632l1.422-1.406a10.829 10.829 0 0 0-15.422 0l1.422 1.406A8.794 8.794 0 0 1 19 16.993z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="m14.089 21.048 1.422 1.406a4.9 4.9 0 0 1 6.978 0l1.422-1.406a6.9 6.9 0 0 0-9.822 0zM16.889 23.876l1.422 1.406a.988.988 0 0 1 1.378 0l1.422-1.406a3.035 3.035 0 0 0-4.222 0z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M19 31A11 11 0 1 0 8 20a11.013 11.013 0 0 0 11 11zm0-20a9 9 0 1 1-9 9 9.01 9.01 0 0 1 9-9zM22 47H8a3 3 0 0 0-3 3v2a3 3 0 0 0 3 3h14a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H8a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1h13zM26 47a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h4a3 3 0 0 0 3-3v-2a3 3 0 0 0-3-3zm5 3v2a1 1 0 0 1-1 1h-3v-4h3a1 1 0 0 1 1 1z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M60 33H48.816A3 3 0 0 0 46 31h-9V7a6.006 6.006 0 0 0-6-6H7a6.006 6.006 0 0 0-6 6v50a6.006 6.006 0 0 0 6 6h24a6.006 6.006 0 0 0 6-6V45h9a3 3 0 0 0 2.816-2H60a3 3 0 0 0 3-3v-4a3 3 0 0 0-3-3zM15 3h8v1a1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1zm20 54a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h6v1a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V3h6a4 4 0 0 1 4 4v24h-3a3 3 0 0 0-2.816 2H18a3 3 0 0 0-3 3v4a3 3 0 0 0 3 3h11.184A3 3 0 0 0 32 45h3zm-6-16H18a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1h11zm18 1a1 1 0 0 1-1 1H32a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1zm14-2a1 1 0 0 1-1 1H49v-6h11a1 1 0 0 1 1 1z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M44 35H34a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1zm-1 4h-8v-2h8zM51 37h2v2h-2zM55 37h2v2h-2z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Tech accessories</h1>
                        </a>
                        <a href="add_product.php?name=Cameras" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M318.006 211.841c-16.814 0-33.145 3.261-48.537 9.69-5.096 2.129-7.501 7.986-5.373 13.082 2.129 5.097 7.986 7.499 13.082 5.373 12.938-5.405 26.674-8.145 40.828-8.145 58.449 0 106 47.552 106 106s-47.551 106-106 106-106-47.552-106-106c0-14.132 2.732-27.85 8.121-40.77 2.126-5.098-.283-10.953-5.38-13.079-5.094-2.123-10.953.283-13.079 5.38-6.411 15.373-9.662 31.68-9.662 48.469 0 69.477 56.523 126 126 126s126-56.523 126-126-56.523-126-126-126z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M318.006 419.841c45.215 0 82-36.785 82-82s-36.785-82-82-82-82 36.785-82 82 36.786 82 82 82zm0-144c34.187 0 62 27.814 62 62s-27.813 62-62 62-62-27.813-62-62 27.813-62 62-62z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M461.284 163.841h-30.42l-34.915-59.087a10 10 0 0 0-8.609-4.913H248.673a9.999 9.999 0 0 0-8.609 4.913l-34.915 59.087H148v-12c0-19.851-16.149-36-36-36s-36 16.149-36 36v12H50.716C22.751 163.841 0 186.592 0 214.558v246.566c0 27.966 22.751 50.717 50.716 50.717h410.567c27.965 0 50.716-22.751 50.716-50.717V214.558c.001-27.966-22.751-50.717-50.715-50.717zm-206.905-44h127.254l26 44H228.379zM96 151.841c0-8.822 7.178-16 16-16s16 7.178 16 16v12H96zm396 309.283c0 16.938-13.779 30.717-30.716 30.717H50.716c-16.937 0-30.716-13.78-30.716-30.717V214.558c0-16.938 13.779-30.717 30.716-30.717h410.567c16.937 0 30.716 13.779 30.716 30.717v246.566z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M318.006 318.341c10.753 0 19.5 8.748 19.5 19.5 0 5.523 4.477 10 10 10s10-4.477 10-10c0-21.78-17.72-39.5-39.5-39.5-5.523 0-10 4.478-10 10s4.477 10 10 10zM318.006 73.532c5.523 0 10-4.478 10-10V10.159c0-5.522-4.477-10-10-10s-10 4.477-10 10v53.373c0 5.523 4.477 10 10 10zM365.591 73.532a9.97 9.97 0 0 0 7.071-2.929l36.691-36.691c3.905-3.905 3.905-10.237-.001-14.143-3.905-3.904-10.237-3.904-14.142 0l-36.69 36.692c-3.905 3.905-3.905 10.237 0 14.143a9.971 9.971 0 0 0 7.071 2.928zM263.35 70.604c1.953 1.952 4.512 2.929 7.071 2.929s5.119-.977 7.071-2.929c3.905-3.905 3.906-10.237.001-14.143L240.802 19.77c-3.905-3.903-10.237-3.904-14.142 0-3.905 3.905-3.906 10.237-.001 14.143zM138 245.841H86c-5.523 0-10 4.478-10 10 0 5.523 4.477 10 10 10h52c5.523 0 10-4.477 10-10s-4.477-10-10-10zM235.96 265.84c2.63 0 5.21-1.07 7.07-2.93s2.93-4.431 2.93-7.07c0-2.63-1.07-5.21-2.93-7.07-1.86-1.859-4.44-2.93-7.07-2.93s-5.21 1.07-7.07 2.93a10.035 10.035 0 0 0-2.93 7.07c0 2.63 1.06 5.21 2.93 7.07 1.86 1.86 4.43 2.93 7.07 2.93z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Cameras</h1>
                        </a>
                        <a href="add_product.php?name=Game Item" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 321.145 321.145" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M320.973 200.981c-.8-18.4-4-38.8-8.8-58-4.8-18.4-10.8-35.6-18-48.8-28-49.2-58.4-41.6-94.8-32-11.6 2.8-24 6-36.8 7.2h-4c-12.8-1.2-25.2-4.4-36.8-7.2-36.4-9.2-66.8-17.2-94.8 32.4-7.2 13.2-13.6 30.4-18 48.8-4.8 19.2-8 39.6-8.8 58-.8 20.4 1.2 35.2 5.6 45.6 4.4 9.6 10.8 15.6 19.2 18 7.6 2 16.4 1.2 25.6-2.8 15.6-6.4 33.6-20 51.2-36.4 12.4-12 35.6-18 58.8-18s46.4 6 58.8 18c17.6 16.4 35.6 30 51.2 36.4 9.2 3.6 18 4.8 25.6 2.8 8-2.4 14.8-8 19.2-18.4 4.4-10 6.4-24.8 5.6-45.6zm-19.2 40c-2.4 5.6-5.6 8.8-9.6 10-4.4 1.2-10 .4-16.4-2-14-5.6-30.4-18-46.4-33.2-15.2-15.2-42-22.8-68.8-22.8s-53.6 7.6-69.2 22c-16.4 15.2-32.8 28-46.4 33.2-6.4 2.4-12 3.6-16.4 2-4-1.2-7.2-4.4-9.6-10-3.2-7.6-4.8-20-4-38.4.8-17.2 3.6-36.8 8.4-55.2 4.4-17.2 10-33.2 16.8-45.2 22-39.6 47.6-33.2 78-25.2 12.4 3.2 25.2 6.4 39.2 7.6h6c14.4-1.2 27.2-4.4 39.6-7.6 30.4-7.6 56-14.4 78 25.2 6.8 12 12.4 27.6 16.8 45.2 4.4 18.4 7.6 37.6 8.4 55.2.8 18.4-.8 30.8-4.4 39.2z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M123.773 122.981c-4-3.6-8.8-6.4-14.4-6.8-.4-5.2-2.8-10.4-6.4-14l-.4-.4c-4.4-4.4-10-6.8-16.4-6.8-6.4 0-12.4 2.8-16.4 6.8-3.6 3.6-6.4 8.8-6.8 14.4-5.6.4-10.4 2.8-14.4 6.4l-.4.4c-4.4 4.4-6.8 10-6.8 16.4 0 6.4 2.8 12.4 6.8 16.4 4 4 8.8 6.4 14.8 6.8.4 5.6 2.8 10.8 6.8 14.4 4.4 4.4 10 6.8 16.4 6.8 6.4 0 12.4-2.8 16.4-6.8 3.6-4 6.4-8.8 6.8-14.4 5.6-.4 10.8-2.8 14.4-6.8 4.4-4.4 6.8-10 6.8-16.4 0-6.4-2.8-12.4-6.8-16.4zm-10 22.4c-1.6 1.6-3.6 2.4-6 2.4h-5.6c-4 0-7.6 3.2-7.6 7.6v5.2c0 2.4-.8 4.4-2.4 6-1.6 1.6-3.6 2.4-6 2.4s-4.4-.8-6-2.4c-1.6-1.6-2.4-3.6-2.4-6v-5.6c0-4-3.2-7.6-7.6-7.6h-5.6c-2.4 0-4.4-.8-6-2.4-1.2-1.2-2.4-3.2-2.4-5.6 0-2.4.8-4.4 2.4-6l.4-.4c1.6-1.2 3.6-2 5.6-2h5.6c4 0 7.6-3.2 7.6-7.6v-5.6c0-2.4.8-4.4 2.4-6 1.6-1.6 3.6-2.4 6-2.4s4.4.8 6 2.4l.4.4c1.2 1.6 2 3.6 2 5.6v5.6c0 4 3.2 7.6 7.6 7.6h5.6c2.4 0 4.4.8 6 2.4 1.6 1.6 2.4 3.6 2.4 6s-.8 4.4-2.4 6z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <circle cx="230.173" cy="110.981" r="14" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    <circle cx="230.173" cy="167.781" r="14" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    <circle cx="201.773" cy="139.381" r="14" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    <circle cx="258.573" cy="139.381" r="14" fill="#000000" opacity="1" data-original="#000000"></circle>
                                </g>
                            </svg>
                            <h1>Game item</h1>
                        </a>
                        <a href="add_product.php?name=Kitchen" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512.001 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M357.848 62.984a7.5 7.5 0 0 0-7.5 7.5v34.5a7.5 7.5 0 1 0 15 0v-34.5c0-4.14-3.36-7.5-7.5-7.5zM418.32 62.984a7.5 7.5 0 0 0-7.5 7.5v34.5a7.5 7.5 0 0 0 7.5 7.5 7.5 7.5 0 0 0 7.5-7.5v-34.5a7.5 7.5 0 0 0-7.5-7.5zM347.844 310.844h41c4.14 0 7.5-3.36 7.5-7.5s-3.36-7.5-7.5-7.5h-41a7.5 7.5 0 1 0 0 15zM388.844 414.176h-41a7.5 7.5 0 0 0-7.5 7.5c0 4.144 3.355 7.5 7.5 7.5h41a7.5 7.5 0 1 0 0-15zm0 0" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M496.488 235.14h-50.324a7.497 7.497 0 0 0-7.5 7.5 7.5 7.5 0 0 0 7.5 7.5h50.324c.282 0 .512.227.512.512v18.114c0 .285-.23.515-.512.515H15.512a.514.514 0 0 1-.512-.515v-18.114c0-.28.23-.511.512-.511h400.652a7.5 7.5 0 0 0 7.5-7.5c0-4.145-3.355-7.5-7.5-7.5H175.266v-12.645c8.914-.371 16.046-7.738 16.046-16.742v-10.41a7.5 7.5 0 1 0-15 0v10.41c0 .969-.785 1.758-1.753 1.758H61.973a1.76 1.76 0 0 1-1.758-1.758v-10.41a7.5 7.5 0 1 0-15 0v10.41c0 9.004 7.137 16.371 16.05 16.742v12.645H15.513C6.96 235.14 0 242.098 0 250.652v18.114c0 8.554 6.96 15.515 15.512 15.515h8.304v205.38c0 11.968 9.735 21.702 21.704 21.702h420.96c11.97 0 21.704-9.734 21.704-21.703V284.281h8.304c8.551 0 15.512-6.96 15.512-15.515v-18.114c0-8.554-6.96-15.511-15.512-15.511zM76.266 222.513h84v12.629h-84zM38.816 489.66V284.281H248.5v212.082H45.52a6.707 6.707 0 0 1-6.704-6.703zm427.664 6.703H263.5v-97.945h209.688v91.242a6.71 6.71 0 0 1-6.708 6.703zm6.707-112.945H263.5v-99.137h209.687zm0 0" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M220.46 356.613H69.54c-7.618 0-13.813 6.196-13.813 13.813v96.836c0 7.617 6.195 13.812 13.812 13.812h150.922c7.617 0 13.812-6.195 13.812-13.812v-96.836c0-7.617-6.195-13.813-13.812-13.813zm-1.187 109.461H70.727v-94.457h148.546zM80.227 344.844c13.511 0 24.5-10.992 24.5-24.5s-10.989-24.5-24.5-24.5c-13.508 0-24.5 10.992-24.5 24.5s10.992 24.5 24.5 24.5zm0-34c5.238 0 9.5 4.261 9.5 9.5s-4.262 9.5-9.5 9.5c-5.239 0-9.5-4.262-9.5-9.5s4.261-9.5 9.5-9.5zM145 344.844c13.508 0 24.5-10.992 24.5-24.5s-10.992-24.5-24.5-24.5-24.5 10.992-24.5 24.5 10.992 24.5 24.5 24.5zm0-34c5.238 0 9.5 4.261 9.5 9.5s-4.262 9.5-9.5 9.5-9.5-4.262-9.5-9.5 4.262-9.5 9.5-9.5zM491.527 0H284.641c-11.29 0-20.473 9.184-20.473 20.473v133.379c0 11.289 9.184 20.476 20.473 20.476h206.886c11.29 0 20.473-9.187 20.473-20.476V20.472C512 9.185 502.816 0 491.527 0zM279.168 153.852V20.472A5.479 5.479 0 0 1 284.641 15h95.941v144.328h-95.941a5.48 5.48 0 0 1-5.473-5.476zm217.832 0a5.48 5.48 0 0 1-5.473 5.476h-95.945V15h95.945A5.479 5.479 0 0 1 497 20.473zM14.953 94.664h215.621c8.246 0 14.957-6.707 14.957-14.957V66.273c0-8.246-6.707-14.953-14.957-14.953h-11.39c-2.61-16.562-16.98-29.265-34.262-29.265H60.609c-17.28 0-31.652 12.703-34.261 29.265H14.953C6.707 51.32 0 58.027 0 66.273v13.438c0 8.246 6.707 14.953 14.953 14.953zM64.75 66.32c4.14 0 7.5-3.36 7.5-7.5 0-4.14-3.36-7.5-7.5-7.5H41.684c2.359-8.226 9.953-14.265 18.925-14.265h124.313c8.973 0 16.566 6.039 18.926 14.265H95.227c-4.141 0-7.5 3.36-7.5 7.5 0 4.14 3.359 7.5 7.5 7.5l116.113-.039a7.346 7.346 0 0 0 1.543 0l17.648-.004.043 13.387L15 79.711l-.047-13.39zm0 0" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Kitchen</h1>
                        </a>
                        <a href="add_product.php?name=Clothes" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <defs>
                                        <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                            <path d="M0 512h512V0H0Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        </clipPath>
                                    </defs>
                                    <path d="M0 0v-100.152" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="matrix(1.33333 0 0 -1.33333 268.395 263.675)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                    <path d="M0 0v-100.152" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="matrix(1.33333 0 0 -1.33333 589.145 263.675)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                    <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                        <path d="M0 0v-34.49a31.66 31.66 0 1 1 63.32 0V0z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(353.538 279.315)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0c-13.226 10.984-21.646 27.552-21.646 46.087h-27.896c-19.321 0-37.028-11.587-44.563-29.776l-46.172-111.469 58.506-24.235v-206.591h240.562v124.294" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(283.067 333.484)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0v47.298L58.5 71.53c.003.001.005.004.003.007L12.334 183.001c-7.54 18.202-25.254 29.776-44.563 29.776h-28.446c0-33.071-26.809-59.881-59.881-59.881-2.206 0-4.383.12-6.527.352" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(441.858 166.794)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0h5.973c9.991 0 19.649 3.59 27.215 10.115l10.189 8.788c.13.114.298.175.47.175h19.142a.712.712 0 0 0 .471-.175l10.19-8.788A41.675 41.675 0 0 1 100.865 0h5.972" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(267.884 352.483)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0h-12.436a14.58 14.58 0 0 0-9.522 3.539l-10.19 8.789A27.51 27.51 0 0 1-37.617 16c-5.27 2.688-8.723 7.958-8.722 13.874l.001 4.728c0 13.843-7.965 26.41-20.292 32.014-6.23 2.832-9.981 9.095-9.555 15.953.499 8.045 7.192 14.738 15.236 15.238 5.721.336 11.07-2.154 14.513-6.994 1.961-2.756 2.85-6.106 2.893-9.488.097-7.512 6.31-13.551 13.888-13.362 7.416.184 13.314 6.823 13.193 14.24-.191 11.685-5.154 22.93-13.684 30.946-8.825 8.293-20.362 12.449-32.481 11.692-21.79-1.352-39.241-18.804-40.594-40.593-1.128-18.168 8.834-34.769 25.38-42.29 2.683-1.221 4.416-4.107 4.416-7.356l.001-4.729c.001-5.915-3.452-11.185-8.722-13.873a27.502 27.502 0 0 1-5.468-3.672l-10.19-8.789A14.579 14.579 0 0 0-107.326 0h-12.437" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(381.184 379.571)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0v-100.152" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(70.144 314.244)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0h5.973c9.99 0 19.648 3.59 27.215 10.115l10.189 8.788c.13.114.297.175.47.175h19.142a.714.714 0 0 0 .471-.175l2.977-2.567" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(136.731 352.483)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="M0 0a14.579 14.579 0 0 0-9.522 3.539l-10.191 8.789A27.51 27.51 0 0 1-25.182 16c-5.269 2.688-8.722 7.958-8.721 13.874l.001 4.728c0 13.842-7.965 26.41-20.292 32.014-6.231 2.832-9.982 9.095-9.556 15.953.5 8.045 7.192 14.738 15.236 15.238 5.721.336 11.071-2.154 14.514-6.994 1.961-2.757 2.849-6.106 2.893-9.488.095-7.512 6.309-13.551 13.887-13.362 7.416.184 13.315 6.823 13.193 14.24-.191 11.685-5.154 22.93-13.684 30.946-8.824 8.293-20.361 12.449-32.48 11.692-21.79-1.352-39.242-18.804-40.594-40.593-1.128-18.168 8.834-34.769 25.38-42.29 2.682-1.221 4.416-4.107 4.416-7.356l.001-4.729c.001-5.915-3.452-11.185-8.722-13.873a27.51 27.51 0 0 1-5.469-3.672l-10.189-8.789A14.585 14.585 0 0 0-94.891 0h-12.436" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(237.596 379.571)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                        <path d="m0 0-9.188-22.181 58.506-24.234v-206.592h131.153v206.592l-58.506 24.234 34.295 82.794c-26.789 5.961-46.817 29.867-46.817 58.451H81.548c-19.321 0-37.029-11.586-44.564-29.776L13.959 33.699" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(20.825 260.507)" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path>
                                    </g>
                                </g>
                            </svg>
                            <h1>Clothes</h1>
                        </a>
                        <a href="add_product.php?name=Toys" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M175.91 240c35.29 0 64-23.327 64-52a8 8 0 0 0-16 0c0 17.806-17.329 32.625-40 35.49V198.1a18.079 18.079 0 0 0 2.428-1.459l13.577-9.689a19.373 19.373 0 0 0 7.994-15.794c0-10.562-8.264-19.155-18.422-19.155h-27.155c-10.158 0-18.422 8.593-18.422 19.155a19.373 19.373 0 0 0 7.994 15.794l13.577 9.689a17.986 17.986 0 0 0 2.429 1.459v25.39c-22.671-2.865-40-17.684-40-35.49a8 8 0 0 0-16 0c0 28.673 28.71 52 64 52Zm-14.71-66.074a3.407 3.407 0 0 1-1.288-2.771c0-1.71 1.11-3.155 2.422-3.155h27.156c1.313 0 2.422 1.445 2.422 3.155a3.408 3.408 0 0 1-1.289 2.771l-13.577 9.688a1.859 1.859 0 0 1-2.269 0Z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <circle cx="223.91" cy="144" r="8" fill="#000000" opacity="1" data-original="#000000" class=""></circle>
                                    <circle cx="127.91" cy="144" r="8" fill="#000000" opacity="1" data-original="#000000" class=""></circle>
                                    <path d="M384 312a32 32 0 1 0-32-32 32.036 32.036 0 0 0 32 32Zm0-48a16 16 0 1 1-16 16 16.019 16.019 0 0 1 16-16Z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M496 328h-48V224a7.957 7.957 0 0 0-1.45-4.585l-56-80a8 8 0 0 0-13.108 0l-56 80A7.957 7.957 0 0 0 320 224v50.063c-10.955-14.728-25.571-26.948-43.618-36.374C294.2 216.745 303.91 189.531 303.91 160a126.381 126.381 0 0 0-5.867-38.468 56 56 0 1 0-76.12-74.785A152.28 152.28 0 0 0 175.91 40a152.242 152.242 0 0 0-46.01 6.748 56 56 0 1 0-76.121 74.784A126.381 126.381 0 0 0 47.91 160c0 29.531 9.714 56.746 27.529 77.689-38.948 20.342-61.912 53.705-66.623 97.139-.01.1-.02.2-.027.3L8.02 346.11a7.69 7.69 0 0 0 0 1.084 48.1 48.1 0 0 0 31.946 42.068A78.657 78.657 0 0 0 32 424c0 39.7 28.71 72 64 72 19 0 36.083-9.372 47.815-24.212a67.177 67.177 0 0 0 64.37 0C219.917 486.628 237 496 256 496c25.076 0 46.817-16.316 57.309-40H496a8 8 0 0 0 8-8V336a8 8 0 0 0-8-8ZM384 157.95 424.635 216h-81.27ZM336 232h96v96h-89.917A130.231 130.231 0 0 0 336 304Zm-23.993 157.206A48.3 48.3 0 0 0 331.641 376H344v32h-25.613a77.169 77.169 0 0 0-6.38-18.794Zm15.073-52.8.72 10.253A32.064 32.064 0 0 1 303 375.2c-10.029-12.215-23.76-20.512-39.169-22.638-1.457-32.539-12.425-62.563-30.345-83.583a116.946 116.946 0 0 0 31.047-19.324c36.645 17.554 58.237 47.437 62.547 86.745ZM271.91 32a40 40 0 0 1 20.18 74.544 111.67 111.67 0 0 0-22.4-31.444 115.713 115.713 0 0 0-32.737-22.546A40.089 40.089 0 0 1 271.91 32Zm-232 40a40 40 0 0 1 74.961-19.446A115.682 115.682 0 0 0 82.134 75.1a111.642 111.642 0 0 0-22.4 31.443A40.09 40.09 0 0 1 39.91 72Zm53.443 14.508C113.649 66.55 142.2 56 175.91 56s62.261 10.55 82.558 30.509c18.986 18.67 29.442 44.769 29.442 73.491s-10.456 54.821-29.442 73.491C238.171 253.45 209.623 264 175.91 264s-62.261-10.55-82.557-30.508C74.366 214.821 63.91 188.722 63.91 160s10.456-54.821 29.443-73.492ZM24.021 346.657l.718-10.254c4.311-39.312 25.9-69.195 62.547-86.751a116.968 116.968 0 0 0 31.195 19.386c-17.867 21.026-28.847 51.138-30.312 83.52C72.746 354.686 59 363 48.971 375.23a32.063 32.063 0 0 1-24.95-28.573ZM96 480c-26.468 0-48-25.121-48-56s21.532-56 48-56 48 25.121 48 56-21.532 56-48 56Zm80-16a51.7 51.7 0 0 1-23.68-5.83A78.736 78.736 0 0 0 160 424c0-36.578-24.377-66.851-55.812-71.39 1.538-31.2 12.747-59.72 30.746-77.876A154.918 154.918 0 0 0 175.91 280a154.862 154.862 0 0 0 41.111-5.3c18.056 18.151 29.265 46.558 30.794 77.912C216.379 357.147 192 387.42 192 424a78.736 78.736 0 0 0 7.68 34.17A51.7 51.7 0 0 1 176 464Zm80 16c-26.468 0-48-25.121-48-56s21.532-56 48-56 48 25.121 48 56-21.532 56-48 56Zm64-56h32a8 8 0 0 0 8-8v-48a8 8 0 0 0-8-8h-10.843a47.615 47.615 0 0 0 2.646-12.806 8 8 0 0 0 0-1.084l-.148-2.11H376v96h-57.613A80.464 80.464 0 0 0 320 424Zm168 16h-96v-96h96Z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M416 424h48a8 8 0 0 0 7.155-11.578l-24-48a8 8 0 0 0-14.31 0l-24 48A8 8 0 0 0 416 424Zm24-38.111L451.056 408h-22.112Z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Toys</h1>
                        </a>
                        <a href="add_product.php?name=Stationary" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                                <g>
                                    <path fill="#ebebeb" d="m41.903 13.052 2.937-9.001 6.312 2.064-3.928 12.04" opacity="1" data-original="#ebebeb"></path>
                                    <path d="M11 40H9.691A3.692 3.692 0 0 0 6 43.691v9.618A3.692 3.692 0 0 0 9.691 57h1.316a4.246 4.246 0 0 0 4.239 4h31.508a4.242 4.242 0 0 0 4.219-3.769A.974.974 0 0 0 51 57h1.309A3.692 3.692 0 0 0 56 53.309v-9.618A3.692 3.692 0 0 0 52.309 40H51V27.336c0-.599-.031-1.195-.092-1.785l6.51-8.01a.998.998 0 0 0 .205-.436l1.153-5.8a.998.998 0 0 0-1.388-1.108l-5.502 2.455a1 1 0 0 0-.368.283l-2.971 3.655 3.34-10.214a.999.999 0 0 0-.639-1.261L44.933 3.05a1 1 0 0 0-1.261.639L41.883 9.16l-.27-5.212a1 1 0 0 0-1.05-.947l-15.413.798a5.868 5.868 0 0 0-5.709-.092L5.695 11.056a.999.999 0 0 0-.41 1.353l1.334 2.496a1 1 0 0 0 .942 1.762l.662 1.238a1.001 1.001 0 0 0 .943 1.763l.661 1.237c-.462.27-.632.86-.378 1.336.255.475.84.662 1.321.427l.597 1.118a17.365 17.365 0 0 0-.367 3.55zm35 19h.754A2.247 2.247 0 0 0 49 56.754v-8.151A9.602 9.602 0 0 0 39.397 39H22.603A9.602 9.602 0 0 0 13 48.603v8.151A2.247 2.247 0 0 0 15.246 59h1.228a4.976 4.976 0 0 1-1-3v-7a5 5 0 0 1 5-5H42a5 5 0 0 1 5 5v7a4.976 4.976 0 0 1-1 3zm-4.446-9 1.895 5.684A1.002 1.002 0 0 1 42.5 57h-4.636a1.002 1.002 0 0 1-.949-1.316L38.81 50H17.474v6a3 3 0 0 0 3 3H42a3 3 0 0 0 3-3v-6zM11 55H9.691A1.69 1.69 0 0 1 8 53.309v-6.74h3zm29.182-2.791L41.113 55h-1.861zM54 46.569v6.74A1.69 1.69 0 0 1 52.309 55H51v-8.431zM44.829 48H17.645a3.001 3.001 0 0 1 2.829-2H42a3 3 0 0 1 2.829 2zM11 42v2.569H8v-.878A1.69 1.69 0 0 1 9.691 42zm40 2.569V42h1.309A1.69 1.69 0 0 1 54 43.691v.878zm-38-2.481A11.592 11.592 0 0 1 22.603 37h16.794c3.994 0 7.516 2.018 9.603 5.088V27.336A15.337 15.337 0 0 0 33.664 12h-5.328A15.337 15.337 0 0 0 13 27.336zM44.986 22a4 4 0 0 0-4-4H21.489a4 4 0 0 0-4 4v9a4 4 0 0 0 4 4h19.497a4 4 0 0 0 4-4v-9zm-6.054 2 2.114 6.176a1 1 0 0 1-.947 1.324H35a1 1 0 0 1-.946-1.324L36.168 24H19.489v7a2 2 0 0 0 2 2h19.497a2 2 0 0 0 2-2v-7zm-1.382 2.138L38.7 29.5h-2.301zM50.5 21.61a1.027 1.027 0 0 1-.372.284l-.004.001c.116.351.221.705.314 1.063l4.544-5.59a2.371 2.371 0 0 1-.317-.205 2.581 2.581 0 0 1-.304-.292zm-7.514.39H19.489a2 2 0 0 1 2-2h19.497a2 2 0 0 1 2 2zm-30.378-1.955c.421-.908.921-1.781 1.495-2.607l-.488.261a1 1 0 0 1-.943-1.763l6.877-3.677-.163-3.155a.996.996 0 0 1 .256-.721l3.016-3.345a3.856 3.856 0 0 0-2.274.432L7.52 12.348l.863 1.614a1 1 0 0 1 .942 1.762l.662 1.238a1 1 0 0 1 .942 1.763l.662 1.237a1.001 1.001 0 0 1 1.017.083zm40.154-4.378a2.568 2.568 0 0 1-.294-.212 3.181 3.181 0 0 1-.24-.223l-3.244 3.991c.117.22.229.443.336.669zm-3.331-8.216.245-.746-4.414-1.444-2.411 7.373a17.302 17.302 0 0 1 3.824 3.246l.324-.991-.412-.134a1.001 1.001 0 0 1 .622-1.901l.412.134.302-.925-1.803-.59a1 1 0 0 1 .621-1.901l1.804.59.265-.81-.374-.122a1 1 0 0 1 .622-1.901zm4.395 6.526c.305.208.686.233.686.233.346.029.652.236.809.546 0 0 .261.567.566.823l.551-2.768zm-41.985.403 6.63-3.545a1 1 0 0 0-.942-1.764l-6.631 3.546a1 1 0 1 0 .943 1.763zm13.382-8.582.155 2.996a1 1 0 0 1-.947 1.05l-2.996.155.073 1.403A17.33 17.33 0 0 1 28.336 10h5.328c2.184 0 4.326.412 6.322 1.194l-.318-6.144zm11.7 1.397-9.599.497a1 1 0 1 0 .103 1.997l9.599-.497a1 1 0 1 0-.103-1.997zm-13.624.119-.555.615.585-.03z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Stationary</h1>
                        </a>
                        <a href="add_product.php?name=Sports" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M441.485 51.3c-40.63-18.694-93.388 8.777-117.61 61.234-13.717 29.706-15.976 61.944-6.195 88.448 7 18.963 19.431 33.005 35.958 40.608a64.646 64.646 0 0 0 27.2 5.866c34.6 0 71.344-25.81 90.409-67.1 13.717-29.706 15.975-61.945 6.194-88.448-6.996-18.959-19.429-33.001-35.956-40.608zm.267 13.718a56.2 56.2 0 0 1 19.954 21.244l-1.862 4.03L435.3 79zm-84.794 90.557 9.266-20.068 24.547 11.294-9.266 20.068zm19.517 22.189-9.266 20.067-24.548-11.294 9.266-20.067zm-5.221-53.151 9.267-20.068 24.547 11.294-9.268 20.072zm30.419 27.2 24.548 11.294-9.266 20.068-24.548-11.294zm5.031-10.9 9.266-20.067 24.548 11.294-9.267 20.068zM421 109.964l9.266-20.064 24.548 11.294-9.266 20.067zm-19.3-51.288a61.782 61.782 0 0 1 12.357-1.294 53.946 53.946 0 0 1 16.79 2.628L424.4 73.987l-24.553-11.295zm-6.885 14.911 24.548 11.294-9.263 20.068-24.549-11.294zM380.1 66.815l3.817 1.756-9.266 20.068-14.728-6.776A97.319 97.319 0 0 1 380.1 66.815zm-28.753 24.312 18.272 8.407-9.266 20.066-21.581-9.929a119.687 119.687 0 0 1 12.575-18.544zm-17.861 29.322 21.836 10.051-9.266 20.068-19.532-8.987a122.756 122.756 0 0 1 6.962-21.132zm-9.06 57.7a100.549 100.549 0 0 1-.03-24.344l16.63 7.651-9.266 20.068zm28.919 49.709A56.23 56.23 0 0 1 333.4 206.6l4.232-9.164 24.547 11.294zm40.033 6.383a56.741 56.741 0 0 1-29.132-1.366l8.834-19.131 24.547 11.294zm9.28-20.1-24.548-11.29 9.267-20.068 24.547 11.294zm18.228 8.387-7.327-3.371 9.266-20.068 16.609 7.641a102.4 102.4 0 0 1-18.548 15.802zm26.5-25.346-19.53-8.982 9.266-20.068 21.862 10.058a121.94 121.94 0 0 1-11.593 18.996zm16.382-30-21.621-9.948 9.267-20.068 18.344 8.441a119.9 119.9 0 0 1-5.985 21.577zm7.484-34.1-14.808-6.813 9.266-20.067 3.853 1.772a95.75 95.75 0 0 1 1.694 25.113z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M452.888 26.608C400.856 2.67 333.706 36.949 303.2 103.024c-17.093 37.02-19.828 77.411-7.5 110.814 6.337 17.173 16.171 31.213 28.874 41.475l-23.839 51.631-2.588-.553a53.384 53.384 0 0 0-8.551-1.119l-4.373-6.338a25.207 25.207 0 0 1-4.264-17.563 37.191 37.191 0 0 0-6.288-25.912L142.754 64.315A38.472 38.472 0 0 0 89.366 54.5a38.3 38.3 0 0 0-9.838 53.32l77.144 111.78a128.009 128.009 0 1 0 67.353 216.461 125.41 125.41 0 0 0 2.69-2.775 44.929 44.929 0 1 0 64.428-24.279l9.692 2 10.808 5.854 26.923 39.014-.788.541a13.722 13.722 0 0 0-3.521 19.1 28.058 28.058 0 0 0 38.942 7.164l15.78-10.851a28.014 28.014 0 0 0 8.139-8.671l6.7 3.629a30.178 30.178 0 0 0 22.289 2.612l26.075-7.017a10.066 10.066 0 0 0 5.615-15.523L438 418.792l37.035-15.649c.042-.017.083-.036.124-.054a10.064 10.064 0 0 0 2.723-16.563l-26.424-25.811 29.005-18.486a10.065 10.065 0 0 0 .58-16.579l-21.377-15.829a30.216 30.216 0 0 0-20.223-5.86l-94.7 6.115 17.333-37.541a86.717 86.717 0 0 0 15.512 1.385c44.008 0 90.436-32.26 114.348-84.046 17.094-37.02 19.828-77.411 7.5-110.814-9.036-24.46-25.126-42.595-46.548-52.452zm-162.77 290.728-16.338 76.17c-5.472-.6-13.323-2.1-18.379-8.476a128.179 128.179 0 0 0 6.207-39.541 130.14 130.14 0 0 0-.753-13.922c3.118-9.405 15.616-15.267 29.263-14.231zm-27.03 86.29a44.649 44.649 0 0 0-19.67 7.688 126.512 126.512 0 0 0 7.3-14.009 35.142 35.142 0 0 0 12.37 6.321zM152.45 231.038a116.715 116.715 0 0 1 21.615 5.742 6 6 0 0 0 7.153-2.36v-.007a6 6 0 0 0-2.927-8.862c-1.286-.479-2.58-.929-3.878-1.365L89.405 101a26.3 26.3 0 0 1 6.76-36.617 26.458 26.458 0 0 1 36.712 6.748l131.91 191.145a25.2 25.2 0 0 1 4.263 17.564 37.189 37.189 0 0 0 6.289 25.91l.486.7a40.833 40.833 0 0 0-17.808 8.769 127.209 127.209 0 0 0-33.992-60.307q-3.73-3.725-7.689-7.073a6 6 0 1 0-7.734 9.169c.868.737 1.718 1.5 2.569 2.272L171.18 299.2a81.267 81.267 0 0 1-18.73-68.162zm95.588 95.316a81.645 81.645 0 0 1-68.364-18.674l40-39.932a114.947 114.947 0 0 1 28.364 58.606zM133.3 229.458q3.606 0 7.208.226a93.145 93.145 0 0 0 22.157 78.016L133.3 337.011l-77.88-77.74a116.086 116.086 0 0 1 77.88-29.813zM17 345.489a115.117 115.117 0 0 1 29.931-77.741l77.88 77.741-29.2 29.147A95.066 95.066 0 0 0 17.22 352.56c-.141-2.345-.22-4.702-.22-7.071zm1.549 19A81.62 81.62 0 0 1 87.1 383.131l-40.171 40.1a114.943 114.943 0 0 1-28.38-58.739zm95.741 95.475a115.728 115.728 0 0 1-58.866-28.26l40.172-40.1a81.234 81.234 0 0 1 18.694 68.363zm11.931 1.331a94.682 94.682 0 0 0-22.121-78.18l29.2-29.148 77.88 77.74a116.214 116.214 0 0 1-84.959 29.593zm93.457-38.069L141.8 345.489l29.375-29.322a93.4 93.4 0 0 0 61.976 23.533 95.248 95.248 0 0 0 16.23-1.408c.145 2.387.227 4.786.227 7.2a115.119 115.119 0 0 1-29.93 77.737zm82.361 24.912a32.929 32.929 0 1 1-32.93-32.93 32.966 32.966 0 0 1 32.93 32.933zm-3.716-49.938-12.695-2.713 16.3-76.012 12.695 2.714zm36.605 31.273 23.512 12.736-9.986 6.866zm47.252 32.469-15.78 10.85a16.048 16.048 0 0 1-22.266-4.091 1.719 1.719 0 0 1 .444-2.4l25.709-17.678 16.254 8.8a15.983 15.983 0 0 1-4.361 4.515zm64.213-10.428-23.406 6.3a18.2 18.2 0 0 1-13.455-1.577l-99.791-54.051 4.5-21 107.011 38.8a13.1 13.1 0 0 1 6.27 4.786zm21.2-58.252-39.452 16.668-111.356-40.588 2.573-12 116.663 8.5a25.206 25.206 0 0 0 3.283-.224zm-27.321-77.326a18.24 18.24 0 0 1 12.247 3.534l19.115 14.154-28.491 18.16a13.259 13.259 0 0 1-8.058 2.031L321.9 345.5l4.769-22.235zm-109.162-4.98-8.916.576-9.436-2.017 21.812-47.241a84.423 84.423 0 0 0 7.664 4.016 82.7 82.7 0 0 0 8.027 3.19zm149.922-126.112c-27.739 60.074-87.751 91.721-133.782 70.544-18.466-8.5-32.4-24.3-40.3-45.7-11.231-30.438-8.63-67.481 7.139-101.631 21.894-47.417 63.895-77.123 103.257-77.123a72.556 72.556 0 0 1 30.524 6.579c18.466 8.5 32.4 24.3 40.3 45.7 11.23 30.438 8.63 67.481-7.138 101.631z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="m108.222 85.293-1.143-1.716a6 6 0 1 0-9.988 6.649l1.142 1.716a6 6 0 1 0 9.989-6.649zM118.358 100.521a6 6 0 0 0-9.988 6.65l42.766 64.244a6 6 0 1 0 9.988-6.649z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>
                            <h1>Sports</h1>
                        </a>
                        <a href="add_product.php?name=Men accessories" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 65 65" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M34.03 41.69a2.228 2.228 0 0 0-2.2-1.91h-.27v-1.6c0-1.68-.65-3.26-1.84-4.43a6.243 6.243 0 0 0-4.43-1.84c-3.46 0-6.27 2.81-6.27 6.27v1.6h-.26c-1.1 0-2.04.82-2.2 1.91l-1.73 12.44c-.09.64.1 1.28.53 1.76.42.48 1.03.76 1.67.76h16.51c.64 0 1.25-.28 1.67-.76s.61-1.13.53-1.76l-1.73-12.44zm-13.06-3.51c0-2.39 1.94-4.33 4.33-4.33 1.15 0 2.24.45 3.06 1.27.82.81 1.26 1.89 1.26 3.05v1.6h-8.65v-1.6zm12.79 16.44s-.1.1-.21.1h-16.5c-.1 0-.17-.05-.21-.1a.302.302 0 0 1-.07-.22l1.73-12.44a.28.28 0 0 1 .28-.24H31.82c.14 0 .26.1.28.24l1.73 12.44c.02.11-.04.19-.07.22z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M60.87 29.26a2.91 2.91 0 0 0 .38-4.05L47.41 8.04c-1-1.25-2.84-1.45-4.09-.45l-11.06 8.82V4.5c0-.54-.43-.97-.97-.97H5.84c-.54 0-.97.43-.97.97v21.26a2.534 2.534 0 0 0-1.76 2.41V58.9c0 1.41 1.14 2.56 2.55 2.56h46.06c1.41 0 2.56-1.15 2.56-2.56v-6.58h5.22c.54 0 .97-.43.97-.97V37.2c0-.54-.43-.97-.97-.97h-5.22v-1.34l6.58-5.63zM44.52 9.11a.97.97 0 0 1 1.37.15l13.84 17.17c.33.42.28 1.01-.13 1.36l-5.32 4.55v-4.16c0-1.41-1.15-2.55-2.56-2.55H32.24v-6.74l12.27-9.78zM30.31 25.63H16.77V5.47h13.54zm-18.07 0V5.47h2.59v20.16zM10.3 5.47v20.16H6.82V5.47zm48.23 44.92H46.5a4.02 4.02 0 0 1-4.02-4.02V42.2c0-2.22 1.8-4.02 4.02-4.02h12.01v12.21zM46.5 36.24c-3.29 0-5.96 2.67-5.96 5.96v4.17c0 3.29 2.67 5.96 5.96 5.96h5.84v6.58c0 .35-.27.62-.62.62H5.66c-.34 0-.61-.28-.61-.62V28.18c0-.34.27-.61.61-.61h46.06c.34 0 .62.27.62.61v8.06z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M22.73 17.24c.54 0 .97-.43.97-.97V8.59c0-.54-.43-.97-.97-.97s-.97.43-.97.97v7.68c0 .54.43.97.97.97zM48.27 41.07c-1.77 0-3.21 1.44-3.21 3.21s1.44 3.21 3.21 3.21 3.21-1.44 3.21-3.21-1.44-3.21-3.21-3.21zm0 4.48c-.7 0-1.27-.57-1.27-1.27s.57-1.27 1.27-1.27 1.27.57 1.27 1.27-.57 1.27-1.27 1.27z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Men accessories</h1>
                        </a>
                        <a href="add_product.php?name=Women accessories" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-1 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M488 360h-80a8 8 0 0 0-8 8v48a8 8 0 0 0 8 8h80a8 8 0 0 0 8-8v-48a8 8 0 0 0-8-8Zm-8 48h-64v-32h64Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    <path d="M390.59 336A41.457 41.457 0 0 0 432 294.59V145.41c0-.586-.013-1.172-.037-1.742A41.277 41.277 0 0 0 400 105.076v-1.384A23.718 23.718 0 0 0 376.309 80h-16.618A23.718 23.718 0 0 0 336 103.692V104H208v-.308A23.718 23.718 0 0 0 184.309 80h-16.618A23.718 23.718 0 0 0 144 103.692v1.384a41.269 41.269 0 0 0-31.962 38.575q-.037.88-.038 1.759V192H42.6A26.626 26.626 0 0 0 16 218.6v170.8A26.626 26.626 0 0 0 42.6 416h82.8a26.626 26.626 0 0 0 26.6-26.6V336h176v8a8 8 0 0 0-8 8v72a8 8 0 0 0 8 8h48a8 8 0 0 0 8-8v-72a8 8 0 0 0-8-8v-8ZM352 103.692A7.7 7.7 0 0 1 359.691 96h16.618a7.7 7.7 0 0 1 7.691 7.692V104h-32ZM167.691 96h16.618a7.7 7.7 0 0 1 7.691 7.692V104h-32v-.308A7.7 7.7 0 0 1 167.691 96Zm-39.668 48.332A25.337 25.337 0 0 1 153.41 120h237.18a25.341 25.341 0 0 1 25.388 24.349c.015.354.022.707.022 1.061v64.1l-105.844 22.28a25.279 25.279 0 0 0-23.4-15.79h-29.512a25.28 25.28 0 0 0-23.4 15.788l-82.162-17.3A26.647 26.647 0 0 0 128 192.128V145.41c0-.354.007-.71.023-1.078ZM296 241.245v13.51a9.254 9.254 0 0 1-9.244 9.245h-29.512a9.254 9.254 0 0 1-9.244-9.245v-13.51a9.254 9.254 0 0 1 9.244-9.245h29.512a9.254 9.254 0 0 1 9.244 9.245ZM64 208h40v1.484A6.523 6.523 0 0 1 97.484 216H70.516A6.523 6.523 0 0 1 64 209.484Zm72 181.4a10.608 10.608 0 0 1-10.6 10.6H42.6A10.608 10.608 0 0 1 32 389.4V218.6A10.608 10.608 0 0 1 42.6 208H48v1.484A22.542 22.542 0 0 0 70.516 232h26.968A22.542 22.542 0 0 0 120 209.484V208h5.4a10.608 10.608 0 0 1 10.6 10.6Zm16-69.4v-89.09l80 16.841v7A25.273 25.273 0 0 0 257.244 280h29.512A25.273 25.273 0 0 0 312 254.755v-7l104-21.892v68.727A25.439 25.439 0 0 1 390.59 320H376v-4.112a15.849 15.849 0 0 0-6.311-12.621l-16.448-12.336A15.776 15.776 0 0 0 328 303.552V320Zm216 96h-32v-56h32Zm-24-72v-40l16 12v28Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>
                            <h1>Women accessories</h1>
                        </a>
                        <a href="add_product.php?name=Furniture" class="bg-white p-3 rounded-md shadow-2xl flex items-center gap-2 cursor-pointer hover:bg-gray-100 hover:ring-[1.5px] hover:ring-gray-500 focus:outline-none focus:ring-[1.5px] focus:ring-gray-500 focus:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="35" height="35" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M502.16 237.16H197.4a6.97 6.97 0 0 1-6.97-6.97V6.97A6.97 6.97 0 0 1 197.4 0h304.76a6.97 6.97 0 0 1 6.97 6.97v43.22c0 3.85-3.12 6.97-6.97 6.97s-6.97-3.12-6.97-6.97V13.94H204.37v209.28h290.82V90.24c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v139.95c0 3.85-3.13 6.97-6.97 6.97zM53.78 508.69H9.84a6.97 6.97 0 0 1-6.97-6.97v-223.2a6.97 6.97 0 0 1 6.97-6.97H68c3.85 0 6.97 3.12 6.97 6.97s-3.12 6.97-6.97 6.97H16.81v209.26H46.8v-21.17a6.97 6.97 0 0 1 6.97-6.97h252.17c3.85 0 6.97 3.12 6.97 6.97s-3.12 6.97-6.97 6.97H60.75v21.17a6.97 6.97 0 0 1-6.97 6.97zM419.2 508.69h-43.93a6.97 6.97 0 0 1-6.97-6.97v-21.17h-33.88c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97h40.85a6.97 6.97 0 0 1 6.97 6.97v21.17h29.99V285.48H121.47c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97H419.2a6.97 6.97 0 0 1 6.97 6.97v223.2c0 3.86-3.12 6.98-6.97 6.98z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M502.16 508.69h-57.88c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97h50.91V178.86c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v322.86c0 3.85-3.13 6.97-6.97 6.97z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M502.16 372.92h-57.88c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97h57.88a6.97 6.97 0 1 1 0 13.94zM502.16 285.48h-57.88c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97h57.88a6.97 6.97 0 1 1 0 13.94zM502.16 133.12H197.4c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97h304.76a6.97 6.97 0 1 1 0 13.94zM419.2 512h-44.02a6.97 6.97 0 0 1-6.97-6.97V385.77c0-27.84 22.65-50.49 50.49-50.49h.5a6.97 6.97 0 0 1 6.97 6.97v162.78a6.97 6.97 0 0 1-6.97 6.97zm-37.05-13.94h30.08V349.8c-17.08 3.07-30.08 18.03-30.08 35.98zM53.86 512H9.84a6.97 6.97 0 0 1-6.97-6.97V342.25a6.97 6.97 0 0 1 6.97-6.97h.49c27.84 0 50.49 22.65 50.49 50.49v119.26a6.954 6.954 0 0 1-6.96 6.97zm-37.05-13.94h30.08V385.78c0-17.95-13-32.92-30.08-35.98z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M375.18 449.09H214.9a6.97 6.97 0 0 1-6.97-6.97v-22.51c.01-20.1 16.37-36.46 36.47-36.46h130.78a6.97 6.97 0 0 1 6.97 6.97v52c0 3.84-3.12 6.97-6.97 6.97zm-153.31-13.94h146.34v-38.06H244.4c-12.42 0-22.53 10.1-22.53 22.52z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M214.14 449.1H53.86a6.97 6.97 0 0 1-6.97-6.97v-52.01a6.97 6.97 0 0 1 6.97-6.97h130.78c20.11 0 36.47 16.36 36.47 36.47v22.51a6.97 6.97 0 0 1-6.97 6.97zM60.83 435.16h146.34v-15.54c0-12.42-10.11-22.53-22.53-22.53H60.83zM402.37 237.16a6.97 6.97 0 0 1-6.97-6.97V6.97c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v223.22c0 3.84-3.12 6.97-6.97 6.97zM452.72 237.16a6.97 6.97 0 0 1-6.97-6.97V126.15c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v104.04a6.97 6.97 0 0 1-6.97 6.97zM300.62 133.12a6.97 6.97 0 0 1-6.97-6.97V8.54c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v117.61a6.97 6.97 0 0 1-6.97 6.97zM316.26 397.09h-42.43c-9.65 0-17.49-7.85-17.49-17.49v-42.43c0-9.65 7.85-17.5 17.49-17.5h42.43c9.65 0 17.49 7.85 17.49 17.5v42.43c0 9.64-7.85 17.49-17.49 17.49zm-42.43-63.48a3.56 3.56 0 0 0-3.55 3.56v42.43a3.55 3.55 0 0 0 3.55 3.55h42.43a3.55 3.55 0 0 0 3.55-3.55v-42.43a3.56 3.56 0 0 0-3.55-3.56z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    <path d="M155.22 397.09h-42.43c-9.65 0-17.5-7.85-17.5-17.49v-42.43c0-9.65 7.85-17.5 17.5-17.5h42.43c9.65 0 17.5 7.85 17.5 17.5v42.43c0 9.64-7.85 17.49-17.5 17.49zm-42.43-63.48c-1.96 0-3.56 1.6-3.56 3.56v42.43c0 1.96 1.6 3.55 3.56 3.55h42.43a3.56 3.56 0 0 0 3.56-3.55v-42.43c0-1.96-1.6-3.56-3.56-3.56zM452.72 456.24a6.97 6.97 0 0 1-6.97-6.97v-33.15c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v33.15a6.97 6.97 0 0 1-6.97 6.97zM233.01 201.72a6.97 6.97 0 0 1-6.97-6.97V161.6c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v33.15a6.97 6.97 0 0 1-6.97 6.97zM316.24 84.48a6.97 6.97 0 0 1-6.97-6.97V60.94c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v16.58c0 3.84-3.12 6.96-6.97 6.96zM284.99 84.48a6.97 6.97 0 0 1-6.97-6.97V60.94c0-3.85 3.12-6.97 6.97-6.97s6.97 3.12 6.97 6.97v16.58c0 3.84-3.12 6.96-6.97 6.96zM469.3 98.91h-33.15c-3.85 0-6.97-3.12-6.97-6.97s3.12-6.97 6.97-6.97h33.15c3.85 0 6.97 3.12 6.97 6.97s-3.12 6.97-6.97 6.97zM115.5 114.78c-2.55 0-4.89-1.39-6.12-3.63l-8.7-15.92-15.91-8.71c-2.24-1.22-3.62-3.57-3.62-6.12s1.39-4.89 3.63-6.11l15.92-8.7 8.71-15.91a6.954 6.954 0 0 1 6.11-3.62c2.55 0 4.89 1.39 6.11 3.63l8.7 15.92 15.91 8.71c2.23 1.22 3.62 3.57 3.62 6.12s-1.39 4.89-3.63 6.11l-15.92 8.7-8.71 15.91a6.934 6.934 0 0 1-6.1 3.62zm-12.86-34.37 6.53 3.57c1.17.64 2.13 1.6 2.77 2.77l3.57 6.53 3.57-6.53c.64-1.17 1.6-2.13 2.77-2.77l6.53-3.57-6.53-3.57a6.965 6.965 0 0 1-2.77-2.77l-3.57-6.53-3.57 6.53a6.965 6.965 0 0 1-2.77 2.77zM60.72 202.12c-2.55 0-4.89-1.39-6.12-3.63l-8.7-15.92-15.91-8.71c-2.24-1.22-3.62-3.57-3.62-6.12s1.39-4.89 3.63-6.11l15.92-8.7 8.71-15.91a6.954 6.954 0 0 1 6.11-3.62c2.55 0 4.89 1.39 6.11 3.63l8.7 15.92 15.91 8.71c2.24 1.22 3.62 3.57 3.62 6.12s-1.39 4.89-3.63 6.11l-15.92 8.7-8.71 15.91a6.934 6.934 0 0 1-6.1 3.62zm-12.86-34.36 6.53 3.57c1.17.64 2.13 1.6 2.77 2.77l3.57 6.53 3.57-6.53c.64-1.17 1.6-2.13 2.77-2.77l6.53-3.57-6.53-3.57a6.965 6.965 0 0 1-2.77-2.77l-3.57-6.53-3.57 6.53a6.965 6.965 0 0 1-2.77 2.77z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                            <h1>Furniture</h1>
                        </a>
                    </div>
                </main>
            </div>
        </div>
    </div>


    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>