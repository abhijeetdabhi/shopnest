<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<?php
include "../include/connect.php";

session_start();

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

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>View Products</title>
    <style>
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

        [x-cloak] {
            display: none;
        }

        #logoutPopUp {
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

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="order_request.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M124 53h-8a4.004 4.004 0 0 0-4 4v2.068l-2.51.07a1.802 1.802 0 0 0-.145.008 4.268 4.268 0 0 1-4.134-1.46A17.653 17.653 0 0 0 92.17 52l-20.487.126a7.058 7.058 0 0 0-4.982 2.034 5.591 5.591 0 0 0-1.646 3.996c.045 3.272 3.056 5.92 6.724 5.92h.04l9.583-.062H86l5.259 9.303a2 2 0 0 0 3.482-1.968l-5.833-10.32a2 2 0 0 0-1.741-1.015l-15.37.062h-.019c-1.463 0-2.708-.901-2.722-1.972a1.622 1.622 0 0 1 .503-1.144 3.038 3.038 0 0 1 2.152-.834L92.196 56a13.456 13.456 0 0 1 10.081 4.404 8.001 8.001 0 0 0 6.244 2.787q.557 0 1.15-.057l2.329-.065v21.467l-1.98-.074a8.11 8.11 0 0 0-7.364 2.828 13.259 13.259 0 0 1-9.936 4.518l-8.72.055V68.605l-.334-.591h-2.263L80 68.023V98H61.698A5.806 5.806 0 0 0 56 103.896V124H5.999A1.973 1.973 0 0 1 4 122.058V5.942A1.973 1.973 0 0 1 5.999 4h72.002A1.973 1.973 0 0 1 80 5.942v42.133l4-.025V5.942A5.978 5.978 0 0 0 78.001 0H5.999A5.978 5.978 0 0 0 0 5.942v116.116A5.978 5.978 0 0 0 5.999 128h51.076a2 2 0 0 0 1.424-.595l24.925-25.252a2.002 2.002 0 0 0 .576-1.405v-4.885l8.745-.055a17.442 17.442 0 0 0 12.9-5.859 4.16 4.16 0 0 1 4.076-1.498l.101.007 2.178.081V91a4.004 4.004 0 0 0 4 4h8a4.004 4.004 0 0 0 4-4V57a4.004 4.004 0 0 0-4-4Zm-64 67.19v-16.294A1.807 1.807 0 0 1 61.698 102h16.257ZM124 91h-8V57h8Z" fill="CurrentColor" opacity="1" data-original="#000000" class=""></path>
                                <path d="M58 15a2 2 0 0 0 0-4H26a2 2 0 0 0 0 4ZM72 23H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM72 31H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM74 45a2 2 0 0 0-2-2H32a2 2 0 0 0 0 4h40a2 2 0 0 0 2-2ZM72 71H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM72 83H32a2 2 0 0 0 0 4h40a2 2 0 0 0 0-4ZM74 93a2 2 0 0 0-2-2H32a2 2 0 0 0 0 4h40a2 2 0 0 0 2-2ZM62.464 63H32a2 2 0 0 0 0 4h35.006a10.57 10.57 0 0 1-4.542-4ZM32 55h29.587a9.768 9.768 0 0 1 2.259-3.64c.124-.127.26-.24.391-.36H32a2 2 0 0 0 0 4ZM10 117h28a2 2 0 0 0 0-4H10a2 2 0 0 0 0 4ZM16 37a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4ZM16 57a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4ZM16 77a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4ZM16 97a8 8 0 1 0-8-8 8.01 8.01 0 0 0 8 8Zm0-12a4 4 0 1 1-4 4 4.004 4.004 0 0 1 4-4Z" fill="CurrentColor" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Orders Request</span>
                        <?php
                            if (isset($_SESSION['existingOrder'])) {
                                if ($_SESSION['existingOrder'] < $_SESSION['currentOrder']) {
                            ?>  
                                    <span class="relative flex size-2">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                                    </span>
                            <?php
                                }
                            }
                        ?>
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

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="view_products.php">
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
                <main class="relative flex-1 overflow-x-hidden overflow-y-auto scrollBar bg-gray-200">
                    <div class="py-12 max-w-screen-xl m-auto px-6">
                        <span class="text-2xl font-semibold">Your products</span>
                        <div class="grid grid-cols-1 min-[480px]:grid-cols-2 md:grid-cols-3 min-[1258px]:grid-cols-4 gap-y-8 text-[#1d2128] mt-4">
                            <?php
                            if (isset($_COOKIE['vendor_id'])) {
                                $product_find = "SELECT * FROM products WHERE vendor_id = $vendor_id";
                                $product_query = mysqli_query($con, $product_find);

                                if (mysqli_num_rows($product_query) > 0) {
                                    while ($res = mysqli_fetch_assoc($product_query)) {
                            ?>
                                        <div class="flex justify-center relative">
                                            <div class="bg-white border rounded-tl-2xl rounded-br-2xl transition transform hover:shadow-lg overflow-hidden h-[28rem] w-[17rem]">
                                                <div class="p-3">
                                                    <div>
                                                        <img src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/product_image/product_profile/' . $res['profile_image_1'] : '../src/sample_images/product_1.jpg' ?>" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl mix-blend-multiply" alt="">
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="space-y-1">
                                                            <a href="../product/product_detail.php?product_id=<?php echo isset($_COOKIE['vendor_id']) ? $res['product_id'] : 'product_id' ?>" class="text-base font-medium line-clamp-2 cursor-pointer"><?php echo isset($_COOKIE['vendor_id']) ? $res['title'] : 'product Name' ?></a>
                                                            <p class="space-x-2">
                                                                <span class="text-lg font-medium text-gray-500">₹<?php echo isset($_COOKIE['vendor_id']) ? $res['vendor_mrp'] : 'MRP' ?></span>
                                                                <del class="text-xs font-normal">₹<?php echo isset($_COOKIE['vendor_id']) ? $res['vendor_price'] : 'Delete Price' ?></del>
                                                            </p>
                                                            <h2>QTY: <?php echo isset($_COOKIE['vendor_id']) ? $res['Quantity'] : 'product Quantity' ?></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="absolute bottom-0 w-full">
                                                    <div class="w-full flex justify-between h-10 divide-x-2 border-t-2">
                                                        <!-- edit -->
                                                        <a href="update_product.php?product_id=<?php echo $res['product_id'] ?>&name=<?php echo $res['Category'] ?>" title="Edit Your Product" class="w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                            Edit
                                                        </a>

                                                        <!-- delete -->
                                                        <a href="delete_product.php?product_id=<?php echo $res['product_id'] ?>" title="Delete Your Product" class="w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                                            <i class="fa-solid fa-trash text-base"></i>
                                                            Remove
                                                        </a>
                                                    </div>
                                                    <div class="border-t-2 w-full ">
                                                        <!-- edit -->
                                                        <a href="add_color.php?product_id=<?php echo $res['product_id'] ?>" class="inline-flex justify-center items-center gap-1 text-blue-600 w-full py-2">
                                                            <svg class="w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                                <g>
                                                                    <path d="M14 32a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5-5Zm0 8a3 3 0 1 1 3-3 3.003 3.003 0 0 1-3 3Zm9 3a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5-5Zm0 8a3 3 0 1 1 3-3 3.003 3.003 0 0 1-3 3Zm-6-23a5 5 0 1 0-5-5 5.006 5.006 0 0 0 5 5Zm0-8a3 3 0 1 1-3 3 3.003 3.003 0 0 1 3-3Zm13 1a5 5 0 1 0-5-5 5.006 5.006 0 0 0 5 5Zm0-8a3 3 0 1 1-3 3 3.003 3.003 0 0 1 3-3Zm31.363-8.363C58.798 2.072 51.15 8 46.458 12.41A26.998 26.998 0 1 0 29 60c2.852 0 5.09-.979 6.146-2.686.663-1.072 1.158-2.943-.251-5.761a6.297 6.297 0 0 1-.052-5.961C35.89 43.896 38.02 43 41 43c7.417 0 15-1.188 15-10a27.003 27.003 0 0 0-3.171-12.662c4.443-4.57 11.25-12.983 8.534-15.701ZM59.95 6.05c.626.675-1.721 6.07-9.119 13.467a62.857 62.857 0 0 1-5.708 5.071 12.112 12.112 0 0 0-3.711-3.711 62.857 62.857 0 0 1 5.071-5.708C53.88 7.772 59.276 5.427 59.95 6.05ZM38.125 25.888a25.742 25.742 0 0 1 2.089-3.407 10.117 10.117 0 0 1 3.305 3.305 25.742 25.742 0 0 1-3.407 2.089 6.034 6.034 0 0 0-1.987-1.987ZM39 31c0 2.365-2.464 5-6 5a8.602 8.602 0 0 1-5.924-2.023c2.116-.458 3.069-2.247 3.87-3.751C32.012 28.226 32.777 27 35 27a4.004 4.004 0 0 1 4 4Zm2 10c-4.687 0-6.86 1.925-7.858 3.54a8.211 8.211 0 0 0-.037 7.907c.801 1.6.915 2.885.34 3.817C32.771 57.35 31.11 58 29 58a25 25 0 1 1 16-44.174c-4.05 4.06-7.23 8.197-8.732 11.312A5.996 5.996 0 0 0 35 25c-3.537 0-4.802 2.376-5.818 4.285-1.093 2.052-1.768 3.102-4.018 2.729a1 1 0 0 0-1.059 1.433C24.198 33.633 26.457 38 33 38c4.785 0 8-3.62 8-7a5.996 5.996 0 0 0-.138-1.268 44.957 44.957 0 0 0 10.48-7.926A24.998 24.998 0 0 1 54 33c0 5.757-3.645 8-13 8Z" data-name="29-Art" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                                </g>
                                                            </svg>
                                                            <h2>Add colors</h2>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                } else {
                                    echo '<div class="absolute font-bold text-2xl mt-4 flex items-center justify-center w-full m-auto">No data available for this period.</div>';
                                }
                            } else {
                                echo '<div class="absolute font-bold text-2xl mt-4 flex items-center justify-center w-full m-auto">No data available for this period.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>