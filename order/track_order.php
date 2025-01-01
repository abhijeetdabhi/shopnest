<?php

if (!isset($_GET['order_id']) || !isset($_COOKIE['user_id'])) {
    header("Location: /user/show_orders.php");
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
    $_SESSION['order_id']
];

if (isset($_GET['order_id'])) {
    $checkValue = [
        $_GET['order_id']
    ];

    $allAvailable = !array_diff($checkValue, $validNames);

    if (!$allAvailable) {
        header("Location: ../user/show_orders.php");
        exit();
    }
}
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
    $user_name = $_COOKIE['fname'];

    $order_id = $_GET['order_id'];

    $retrieve_order = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $retrieve_order_query = mysqli_query($con, $retrieve_order);

    $res = mysqli_fetch_assoc($retrieve_order_query);

    $product_id = $res['order_id'];
    $products_id = $res['product_id'];
    $product_title = $res['order_title'];
    $product_color = $res['order_color'];
    $product_size = $res['order_size'];
    $product_qty = $res['qty'];
    $product_MRP = $res['order_price'];
    $travelTime = $res['travelTime'];
    $todays = date('Y-m-d');

    date_default_timezone_set('Asia/Kolkata');

    $dateTime = $res['date'];
    $newDate = new DateTime($dateTime);
    $onlyTime = $newDate->format("h:i:s A");
    $orderPlacedTime = $onlyTime;

    $travelTime = $res['travelTime'];

    $currentTime = date('h:i:s A');

    $date = new DateTime($orderPlacedTime);
    $date2 = new DateTime($orderPlacedTime);
    $date3 = new DateTime($orderPlacedTime);
    $date4 = new DateTime($orderPlacedTime);

    $remainTime = $travelTime;
    $time1 = $date->getTimestamp();
    $time1Formatted = $date->format("h:i:s A");

    $remainTime2 = floor($travelTime / 3);
    $date2->modify("+$remainTime2 minutes");
    $time2 = $date2->getTimestamp();
    $time2Formatted = $date2->format("h:i:s A");

    $remainTime3 = floor($travelTime / 2);
    $date3->modify("+$remainTime3 minutes");
    $time3 = $date3->getTimestamp();
    $time3Formatted = $date3->format("h:i:s A");

    $remainTime4 = floor($travelTime / 1);
    $date4->modify("+$remainTime4 minutes");
    $time4 = $date4->getTimestamp();
    $time4Formatted = $date4->format("h:i:s A");

    $shipedTime = $date4->format('h:i A');
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
    <title>Track Order</title>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
    include "../pages/_navbar.php";
    ?>

    <section class="max-w-screen-lg m-auto bg-white py-8 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div>
                <?php
                if ($time4Formatted <= $currentTime) {
                ?>
                    <h2 class="text-xl font-semibold sm:text-2xl">Your order is delivered</h2>
                <?php
                } else {
                ?>
                    <p class="text-red-500 my-4">Note: We aim to deliver your order within given minutes. However, please note that delivery times may vary due to factors like traffic and other unforeseen circumstances. We appreciate your understanding!</p>
                    <h2 class="text-xl font-semibold sm:text-2xl">Your order is confirmed</h2>
                <?php
                }
                ?>
                <div>
                    <h3 class="mt-7 text-xl font-medium">Hi <?php echo isset($_COOKIE['user_id']) ? $user_name : 'Username'; ?>!</h3>
                    <?php
                    if ($time4Formatted <= $currentTime) {
                    ?>
                        <span>Your order is delivered</span>
                    <?php
                    } else {
                    ?>
                        <span>Your order has been confirmed and will be delivered soon.</span>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="mt-10">
                <?php
                if (isset($_COOKIE['user_id']) && isset($_GET['order_id'])) {
                ?>
                    <a href="../user/re-order.php?product_id=<?php echo urlencode($products_id); ?>&color=<?php echo $product_color; ?>&size=<?php echo $product_size; ?>&qty=<?php echo $product_qty; ?>&MRP=<?php echo $product_MRP ?>&travelTime=<?php echo $travelTime ?>" class="bg-gray-600 text-white font-semibold py-2.5 px-6 rounded-tl-xl rounded-br-xl hover:bg-gray-700 transition cursor-pointer">Re-Order</a>
                <?php

                    $_SESSION['reOrderId'] = $products_id;
                    $_SESSION['reOrderColor'] = $product_color;
                    $_SESSION['reOrderSize'] = $product_size;
                    $_SESSION['reOrderQty'] = $product_qty;
                    $_SESSION['reOrderMRP'] = $product_MRP;
                    $_SESSION['reOrderTravelTime'] = $travelTime;
                } else {
                ?>
                    <h1 class="bg-gray-600 text-white font-semibold py-2.5 px-6 w-max rounded-tl-xl rounded-br-xl cursor-not-allowed">Re-Order</h1>
                <?php
                }
                ?>
            </div>
            <hr class="my-10">
            <div>
                <h3 class="text-xl font-medium sm:text-2xl">Order ID: #<?php echo isset($_COOKIE['user_id']) ? $res['order_id'] : 'product ID' ?></h3>
                <div class="grid grid-cols-1 mt-12 gap-7 w-full md:grid-cols-2 lg:grid-cols-4 lg:gap-x-12">
                    <div>
                        <h4 class="font-semibold mb-2">Full name</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['user_first_name'] . ' ' . $res['user_last_name'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">User email</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['user_email'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">User mobile</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['user_mobile'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Devliery address</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['user_address'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">State</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['user_state'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">City</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['user_city'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Order date</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['date'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Payment information</h4>
                        <p class="text-gray-600"><?php echo isset($_COOKIE['user_id']) ? $res['payment_type'] : '-' ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 shadow-lg rounded-lg overflow-hidden w-full flex flex-col min-[580px]:flex-row md:items-center mt-10 px-4">
                <div class=" flex justify-center items-center">
                    <img class="w-52 md:w-40 mix-blend-multiply" src="<?php echo isset($_COOKIE['user_id']) ? '../src/product_image/product_profile/' . $res['order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="Product Image">
                </div>
                <div class="p-6 flex-1">
                    <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2"><?php echo isset($_COOKIE['user_id']) ? $res['order_title'] : 'Product Title' ?></h2>
                    <p class="font-medium text-base leading-7 text-black pr-4">Quantity: <span class="font-medium"><?php echo isset($_COOKIE['user_id']) ? $res['qty'] : '-' ?></span></p>
                    <p class="font-medium text-base leading-7 text-black pr-4">Price: <span class="font-bold text-green-500">₹<?php echo isset($_COOKIE['user_id']) ? $res['total_price'] : '-' ?></span></p>
                    <div class="text-gray-700 flex items-center gap-1 mt-1">
                        <span class="font-medium text-base leading-7 text-black">Color:</span>
                        <h1 class="my-auto"><?php echo isset($_COOKIE['user_id']) ? htmlspecialchars($product_color) : '-' ?></h1>
                    </div>
                    <p class="font-medium text-base leading-7 text-black pr-4">Size: <span class="font-medium"><?php echo isset($_COOKIE['user_id']) ? $res['order_size'] : '-' ?></span></p>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mt-12">
            <div>
                <?php
                if ($time4Formatted <= $currentTime) {
                ?>
                    <h2 class="font-semibold text-2xl mb-4">Your order is delivered</h2>
                <?php
                } else {
                ?>
                    <h2 class="font-semibold text-2xl mb-4">Shipped on: <span class="text-gray-500"><?php echo isset($time4Formatted) ? $shipedTime : 'Shipping Date'; ?></span></h2>
                <?php
                }
                ?>
            </div>
            <div class="mt-6 grow sm:mt-8 lg:mt-0">
                <div class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900">Order traking</h3>

                    <?php
                    if (isset($_COOKIE['user_id'])) {
                    ?>
                        <ol class="relative ms-3 border-s border-gray-200 ">
                            <li class="mb-10 ms-6 <?php echo $time4Formatted <= $currentTime ? htmlspecialchars('text-indigo-700') : htmlspecialchars('text-gray-700') ?> flex item-center space-x-2">
                                <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $time4Formatted <= $currentTime ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> bg-gray-100 ring-8 ring-white">
                                    <i class="<?php echo $time4Formatted <= $currentTime ? htmlspecialchars('fa-solid fa-circle-check text-indigo-600') : htmlspecialchars('fa-solid fa-truck text-gray-600') ?>"></i>
                                </span>
                                <div class="">
                                    <h4 class="font-semibold">Delivered</h4>
                                    <p class="text-sm font-normal">Your product has been successfully delivered!</p>
                                </div>
                            </li>

                            <li class="mb-10 ms-6 <?php echo $time3Formatted <= $currentTime ? htmlspecialchars('text-indigo-700') : htmlspecialchars('text-gray-700') ?> flex item-center space-x-2">
                                <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $time3Formatted <= $currentTime ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                    <i class="<?php echo $time3Formatted <= $currentTime ? htmlspecialchars('fa-solid fa-circle-check text-indigo-600') : htmlspecialchars('fa-solid fa-road text-gray-600') ?>"></i>
                                </span>
                                <div class="">
                                    <h4 class="font-semibold">On the Way</h4>
                                    <p class="text-sm font-normal">The delivery boy is on the way to deliver your product.</p>
                                </div>
                            </li>

                            <li class="mb-10 ms-6 <?php echo $time2Formatted <= $currentTime ? htmlspecialchars('text-indigo-700') : htmlspecialchars('text-gray-700') ?> flex item-center space-x-2">
                                <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $time2Formatted <= $currentTime ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                    <i class="<?php echo $time2Formatted <= $currentTime ? htmlspecialchars('fa-solid fa-circle-check text-indigo-600') : htmlspecialchars('fa-solid fa-boxes-packing text-gray-600') ?>"></i>
                                </span>
                                <div class="">
                                    <h4 class="font-semibold">Order Packed</h4>
                                    <p class="text-sm font-normal">The product is purchased and packed for delivery.</p>
                                </div>
                            </li>

                            <li class="mb-10 ms-6 <?php echo $time1Formatted <= $currentTime ? htmlspecialchars('text-indigo-700') : htmlspecialchars('text-gray-700') ?> flex item-center space-x-2">
                                <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $time1Formatted <= $currentTime ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                    <i class="<?php echo $time1Formatted <= $currentTime ? htmlspecialchars('fa-solid fa-circle-check text-indigo-600') : htmlspecialchars('fa-solid fa-box text-gray-600') ?>"></i>
                                </span>
                                <div class="">
                                    <h4 class="font-semibold text-indigo-600">Order Placed</h4>
                                    <p class="text-sm font-normal text-indigo-600">Your Order has been Placed</p>
                                </div>
                            </li>
                        </ol>
                    <?php
                    } else {
                    ?>
                        <h1 class="font-bold text-2xl">Error: No Product Found</h1>
                        <span class="text-gray-400 mt-2">It seems you haven't selected a product to track. Please go back and select a product to view its tracking information.</span>
                    <?php
                    }
                    ?>


                    <div class="flex flex-col items-center gap-4 gap-y-4 sm:flex-row">
                        <?php
                        if (isset($_COOKIE['user_id'])) {

                            if ($time2Formatted > $currentTime) {
                        ?>
                                <a href="cancel_order.php?order_id=<?php echo isset($_COOKIE['user_id']) ? $res['order_id'] : 'order_id' ?>" class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-red-600 px-5 py-2.5 text-sm font-medium text-white">Cancel the order</a>
                                <h1 class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white opacity-50 select-none cursor-not-allowed">Return Order</h1>
                            <?php
                            } elseif ($time4Formatted < $currentTime) {
                            ?>
                                <a href="return_order.php?order_id=<?php echo isset($_COOKIE['user_id']) ? $res['order_id'] : 'order_id' ?>" class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">Return Order</a>
                                <h1 class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-red-600 px-5 py-2.5 text-sm font-medium text-white opacity-20 cursor-not-allowed">Cancel the order</h1>
                            <?php
                            }
                            ?>
                            <a href="../product/invoice.php?order_id=<?php echo isset($_COOKIE['user_id']) ? $res['order_id'] : 'order_id' ?>" class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white">Invoice</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- footer -->
    <?php
    include "../pages/_footer.php";
    ?>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>