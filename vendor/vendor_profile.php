<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: /index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /admin/dashboard.php");
    exit;
}
?>

<?php
include "../include/connect.php";

if (isset($_COOKIE['vendor_id'])) {
    $vendor_id = $_COOKIE['vendor_id'];

    $retrieve_data = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);
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
    <title>Vendor Deshboard</title>
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
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-center mt-8 mr-2">
                    <a class="flex w-fit" href="">
                        <!-- icon logo div -->
                        <div>
                            <img class="w-7 sm:w-14 mt-0.5" src="../src/logo/white_cart_logo.svg" alt="">
                        </div>
                        <!-- text logo -->
                        <div>
                            <img class="w-16 sm:w-36" src="../src/logo/white_text_logo.svg" alt="">
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

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="vendor_profile.php">
                        <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
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

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="vendor_logout.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                            <path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path>
                        </svg>
                        <span class="mx-3">Log out</span>
                    </a>
                </nav>
            </div>

            <div class="flex flex-col flex-1">
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
                                <a href="vendor_logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                            </div>
                        </div>
                    </div>
                </header>
                <main id="main" class="overflow-y-auto scrollBar">
                    <div class="mx-4 md:mx-12 my-12 bg-white shadow-lg">
                        <div class="relative">
                            <div class="relative">
                                <img class="h-40 md:h-80 w-full" src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/vendor_images/vendor_cover_image/' . $row['cover_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png' ?>" alt="">
                            </div>
                        </div>
                        <div class="relative m-auto -translate-y-[3rem] md:-translate-y-[4rem]">
                            <img class="w-20 h-20 md:w-28 md:h-28 m-auto rounded-full object-cover" src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/vendor_images/vendor_profile_image/' . $row['dp_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png' ?>" alt="">
                            <input type="file" id="dpImage" name="dp" class="hidden">
                        </div>
                        <div class="m-auto text-center -mt-20 py-8">
                            <div class="mt-3">
                                <h2 class="text-2xl font-medium text-gray-950"><?php echo isset($_COOKIE['vendor_id']) ? $row['username'] : 'username' ?></h2>
                                <span class="text-base font-medium text-gray-400 mt-2 mb-7">Seller</span>
                            </div>
                            <div class="mt-6">
                                <h3 class="text-base font-medium text-gray-950">About me</h3>
                                <p class="text-sm font-normal text-gray-800 mt-4 max-w-3xl m-auto"><?php echo isset($_COOKIE['vendor_id']) ? $row['Bio'] : 'Bio' ?></p>
                            </div>
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