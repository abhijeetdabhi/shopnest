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


    // for sales
    $sale_orders = "SELECT * FROM orders WHERE vendor_id = '$vendor_id'";
    $sale_query = mysqli_query($con, $sale_orders);

    $totalSale = 0;
    foreach ($sale_query as $sales) {
        $trimPrice = str_replace(",", "", $sales['total_price']);
        $totalSale += $trimPrice;
    }

    $fetch_orders_query = "
            SELECT date, COUNT(*) AS product_count
            FROM orders
            WHERE vendor_id = '$vendor_id'
            GROUP BY date
        ";
    $orders_result = mysqli_query($con, $fetch_orders_query);

    $data = [];
    while ($order = mysqli_fetch_assoc($orders_result)) {
        $data[] = [
            'date' => $order['date'], // Date field
            'product_count' => (int)$order['product_count'] // Count of products sold
        ];
    }

    $data_json = json_encode($data);

    // for earning
    $earning_orders = "SELECT * FROM orders WHERE vendor_id = '$vendor_id'";
    $earning_query = mysqli_query($con, $earning_orders);

    $totalEarnings = 0;
    foreach ($earning_query as $earnings) {
        $trimEarnings = floatval(str_replace(",", "", $earnings['vendor_profit']));
        $totalEarnings += $trimEarnings;
    }

    // for total products
    $products = "SELECT * FROM products WHERE vendor_id = '$vendor_id'";
    $products_query = mysqli_query($con, $products);

    $products = mysqli_num_rows($products_query);



    // for total orders
    $orders = "SELECT * FROM orders WHERE vendor_id = '$vendor_id'";
    $orders_query = mysqli_query($con, $orders);

    $order = mysqli_num_rows($orders_query);
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

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
                            <img class="w-7 sm:w-14 mt-0.5" src="/src/logo/white_cart_logo.svg" alt="">
                        </div>
                        <!-- text logo -->
                        <div>
                            <img class="w-16 sm:w-36" src="/src/logo/white_text_logo.svg" alt="">
                        </div>
                    </a>
                </div>
                <nav class="mt-10">
                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="vendor_dashboard.php">
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
                                <a href="vendor_logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                            </div>
                        </div>
                    </div>
                </header>
                <main id="main" class="px-4 md:px-12 py-12 overflow-y-scroll scrollBar overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
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
                                <h3 class="text-2xl font-bold text-gray-500"><?php echo isset($_COOKIE['vendor_id']) ? '₹' . number_format($totalSale) : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total sales</span>
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
                                <h3 class="text-2xl font-bold text-green-600"><?php echo isset($_COOKIE['vendor_id']) ? '₹' . number_format($totalEarnings) : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total earnings</span>
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
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['vendor_id']) ? $products : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total products</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white shadow-xl rounded-md px-4 py-3">
                            <div class="bg-gray-50 rounded-md max-w-max p-2">
                                <svg class="w-8 h-8 fill-gray-600" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 438.891 438.891" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M347.968 57.503h-39.706V39.74c0-5.747-6.269-8.359-12.016-8.359h-30.824C258.108 10.483 239.822.034 218.924.034c-20.668-.777-39.467 11.896-46.498 31.347h-30.302c-5.747 0-11.494 2.612-11.494 8.359v17.763H90.923c-23.53.251-42.78 18.813-43.886 42.318v299.363c0 22.988 20.898 39.706 43.886 39.706h257.045c22.988 0 43.886-16.718 43.886-39.706V99.822c-1.106-23.506-20.356-42.068-43.886-42.319zm-196.441-5.224h28.735a11.496 11.496 0 0 0 9.927-9.404c3.094-13.474 14.915-23.146 28.735-23.51 13.692.415 25.335 10.117 28.212 23.51a11.494 11.494 0 0 0 10.449 9.404h29.78v41.796H151.527V52.279zm219.429 346.906c0 11.494-11.494 18.808-22.988 18.808H90.923c-11.494 0-22.988-7.314-22.988-18.808V99.822c1.066-11.964 10.978-21.201 22.988-21.42h39.706v26.645c.552 5.854 5.622 10.233 11.494 9.927h154.122a11.493 11.493 0 0 0 12.016-9.927V78.401h39.706c12.009.22 21.922 9.456 22.988 21.42v299.364z" fill="" opacity="1" data-original="#000000"></path>
                                        <path d="M179.217 233.569c-3.919-4.131-10.425-4.364-14.629-.522l-33.437 31.869-14.106-14.629c-3.919-4.131-10.425-4.363-14.629-.522a10.971 10.971 0 0 0 0 15.151l21.42 21.943a9.403 9.403 0 0 0 7.314 3.135 10.446 10.446 0 0 0 7.314-3.135l40.751-38.661c4.04-3.706 4.31-9.986.603-14.025a8.78 8.78 0 0 0-.601-.604zM329.16 256.034H208.997c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449H329.16c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449zM179.217 149.977c-3.919-4.131-10.425-4.364-14.629-.522l-33.437 31.869-14.106-14.629c-3.919-4.131-10.425-4.364-14.629-.522a10.971 10.971 0 0 0 0 15.151l21.42 21.943a9.403 9.403 0 0 0 7.314 3.135 10.446 10.446 0 0 0 7.314-3.135l40.751-38.661c4.04-3.706 4.31-9.986.603-14.025a8.78 8.78 0 0 0-.601-.604zM329.16 172.442H208.997c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449H329.16c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449zM179.217 317.16c-3.919-4.131-10.425-4.363-14.629-.522l-33.437 31.869-14.106-14.629c-3.919-4.131-10.425-4.363-14.629-.522a10.971 10.971 0 0 0 0 15.151l21.42 21.943a9.403 9.403 0 0 0 7.314 3.135 10.446 10.446 0 0 0 7.314-3.135l40.751-38.661c4.04-3.706 4.31-9.986.603-14.025a9.253 9.253 0 0 0-.601-.604zM329.16 339.626H208.997c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449H329.16c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z" fill="" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-950"><?php echo isset($_COOKIE['vendor_id']) ? $order : '0' ?></h3>
                                <span class="text-sm font-medium text-gray-500">Total orders</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow-xl rounded-md px-4 py-3 mt-12">
                        <h1 class="text-2xl font-bold text-gray-950">Sales</h1>
                        <div id="chart" style="height: 250px;"></div>
                        <script>
                            $(document).ready(function() {
                                var chartData = <?php echo $data_json; ?>;

                                if (chartData.length === 0) {
                                    $('#chart').html('<div style="text-align: center; margin-top: 80px; font-size: 30px; color: #000;">No data available for this period.</div>');
                                } else {
                                    new Morris.Bar({
                                        element: 'chart',
                                        data: chartData,
                                        xkey: 'date',
                                        ykeys: ['product_count'],
                                        labels: ['Number of Products Sold'],
                                        barColors: ['#00a65a'],
                                        hideHover: 'auto',
                                        resize: true,
                                        xLabelAngle: 60,
                                        xLabels: 'day',
                                    });
                                }
                            });
                        </script>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>