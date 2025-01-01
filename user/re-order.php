<?php

if (!isset($_GET['product_id']) || !isset($_COOKIE['user_id'])) {
    header("Location: /index.php");
    exit;
}

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

session_start();

$validNames = [
    $_SESSION['reOrderId'],
    $_SESSION['reOrderColor'],
    $_SESSION['reOrderSize'],
    $_SESSION['reOrderQty'],
    $_SESSION['reOrderMRP'],
    $_SESSION['reOrderTravelTime']
];

if (isset($_GET['product_id']) && isset($_GET['color']) && isset($_GET['size']) && isset($_GET['qty']) && isset($_GET['MRP']) && isset($_GET['travelTime'])) {
    $checkValue = [
        $_GET['product_id'],
        $_GET['color'],
        $_GET['size'],
        $_GET['qty'],
        $_GET['MRP'],
        $_GET['travelTime']
    ];

    $allAvailable = !array_diff($checkValue, $validNames);
    if (!$allAvailable) {
        header("Location: ../user/show_orders.php");
        exit();
    }
}

if (isset($_GET['product_id']) && isset($_GET['color']) && isset($_GET['size']) && isset($_GET['qty']) && isset($_GET['MRP']) && isset($_GET['travelTime'])) {
    $product_id = $_GET['product_id'];
    $travelTime = $_GET['travelTime'];

    $product_find = "SELECT * FROM products WHERE product_id = '$product_id'";
    $product_query = mysqli_query($con, $product_find);

    $row = mysqli_fetch_assoc($product_query);

    $title = $row['title'];
    $product_image = $row['profile_image_1'];
    $color = $_GET['color'];
    $size = $_GET['size'];
    $qty = $_GET['qty'];

    if (isset($product_id)) {
        $MRP = $_GET['MRP'];

        $products_price = explode(",", $MRP);

        $productPrice = implode("", $products_price);

        $totalPriceWithQty = number_format($productPrice * $qty);
    }


    $vendor_id = $row['vendor_id'];


    $vendor_find = "SELECT * FROM vendor_registration WHERE vendor_id  = '$vendor_id'";
    $vendor_query = mysqli_query($con, $vendor_find);
    $ven = mysqli_fetch_assoc($vendor_query);

    $user_id = $_COOKIE['user_id'];

    $get_user = "SELECT * FROM user_registration WHERE user_id = '$user_id'";
    $user_query = mysqli_query($con, $get_user);

    $us = mysqli_fetch_assoc($user_query);
} else {
    header("Location: ../user/show_orders.php");
    exit();
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        <div class="flex items-center justify-center">
            <a class="flex items-center" href="/index.php">
                <!-- icon logo div -->
                <div class="mr-2">
                    <img class="w-7 sm:w-14" src="/src/logo/black_cart_logo.svg" alt="Cart Logo">
                </div>
                <!-- text logo -->
                <div>
                    <img class="w-20 sm:w-36" src="/src/logo/black_text_logo.svg" alt="Shopnest Logo">
                </div>
            </a>
        </div>
        <div class="flex items-center">
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="relative block w-8 h-8 md:w-10 md:h-10 overflow-hidden rounded-full shadow-lg focus:outline-none transition-transform transform hover:scale-105">
                    <img class="object-cover w-full h-full" src="<?php echo isset($_COOKIE['user_id']) ? '/src/user_dp/' . $us['profile_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png'; ?>" alt="Your avatar">
                </button>
                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
                <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl ring-2 ring-gray-300 divide-y-2 divide-gray-300" style="display: none;">
                    <a href="/user/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Profile</a>
                    <a href="/user/show_orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Orders</a>
                    <a href="/user/user_logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                </div>
            </div>
        </div>
    </header>


    <form id="dataForm" class="max-w-screen-xl m-auto" action="" method="post">
        <div class="grid lg:grid-cols-2">
            <div class="px-4 pt-8">
                <p class="text-xl font-medium">Order summary</p>
                <p class="text-gray-400">Check your items. And select a suitable payment method.</p>
                <div class="flex flex-col min-[540px]:flex-row items-center mt-8 space-y-3 rounded-lg bg-gray-100 px-2 py-4 sm:px-6 shadow-lg">
                    <img class="m-2 w-52 md:w-40 rounded-md object-cover object-center mix-blend-multiply" src="<?php echo isset($product_id) ? '../src/product_image/product_profile/' . $product_image : '../src/sample_images/product_1.jpg' ?>" alt="" />
                    <div class="flex w-full flex-col px-4 py-4 gap-y-3">
                        <span class="font-semibold line-clamp-2"><?php echo isset($product_id) ? $title : 'product title' ?></span>
                        <p class="text-lg font-semibold text-green-500">₹<?php echo isset($product_id) ? $MRP : 'MRP' ?></p>
                        <div class="flex item-center justify-between">
                            <div class="flex item-center gap-1">
                                <h1 class="text-lg font-semibold">Color:</h1>
                                <span class="my-auto"><?php echo isset($product_id) ? $color : 'product color' ?></span>
                            </div>
                            <div class="flex item-center gap-1">
                                <?php
                                if (isset($size) == null) {
                                    echo "";
                                } else {
                                ?>
                                    <span class="text-lg font-semibold">Size:</span>
                                    <p class="my-auto"><?php echo isset($product_id) ? $size : 'product Size' ?></p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="flex item-center gap-1">
                            <span class="text-lg font-semibold">QTY:</span>
                            <p class="my-auto"><?php echo isset($product_id) ? $qty : 'product Quantity'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="flex item-center gap-1 mt-8">
                    <span class="text-lg font-semibold">Deliverd In Just:</span>
                    <p class="my-auto text-green-500 font-bold"><?php echo isset($product_id) ? $travelTime . " minutes" : 'Time'; ?></p>
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
                                <input type="text" id="FirstName" name="FirstName" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['first_name'] : 'User First Name' ?>" />
                            </div>
                        </div>
                        <div>
                            <label for="lastName" class="mt-4 mb-2 block text-sm font-medium require">Last name:</label>
                            <div class="relative">
                                <input type="text" id="lastName" name="lastName" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['last_name'] : 'User Last Name' ?>" />
                            </div>
                        </div>
                    </div>
                    <label for="Phone_number" class="mt-4 mb-2 block text-sm font-medium require">Phone number:</label>
                    <div class="relative">
                        <input type="number" id="Phone_number" name="Phone_number" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base uppercase shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['phone'] : 'User Phone Number' ?>" />
                    </div>
                    <label for="user_email" class="mt-4 mb-2 block text-sm font-medium require">Email:</label>
                    <div class="relative">
                        <input type="email" id="user_email" name="user_email" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['email'] : 'User email' ?>" />
                    </div>
                    <label for="Address" class="mt-4 mb-2 block text-sm font-medium require">Shipping address:</label>
                    <div class="relative">
                        <input type="text" id="Address" name="Address" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['Address'] : 'User Address' ?>" />
                    </div>
                    <label for="state" class="mt-4 mb-2 block text-sm font-medium require">State:</label>
                    <div class="relative">
                        <input type="text" id="state" name="state" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['state'] : 'User state' ?>" readonly />
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div>
                            <label for="city" class="mt-4 mb-2 block text-sm font-medium require">City:</label>
                            <div class="relative">
                                <input type="text" id="city" name="city" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" value="<?php echo isset($product_id) ? $us['city'] : 'User city' ?>" readonly />
                            </div>
                        </div>
                        <div>
                            <label for="pin" class="mt-4 mb-2 block text-sm font-medium require">Pincode:</label>
                            <div class="relative">
                                <input type="tel" id="pin" name="pin" class="w-full rounded-md border border-gray-200 px-4 py-3 text-base shadow-sm outline-none focus:z-10 focus:border-gray-500 focus:ring-gray-500" maxlength="6" value="<?php echo isset($product_id) ? $us['pin'] : 'User Pin' ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="mt-6 border-t border-b py-2">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Subtotal</p>
                            <?php
                            if (isset($product_id)) {
                                $product_mrp = $_GET['MRP'];
                                $products_price = explode(",", $product_mrp);

                                $productPrice = implode("", $products_price);
                            }
                            ?>
                            <p class="font-semibold text-gray-900">₹<?php echo isset($product_id) ? $totalPriceWithQty : 'MRP' ?></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Shipping</p>
                            <p class="font-semibold text-gray-900">₹<?php
                                                                    if (isset($product_id)) {
                                                                        $totalPriceWithQty = str_replace(',', '', $totalPriceWithQty);
                                                                        $totalPriceWithQty = (int) $totalPriceWithQty;
                                                                        if ($totalPriceWithQty <= 599) {
                                                                            $shipping = 40;
                                                                        } else {
                                                                            $shipping = 0;
                                                                        }
                                                                    } else {
                                                                        $shipping = 0;
                                                                    }

                                                                    // Output the shipping value
                                                                    echo $shipping;
                                                                    ?></p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <p class="text-base font-medium text-gray-900">Total</p>
                        <label for="totalPrice">
                            <h1 class="float-right text-2xl font-semibold text-green-500">₹
                                <?php
                                if (isset($product_id)) {
                                    $productPrice = (float)$productPrice;
                                    $qty = (int)$qty;

                                    $totalPriceWithQty = $productPrice * $qty;

                                    $total = $totalPriceWithQty + $shipping;

                                    $formattedTotalPriceWithQty = number_format($totalPriceWithQty, 0);
                                    $formattedTotal = number_format($total, 0);

                                    echo $formattedTotal;
                                } else {
                                    echo 'Total Amount';
                                }
                                ?>
                            </h1>
                        </label>
                        <input type="text" id="totalPrice" class="hidden float-right bg-transparent border-none text-2xl font-semibold text-gray-900" name="totalProductPrice" value="₹<?php
                                                                                                                                                                                        if (isset($product_id)) {
                                                                                                                                                                                            $productPrice = (float)$productPrice;
                                                                                                                                                                                            $qty = (int)$qty;

                                                                                                                                                                                            $totalPriceWithQty = $productPrice * $qty;

                                                                                                                                                                                            $total = $totalPriceWithQty + $shipping;

                                                                                                                                                                                            $formattedTotalPriceWithQty = number_format($totalPriceWithQty, 0);
                                                                                                                                                                                            $formattedTotal = number_format($total, 0);

                                                                                                                                                                                            echo $formattedTotal;
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo 'Total Amount';
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>" dir="rtl">
                    </div>
                </div>
                <div>
                    <button id="checkOutBtn" type="submit" name="placeOrder" class="mt-4 mb-8 w-full rounded-tl-xl rounded-br-xl bg-gray-700 px-6 py-3 font-medium text-white transition duration-200 cursor-pointer hover:bg-gray-800">Place Order</button>
                </div>
            </div>
        </div>
    </form>


    <!-- Successfully message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 m-auto rounded-lg border-green-400 py-3 px-6 bg-gray-800 z-50" id="SpopUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="Successfully"></div>
        </div>
    </div>


    <!-- Error message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 rounded-lg border-red-500 py-3 px-6 bg-gray-800 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-red-400">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="errorMessage"></div>
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
            let dataForm = document.getElementById('dataForm');

            // Display the loader
            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
            dataForm.style.opacity = '0.4';
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

            // Display success message
            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';

                // Trigger confetti from both the left and right bottom corners


                fireExplosiveConfettiFromLeft();
                fireExplosiveConfettiFromRight();
                // Redirect after 2 seconds
                setInterval(() => {
                    window.location.href = "show_orders.php";

                }, 1500);
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
    </script>

    <script>
        $(document).ready(function() {
            $('#dataForm').on('submit', function(e) {

                e.preventDefault();

                let FirstName = $('#FirstName').val().trim();
                let lastName = $('#lastName').val().trim();
                let Phone_number = $('#Phone_number').val().trim();
                let user_email = $('#user_email').val().trim();
                let Address = $('#Address').val().trim();
                let state = $('#state').val().trim();
                let city = $('#city').val().trim();
                let pin = $('#pin').val().trim();
                let paymentType = $('input[name="payment"]:checked').val();

                if (FirstName === '' || lastName === '' || Phone_number === '' || user_email === '' || Address === '' || state === '' || city === '' || pin === '') {
                    displayErrorMessage('Please fill out all fields.')
                    return
                } else if (!paymentType) {
                    displayErrorMessage('Please select payment method.')
                    return
                }

                $.ajax({
                    type: "POST",
                    url: "",
                    data: {
                        title: "<?php echo $title ?>",
                        pimg: "<?php echo $product_image ?>",
                        totalPriceWithQty: "<?php echo $totalPriceWithQty ?>",
                        color: "<?php echo $color ?>",
                        size: "<?php echo $size ?>",
                        travelTime: <?php echo $travelTime ?>,
                        qty: "<?php echo $qty ?>",

                        product_id: "<?php echo $product_id ?>",
                        vendor_id: "<?php echo $vendor_id ?>",
                        user_id: "<?php echo $user_id ?>",

                        shipping: "<?php echo $shipping ?>",
                        formattedTotal: "<?php echo $formattedTotal ?>",

                        FirstName: FirstName,
                        lastName: lastName,
                        Phone_number: Phone_number,
                        user_email: user_email,
                        Address: Address,
                        state: state,
                        city: city,
                        pin: pin,
                        paymentType: paymentType
                    },
                    success: function(response) {
                        loader();
                        displaySuccessMessage("Order Place Successfully")
                    }
                });
            });
        });
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

include "../include/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_title = $_POST['title'];
    $order_image = $_POST['pimg'];
    $order_price = $_POST['totalPriceWithQty'];
    $order_color = $_POST['color'];
    $order_size = $_POST['size'];
    $order_travelTime = $_POST['travelTime'];
    $product_qty = $_POST['qty'];

    $shipping = $_POST['shipping'];
    $formattedTotal = $_POST['formattedTotal'];

    $product_id = $_POST['product_id'];
    $vendor_id = $_POST['vendor_id'];
    $user_id = $_POST['user_id'];

    $FirstName = $_POST['FirstName'];
    $lastName = $_POST['lastName'];
    $Phone_number = $_POST['Phone_number'];
    $user_email = $_POST['user_email'];
    $Address = $_POST['Address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pin = $_POST['pin'];
    $paymentType = $_POST['paymentType'];


    $bac = str_replace(",", "", $order_price);
    $bac = (int)$bac;

    $totalProductPrice = number_format($bac + $shipping);

    $orders_prices = str_replace(",", "", $order_price);

    $admin_profit = 20 + $shipping;
    $vendor_profit = number_format($orders_prices - $admin_profit);

    date_default_timezone_set('Asia/Kolkata');
    $order_place_date = date('d-m-Y h:i:s A');

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
    $user_order_travelTime = $order_travelTime;

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

    $order_insert_sql = "INSERT INTO orders(order_title, order_image, order_price, order_color, order_size, qty, travelTime, user_id, product_id, vendor_id, user_first_name, user_last_name, user_email, user_mobile, user_address, user_state, user_city, user_pin, payment_type, total_price, vendor_profit, admin_profit, date) VALUES ('$user_order_title','$user_order_image','$user_order_price','$user_order_color','$user_order_size','$user_order_qty','$user_order_travelTime','$user_order_user_id','$user_order_product_id','$user_order_vendor_id','$order_user_first_name','$order_user_last_name','$order_user_email','$order_user_mobile','$order_user_address','$order_user_state','$order_user_city','$order_user_pin','$order_payment_type','$order_total_price','$order_vendor_profit','$order_admin_profit','$order_date')";
    $order_insert_query = mysqli_query($con, $order_insert_sql);

    $update_qty = "UPDATE products SET Quantity='$remove_quty' WHERE product_id = '$product_id'";
    $update_qty_quary = mysqli_query($con, $update_qty);
}
?>

<?php
?>