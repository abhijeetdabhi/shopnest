<?php
if (isset($_COOKIE['vendor_id'])) {
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /admin/dashboard.php");
    exit;
}
?>

<?php
include "../include/connect.php";

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
    $user_name = $_COOKIE['fname'];

    $retrieve_data = "SELECT * FROM user_registration WHERE user_id = '$user_id'";
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
    <title>Return Orders</title>

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
        include "user_logout.php";
        ?>
    </div>

    <div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-white">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity h-screen bg-black opacity-50 lg:hidden" x-cloak></div>
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0" x-cloak>
                <div class="flex items-center justify-center mt-8 mr-2">
                    <a class="flex w-fit" href="/index.php">
                        <!-- icon logo div -->
                        <div>
                            <img class="w-7 sm:w-14 mt-0.5" src="/src/logo/white_cart_logo.svg" alt="">
                        </div>
                        <!-- text logo -->
                        <div>
                            <img class="w-16 sm:w-36" src="/src/logo/white_text_logo.svg" alt="">
                        </div>
                    </a>
                </div>
                <nav class="mt-10">
                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="profile.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g transform="matrix(0.9799999999999999,0,0,0.9799999999999999,5.120029888153141,5.1200097656250705)">
                                <path d="m498.147 222.58-57.298-57.298V15c0-8.284-6.716-15-15-15h-64.267c-8.284 0-15 6.716-15 15v56.017l-57.174-57.174C280.482 4.916 268.614 0 255.99 0c-12.625 0-24.494 4.916-33.42 13.843L13.832 222.582c-18.428 18.427-18.428 48.411 0 66.838 8.927 8.927 20.795 13.843 33.419 13.843 2.645 0 5.253-.229 7.812-.651v154.223c0 30.419 24.748 55.166 55.167 55.166h97.561c8.284 0 15-6.716 15-15V383.467h66.4V497c0 8.284 6.716 15 15 15h97.56c30.419 0 55.166-24.747 55.166-55.166V302.611c2.558.423 5.165.651 7.81.651h.003c12.622 0 24.49-4.916 33.419-13.844 8.926-8.926 13.842-20.794 13.843-33.418-.002-12.624-4.918-24.493-13.845-33.42zM376.583 30h34.267v105.283l-34.267-34.268zm25.167 452h-82.56V368.467c0-8.284-6.716-15-15-15h-96.4c-8.284 0-15 6.716-15 15V482h-82.561c-13.877 0-25.167-11.289-25.167-25.166V285.025L255.99 114.101l170.926 170.926v171.808c0 13.876-11.289 25.165-25.166 25.165zm75.186-213.795a17.155 17.155 0 0 1-12.208 5.058 17.156 17.156 0 0 1-12.204-5.055l-.004-.004L266.597 82.281c-5.856-5.859-15.354-5.857-21.213 0L59.459 268.203l-.005.005c-3.26 3.26-7.593 5.055-12.203 5.055s-8.945-1.795-12.206-5.056c-6.73-6.73-6.73-17.682 0-24.412L243.783 35.056A17.152 17.152 0 0 1 255.99 30c4.61 0 8.945 1.796 12.205 5.056l82.781 82.78 125.958 125.957c6.731 6.73 6.731 17.683.002 24.412z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Home</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="show_orders.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 96 96" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="m90.895 25.211-42-21a2.004 2.004 0 0 0-1.789 0l-42 21A2 2 0 0 0 4 27v42a2 2 0 0 0 1.105 1.789l42 21a1.998 1.998 0 0 0 1.79 0l42-21A2 2 0 0 0 92 69V27a2 2 0 0 0-1.105-1.789zM48 8.236 85.528 27 77.5 31.014 39.973 12.25zm13.5 30.778L23.972 20.25 35.5 14.486 73.028 33.25zm1.5 3.722 12-6v14.877l-3.838-2.741a2.006 2.006 0 0 0-1.506-.343 2.007 2.007 0 0 0-1.301.832L63 57.098zm-43.5-20.25L57.027 41.25 48 45.764 10.472 27zM8 30.236l38 19v37.527l-38-19zm42 56.528V49.236l9-4.5V63.5a2 2 0 0 0 3.645 1.139l7.845-11.331 5.349 3.82A1.997 1.997 0 0 0 79 55.5V34.736l9-4.5v37.527z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Your orders</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="cancled_product.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M511.902 126.274a16 16 0 0 0-9.135-12.773l-240-112c-4.29-2.001-9.244-2-13.533 0l-240 112a15.999 15.999 0 0 0-9.135 12.768A89.385 89.385 0 0 0 0 128v272a15.998 15.998 0 0 0 10.058 14.855l240 96a16 16 0 0 0 11.883.001l65.032-26.007C346.596 501.761 372.124 512 400 512c61.757 0 112-50.243 112-112V128c0-.08-.087-1.616-.098-1.726zM256 33.656l199.743 93.214-76.913 30.765-203.503-86.332zm-16 438.711-208-83.2V151.632l208 83.2zm16-265.6L56.256 126.87l80.053-37.358 200.346 84.993zM400 480c-44.112 0-80-35.888-80-80s35.888-80 80-80 80 35.888 80 80-35.888 80-80 80zm0-192c-61.757 0-112 50.243-112 112 0 21.716 6.219 42.003 16.96 59.188L272 472.369V234.832l208-83.2v170.07C459.656 300.92 431.311 288 400 288z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="m422.627 400 12.686-12.686c6.249-6.249 6.249-16.379 0-22.628-6.248-6.248-16.379-6.248-22.627 0L400 377.372l-12.687-12.687c-6.248-6.248-16.379-6.248-22.627 0-6.249 6.249-6.249 16.379 0 22.628L377.373 400l-12.686 12.686c-6.249 6.249-6.249 16.379 0 22.628C367.811 438.438 371.905 440 376 440s8.189-1.562 11.313-4.686L400 422.627l12.687 12.687C415.811 438.438 419.905 440 424 440s8.189-1.562 11.313-4.686c6.249-6.249 6.249-16.379 0-22.628z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Cancled orders</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="show_return_order.php">
                        <svg class="w-7 h-7 fill-white -ml-1" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 100 100" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M73.76 38.48v23.07a1.74 1.74 0 0 1-1.27 1.71l-21.8 7.65a1.59 1.59 0 0 1-1.38 0l-21.9-7.65a1.73 1.73 0 0 1-1.17-1.71l-.11-23.07a1.83 1.83 0 0 1 1.38-1.7l21.91-7.65a1.14 1.14 0 0 1 1.16 0l22 7.65a1.73 1.73 0 0 1 1.17 1.7zM29.21 89.94a1.81 1.81 0 0 1 1.71-3.19A41.41 41.41 0 0 0 82.27 24a.41.41 0 0 0-.75.32l.32 1.28c.64 2.34-2.87 3.19-3.51 1l-2.55-9.79A1.74 1.74 0 0 1 78 14.67l9.68 2.55a1.82 1.82 0 0 1-1 3.51l-1.91-.53c-.43-.11-.75.32-.43.63a45.06 45.06 0 0 1-55.13 69.11zm42.64-79.31c2.12 1.17.32 4.36-1.7 3.19A41.43 41.43 0 0 0 17.73 76a.44.44 0 0 0 .75-.42l-.32-1.17c-.64-2.34 2.87-3.19 3.51-1l2.55 9.78A1.75 1.75 0 0 1 22 85.37l-9.68-2.55c-2.34-.64-1.38-4.15.85-3.51l2 .53c.43.11.75-.32.43-.74C.51 61.45 1.68 34.66 18.16 18.18a45.07 45.07 0 0 1 53.69-7.55zm-20.1 37.1v18.4a.47.47 0 0 0 .64.42l17.54-6.17c.11-.1.32-.21.32-.42V41.57c0-.22-.32-.43-.63-.32l-17.55 6.06c-.21.1-.32.21-.32.42zm-3.61 18.4v-18.4a.55.55 0 0 0-.21-.42l-7.13-2.45a.47.47 0 0 0-.63.43v6.8a1.8 1.8 0 0 1-1.81 1.81 1.86 1.86 0 0 1-1.81-1.81v-8.4a.55.55 0 0 0-.21-.42l-6-2c-.31-.11-.63.1-.63.32V60c0 .21.1.32.32.42l17.54 6.17c.32.11.53-.11.53-.42zm-13.5-27.22 4.68 1.59a.19.19 0 0 0 .31 0l15.21-5.31c.21 0 .32-.21.32-.43a.35.35 0 0 0-.32-.32l-4.68-1.7h-.32l-15.2 5.32a.44.44 0 0 0 0 .85zm11.48 4 3.72 1.27h.32l15.2-5.31a.44.44 0 0 0 0-.85l-3.82-1.38h-.32l-15.1 5.46c-.43.1-.43.64 0 .85zm19.56 12.27a1.8 1.8 0 0 1 1.17 3.4L60.9 60.7a1.8 1.8 0 0 1-1.17-3.4z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Return orders</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="show_reviews.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512.002 512.002" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M151.57 208.93c-1.86-1.86-4.44-2.93-7.07-2.93s-5.209 1.069-7.07 2.93c-1.86 1.86-2.93 4.44-2.93 7.07s1.07 5.21 2.93 7.069c1.86 1.86 4.44 2.931 7.07 2.931s5.21-1.07 7.07-2.931c1.86-1.859 2.93-4.439 2.93-7.069s-1.07-5.21-2.93-7.07z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M482 0H84C67.458 0 54 13.458 54 30v166c0 16.542 13.458 30 30 30h18c5.523 0 10-4.478 10-10s-4.477-10-10-10H84c-5.514 0-10-4.486-10-10V30c0-5.514 4.486-10 10-10h398c5.514 0 10 4.486 10 10v166c0 5.514-4.486 10-10 10h-66.887a10.001 10.001 0 0 0-7.071 2.929l-32.929 32.929-32.929-32.929a10.001 10.001 0 0 0-7.071-2.929h-77.985a58.724 58.724 0 0 0-2.507-5.579c-7.16-13.911-19.348-24.078-34.316-28.629l-14.458-4.396c-5.09-1.55-10.502 1.162-12.312 6.165l-22.718 62.789a75.664 75.664 0 0 1-34.993 40.74l-21.326 11.612c-5.241-6.362-13.176-10.425-22.043-10.425h-63.9c-15.744 0-28.552 12.809-28.552 28.553v176.616C.001 499.191 12.81 512 28.554 512h63.9c9.954 0 18.729-5.123 23.841-12.868l10.204 4.002a127.9 127.9 0 0 0 46.898 8.868h134.928c20.245 0 36.715-16.47 36.715-36.715a36.47 36.47 0 0 0-4.962-18.396c14.894-4.681 25.729-18.615 25.729-35.034a36.489 36.489 0 0 0-5.2-18.81c14.26-5.044 24.506-18.655 24.506-34.621 0-16.63-11.118-30.705-26.308-35.203a36.475 36.475 0 0 0 4.865-18.229c0-20.244-16.47-36.715-36.715-36.715h-80.188l11.214-33.294a57.464 57.464 0 0 0 3.02-18.984h69.97l37.071 37.071c1.953 1.952 4.512 2.929 7.071 2.929s5.119-.977 7.071-2.929L419.256 226H482c16.542 0 30-13.458 30-30V30c0-16.542-13.458-30-30-30zM101.007 483.447c-.001 4.716-3.837 8.553-8.553 8.553h-63.9c-4.716 0-8.552-3.837-8.552-8.553V306.831c0-4.716 3.836-8.553 8.552-8.553h21.95v123.121c0 5.522 4.477 10 10 10s10-4.478 10-10V298.278h21.95c3.735 0 6.91 2.411 8.073 5.755.083.484.203.964.361 1.439.071.444.119.895.119 1.359v176.616zm225.949-185.17v.001c9.217 0 16.715 7.498 16.715 16.715 0 9.217-7.498 16.716-16.715 16.716h-54.251c-5.523 0-10 4.478-10 10s4.477 10 10 10l75.694.002c9.217 0 16.715 7.498 16.715 16.715 0 9.217-7.498 16.716-16.715 16.716h-75.694c-5.523 0-10 4.478-10 10s4.477 10 10 10h56.388c9.217 0 16.715 7.498 16.715 16.715 0 9.217-7.498 16.715-16.715 16.715h-56.388c-5.523 0-10 4.478-10 10s4.477 10 10 10h35.621c9.217 0 16.715 7.499 16.715 16.716 0 9.217-7.498 16.715-16.715 16.715H173.397c-13.607 0-26.929-2.52-39.596-7.487l-12.795-5.018V307.931l24.381-13.276a95.638 95.638 0 0 0 44.235-51.5l19.489-53.862 5.376 1.634c9.75 2.965 17.688 9.587 22.352 18.647s5.441 19.369 2.188 29.026l-15.657 46.485a10 10 0 0 0 9.477 13.192h94.109z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M466.201 96.976c-1.894-5.824-6.836-9.989-12.898-10.868l-17.688-2.565-7.915-16.025c-2.712-5.491-8.199-8.901-14.323-8.901h-.004c-6.125.002-11.613 3.415-14.322 8.908l-7.906 16.03-17.688 2.575c-6.061.883-11.001 5.05-12.892 10.876-1.891 5.825-.341 12.1 4.047 16.375l12.802 12.472-3.017 17.617c-1.034 6.038 1.402 12.023 6.359 15.623a15.918 15.918 0 0 0 9.372 3.065c2.54 0 5.094-.613 7.453-1.854l15.819-8.322 15.823 8.313c5.422 2.848 11.868 2.381 16.823-1.221 4.954-3.602 7.387-9.589 6.35-15.626l-3.026-17.615 12.797-12.48c4.381-4.278 5.928-10.553 4.034-16.377zm-32.313 16.017a15.971 15.971 0 0 0-4.59 14.141l2.003 11.662-10.479-5.506a15.977 15.977 0 0 0-14.864.006l-10.473 5.51 1.997-11.663a15.97 15.97 0 0 0-4.598-14.14l-8.477-8.258 11.711-1.705a15.965 15.965 0 0 0 12.025-8.741l5.235-10.613 5.24 10.61a15.973 15.973 0 0 0 12.03 8.735l11.711 1.698-8.471 8.264zM338.988 96.976c-1.895-5.824-6.836-9.988-12.898-10.868l-17.688-2.565-7.915-16.025c-2.712-5.491-8.199-8.901-14.323-8.901h-.004c-6.125.002-11.614 3.415-14.323 8.909l-7.905 16.029-17.688 2.575c-6.061.883-11.001 5.05-12.892 10.876-1.891 5.825-.341 12.1 4.047 16.375l12.802 12.472-3.017 17.617c-1.034 6.038 1.403 12.024 6.359 15.623a15.915 15.915 0 0 0 9.371 3.065c2.54 0 5.093-.613 7.452-1.854l15.819-8.322 15.824 8.313c5.423 2.848 11.867 2.381 16.823-1.221 4.954-3.602 7.387-9.589 6.35-15.626l-3.026-17.615 12.797-12.48c4.383-4.278 5.93-10.552 4.035-16.377zm-32.313 16.017a15.971 15.971 0 0 0-4.59 14.141l2.003 11.662-10.479-5.505a15.974 15.974 0 0 0-14.865.005l-10.473 5.51 1.997-11.663a15.97 15.97 0 0 0-4.598-14.14l-8.477-8.258 11.71-1.705a15.972 15.972 0 0 0 12.027-8.742l5.234-10.613 5.239 10.609a15.971 15.971 0 0 0 12.031 8.737l11.711 1.698-8.47 8.264zM211.776 96.976c-1.895-5.824-6.837-9.989-12.898-10.868l-17.688-2.565-7.915-16.025c-2.712-5.491-8.199-8.901-14.323-8.901h-.004c-6.125.002-11.614 3.415-14.323 8.909l-7.905 16.029-17.688 2.575c-6.062.883-11.001 5.051-12.893 10.877-1.891 5.825-.34 12.1 4.047 16.374l12.802 12.472-3.017 17.617c-1.034 6.038 1.403 12.024 6.359 15.623a15.915 15.915 0 0 0 9.371 3.065c2.54 0 5.093-.613 7.452-1.854l15.819-8.322 15.823 8.313c5.422 2.848 11.868 2.381 16.823-1.221 4.954-3.602 7.387-9.589 6.35-15.626l-3.026-17.615 12.797-12.48c4.385-4.278 5.931-10.552 4.037-16.377zm-32.313 16.017a15.971 15.971 0 0 0-4.59 14.141l2.003 11.662-10.479-5.505a15.974 15.974 0 0 0-14.865.005l-10.473 5.51 1.998-11.666a15.977 15.977 0 0 0-4.599-14.137l-8.477-8.258 11.71-1.705a15.972 15.972 0 0 0 12.027-8.742l5.234-10.613 5.239 10.609a15.971 15.971 0 0 0 12.031 8.737l11.712 1.698-8.471 8.264zM60.504 447.359c-5.523 0-10 4.478-10 10v.156c0 5.522 4.477 10 10 10s10-4.478 10-10v-.156c0-5.522-4.477-10-10-10z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Your reviews</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="my_address.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M341.476 338.285c54.483-85.493 47.634-74.827 49.204-77.056C410.516 233.251 421 200.322 421 166 421 74.98 347.139 0 256 0 165.158 0 91 74.832 91 166c0 34.3 10.704 68.091 31.19 96.446l48.332 75.84C118.847 346.227 31 369.892 31 422c0 18.995 12.398 46.065 71.462 67.159C143.704 503.888 198.231 512 256 512c108.025 0 225-30.472 225-90 0-52.117-87.744-75.757-139.524-83.715zm-194.227-92.34a15.57 15.57 0 0 0-.517-.758C129.685 221.735 121 193.941 121 166c0-75.018 60.406-136 135-136 74.439 0 135 61.009 135 136 0 27.986-8.521 54.837-24.646 77.671-1.445 1.906 6.094-9.806-110.354 172.918L147.249 245.945zM256 482c-117.994 0-195-34.683-195-60 0-17.016 39.568-44.995 127.248-55.901l55.102 86.463a14.998 14.998 0 0 0 25.298 0l55.101-86.463C411.431 377.005 451 404.984 451 422c0 25.102-76.313 60-195 60z" fill="" opacity="1" data-original="#000000"></path>
                                <path d="M256 91c-41.355 0-75 33.645-75 75s33.645 75 75 75 75-33.645 75-75-33.645-75-75-75zm0 120c-24.813 0-45-20.187-45-45s20.187-45 45-45 45 20.187 45 45-20.187 45-45 45z" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Your address</span>
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

            <div class="flex flex-col flex-1">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-600">
                    <div class="flex items-center justify-between">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <div class="flex flex-col mx-4 lg:mx-0">
                            <h1 class="font-semibold text-2xl">Hello
                                <span id="usersName">
                                    <?php
                                    if (isset($_COOKIE['user_id'])) {
                                        echo $user_name;
                                    } else {
                                        echo 'User';
                                    }
                                    ?>
                                </span>!
                            </h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-9 h-9 overflow-hidden rounded-full shadow border ring-0">
                                <img class="object-cover w-full h-full" src="<?php
                                                                                if (isset($_COOKIE['user_id'])) {
                                                                                    echo '../src/user_dp/' . $row['profile_image'];
                                                                                } else {
                                                                                    echo 'https://static.vecteezy.com/system/resources/previews/005/129/844/non_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg';
                                                                                }
                                                                                ?>" alt="Your avatar">
                            </button>
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
                            <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl ring-2 ring-gray-300 divide-y-2 divide-gray-300" style="display: none;">
                                <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Profile</a>
                                <a href="show_orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Orders</a>
                                <a id="logoutButton2" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                            </div>
                        </div>
                    </div>
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
                </header>
                <section class="relative pt-7 overflow-y-scroll h-full">
                    <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
                        <h2 class="font-manrope font-bold text-4xl leading-10 text-black text-center mb-11">Your return orders</h2>
                        <div class="w-full px-3 min-[400px]:px-6">
                            <?php
                            if (isset($_COOKIE['user_id'])) {
                                $retrieve_order = "SELECT * FROM return_orders WHERE user_id = '$user_id'";
                                $retrieve_order_query = mysqli_query($con, $retrieve_order);

                                while ($res = mysqli_fetch_assoc($retrieve_order_query)) {
                                    $today = date('d-m-Y', strtotime($res['date']));
                                    $future_date = date('d-m-Y', strtotime('+5 days', strtotime($today)));

                            ?>
                                    <div class="flex flex-col md:flex-row items-center py-5 bg-gray-100 px-5 gap-6 w-full mb-7 rounded-xl shadow-md hover:shadow-lg transition-shadow md:h-44">
                                        <div class="w-full md:w-auto text-center md:text-left">
                                            <a href="../product/product_detail.php?product_id=<?php echo $res['product_id'] ?>">
                                                <img class="aspect-square w-full md:w-32 lg:w-36 object-cover rounded-lg mix-blend-multiply" src="<?php echo isset($_COOKIE['user_id']) ? '../src/product_image/product_profile/' . $res['return_order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-4 md:gap-6 lg:gap-10">
                                            <div class="flex-1">
                                                <a href="../product/product_detail.php?product_id=<?php echo $res['product_id'] ?>" class="font-semibold text-lg md:text-xl text-gray-800 line-clamp-2"><?php echo isset($_COOKIE['user_id']) ? $res['return_order_title'] : 'return_order_title' ?></a>
                                                <p class="text-gray-600 mt-2 space-x-1">
                                                    <span class="font-medium">Price:</span>
                                                    <span class="text-black">
                                                        ₹<?php echo isset($_COOKIE['user_id']) ? $res['return_order_price'] : 'return_order_price' ?>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="flex items-center justify-between md:justify-normal gap-5 md:gap-10 w-full md:w-auto">
                                                <div class="text-center">
                                                    <p class="text-sm md:text-base md:font-medium text-gray-700 mb-1">Status</p>
                                                    <span class="inline-block px-4 py-1 rounded-tl-lg rounded-br-lg bg-red-100 text-red-600 text-sm font-medium">Return</span>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-sm md:text-base md:font-medium text-gray-700 mb-1">Order return date</p>
                                                    <span class="text-blue-500 font-semibold">
                                                        <?php echo isset($_COOKIE['user_id']) ? $res['date'] : 'Date' ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<div class="relative font-bold text-2xl w-max text-center mt-12 flex items-center justify-center m-auto">No data available for this period.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>