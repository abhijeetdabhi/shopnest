<?php

if (!isset($_GET['totalPrice']) || !isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_COOKIE['Cart_products'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}

session_start();
?>

<?php
include "../include/connect.php";

$totalPriceOfProducts = $_SESSION['totalCartPrice'];
$totalQtyOfProducts = $_SESSION['qty'];
$totalTravelTimeOfProducts = $_SESSION['travelTime'];

$validNames = [$totalPriceOfProducts, $totalQtyOfProducts, $totalTravelTimeOfProducts];

if (isset($_GET['totalPrice']) && isset($_GET['qty']) && isset($_GET['travelTime'])) {
    $totalPriceOfProducts = $_GET['totalPrice'];
    $totalQtyOfProducts = $_GET['qty'];
    $totalTravelTimeOfProducts = $_GET['travelTime'];

    $checkValue = [$totalPriceOfProducts, $totalQtyOfProducts, $totalTravelTimeOfProducts];

    $allAvailable = true;
    foreach ($checkValue as $value) {
        if (!in_array($value, $validNames)) {
            $allAvailable = false;
        }
    }

    if (!$allAvailable) {
        echo "available";
        header("Location: cart.php");
        exit();
    }
}

if (isset($_COOKIE['user_id'])) {
    $totalPrice = $_GET['totalPrice'];
    $myCookie = $_COOKIE['user_id'];
    if (isset($_COOKIE['Cart_products'])) {
        $cookie_value = $_COOKIE['Cart_products'];

        $cart_products = json_decode($cookie_value, true);
        if (!empty($cart_products) && is_array($cart_products)) {
            foreach ($cart_products as $Cproducts) {
                $cart_products_id = $Cproducts['cart_id'];
                $cart_products_image = $Cproducts['cart_image'];
                $cart_products_title = $Cproducts['cart_title'];
                $cart_products_price = $Cproducts['cart_price_per_unit'];
                $cart_products_color = $Cproducts['cart_color'];
                $cart_products_size = $Cproducts['cart_size'];
                $cart_products_qty = $Cproducts['cart_qty'];
            }
        }
    }

    $travelTime = $_GET['travelTime'];

    $product_find = "SELECT * FROM products WHERE product_id = '$cart_products_id'";
    $product_query = mysqli_query($con, $product_find);

    $row = mysqli_fetch_assoc($product_query);

    $qty = $_GET['qty'];

    $cleaned_string = trim($qty, '[]');
    $array = explode(',', $cleaned_string);
    $numbers = array_map('intval', $array);
    $quantityMap = array_combine(array_keys($cart_products), $numbers);

    $vendor_id = $row['vendor_id'];

    $vendor_find = "SELECT * FROM vendor_registration WHERE vendor_id  = '$vendor_id'";
    $vendor_query = mysqli_query($con, $vendor_find);
    $ven = mysqli_fetch_assoc($vendor_query);

    $user_id = $_COOKIE['user_id'];

    $get_user = "SELECT * FROM user_registration WHERE user_id = '$user_id'";
    $user_query = mysqli_query($con, $get_user);

    $us = mysqli_fetch_assoc($user_query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- alpine CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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

    <!-- confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>


    <!-- title -->
    <title>Check Out Page</title>
    <style>
        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
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

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-600">
        <div>
            <a href="../shopping/cart.php">
                <!-- Left Arrow Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492" class="w-6 h-6">
                    <path d="M198.608 246.104 382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="currentColor"></path>
                </svg>
            </a>
        </div>
        <div class="flex items-center justify-center">
            <a class="flex items-center" href="cart.php">
                <!-- icon logo div -->
                <div class="mr-2">
                    <img class="w-7 sm:w-14" src="../src/logo/black_cart_logo.svg" alt="Cart Logo">
                </div>
                <!-- text logo -->
                <div>
                    <img class="w-20 sm:w-36" src="../src/logo/black_text_logo.svg" alt="Shopnest Logo">
                </div>
            </a>
        </div>
        <div class="flex items-center">
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="relative block w-8 h-8 md:w-10 md:h-10 overflow-hidden rounded-full shadow-lg focus:outline-none transition-transform transform hover:scale-105">
                    <img class="object-cover w-full h-full" src="<?php echo isset($_COOKIE['user_id']) ? '../src/user_dp/' . $us['profile_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png'; ?>" alt="Your avatar">
                </button>
                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
                <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl ring-2 ring-gray-300 divide-y-2 divide-gray-300" style="display: none;">
                    <a href="../user/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Profile</a>
                    <a href="../user/show_orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Orders</a>
                    <a href="../user/user_logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                </div>
            </div>
        </div>
    </header>


    <form id="dataForm" class="max-w-screen-xl m-auto" action="" method="post">
        <div class="grid lg:grid-cols-2">
            <div class="px-4 pt-8">
                <p class="text-xl font-medium">Order summary</p>
                <p class="text-gray-400">Check your items. And select a suitable payment method.</p>
                <?php
                if (isset($_COOKIE['Cart_products'])) {
                    $cookie_value = $_COOKIE['Cart_products'];

                    $cart_products = json_decode($cookie_value, true);

                    if (!empty($cart_products) && is_array($cart_products)) {
                        foreach ($cart_products as $index => $Cproducts) {
                            $cart_products_id = $Cproducts['cart_id'];
                            $cart_products_image = $Cproducts['cart_image'];
                            $cart_products_title = $Cproducts['cart_title'];
                            $cart_products_price = $Cproducts['cart_price_per_unit'];
                            $cart_products_color = $Cproducts['cart_color'];
                            $cart_products_size = $Cproducts['cart_size'];

                            $product_quantity = isset($quantityMap[$index]) ? $quantityMap[$index] : 'N/A';
                            $cart_price = str_replace(',', '', $cart_products_price);

                            $total_price = (int)$product_quantity * (int)$cart_price;
                ?>
                            <div class="flex flex-col min-[580px]:flex-row items-center justify-center rounded-lg bg-gray-100  mt-8 space-y-3 px-2 py-4 shadow-md">
                                <img class="m-2 h-52 md:h-36 rounded-md object-cover object-center" src="<?php echo isset($myCookie) ? '../src/product_image/product_profile/' . $cart_products_image : '../src/sample_images/product_1.jpg' ?>" alt="" />
                                <div class="flex w-full flex-col px-4 py-4 gap-y-3">
                                    <span class="font-semibold line-clamp-2"><?php echo isset($myCookie) ? $cart_products_title : 'product title' ?></span>
                                    <p class="text-lg font-semibold text-green-500">₹<?php echo isset($myCookie) ? number_format($total_price) : 'MRP' ?></p>
                                    <div class="flex item-center justify-between">
                                        <div class="flex item-center gap-1">
                                            <span class="text-lg font-semibold text-gray-600">Color:</span>
                                            <div class="my-auto"><?php echo isset($myCookie) ? htmlspecialchars($cart_products_color) : 'product color' ?></div>
                                        </div>
                                        <div class="flex item-center gap-1">
                                            <span class="text-lg font-semibold text-gray-600">Size:</span>
                                            <p class="my-auto"><?php echo isset($myCookie) ? $cart_products_size : 'product Size' ?></p>
                                        </div>
                                    </div>
                                    <div class="flex item-center justify-between flex-wrap">
                                        <div class="flex item-center gap-1">
                                            <span class="text-lg font-semibold text-gray-600">QTY:</span>
                                            <p class="my-auto"><?php echo isset($myCookie) ? $product_quantity : 'product Qty'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>

                <div class="flex item-center gap-1 mt-8">
                    <span class="text-lg font-semibold">Deliverd In Just:</span>
                    <p class="my-auto text-green-500 font-bold"><?php echo isset($myCookie) ? $travelTime . " minutes" : 'Time'; ?></p>
                </div>

                <p class="mt-8 text-xl font-medium">Payment methods</p>
                <p class="text-gray-400">Complete your order by providing your payment details.</p>
                <div class="mt-5 grid space-y-3 border bg-white rounded-lg px-2 py-4 sm:px-6">
                    <div class="flex items-center gap-3 cursor-pointer w-max">
                        <input type="radio" name="payment" id="COD" value="Cash on delivery" class="cursor-pointer text-gray-600 focus:ring-gray-600">
                        <label class="cursor-pointer text-base font-medium" for="COD">Cash on delivery</label>
                    </div>
                </div>
                <p class="text-red-500 my-4 mt-6">Note: We aim to deliver your order within given minutes. However, please note that delivery times may vary due to factors like traffic and other unforeseen circumstances. We appreciate your understanding!</p>
            </div>
            <div class="mt-10 px-4 pt-8 lg:mt-0">
                <p class="text-xl font-medium">Billing details</p>
                <div class="">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div>
                            <label for="FirstName" class="mt-4 mb-2 block text-sm font-medium require">First name:</label>
                            <div class="relative">
                                <input type="text" id="FirstName" name="FirstName" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['first_name'] : 'User First Name' ?>" />
                            </div>
                        </div>
                        <div>
                            <label for="lastName" class="mt-4 mb-2 block text-sm font-medium require">Last name:</label>
                            <div class="relative">
                                <input type="text" id="lastName" name="lastName" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['last_name'] : 'User Last Name' ?>" />
                            </div>
                        </div>
                    </div>
                    <label for="Phone_number" class="mt-4 mb-2 block text-sm font-medium require">Phone number:</label>
                    <div class="relative">
                        <input type="number" id="Phone_number" name="Phone_number" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base uppercase shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['phone'] : 'User Phone Number' ?>" />
                    </div>
                    <label for="user_email" class="mt-4 mb-2 block text-sm font-medium require">Email:</label>
                    <div class="relative">
                        <input type="email" id="user_email" name="user_email" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['email'] : 'User email' ?>" />
                    </div>
                    <label for="Address" class="mt-4 mb-2 block text-sm font-medium require">Shipping address:</label>
                    <div class="relative">
                        <input type="text" id="Address" name="Address" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['Address'] : 'User Address' ?>" />
                    </div>
                    <label for="state" class="mt-4 mb-2 block text-sm font-medium require">State:</label>
                    <div class="relative">
                        <input type="text" id="state" name="state" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['state'] : 'User state' ?>" readonly />
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div>
                            <label for="city" class="mt-4 mb-2 block text-sm font-medium require">City:</label>
                            <div class="relative">
                                <input type="text" id="city" name="city" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($myCookie) ? $us['city'] : 'User city' ?>" readonly />
                            </div>
                        </div>
                        <div>
                            <label for="pin" class="mt-4 mb-2 block text-sm font-medium require">Pincode:</label>
                            <div class="relative">
                                <input type="tel" id="pin" name="pin" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" maxlength="6" value="<?php echo isset($myCookie) ? $us['pin'] : 'User Pin' ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="mt-6 border-t border-b py-2">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Subtotal</p>
                            <?php
                            if (isset($myCookie)) {
                                $product_mrp = $totalPrice;
                                $products_price = explode(",", $product_mrp);

                                $productPrice = implode("", $products_price);
                            }
                            ?>
                            <p class="font-semibold text-gray-900">₹<?php echo isset($myCookie) ? number_format($totalPrice) : 'MRP' ?></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Shipping</p>
                            <p class="font-semibold text-gray-900">₹<?php echo isset($myCookie) ? ($productPrice <= 599 ? $shipping = 40 : $shipping = 0) : $shipping = 0 ?></p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <p class="text-base font-medium text-gray-900">Total</p>
                        <label for="totalPrice">
                            <h1 class="float-right text-2xl font-semibold text-green-500">₹
                                <?php
                                if (isset($myCookie)) {
                                    $product_mrp = $totalPrice;
                                    $products_price = explode(",", $product_mrp);

                                    $productPrice = implode("", $products_price);

                                    $total = $totalPrice + $shipping;

                                    $formattedTotalPriceWithQty = number_format($totalPrice, 0);
                                    $formattedTotal = number_format($total, 0);

                                    echo $formattedTotal;
                                } else {
                                    echo 'Total Amount';
                                }
                                ?>
                            </h1>
                        </label>
                        <input type="text" id="totalPrice" class="hidden float-right bg-transparent border-none text-2xl font-semibold text-gray-900" name="totalProductPrice" value="₹<?php
                                                                                                                                                                                        if (isset($myCookie)) {
                                                                                                                                                                                            $product_mrp = $totalPrice;
                                                                                                                                                                                            $products_price = explode(",", $product_mrp);

                                                                                                                                                                                            $productPrice = implode("", $products_price);

                                                                                                                                                                                            $total = $totalPrice + $shipping;

                                                                                                                                                                                            $formattedTotalPriceWithQty = number_format($totalPrice, 0);
                                                                                                                                                                                            $formattedTotal = number_format($total, 0);

                                                                                                                                                                                            echo $formattedTotal;
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo 'Total Amount';
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>" dir="rtl">
                    </div>
                </div>
                <div>
                    <input type="submit" name="placeOrder" id="placeOrder" value="Place order" class="cursor-pointer hover:bg-gray-800 mt-4 mb-8 w-full rounded-tl-xl rounded-br-xl bg-gray-700 px-6 py-3 font-medium text-white transition duration-200">
                </div>
            </div>
        </div>
    </form>

    <br><br>

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
        <div id="spin1" class="w-24 h-24 border-4 border-transparent outer-line border-t-gray-700 rounded-full flex items-center justify-center"></div>
        <div id="spin2" class="w-20 h-20 border-4 border-transparent rotate-180 inner-line border-t-gray-900 rounded-full absolute"> </div>
        <img class="w-10 absolute" src="../src/logo/black_cart_logo.svg" alt="Cart Logo">
    </div>

    <script>
        // Loader function
        function loader() {
            let loader = document.getElementById('loader');
            let body = document.body;
            let dataForm = document.getElementById('dataForm');
            let spin1 = document.getElementById('spin1');
            let spin2 = document.getElementById('spin2');

            // Add animation classes
            spin1.classList.add('outer-line');
            spin2.classList.add('inner-line');

            // Display the loader
            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
            dataForm.style.opacity = '0.4';
        }


        // Display error message
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

        // Display success message with confetti effects
        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');

            // Keep animation classes active
            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';

                // Fire confetti effects from both sides
                fireExplosiveConfettiFromLeft();
                fireExplosiveConfettiFromRight();

                // Redirect after animation
                setTimeout(() => {
                    window.location.href = '../user/show_orders.php';
                }, 2000);
            }, 2000);
        }


        // Explosive Confetti from the left bottom corner
        function fireExplosiveConfettiFromLeft() {
            confetti({
                particleCount: 900, // Number of confetti particles
                spread: 180, // Spread angle of confetti
                origin: {
                    x: 0, // Confetti starts from the left bottom corner
                    y: 1
                },
                scalar: 1, // Larger particles for explosive effect
                colors: ['#ff0000', '#00ff00', '#0000ff', '#ffff00'],
                gravity: 0.8, // Gravity for explosive effect
                drift: 1, // Drift direction
            });
        }

        // Explosive Confetti from the right bottom corner
        function fireExplosiveConfettiFromRight() {
            confetti({
                particleCount: 900, // Number of confetti particles
                spread: 180, // Spread angle of confetti
                origin: {
                    x: 1, // Confetti starts from the right bottom corner
                    y: 1
                },
                scalar: 1, // Larger particles for explosive effect
                colors: ['#ff0000', '#00ff00', '#0000ff', '#ffff00'],
                gravity: 0.8, // Gravity for explosive effect
                drift: -1, // Drift direction
            });
        }

        function checkButton (event){
            let COD = document.getElementById('COD');
            let placeOrder = document.getElementById('placeOrder');

            if(COD.checked) {
                placeOrder.disabled = false;
                placeOrder.classList.remove('opacity-25');
                placeOrder.classList.add('cursor-pointer');
                placeOrder.classList.remove('cursor-not-allowed');
            } else {
                placeOrder.disabled = true;
                placeOrder.classList.add('opacity-25');
                placeOrder.classList.remove('cursor-pointer');
                placeOrder.classList.add('cursor-not-allowed');
            }
        }
        let COD = document.getElementById('COD');
        COD.addEventListener('change', checkButton);
        checkButton();
    </script>

    <!-- footer -->
    <?php
    include "../pages/_footer.php";
    ?>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>

<?php

if (isset($_POST['placeOrder'])) {
    if (isset($_COOKIE['Cart_products'])) {
        $cookie_value = $_COOKIE['Cart_products'];
        $cart_products = json_decode($cookie_value, true);
        include "../pages/mail.php";
        if (!empty($cart_products) && is_array($cart_products)) {
            foreach ($cart_products as $index => $Cproducts) {
                // Escape special characters
                $order_image = mysqli_real_escape_string($con, $Cproducts['cart_image']);
                $order_title = mysqli_real_escape_string($con, $Cproducts['cart_title']);
                $order_price = mysqli_real_escape_string($con, $Cproducts['cart_price']);
                $order_color = mysqli_real_escape_string($con, $Cproducts['cart_color']);
                $order_size = mysqli_real_escape_string($con, $Cproducts['cart_size']);


                $user_id = mysqli_real_escape_string($con, $_COOKIE['user_id']);
                $product_id = mysqli_real_escape_string($con, $Cproducts['cart_id']);
                $vendor_id = mysqli_real_escape_string($con, $row['vendor_id']);

                $FirstName = mysqli_real_escape_string($con, $_POST['FirstName']);
                $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
                $Phone_number = mysqli_real_escape_string($con, $_POST['Phone_number']);
                $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
                $Address = mysqli_real_escape_string($con, $_POST['Address']);
                $state = mysqli_real_escape_string($con, $_POST['state']);
                $city = mysqli_real_escape_string($con, $_POST['city']);
                $pin = mysqli_real_escape_string($con, $_POST['pin']);

                if (isset($_POST['payment'])) {
                    $paymentType = mysqli_real_escape_string($con, $_POST['payment']);
                }

                $bac = str_replace(",", "", $order_price);
                $bac = (int)$bac;

                if ($bac <= 599) {
                    $shipping = 40;
                } else {
                    $shipping = 0;
                }

                $totalProductPrice = number_format($bac + $shipping);

                $orders_prices = str_replace(",", "", $Cproducts['cart_price']);

                $admin_profit = 20 + $shipping;
                $vendor_profit = number_format($orders_prices - $admin_profit);

                date_default_timezone_set('Asia/Kolkata');
                $order_place_date = date('d-m-Y h:i:s A');

                if (!empty($FirstName) && !empty($lastName) && !empty($Phone_number) && !empty($user_email) && !empty($Address) && !empty($state) && !empty($city) && !empty($pin) && !empty($paymentType)) {
                    // remove quantity of products
                    $product_id = mysqli_real_escape_string($con, $Cproducts['cart_id']);

                    $product_qty = $product_quantity = isset($quantityMap[$index]) ? $quantityMap[$index] : 'N/A';

                    $get_qty = "SELECT * FROM products WHERE product_id = '$product_id'";
                    $get_qty_query = mysqli_query($con, $get_qty);

                    $qty = mysqli_fetch_assoc($get_qty_query);
                    $product_quty = $qty['Quantity'];
                    $qty_replace = str_replace(",", "", $product_quty);
                    $remove_quty = $qty_replace - $product_qty;

                    $user_order_title = $order_title;
                    $user_order_image = $order_image;
                    $user_order_price = $order_price;
                    $user_order_color = $order_color;
                    $user_order_size = $order_size;
                    $user_order_qty = $product_qty;
                    $user_order_travelTime = $travelTime;

                    $user_order_user_id = $user_id;
                    $user_order_product_id = $product_id;
                    $user_order_vendor_id = $vendor_id;

                    $order_user_first_name = $FirstName;
                    $order_user_last_name = $lastName;
                    $order_user_email = $user_email;
                    $order_user_mobile = $Phone_number;
                    $order_user_address = $Address;
                    $order_user_state = $state;
                    $order_user_city = $city;
                    $order_user_pin = $pin;
                    $order_payment_type = $paymentType;

                    $order_total_price = $totalProductPrice;
                    $order_vendor_profit = $vendor_profit;
                    $order_admin_profit = $admin_profit;
                    $order_date = $order_place_date;

                    $order_insert_sql = "INSERT INTO orders(order_title, order_image, order_price, order_color, order_size, qty, travelTime, user_id, product_id, vendor_id, user_first_name, user_last_name, user_email, user_mobile, user_address, user_state, user_city, user_pin, payment_type, Status,total_price, vendor_profit, admin_profit, date) VALUES ('$user_order_title','$user_order_image','$user_order_price','$user_order_color','$user_order_size','$user_order_qty','$user_order_travelTime','$user_order_user_id','$user_order_product_id','$user_order_vendor_id','$order_user_first_name','$order_user_last_name','$order_user_email','$order_user_mobile','$order_user_address','$order_user_state','$order_user_city','$order_user_pin','$order_payment_type', 'pending','$order_total_price','$order_vendor_profit','$order_admin_profit','$order_date')";
                    $order_insert_query = mysqli_query($con, $order_insert_sql);

                    $update_qty = "UPDATE products SET Quantity='$remove_quty' WHERE product_id = '$product_id'";
                    $update_qty_quary = mysqli_query($con, $update_qty);

                    if ($update_qty_quary) {
                        $product_id = mysqli_real_escape_string($con, $Cproducts['cart_id']);

                        $retrieve_order = "SELECT * FROM orders WHERE product_id = '$product_id'";
                        $retrieve_order_query = mysqli_query($con, $retrieve_order);
                        $res = mysqli_fetch_assoc($retrieve_order_query);

                        $mail->addAddress($user_email);
                        $mail->isHTML(true);

                        if ($res) {
                            $username = $res['user_first_name'] . ' ' . $res['user_last_name'];
                            $order_id = $res['order_id'];
                            $order_date = $res['date'];
                            $order_title = $res['order_title'];
                            $order_image = '../src/product_image/product_profile/' . $res['order_image'];
                            $order_price = $res['order_price'];
                            $order_color = $res['order_color'];
                            $order_size = $res['order_size'];
                            $order_qty = $res['qty'];
                            $user_email = $res['user_email'];
                            $user_mobile = $res['user_mobile'];
                            $user_address = $res['user_address'];
                            $total_price = $res['total_price'];
                            $today = date('d-m-Y', strtotime($res['date']));
                            $delivery_date = date('d-m-Y', strtotime('+5 days', strtotime($today)));

                            $mail->Subject = "Order Placed - #$order_id (Pending Confirmation)";
                            $mail->Body = "<html>
                            <head>
                            <title>Order Placed - Pending Confirmation</title>
                            </head>
                            <body>
                            <p>Dear $username,</p>
                            <p>Thank you for placing an order with us! We are excited to inform you that your order has been received and is currently pending confirmation. The details of your order are as follows:</p>
                            <p><strong>Order Number:</strong> $order_id<br>
                            <strong>Order Date:</strong> $order_date</p>
                            <h3>Items Ordered:</h3>
                            <table border='1' cellpadding='10'>
                                <tr>
                                <td><strong>Product Name:</strong></td>
                                <td>$order_title</td>
                                </tr>
                                <tr>
                                <td><strong>Image:</strong></td>
                                <td><img src='$order_image' alt='Product Image' width='100'></td>
                                </tr>
                                <tr>
                                <td><strong>Price:</strong></td>
                                <td>$order_price</td>
                                </tr>
                                <tr>
                                <td><strong>Quantity:</strong></td>
                                <td>$order_qty</td>
                                </tr>
                                <tr>
                                <td><strong>Color:</strong></td>
                                <td>$order_color</td>
                                </tr>
                                <tr>
                                    <td><strong>Size:</strong></td>
                                    <td>$order_size</td>
                                </tr>
                            </table>
                            <p><strong>Mobile Number:</strong> $user_mobile</p>
                            <p><strong>Billing E-mail:</strong> $user_email</p>
                            <p><strong>Billing Address:</strong> $user_address</p>
                            <p><strong>Order Total Price:</strong> $total_price</p>
                            <p><strong>Estimated Delivery Date:</strong> $delivery_date</p>
                            <p>Your order is currently pending confirmation from the vendor. Once the vendor accepts your order, we will send you a confirmation and update you on the shipping details.</p>
                            <p>If you have any questions or need further assistance, please do not hesitate to contact us.</p>
                            <p>Thank you for choosing shopNest. We look forward to serving you again!</p>
                            <p>Best regards,<br>
                            shopNest<br>
                            shopnest2603@gmail.com</p>
                            </body>
                            </html>";

                            $mail->send();
                        }
                        echo '<script>displaySuccessMessage("Your order has been placed.");</script>';
                    }

                    $url = 'http://localhost/shopnest/shopping/checkout_from_cart.php';
                    $_SESSION['cartUrl'] = $url;

                    echo '<script>loader()</script>';
                    echo '<script>displaySuccessMessage("Your order has been placed.");</script>';
                } else {
                    echo '<script>displayErrorMessage("Missing fields in the order data.");</script>';
                }
            }
        }
    }
}

?>