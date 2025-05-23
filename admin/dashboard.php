<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}
?>

<?php

include "../include/connect.php";

session_start();

if (isset($_COOKIE['adminEmail'])) {
    // for views
    $views = "SELECT * FROM page_count";
    $views_query = mysqli_query($con, $views);

    $Cview = mysqli_num_rows($views_query);

    $weekly = " SELECT view_date, COUNT(view_count) as total_count 
        FROM page_count 
        WHERE view_date >= CURDATE() - INTERVAL 16 DAY
        GROUP BY view_date 
        ORDER BY view_date DESC
    ";
    $weekQuery = mysqli_query($con, $weekly);

    $weekData = array();
    while ($row = mysqli_fetch_assoc($weekQuery)) {
        $date = $row['view_date'];
        $myDate = date('j/n/y', strtotime($date));
        $weekData[] = array(
            'date' => $myDate,
            'count' => (int) $row['total_count']
        );
    }

    $week_json = json_encode($weekData);

    $monthly = " SELECT view_date, COUNT(view_count) as total_count 
        FROM page_count 
        WHERE view_date >= CURDATE() - INTERVAL 1 MONTH
        GROUP BY view_date 
        ORDER BY view_date DESC
    ";

    $monthQuery = mysqli_query($con, $monthly);

    $monthData = array();
    while ($row = mysqli_fetch_assoc($monthQuery)) {
        $date = $row['view_date'];
        $myDate = date('j/n/y', strtotime($date));
        $monthData[] = array(
            'date' => $myDate,
            'count' => (int) $row['total_count']
        );
    }
    $month_json = json_encode($monthData);

    // for profit
    $earning_orders = "SELECT * FROM orders";
    $earning_query = mysqli_query($con, $earning_orders);

    $totalEarnings = 0;
    foreach ($earning_query as $earnings) {
        $trimEarnings = str_replace(",", "", $earnings['admin_profit']);
        $totalEarnings += $trimEarnings;
    }

    // for total products
    $products = "SELECT * FROM products";
    $products_query = mysqli_query($con, $products);

    $products = mysqli_num_rows($products_query);

    // for total users
    $users = "SELECT * FROM user_registration";
    $users_query = mysqli_query($con, $users);

    $user = mysqli_num_rows($users_query);


    // for total vendors
    $vendors = "SELECT * FROM vendor_registration";
    $vendors_query = mysqli_query($con, $vendors);

    $vendor = mysqli_num_rows($vendors_query);


    // new user in this week
    $nUsers = array();
    $newUser = "SELECT date, COUNT(date) as total_user FROM user_registration GROUP BY date";
    $newUser_query = mysqli_query($con, $newUser);

    while ($nusr = mysqli_fetch_assoc($newUser_query)) {
        $nUsers[] = array(
            'date' => $nusr['date'],
            'users' => (int) $nusr['total_user']
        );
    }

    $user_json = json_encode($nUsers);


    // new vendor in this week
    $nvendor = array();
    $newVendor = "SELECT date, COUNT(date) as total_vendor FROM vendor_registration GROUP BY date";
    $newVendor_query = mysqli_query($con, $newVendor);

    while ($nvndr = mysqli_fetch_assoc($newVendor_query)) {
        $nvendor[] = array(
            'date' => $nvndr['date'],
            'vendor' => (int) $nvndr['total_vendor']
        );
    }

    $vendor_json = json_encode($nvendor);


    if (!isset($_SESSION['existingData'])) {
        $_SESSION['existingData'] = 0;
    }

    $newData = "SELECT * FROM vendor_request WHERE status = 'Pending'";
    $newDataQuery = mysqli_query($con, $newData);

    $newCount = mysqli_num_rows($newDataQuery);

    $_SESSION['currentData'] = $newCount;
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

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Dashboard</title>
    <style>
        .scrollBar::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e6e6e6;
        }

        .scrollBar::-webkit-scrollbar {
            width: 10px;
            height: 5px;
            background-color: #F5F5F5;
        }

        .scrollBar::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #bfbfbf;
        }

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
        include "logout.php";
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
                <nav class="mt-10 mb-3">
                    <a class="flex items-center px-6 py-2 mt-3 text-gray-100 bg-gray-700 bg-opacity-25" href="dashboard.php">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <span class="mx-3">Dashboard</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="tables.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M21.5 23h-19A2.503 2.503 0 0 1 0 20.5v-17C0 2.122 1.122 1 2.5 1h19C22.878 1 24 2.122 24 3.5v17c0 1.378-1.122 2.5-2.5 2.5zM2.5 2C1.673 2 1 2.673 1 3.5v17c0 .827.673 1.5 1.5 1.5h19c.827 0 1.5-.673 1.5-1.5v-17c0-.827-.673-1.5-1.5-1.5z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M23.5 8H.5a.5.5 0 0 1 0-1h23a.5.5 0 0 1 0 1zM23.5 13H.5a.5.5 0 0 1 0-1h23a.5.5 0 0 1 0 1zM23.5 18H.5a.5.5 0 0 1 0-1h23a.5.5 0 0 1 0 1z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M6.5 23a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 1 0v15a.5.5 0 0 1-.5.5zM12 23a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 1 0v15a.5.5 0 0 1-.5.5zM17.5 23a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 1 0v15a.5.5 0 0 1-.5.5z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Tables</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_users.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M210.352 246.633c33.882 0 63.218-12.153 87.195-36.13 23.969-23.972 36.125-53.304 36.125-87.19 0-33.876-12.152-63.211-36.129-87.192C273.566 12.152 244.23 0 210.352 0c-33.887 0-63.22 12.152-87.192 36.125s-36.129 53.309-36.129 87.188c0 33.886 12.156 63.222 36.13 87.195 23.98 23.969 53.316 36.125 87.19 36.125zM144.379 57.34c18.394-18.395 39.973-27.336 65.973-27.336 25.996 0 47.578 8.941 65.976 27.336 18.395 18.398 27.34 39.98 27.34 65.972 0 26-8.945 47.579-27.34 65.977-18.398 18.399-39.98 27.34-65.976 27.34-25.993 0-47.57-8.945-65.973-27.34-18.399-18.394-27.344-39.976-27.344-65.976 0-25.993 8.945-47.575 27.344-65.973zM426.129 393.703c-.692-9.976-2.09-20.86-4.149-32.351-2.078-11.579-4.753-22.524-7.957-32.528-3.312-10.34-7.808-20.55-13.375-30.336-5.77-10.156-12.55-19-20.16-26.277-7.957-7.613-17.699-13.734-28.965-18.2-11.226-4.44-23.668-6.69-36.976-6.69-5.227 0-10.281 2.144-20.043 8.5a2711.03 2711.03 0 0 1-20.879 13.46c-6.707 4.274-15.793 8.278-27.016 11.903-10.949 3.543-22.066 5.34-33.043 5.34-10.968 0-22.086-1.797-33.043-5.34-11.21-3.622-20.3-7.625-26.996-11.899-7.77-4.965-14.8-9.496-20.898-13.469-9.754-6.355-14.809-8.5-20.035-8.5-13.313 0-25.75 2.254-36.973 6.7-11.258 4.457-21.004 10.578-28.969 18.199-7.609 7.281-14.39 16.12-20.156 26.273-5.558 9.785-10.058 19.992-13.371 30.34-3.2 10.004-5.875 20.945-7.953 32.524-2.063 11.476-3.457 22.363-4.149 32.363C.343 403.492 0 413.668 0 423.949c0 26.727 8.496 48.363 25.25 64.32C41.797 504.017 63.688 512 90.316 512h246.532c26.62 0 48.511-7.984 65.062-23.73 16.758-15.946 25.254-37.59 25.254-64.325-.004-10.316-.351-20.492-1.035-30.242zm-44.906 72.828c-10.934 10.406-25.45 15.465-44.38 15.465H90.317c-18.933 0-33.449-5.059-44.379-15.46-10.722-10.208-15.933-24.141-15.933-42.587 0-9.594.316-19.066.95-28.16.616-8.922 1.878-18.723 3.75-29.137 1.847-10.285 4.198-19.937 6.995-28.675 2.684-8.38 6.344-16.676 10.883-24.668 4.332-7.618 9.316-14.153 14.816-19.418 5.145-4.926 11.63-8.957 19.27-11.98 7.066-2.798 15.008-4.329 23.629-4.56 1.05.56 2.922 1.626 5.953 3.602 6.168 4.02 13.277 8.606 21.137 13.625 8.86 5.649 20.273 10.75 33.91 15.152 13.941 4.508 28.16 6.797 42.273 6.797 14.114 0 28.336-2.289 42.27-6.793 13.648-4.41 25.058-9.507 33.93-15.164 8.043-5.14 14.953-9.593 21.12-13.617 3.032-1.973 4.903-3.043 5.954-3.601 8.625.23 16.566 1.761 23.636 4.558 7.637 3.024 14.122 7.059 19.266 11.98 5.5 5.262 10.484 11.798 14.816 19.423 4.543 7.988 8.208 16.289 10.887 24.66 2.801 8.75 5.156 18.398 7 28.675 1.867 10.434 3.133 20.239 3.75 29.145v.008c.637 9.058.957 18.527.961 28.148-.004 18.45-5.215 32.38-15.937 42.582zm0 0" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Users</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_vendors.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                            <g>
                                <path d="M17.898 27.921a2.951 2.951 0 0 1-.648.071C14.171 28 8.087 28 5.007 28a3.001 3.001 0 0 1-2.998-2.855l-.001-.028a39.881 39.881 0 0 1 .5-7.195c.255-1.546 1.578-3.49 2.926-4.311l.163-.098a.998.998 0 0 1 1.1.05C7.941 14.467 9.472 15 11.126 15s3.185-.533 4.429-1.437a1 1 0 0 1 1.094-.053l.169.101c.684.417 1.37 1.115 1.905 1.909A7.504 7.504 0 0 1 30 22a7.495 7.495 0 0 1-3.718 6.477A7.465 7.465 0 0 1 22.5 29.5a7.463 7.463 0 0 1-4.602-1.579zm-.757-11.167a5.187 5.187 0 0 0-1.004-1.175A9.497 9.497 0 0 1 11.126 17a9.499 9.499 0 0 1-5.012-1.422c-.782.643-1.482 1.757-1.632 2.669a37.847 37.847 0 0 0-.474 6.824c.038.522.472.929.998.929 2.747 0 7.885 0 11.147-.005a7.47 7.47 0 0 1-1.035-5.324 7.493 7.493 0 0 1 2.023-3.917zm1.648 9.303A5.476 5.476 0 0 0 22.5 27.5a5.473 5.473 0 0 0 3.045-.92 5.5 5.5 0 1 0-6.518-8.843 5.501 5.501 0 0 0-1.786 5.879 5.51 5.51 0 0 0 1.548 2.441zm2.713-.384a4.267 4.267 0 0 1-1.367-.581 1 1 0 0 1 1.119-1.658 2.415 2.415 0 0 0 1.564.368c.251-.034.488-.14.488-.442 0-.041-.041-.051-.072-.069a1.784 1.784 0 0 0-.313-.132c-.388-.13-.832-.216-1.235-.334-1.163-.339-1.992-.962-1.992-2.173 0-.611.18-1.091.458-1.464.323-.435.795-.734 1.352-.887a1 1 0 0 1 1.994.021c.508.126.992.336 1.38.607a1 1 0 0 1-1.145 1.64 2.322 2.322 0 0 0-1.546-.37c-.254.035-.493.148-.493.453 0 .041.041.051.072.069.093.054.2.094.313.132.388.13.832.216 1.235.334 1.163.339 1.992.962 1.992 2.173 0 1.237-.668 1.948-1.592 2.275-.07.025-.143.047-.218.066a1.001 1.001 0 0 1-1.994-.028zM11.126 2a5.455 5.455 0 0 1 5.453 5.452c0 3.01-2.444 5.453-5.453 5.453s-5.452-2.443-5.452-5.453A5.455 5.455 0 0 1 11.126 2zm0 2a3.454 3.454 0 0 0-3.452 3.452 3.454 3.454 0 0 0 3.452 3.453 3.454 3.454 0 0 0 3.453-3.453A3.454 3.454 0 0 0 11.126 4z" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Vendors</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="new_vendor_request.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path d="m503.299 378.185-39.741-169.197c-3.33-14.19-17.6-23.034-31.832-19.709l-8.441 1.984V20c0-6.628-5.373-12-12-12H167.934a11.996 11.996 0 0 0-8.485 3.515L92.241 78.723a12.003 12.003 0 0 0-3.515 8.485v104.06l-8.477-1.991c-6.864-1.609-13.955-.441-19.97 3.287-6.017 3.729-10.217 9.562-11.827 16.424L8.719 378.15c-1.633 6.86-.479 13.961 3.249 19.995 3.733 6.043 9.579 10.259 16.451 11.87l36.923 8.678c2.02.472 4.04.698 6.03.698 7.43 0 14.43-3.159 19.371-8.441l82.438 82.166c7.04 7.02 16.407 10.883 26.384 10.883h.063c9.997-.016 19.376-3.91 26.41-10.964a37.123 37.123 0 0 0 7.674-11.205l3.869 3.858c7.398 7.38 16.532 11.272 25.986 11.272 3.058 0 6.15-.407 9.227-1.236 11.162-3.005 20.602-11.193 25.438-21.616 7.016 5.554 14.644 7.964 22.036 7.964 10.131 0 19.813-4.504 26.849-11.555 6.488-6.504 10.797-15.255 11.41-24.523 9.007-.599 17.673-4.644 24.411-11.397 5.751-5.765 9.796-13.294 11.07-21.385 1.63.184 3.27.287 4.917.287 6.085 0 12.244-1.263 18.109-3.856l2.298-1.021c4.949 6.67 12.846 10.769 21.296 10.768 1.99 0 4.011-.227 6.029-.7l36.891-8.67c6.88-1.607 12.727-5.814 16.464-11.846 3.73-6.021 4.899-13.118 3.289-19.988zM161.631 43.273v37.661H123.97zm-48.906 61.661h60.906c6.627 0 12-5.373 12-12V32h213.653v164.903l-4.458 1.048c-6.88 1.613-12.725 5.824-16.456 11.858-3.727 6.027-4.882 13.129-3.259 19.972l2.133 9.085-.591.214c-10.629 3.836-20.679 3.243-30.729-1.815l-50.797-25.54c-25.065-12.601-54.353-7.482-73.636 12.639h-83.9c.294-12.266-8.018-23.509-20.402-26.412l-4.463-1.048v-91.971zM70.816 395.327l-36.913-8.676c-.841-.197-1.312-.786-1.518-1.12a2.402 2.402 0 0 1-.31-1.858l39.741-169.197v-.005c.188-.795.705-1.258 1.106-1.507a2.48 2.48 0 0 1 1.302-.385c.171 0 .353.019.542.063l36.94 8.675c1.297.304 2.132 1.674 1.828 2.977L73.79 393.477c-.305 1.307-1.674 2.152-2.974 1.848zm299.518 13.253c-.195 3.162-1.795 6.467-4.388 9.066-2.59 2.597-5.886 4.202-9.041 4.404-3.401.217-6.676-1.206-9.713-4.236l-60.207-60.037c-4.693-4.679-12.292-4.669-16.97.024-4.68 4.693-4.669 12.291.024 16.97l60.205 60.035c8.871 8.85 1.457 17.18-.119 18.76-1.577 1.58-9.889 9.014-18.761.163l-64.487-64.317c-4.692-4.68-12.29-4.67-16.971.022-4.68 4.692-4.67 12.291.022 16.971l43.468 43.353.014.015c3.713 3.705 5.019 7.747 3.881 12.014-1.332 4.993-5.747 9.419-10.737 10.762-4.263 1.147-8.31-.148-12.026-3.855l-47.792-47.65c-4.693-4.679-12.291-4.668-16.971.025-4.679 4.693-4.668 12.291.025 16.97l19.218 19.161c5.216 5.201 5.23 13.674.032 18.887-2.509 2.516-5.866 3.905-9.455 3.91h-.023c-3.578 0-6.929-1.377-9.44-3.88l-90.018-89.721 32.427-138.034h67.507l-42.942 48.196c-5.883 6.612-8.262 15.041-6.691 23.787 1.602 8.688 6.764 15.746 14.546 19.879 23.227 12.305 51.395 10.823 73.525-3.875l25.014-16.657c8.183-5.432 18.771-4.377 25.737 2.553l76.91 76.688c2.99 3.011 4.404 6.255 4.195 9.645zm14.303-25.093-78.471-78.244c-15.15-15.073-38.155-17.353-55.961-5.534l-25.017 16.659c-14.781 9.817-33.556 10.833-48.987 2.658-1.302-.691-1.916-1.541-2.181-2.976-.255-1.419.037-2.443 1.003-3.529l62.779-70.46c11.9-13.332 30.606-16.905 46.544-8.892l50.792 25.538c15.156 7.628 31.571 8.86 47.616 3.633l28.969 123.401-4.413 1.959c-8.015 3.545-16.487 1.974-22.673-4.212zm94.972 2.047a2.436 2.436 0 0 1-1.537 1.119l-36.9 8.672c-1.303.307-2.674-.558-2.983-1.859L398.47 224.27a2.39 2.39 0 0 1 .313-1.837c.205-.331.674-.916 1.528-1.116l36.89-8.67c.186-.043.372-.064.556-.064 1.126 0 2.175.774 2.437 1.889l39.741 169.197c.198.847-.119 1.532-.325 1.866zM144.907 158.498c0-6.627 5.373-12 12-12h198.167c6.627 0 12 5.373 12 12s-5.373 12-12 12H156.907c-6.627 0-12-5.373-12-12zm82.799-54.821c0-6.627 5.373-12 12-12h115.368c6.627 0 12 5.373 12 12s-5.373 12-12 12H239.706c-6.627 0-12-5.373-12-12z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                            </g>
                        </svg>
                        <div class="flex items-center justify-between">
                            <span class="mx-3">Vendor request</span>
                            <?php
                            if (isset($_SESSION['existingData'])) {
                                if ($_SESSION['existingData'] < $_SESSION['currentData']) {
                            ?>  
                                    <span class="relative flex size-2">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                                    </span>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="rejected_vendor.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 511.792 511.792" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M496.085 120.75 120.75 496.085c-10.943 10.943-28.685 10.943-39.629 0l-65.414-65.414c-10.943-10.943-10.943-28.685 0-39.629L391.042 15.707c10.943-10.943 28.685-10.943 39.629 0l65.414 65.414c10.943 10.944 10.943 28.686 0 39.629z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="currentColor" class=""></path>
                                <path d="M97.244 249.153 296.531 49.866c16.666-16.666 43.686-16.666 60.352 0h0L49.866 356.883h0c-16.666-16.666-16.666-43.686 0-60.352l24.459-24.459M392.502 284.685l69.424-69.424c16.666-16.666 16.666-43.686 0-60.352h0L154.909 461.926h0c16.666 16.666 43.686 16.666 60.352 0L366.927 310.26M198.246 345.645s8.962.028 11.126-7.537c1.068-3.733-.054-7.751-2.799-10.497l-29.904-29.904M142.417 332.302l-15.621 15.621 37.073 37.074 15.621-15.622M159.802 351.99l-14.47 14.47M216.957 257.762l-15.621 15.621 37.073 37.074 15.621-15.622M234.342 277.451l-14.47 14.469M343.069 131.65l-15.621 15.621 37.073 37.074 15.621-15.622M360.454 151.339l-14.47 14.469M366.927 108.632l35.681 35.681M409.989 101.803c10.004 10.004 12.368 23.473 3.713 32.436-2.881 2.984-10.431 10.591-10.431 10.591s-13.199-13.104-18.241-18.147c-4.142-4.142-18.141-18.088-18.141-18.088l10.283-10.283c9.663-9.663 22.813-6.513 32.817 3.491zM269.491 211.276a26.33 26.33 0 0 0-13.654 7.265c-10.332 10.332-10.332 27.083 0 37.415s27.083 10.332 37.415 0c4.196-4.196 6.266-9.029 6.553-13.982a21.338 21.338 0 0 0-.048-3.085M285.288 189.089l20.663-20.662M296.772 179.994l36.221 36.221M107.165 406.328l33.574 2.14M83.095 391.282l37.415 37.415M113.048 380.777c5.37 5.37 5.015 14.433-.55 19.998-2.76 2.76-9.83 9.916-9.83 9.916s-7.104-7.015-9.811-9.722c-2.223-2.223-9.749-9.699-9.749-9.699l9.942-9.942c5.565-5.566 14.628-5.921 19.998-.551z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="currentColor" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="currentColor" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Rejected vendors</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_product.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 96 96" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="m90.895 25.211-42-21a2.004 2.004 0 0 0-1.789 0l-42 21A2 2 0 0 0 4 27v42a2 2 0 0 0 1.105 1.789l42 21a1.998 1.998 0 0 0 1.79 0l42-21A2 2 0 0 0 92 69V27a2 2 0 0 0-1.105-1.789zM48 8.236 85.528 27 77.5 31.014 39.973 12.25zm13.5 30.778L23.972 20.25 35.5 14.486 73.028 33.25zm1.5 3.722 12-6v14.877l-3.838-2.741a2.006 2.006 0 0 0-1.506-.343 2.007 2.007 0 0 0-1.301.832L63 57.098zm-43.5-20.25L57.027 41.25 48 45.764 10.472 27zM8 30.236l38 19v37.527l-38-19zm42 56.528V49.236l9-4.5V63.5a2 2 0 0 0 3.645 1.139l7.845-11.331 5.349 3.82A1.997 1.997 0 0 0 79 55.5V34.736l9-4.5v37.527z" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Products</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="contact_page.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M255.986 368.994c69.385 0 125.834-56.437 125.834-125.807a125.977 125.977 0 0 0-125.834-125.834c-69.37 0-125.806 56.449-125.806 125.834a126.3 126.3 0 0 0 33.62 85.588l-13.013 48.547a15 15 0 0 0 21.993 16.872l50.895-29.408a125.582 125.582 0 0 0 32.311 4.208zm-41.747-33.4-25.091 14.5 5.868-21.89a15 15 0 0 0-4.268-14.863 94.89 94.89 0 0 1-30.568-70.149 95.775 95.775 0 1 1 66.2 91.128 15 15 0 0 0-12.141 1.271zM503.8 253.9c.163-6.138.332-12.485.039-19.093a71.337 71.337 0 0 0-71.782-68.279C402.4 98.677 334.645 51.136 255.986 51.136S109.6 98.676 79.942 166.527a71.339 71.339 0 0 0-71.779 68.257c-.294 6.632-.125 12.98.038 19.119.173 6.486.351 13.193.018 20.73a71.432 71.432 0 0 0 68.18 74.36q1.678.078 3.349.078a70.393 70.393 0 0 0 27.415-5.54 14.973 14.973 0 0 0 8.114-19.377 8.044 8.044 0 0 0-.824-2.021 162.3 162.3 0 0 1-20.491-78.946c0-89.355 72.684-162.051 162.024-162.051s162.052 72.7 162.052 162.051a161.532 161.532 0 0 1-132.157 159.287 41.584 41.584 0 1 0 1.328 30.209 192.361 192.361 0 0 0 130.075-85.231 70.237 70.237 0 0 0 14.951 1.62q1.653 0 3.315-.076a71.366 71.366 0 0 0 68.23-74.383c-.332-7.513-.153-14.226.02-20.713zM77.733 319.023a41.405 41.405 0 0 1-39.543-43.085c.379-8.579.178-16.151 0-22.833-.156-5.875-.3-11.423-.055-17.014a41.394 41.394 0 0 1 31.274-38.35 192.359 192.359 0 0 0 8.3 116.877l-.018.007q.876 2.232 1.809 4.443-.877-.004-1.767-.045zm170.118 111.841a11.589 11.589 0 1 1 11.588-11.593v.022a11.6 11.6 0 0 1-11.588 11.571zm225.958-154.947a41.366 41.366 0 0 1-39.591 43.108q-.864.041-1.724.044a.255.255 0 0 0 .011-.177 192.27 192.27 0 0 0 10.086-121.15 41.391 41.391 0 0 1 31.275 38.371c.247 5.568.1 11.116-.056 16.99-.178 6.682-.38 14.255-.001 22.814zm-252.869-34.2a14.464 14.464 0 0 1 .07 1.47 14.661 14.661 0 0 1-.07 1.48c-.05.48-.13.97-.22 1.45s-.22.96-.36 1.43-.31.93-.5 1.38-.4.9-.63 1.33-.48.85-.75 1.26a12.819 12.819 0 0 1-.87 1.18c-.31.39-.65.75-.99 1.1a14.668 14.668 0 0 1-1.1.99c-.38.31-.78.6-1.18.88-.41.26-.83.52-1.27.75a13.2 13.2 0 0 1-1.32.62 14.253 14.253 0 0 1-1.38.5c-.47.14-.95.26-1.43.36a14.512 14.512 0 0 1-1.45.22 15.681 15.681 0 0 1-2.96 0 14.512 14.512 0 0 1-1.45-.22c-.48-.1-.96-.22-1.43-.36a14.253 14.253 0 0 1-1.38-.5 13.2 13.2 0 0 1-1.32-.62c-.44-.23-.86-.49-1.27-.75-.4-.28-.8-.57-1.18-.88a14.668 14.668 0 0 1-1.1-.99c-.34-.35-.68-.71-.99-1.1a12.819 12.819 0 0 1-.87-1.18q-.4-.615-.75-1.26c-.23-.43-.44-.88-.63-1.33s-.35-.91-.5-1.38-.26-.95-.36-1.43a14.086 14.086 0 0 1-.29-2.93c0-.49.03-.98.07-1.47s.13-.98.22-1.46.22-.95.36-1.42.31-.93.5-1.38.4-.9.63-1.33a15.584 15.584 0 0 1 1.62-2.45c.31-.38.65-.75.99-1.09a14.668 14.668 0 0 1 1.1-.99c.38-.31.78-.61 1.18-.88a14.6 14.6 0 0 1 1.27-.75q.645-.345 1.32-.63c.45-.18.92-.35 1.38-.49a14.242 14.242 0 0 1 1.43-.36 14.718 14.718 0 0 1 5.86 0 14.242 14.242 0 0 1 1.43.36c.46.14.93.31 1.38.49s.89.4 1.32.63a14.6 14.6 0 0 1 1.27.75c.4.27.8.57 1.18.88a14.668 14.668 0 0 1 1.1.99c.34.34.68.71.99 1.09a15.584 15.584 0 0 1 1.62 2.45c.23.43.44.88.63 1.33s.35.91.5 1.38.26.95.36 1.42.17.966.22 1.456zm20.06 1.47a14.988 14.988 0 0 1 14.986-15h.028a15 15 0 1 1-15.014 15zm50.06 1.476a14.661 14.661 0 0 1-.07-1.48 14.464 14.464 0 0 1 .07-1.47c.05-.49.13-.98.22-1.46s.22-.95.36-1.42a13.353 13.353 0 0 1 .5-1.38c.18-.45.4-.9.62-1.33a16.64 16.64 0 0 1 1.63-2.45c.31-.38.65-.75.99-1.09a14.668 14.668 0 0 1 1.1-.99 12.913 12.913 0 0 1 1.18-.88q.615-.4 1.26-.75c.43-.23.88-.44 1.33-.63s.92-.35 1.38-.49a14.242 14.242 0 0 1 1.43-.36 14.684 14.684 0 0 1 4.4-.22 14.277 14.277 0 0 1 1.46.22 13.41 13.41 0 0 1 1.42.36c.47.14.94.31 1.39.49s.89.4 1.32.63a14.6 14.6 0 0 1 1.27.75c.4.27.8.57 1.18.88a12.8 12.8 0 0 1 1.09.99c.35.34.68.71 1 1.09.3.38.6.78.87 1.19a14.425 14.425 0 0 1 .75 1.26c.23.43.44.88.63 1.33a13.294 13.294 0 0 1 .49 1.38 11.812 11.812 0 0 1 .36 1.42 11.959 11.959 0 0 1 .22 1.46 14.479 14.479 0 0 1 .08 1.47 14.676 14.676 0 0 1-.08 1.48 12.1 12.1 0 0 1-.22 1.45 11.967 11.967 0 0 1-.36 1.43 14.174 14.174 0 0 1-.49 1.38c-.19.45-.4.9-.63 1.33s-.48.85-.75 1.26-.57.81-.87 1.18c-.32.39-.65.75-1 1.1a12.8 12.8 0 0 1-1.09.99c-.38.31-.78.6-1.18.87a14.692 14.692 0 0 1-1.27.76 13.2 13.2 0 0 1-1.32.62 13.525 13.525 0 0 1-1.39.5c-.46.14-.94.26-1.42.36a14.461 14.461 0 0 1-2.93.29 14.661 14.661 0 0 1-1.48-.07 14.512 14.512 0 0 1-1.45-.22c-.48-.1-.96-.22-1.43-.36a14.253 14.253 0 0 1-1.38-.5 13.359 13.359 0 0 1-1.33-.62c-.43-.23-.85-.49-1.26-.76a12.819 12.819 0 0 1-1.18-.87 14.668 14.668 0 0 1-1.1-.99c-.34-.35-.68-.71-.99-1.1a12.819 12.819 0 0 1-.87-1.18c-.27-.41-.53-.83-.76-1.26s-.44-.88-.62-1.33a14.253 14.253 0 0 1-.5-1.38c-.14-.47-.26-.95-.36-1.43s-.17-.97-.22-1.45z" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Inquiries</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="customer_complaint.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 18062 18062" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                            <g>
                                <path d="M5557 16496H3939l-71 892h1689zM4877 5133c-43 0-87-9-127-28L2217 3939l-1289 1c-168 0-305-137-305-305V369c0-169 137-305 305-305h5305c168 0 305 136 305 305v3266c0 168-137 305-305 305H5182v888c0 167-140 305-305 305zM1233 3330h1051c44 0 87 9 127 27l2161 995v-717c0-169 137-305 305-305h1051V674H1233zm1674 7885H1889c-159 0-292-123-304-282l-351-4563c-13-175 129-329 304-329h1720c175 0 318 154 304 329l-351 4563c-12 159-144 282-304 282zm-735-610h453l304-3954H1867zm735 2682H1889c-168 0-305-137-305-305v-1099c0-169 137-305 305-305h1018c169 0 305 136 305 305v1099c0 168-136 305-305 305zm-713-610h408v-489h-408zm14589-5158h-1018c-159 0-292-123-304-282l-351-4563c-13-175 129-328 304-328h1720c175 0 318 153 304 328l-351 4563c-12 159-145 282-304 282zm-735-610h453l304-3954h-1062zm735 2682h-1018c-168 0-305-136-305-305V8187c0-169 137-305 305-305h1018c169 0 305 136 305 305v1099c0 169-136 305-305 305zm-713-610h408v-489h-408zM2398 2307h-379c-169 0-305-137-305-305 0-169 136-305 305-305h379c169 0 305 136 305 305 0 168-136 305-305 305zm1388 0h-380c-168 0-304-137-304-305 0-169 136-305 304-305h380c168 0 305 136 305 305 0 168-137 305-305 305zm1388 0h-380c-168 0-305-137-305-305 0-169 137-305 305-305h380c168 0 305 136 305 305 0 168-137 305-305 305zm7975 7165h-1065c-142 312-348 662-647 1022l360 1527 2597 625c1037 243 1195 1014 1201 1082l316 3941c14 175-128 329-304 329H3537c-175 0-318-154-304-329l317-3941c5-68 164-838 1203-1083l2595-624 359-1527c-31-38-62-76-91-114h-976c-169 0-305-136-305-305v-603h-340c-168 0-305-137-305-305V7432c0-169 137-305 305-305h375c-315-1320-38-2432 813-3145 264-222 957-758 1691-955 1147-309 2571-195 3293 673 399 478 280 815 674 1283 486 579 355 1383 82 2144h226c169 0 305 136 305 305v1735c0 168-136 305-305 305zm-1557-394c5-16 11-31 18-46 149-385 176-663 181-739-239-1581-836-2434-1279-2434-108 0-219 52-329 154-425 393-829 584-1235 584-273 0-491-87-651-151-46-19-105-43-144-54-23 37-69 127-124 333-124 467-337 1098-659 1541 23 229 123 840 559 1504h1516c168 0 305 137 305 305 0 169-137 305-305 305h-966c262 206 670 458 1086 448l40 1c657 0 1288-643 1344-701 321-382 520-747 643-1050zm713-216h539V7737h-168l-278 613c-7 93-29 273-93 512zm-5231 610h-130v298h275c-55-102-103-201-145-298zm-522-1735h-252v1125h560c-76-290-98-512-104-620-77-171-145-339-204-505zm-2564 8149h1569v-271c0-168 137-305 305-305 169 0 305 137 305 305v1773h6810v-1773c0-168 136-305 305-305 168 0 305 137 305 305v271h1569l-167-2083c-24-76-163-432-734-563l-2640-635-1855 1447c-110 87-265 87-375 0l-1855-1447-2637 634c-574 132-714 488-737 564zm3955-3732 1629 1271 1629-1271-282-1201c-908 649-1787 647-2693 0zm5644 5234h1690l-72-892h-1618zM10047 3480c-333 0-684 47-1015 136-616 166-1224 638-1457 833-987 827-762 2166-460 3043 120-256 231-570 325-924 68-257 211-791 685-791 506 0 772 594 1644-212 223-207 480-316 743-316 716 0 1340 777 1691 2044 307-725 534-1485 171-1918-466-554-379-929-675-1285-328-394-915-610-1652-610zm-446 12133c-168 0-304-136-304-305v-395c0-169 136-305 304-305 169 0 305 136 305 305v395c0 169-136 305-305 305zm0 1304c-168 0-304-136-304-305v-395c0-169 136-305 304-305 169 0 305 136 305 305v395c0 169-136 305-305 305z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Complaints</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="setting.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <defs>
                                    <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                        <path d="M0 512h512V0H0Z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    </clipPath>
                                </defs>
                                <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                    <path d="M0 0c-43.446 0-78.667-35.22-78.667-78.667 0-43.446 35.221-78.666 78.667-78.666 43.446 0 78.667 35.22 78.667 78.666C78.667-35.22 43.446 0 0 0Zm220.802-22.53-21.299-17.534c-24.296-20.001-24.296-57.204 0-77.205l21.299-17.534c7.548-6.214 9.497-16.974 4.609-25.441l-42.057-72.845c-4.889-8.467-15.182-12.159-24.337-8.729l-25.835 9.678c-29.469 11.04-61.688-7.561-66.862-38.602l-4.535-27.213c-1.607-9.643-9.951-16.712-19.727-16.712h-84.116c-9.776 0-18.12 7.069-19.727 16.712l-4.536 27.213c-5.173 31.041-37.392 49.642-66.861 38.602l-25.834-9.678c-9.156-3.43-19.449.262-24.338 8.729l-42.057 72.845c-4.888 8.467-2.939 19.227 4.609 25.441l21.3 17.534c24.295 20.001 24.295 57.204 0 77.205l-21.3 17.534c-7.548 6.214-9.497 16.974-4.609 25.441l42.057 72.845c4.889 8.467 15.182 12.159 24.338 8.729l25.834-9.678c29.469-11.04 61.688 7.561 66.861 38.602l4.536 27.213c1.607 9.643 9.951 16.711 19.727 16.711h84.116c9.776 0 18.12-7.068 19.727-16.711l4.535-27.213c5.174-31.041 37.393-49.642 66.862-38.602l25.835 9.678c9.155 3.43 19.448-.262 24.337-8.729l42.057-72.845c4.888-8.467 2.939-19.227-4.609-25.441z" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 334.666)" fill="none" stroke="currentColor" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="currentColor" class=""></path>
                                </g>
                            </g>
                        </svg>
                        <span class="mx-3 tracking-wide">Setting</span>
                    </a>

                    <a id="logoutButton1" class="group flex items-center px-6 py-2 mt-3 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="#">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                            <path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path>
                        </svg>
                        <span class="mx-3">Log Out</span>
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
                            <h1 class="text-2xl font-semibold">Hello Admin !</h1>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                <img class="object-cover w-full h-full" src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=296&amp;q=80" alt="Your avatar">
                            </button>
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
                            <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl divide-y-2 divide-gray-300 ring-2 ring-gray-400" style="display: none;">
                                <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Dashboard</a>
                                <a href="view_product.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Products</a>
                                <a id="logoutButton2" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                            </div>
                        </div>
                    </div>
                </header>
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
                <main id="main" class="px-4 md:px-12 py-12 overflow-y-scroll scrollBar overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                        <div class="flex items-center gap-4 bg-white shadow-xl rounded-md px-4 py-3">
                            <div class="bg-gray-50 rounded-md max-w-max p-2">
                                <svg class="w-8 h-8 fill-gray-600" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M508.745 246.041c-4.574-6.257-113.557-153.206-252.748-153.206S7.818 239.784 3.249 246.035a16.896 16.896 0 0 0 0 19.923c4.569 6.257 113.557 153.206 252.748 153.206s248.174-146.95 252.748-153.201a16.875 16.875 0 0 0 0-19.922zM255.997 385.406c-102.529 0-191.33-97.533-217.617-129.418 26.253-31.913 114.868-129.395 217.617-129.395 102.524 0 191.319 97.516 217.617 129.418-26.253 31.912-114.868 129.395-217.617 129.395z" fill="" opacity="1" data-original="#000000"></path>
                                        <path d="M255.997 154.725c-55.842 0-101.275 45.433-101.275 101.275s45.433 101.275 101.275 101.275S357.272 311.842 357.272 256s-45.433-101.275-101.275-101.275zm0 168.791c-37.23 0-67.516-30.287-67.516-67.516s30.287-67.516 67.516-67.516 67.516 30.287 67.516 67.516-30.286 67.516-67.516 67.516z" fill="" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['adminEmail']) ? $Cview : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total view</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white shadow-xl rounded-md px-4 py-3">
                            <div class="bg-gray-50 rounded-md max-w-max p-2">
                                <svg class="w-8 h-8 fill-gray-600" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 511 511.999" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M216.5 366c5.52 0 10-4.48 10-10s-4.48-10-10-10-10 4.48-10 10 4.48 10 10 10zm0 0" fill="" opacity="1" data-original="#000000"></path>
                                        <path d="m3.43 389.07 120 120a9.996 9.996 0 0 0 14.14 0l66-66a9.996 9.996 0 0 0 0-14.14l-2.93-2.93h144.15c12.66 0 24.741-4.746 34.058-13.395l121.316-113.699c11.613-10.785 15.461-27.918 9.57-42.629a38.492 38.492 0 0 0-23.851-22.355 38.492 38.492 0 0 0-32.453 3.957c-.063.039-26.934 17.672-26.934 17.672-.183-54.207-32.945-112.012-78.043-138.035a30.088 30.088 0 0 0 5.887-10.375c5.16-15.7-3.418-32.692-19.14-37.883-.493-.164-.985-.309-1.477-.461l25.742-46.242a9.989 9.989 0 0 0 .512-8.664 9.984 9.984 0 0 0-6.457-5.801C335.063 2.723 315.879 0 296.5 0c-19.375 0-38.562 2.723-57.02 8.086a9.997 9.997 0 0 0-5.945 14.469l25.742 46.242c-.5.156-1 .305-1.5.469-15.699 5.183-24.273 22.171-19.113 37.882a30.052 30.052 0 0 0 5.91 10.36C198.804 143.918 166.5 202.316 166.5 256c0 1.465.035 2.91.082 4.344-17.91 4.886-34.562 13.789-48.566 26.05l-30.391 26.59-4.055-4.054a9.996 9.996 0 0 0-14.14 0l-66 66a9.996 9.996 0 0 0 0 14.14zM257.332 24.184C270.145 21.402 283.27 20 296.5 20s26.355 1.402 39.172 4.184L313.387 64.21a121.925 121.925 0 0 0-33.77 0zm6.688 64.082c20.52-6.715 42.89-7.223 64.933-.008 5.246 1.73 8.11 7.402 6.387 12.637a9.94 9.94 0 0 1-8.887 6.855c-19.719-6.27-40.2-6.281-59.91-.02h-.004c-4.11-.257-7.598-2.945-8.879-6.832-1.723-5.242 1.14-10.914 6.36-12.632zm5.53 39.55c17.34-6.246 35.305-6.394 52.688-.421C368.7 143.37 406.5 201.063 406.5 256c0 4.656-.293 9.094-.871 13.242l-48.067 31.535C350.123 291.56 338.844 286 326.5 286h-20v-11.719c11.64-4.129 20-15.246 20-28.281 0-16.543-13.457-30-30-30-5.512 0-10-4.484-10-10s4.488-10 10-10c3.543 0 7.281 1.809 10.816 5.227 3.97 3.84 10.301 3.734 14.141-.23 3.84-3.97 3.734-10.302-.234-14.142-5.075-4.914-10.153-7.69-14.723-9.207V166c0-5.523-4.477-10-10-10s-10 4.477-10 10v11.719c-11.637 4.129-20 15.246-20 28.281 0 16.543 13.457 30 30 30 5.516 0 10 4.484 10 10s-4.484 10-10 10c-4.273 0-8.883-2.688-12.984-7.566-3.555-4.227-9.864-4.774-14.09-1.22-4.227 3.556-4.774 9.864-1.219 14.09 5.344 6.36 11.633 10.79 18.293 13.024V286h-3.328c-4.914 0-7.121-3.203-10.582-5.441-21.13-15.836-47.3-24.559-73.7-24.559-4.128 0-8.265.215-12.382.633 0-.211-.008-.418-.008-.633 0-54.168 37.258-111.668 83.05-128.184zM131.189 301.441C149.977 284.988 174.12 276 198.89 276c22.101 0 44.011 7.3 61.691 20.555 2.55 1.492 9.652 9.445 22.586 9.445H326.5c11.383 0 20 9.254 20 20 0 11.027-8.973 20-20 20h-70c-5.523 0-10 4.477-10 10s4.477 10 10 10h70c22.055 0 40-17.945 40-40 0-2.293-.203-4.555-.586-6.781l98.2-64.43a18.573 18.573 0 0 1 15.558-1.86 18.562 18.562 0 0 1 11.492 10.778c2.887 7.203 1.074 15.27-4.644 20.578L365.207 397.98a29.917 29.917 0 0 1-20.418 8.02H180.641l-78.84-78.844zm-54.688 28.7L182.36 436l-51.86 51.86L24.64 382zm0 0" fill="" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['adminEmail']) ? '₹' . number_format($totalEarnings) : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total profit</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white shadow-xl rounded-md px-4 py-3">
                            <div class="bg-gray-50 rounded-md max-w-max p-2">
                                <svg class="w-8 h-8 fill-gray-600" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 96 96" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="m90.895 25.211-42-21a2.004 2.004 0 0 0-1.789 0l-42 21A2 2 0 0 0 4 27v42a2 2 0 0 0 1.105 1.789l42 21a1.998 1.998 0 0 0 1.79 0l42-21A2 2 0 0 0 92 69V27a2 2 0 0 0-1.105-1.789zM48 8.236 85.528 27 77.5 31.014 39.973 12.25zm13.5 30.778L23.972 20.25 35.5 14.486 73.028 33.25zm1.5 3.722 12-6v14.877l-3.838-2.741a2.006 2.006 0 0 0-1.506-.343 2.007 2.007 0 0 0-1.301.832L63 57.098zm-43.5-20.25L57.027 41.25 48 45.764 10.472 27zM8 30.236l38 19v37.527l-38-19zm42 56.528V49.236l9-4.5V63.5a2 2 0 0 0 3.645 1.139l7.845-11.331 5.349 3.82A1.997 1.997 0 0 0 79 55.5V34.736l9-4.5v37.527z" fill="" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['adminEmail']) ? $products : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total product</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white shadow-xl rounded-md px-4 py-3">
                            <div class="bg-gray-50 rounded-md max-w-max p-2">
                                <svg class="w-8 h-8 fill-gray-600" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M210.352 246.633c33.882 0 63.218-12.153 87.195-36.13 23.969-23.972 36.125-53.304 36.125-87.19 0-33.876-12.152-63.211-36.129-87.192C273.566 12.152 244.23 0 210.352 0c-33.887 0-63.22 12.152-87.192 36.125s-36.129 53.309-36.129 87.188c0 33.886 12.156 63.222 36.13 87.195 23.98 23.969 53.316 36.125 87.19 36.125zM144.379 57.34c18.394-18.395 39.973-27.336 65.973-27.336 25.996 0 47.578 8.941 65.976 27.336 18.395 18.398 27.34 39.98 27.34 65.972 0 26-8.945 47.579-27.34 65.977-18.398 18.399-39.98 27.34-65.976 27.34-25.993 0-47.57-8.945-65.973-27.34-18.399-18.394-27.344-39.976-27.344-65.976 0-25.993 8.945-47.575 27.344-65.973zM426.129 393.703c-.692-9.976-2.09-20.86-4.149-32.351-2.078-11.579-4.753-22.524-7.957-32.528-3.312-10.34-7.808-20.55-13.375-30.336-5.77-10.156-12.55-19-20.16-26.277-7.957-7.613-17.699-13.734-28.965-18.2-11.226-4.44-23.668-6.69-36.976-6.69-5.227 0-10.281 2.144-20.043 8.5a2711.03 2711.03 0 0 1-20.879 13.46c-6.707 4.274-15.793 8.278-27.016 11.903-10.949 3.543-22.066 5.34-33.043 5.34-10.968 0-22.086-1.797-33.043-5.34-11.21-3.622-20.3-7.625-26.996-11.899-7.77-4.965-14.8-9.496-20.898-13.469-9.754-6.355-14.809-8.5-20.035-8.5-13.313 0-25.75 2.254-36.973 6.7-11.258 4.457-21.004 10.578-28.969 18.199-7.609 7.281-14.39 16.12-20.156 26.273-5.558 9.785-10.058 19.992-13.371 30.34-3.2 10.004-5.875 20.945-7.953 32.524-2.063 11.476-3.457 22.363-4.149 32.363C.343 403.492 0 413.668 0 423.949c0 26.727 8.496 48.363 25.25 64.32C41.797 504.017 63.688 512 90.316 512h246.532c26.62 0 48.511-7.984 65.062-23.73 16.758-15.946 25.254-37.59 25.254-64.325-.004-10.316-.351-20.492-1.035-30.242zm-44.906 72.828c-10.934 10.406-25.45 15.465-44.38 15.465H90.317c-18.933 0-33.449-5.059-44.379-15.46-10.722-10.208-15.933-24.141-15.933-42.587 0-9.594.316-19.066.95-28.16.616-8.922 1.878-18.723 3.75-29.137 1.847-10.285 4.198-19.937 6.995-28.675 2.684-8.38 6.344-16.676 10.883-24.668 4.332-7.618 9.316-14.153 14.816-19.418 5.145-4.926 11.63-8.957 19.27-11.98 7.066-2.798 15.008-4.329 23.629-4.56 1.05.56 2.922 1.626 5.953 3.602 6.168 4.02 13.277 8.606 21.137 13.625 8.86 5.649 20.273 10.75 33.91 15.152 13.941 4.508 28.16 6.797 42.273 6.797 14.114 0 28.336-2.289 42.27-6.793 13.648-4.41 25.058-9.507 33.93-15.164 8.043-5.14 14.953-9.593 21.12-13.617 3.032-1.973 4.903-3.043 5.954-3.601 8.625.23 16.566 1.761 23.636 4.558 7.637 3.024 14.122 7.059 19.266 11.98 5.5 5.262 10.484 11.798 14.816 19.423 4.543 7.988 8.208 16.289 10.887 24.66 2.801 8.75 5.156 18.398 7 28.675 1.867 10.434 3.133 20.239 3.75 29.145v.008c.637 9.058.957 18.527.961 28.148-.004 18.45-5.215 32.38-15.937 42.582zm0 0" fill="" opacity="1" data-original="#000000" class=""></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['adminEmail']) ? $user : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total users</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white shadow-xl rounded-md px-4 py-3">
                            <div class="bg-gray-50 rounded-md max-w-max p-2">
                                <svg class="w-8 h-8 fill-gray-600" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M30 20V9.657c.182-.087.358-.186.525-.305 1.167-.83 1.652-2.371 1.205-3.833-.32-1.049-.881-2.54-1.295-3.606A2.977 2.977 0 0 0 27.639 0H4.359C3.113 0 2.017.75 1.566 1.91 1.155 2.966.6 4.444.279 5.499-.204 7.082.478 8.931 2 9.655V20c-1.103 0-2 .897-2 2v2c0 1.103.897 2 2 2v3c0 1.654 1.346 3 3 3h22c1.654 0 3-1.346 3-3v-3c1.103 0 2-.897 2-2v-2c0-1.103-.897-2-2-2zM2.192 6.08c.304-.996.84-2.423 1.237-3.446A.991.991 0 0 1 4.36 2h23.28a.99.99 0 0 1 .93.636c.33.847.93 2.426 1.25 3.468.19.627.004 1.292-.454 1.619a1.518 1.518 0 0 1-1.732.001c-.936-.666-2.313-.677-3.266 0-.508.36-1.226.36-1.734 0a2.856 2.856 0 0 0-3.266 0c-.508.36-1.226.36-1.734 0a2.853 2.853 0 0 0-3.265 0c-.51.361-1.227.36-1.735 0a2.853 2.853 0 0 0-3.265 0c-.51.361-1.227.36-1.735 0a2.853 2.853 0 0 0-3.265 0 1.507 1.507 0 0 1-1.538.116c-.58-.293-.853-1.05-.638-1.76zM4 9.948a3.483 3.483 0 0 0 1.526-.594.84.84 0 0 1 .949 0c1.19.845 2.86.846 4.051 0a.84.84 0 0 1 .949 0c1.19.845 2.86.846 4.051 0a.84.84 0 0 1 .949 0c1.19.846 2.86.846 4.05 0a.84.84 0 0 1 .95 0c1.19.846 2.86.846 4.05 0a.84.84 0 0 1 .95 0c.457.325.977.53 1.525.608V20h-6.356a6.003 6.003 0 0 0-3.761-3.683A2.982 2.982 0 0 0 19 14c0-1.654-1.346-3-3-3s-3 1.346-3 3c0 .938.441 1.766 1.117 2.317A6.002 6.002 0 0 0 10.357 20H4zM12.534 20c.699-1.207 2.009-2 3.466-2s2.768.793 3.467 2zM16 15c-.551 0-1-.449-1-1s.449-1 1-1 1 .449 1 1-.449 1-1 1zm12 14a1 1 0 0 1-1 1H5c-.551 0-1-.448-1-1v-3h24zm2-5H2v-2h18.9l.006-.001h8.085L29 22l.01-.002H30z" fill="" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['adminEmail']) ? $vendor : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total vendors</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12">
                        <div class="w-full bg-white rounded-xl p-4 h-full">
                            <div class="space-y-3 py-4">
                                <div class="space-x-1 text-xs">
                                    <span class="border-2 px-4 border-[#ff0000] bg-[#ffe6e6]">
                                    </span>
                                    <span>Less than 10 view</span>
                                </div>
                                <div class="space-x-1 text-xs">
                                    <span class="border-2 px-4 border-[#2563eb] bg-[#ece6ff]">
                                    </span>
                                    <span>More than 10 view</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between flex-wrap mb-4">
                                <h2 class="text-xl font-bold md:text-4xl">Visitors analytics</h2>
                                <div class="flex items-center gap-3">
                                    <button id="weekButton" class="rounded-md text-[#2563eb] border-2 border-[#2563eb] bg-[#2563eb33] p-1 active:scale-90 transition">Weekly</button>
                                    <button id="monthButton" class="rounded-md text-[#2563eb] border-2 border-[#2563eb] bg-[#2563eb33] p-1 active:scale-90 transition">Monthly</button>
                                </div>
                            </div>
                            <div class="chart-container w-full h-full rounded-md">
                                <canvas id="conversionChart" width="100" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-5">
                            <h2 class="text-2xl font-bold">New Vendor This Week</h2>
                            <div class="chart-container flex items-center justify-between mt-4 rounded-md">
                                <div class="w-full h-auto">
                                    <canvas id="newVendor"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl p-5">
                            <h2 class="text-2xl font-bold">New User This Week</h2>
                            <div class="chart-container flex items-center justify-between mt-4 rounded-md">
                                <div class="w-full h-auto">
                                    <canvas id="newUser"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script>
        // Total Visitors
        const weekFromData = <?php echo $week_json ?>;
        const weekDate = weekFromData.map(week => week.date);
        const weekCount = weekFromData.map(week => week.count);

        const monthFromData = <?php echo $month_json ?>;
        const monthDate = monthFromData.map(month => month.date);
        const monthCount = monthFromData.map(month => month.count);

        var backgroundColor = weekCount.map(c => c < 10 ? 'rgba(255, 0, 0, 0.2)' : 'rgba(37, 99, 235, 0.2)');
        var borderColor = weekCount.map(c => c < 10 ? 'rgba(255, 0, 0, 1)' : '#2563eb');
        var pointBackgroundColor = weekCount.map(c => c < 10 ? 'rgba(255, 0, 0, 1)' : '#2563eb');
        var pointBorderColor = weekCount.map(c => c < 10 ? 'rgba(255, 0, 0, 1)' : '#2563eb');

        var backgroundColor = monthCount.map(c => c < 10 ? 'rgba(255, 0, 0, 0.2)' : 'rgba(37, 99, 235, 0.2)');
        var borderColor = monthCount.map(c => c < 10 ? 'rgba(255, 0, 0, 1)' : '#2563eb');
        var pointBackgroundColor = monthCount.map(c => c < 10 ? 'rgba(255, 0, 0, 1)' : '#2563eb');
        var pointBorderColor = monthCount.map(c => c < 10 ? 'rgba(255, 0, 0, 1)' : '#2563eb');

        const data = {
            labels: weekDate,
            datasets: [{
                label: "Page Views",
                data: weekCount,
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                pointBackgroundColor: pointBackgroundColor,
                pointBorderWidth: 2,
                pointRadius: 4,
            }]
        };

        const options = {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw; // Example: Conversion Rate: 50%
                        }
                    }
                }
            }
        };

        window.onload = function() {
            const ctx = document.getElementById('conversionChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });

            document.getElementById('weekButton').addEventListener('click', function() {
                myChart.data.labels = weekDate;
                myChart.data.datasets[0].data = weekCount;
                myChart.update();
            });

            // Update chart for monthly data
            document.getElementById('monthButton').addEventListener('click', function() {
                myChart.data.labels = monthDate;
                myChart.data.datasets[0].data = monthCount;
                myChart.update();
            });
        };


        function adjustCanvasHeight() {
            const canvas = document.getElementById('conversionChart');
            if (window.innerWidth > 425) {
                canvas.height = 40;
            } else {
                canvas.height = 100;
            }
        }

        window.addEventListener('resize', adjustCanvasHeight);
        adjustCanvasHeight();

        // new vendor
        const newVendor = <?php echo $vendor_json ?>

        const vendorDate = newVendor.map(item => item.date);
        const vendorCount = newVendor.map(item => item.vendor);

        const vendorBackgroundColor = vendorCount.map(v => v < 5 ? '#FF0000' : '#2563eb');

        const Vendor = document.getElementById('newVendor').getContext('2d');
        const newVendorWeek = new Chart(Vendor, {
            type: 'bar',
            data: {
                labels: vendorDate,
                datasets: [{
                    data: vendorCount,
                    backgroundColor: vendorBackgroundColor,
                    borderWidth: 0,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                layout: {
                    padding: 10
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(1);
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // new user
        const newUser = <?php echo $user_json ?>;

        const userDate = newUser.map(item => item.date);
        const userCount = newUser.map(item => item.users);

        const Users = document.getElementById('newUser').getContext('2d');

        const userBackgroundColor = userCount.map(u => u < 5 ? '#FF0000' : '#2563eb');

        const userWeek = new Chart(Users, {
            type: 'line', // Line chart
            data: {
                labels: userDate,
                datasets: [{
                    data: userCount,
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    fill: false,
                    tension: .4,
                    pointBackgroundColor: userBackgroundColor,
                    pointBorderWidth: 2,
                    pointRadius: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }, // Hide legend if not needed
                    tooltip: {
                        enabled: true
                    } // Enable tooltips
                },
                layout: {
                    padding: 10
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(1);
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>


</body>

</html>