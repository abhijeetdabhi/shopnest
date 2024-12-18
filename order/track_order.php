<?php

    if(!isset($_GET['order_id']) || !isset($_COOKIE['user_id'])){
        header("Location: /index.php");
        exit;
    }

    if(isset($_COOKIE['vendor_id'])){
        header("Location: /vendor/vendor_dashboard.php");
        exit;
    }

    if(isset($_COOKIE['adminEmail'])){
        header("Location: /admin/dashboard.php");
        exit;
    }
?>


<?php
include "../include/connect.php";

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
    $todays = date('Y-m-d');

    $today = date('Y-m-d', strtotime($res['date']));
    $future_date = date('Y-m-d', strtotime('+5 days', strtotime($today)));

    $toDay = date('Y-m-d', strtotime('+0 days', strtotime($today)));
    $oneday = date('Y-m-d', strtotime('+1 days', strtotime($today)));
    $secondday = date('Y-m-d', strtotime('+2 days', strtotime($today)));
    $thirdday = date('Y-m-d', strtotime('+3 days', strtotime($today)));
    $fourday = date('Y-m-d', strtotime('+4 days', strtotime($today)));
    $fifth = date('Y-m-d', strtotime('+5 days', strtotime($today)));

    $return_date = date('Y-m-d', strtotime('+7 days', strtotime($future_date)));
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
                if (isset($future_date) && isset($todays) && $future_date < $todays) {
                ?>
                    <h2 class="text-xl font-semibold sm:text-2xl">Your order is delivered</h2>
                <?php
                } else {
                ?>
                    <h2 class="text-xl font-semibold sm:text-2xl">Your order is confirmed</h2>
                <?php
                }
                ?>
                <div>
                    <h3 class="mt-7 text-xl font-medium">Hi <?php echo isset($_COOKIE['user_id']) ? $user_name : 'Username'; ?>!</h3>
                    <?php
                    if (isset($future_date) && isset($todays) &&  $future_date < $todays) {
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
                    if(isset($_COOKIE['user_id']) && isset($_GET['order_id'])){
                        ?>
                            <a href="../user/re-order.php?product_id=<?php echo urlencode($products_id); ?>&color=<?php echo $product_color; ?>&size=<?php echo $product_size; ?>&qty=<?php echo $product_qty; ?>&MRP=<?php echo $product_MRP ?>" class="bg-gray-600 text-white font-semibold py-2.5 px-6 rounded-tl-xl rounded-br-xl hover:bg-gray-700 transition cursor-pointer">Re-Order</a>
                        <?php
                    }else{
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
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['user_first_name'] . ' ' . $res['user_last_name'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">User email</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['user_email'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">User mobile</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['user_mobile'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Devliery address</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['user_address'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">State</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['user_state'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">City</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['user_city'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Order date</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['date'] : '-' ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Payment information</h4>
                        <p><?php echo isset($_COOKIE['user_id']) ? $res['payment_type'] : '-' ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white border-2 rounded-lg overflow-hidden w-full flex flex-col md:flex-row mt-10">
                <!-- Product Image -->
                <img class="h-full md:h-40 object-cover" src="<?php echo isset($_COOKIE['user_id']) ? '../src/product_image/product_profile/' . $res['order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="Product Image">

                <!-- Product Details -->
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
                    if(isset($future_date) && isset($todays) && $future_date < $todays){
                        ?>
                            <h2 class="font-semibold text-2xl mb-4">Your order is delivered</h2>
                        <?php
                    }else{
                        ?>
                            <h2 class="font-semibold text-2xl mb-4">Shipped on: <span class="text-gray-500"><?php echo isset($future_date) ? date('d-m-Y', strtotime($future_date)) : 'Shipping Date'; ?></span></h2>
                        <?php
                    }
                ?>
            </div>
            <div class="mt-6 grow sm:mt-8 lg:mt-0">
                <div class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900">Order traking</h3>

                    <?php
                        if(isset($_COOKIE['user_id'])){
                            ?>
                                <ol class="relative ms-3 border-s border-gray-200 ">
                                    <li class="mb-10 ms-6">
                                        <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $fifth <= date('Y-m-d') ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                            <i class="<?php echo $fifth <= date('Y-m-d') ? htmlspecialchars('fa-solid fa-circle-check') . ' ' .  htmlspecialchars('text-indigo-600') : htmlspecialchars('fas fa-clipboard-check') . ' ' . htmlspecialchars('text-black') ?>"></i>
                                        </span>
                                        <div class="ml-2">
                                            <h4 class="mb-0.5 text-base font-semibold <?php echo $fifth <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-900') ?>"><?php echo isset($fifth) ? date('d-m-Y', strtotime($fifth)) : 'Delivery Date'?></h4>
                                            <p class="text-sm font-normal <?php echo isset($fifth) ? ($fifth <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-500')) : 'product Devlivery Date'?>">Products delivered</p>
                                        </div>
                                    </li>

                                    <li class="mb-10 ms-6">
                                        <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $fourday <= date('Y-m-d') ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                            <i class="<?php echo $fourday <= date('Y-m-d') ? htmlspecialchars('fa-solid fa-circle-check') . ' ' .  htmlspecialchars('text-indigo-600') : htmlspecialchars('fas fa-cube') . ' ' . htmlspecialchars('text-black') ?>"></i>
                                        </span>
                                        <div class="ml-2">
                                            <h4 class="mb-0.5 text-base font-semibold <?php echo $fourday <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-900') ?>"><?php echo isset($fourday) ? date('d-m-Y', strtotime($fourday)) : 'Products being delivered Date'?></h4>
                                            <p class="text-sm font-normal <?php echo $fourday <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-500')?>">Out For Delivery</p>
                                        </div>
                                    </li>

                                    <li class="mb-10 ms-6 text-blue-700">
                                        <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $thirdday <= date('Y-m-d') ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                            <i class="<?php echo $thirdday <= date('Y-m-d') ? htmlspecialchars('fa-solid fa-circle-check') . ' ' .  htmlspecialchars('text-indigo-600') : htmlspecialchars('fas fa-warehouse') . ' ' . htmlspecialchars('text-black') ?>"></i>
                                        </span>
                                        <div class="ml-2">
                                            <h4 class="mb-0.5 font-semibold <?php echo $thirdday <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-900') ?>"><?php echo isset($thirdday) ? date('d-m-Y', strtotime($thirdday)) : 'Products in the couriers warehouse Date'?></h4>
                                            <p class="text-sm font-normal <?php echo $thirdday <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-500')?>">Products in the courier's warehouse</p>
                                        </div>
                                    </li>

                                    <li class="mb-10 ms-6 text-blue-700">
                                        <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $secondday <= date('Y-m-d') ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                            <i class="<?php echo $secondday <= date('Y-m-d') ? htmlspecialchars('fa-solid fa-circle-check') . ' ' .  htmlspecialchars('text-indigo-600') : htmlspecialchars('fas fa-truck') . ' ' . htmlspecialchars('text-black') ?>"></i>
                                        </span>
                                        <div class="ml-2">
                                            <h4 class="mb-0.5 text-base font-semibold <?php echo $secondday <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-900') ?>"><?php echo isset($secondday) ? date('d-m-Y', strtotime($secondday)) : 'Products delivered to the courier Date'?></h4>
                                            <p class="text-sm font-normal <?php echo $secondday <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-500')?>">Products delivered to the courier</p>
                                        </div>
                                    </li>

                                    <li class="mb-10 ms-6 text-blue-700">
                                        <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                            <i class="<?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('fa-solid fa-circle-check') . ' ' .  htmlspecialchars('text-indigo-600') : htmlspecialchars('fas fa-credit-card') . ' ' . htmlspecialchars('text-black') ?>"></i>
                                        </span>
                                        <div class="ml-2">
                                            <h4 class="mb-0.5 font-semibold <?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-900') ?>"><?php echo isset($toDay) ? date('d-m-Y', strtotime($toDay)) : 'Payment accepted Date'?></h4>
                                            <p class="text-sm font-normal <?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-500')?>">Payment accepted - <?php echo isset($_COOKIE['user_id']) ? $res['payment_type'] : 'payment_type' ?></p>
                                        </div>
                                    </li>
                                    

                                    <li class="ms-6">
                                        <span class="absolute -start-4 flex h-8 w-8 items-center justify-center rounded-full <?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('bg-indigo-100') : htmlspecialchars('bg-gray-100') ?> ring-8 ring-white">
                                            <i class="<?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('fa-solid fa-circle-check') . ' ' .  htmlspecialchars('text-indigo-600') : htmlspecialchars('fas fa-cart-plus') . ' ' . htmlspecialchars('text-black') ?>"></i>
                                        </span>
                                        <div class="ml-2">
                                            <h4 class="mb-0.5 font-semibold <?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-900') ?>"><?php echo isset($toDay) ? date('d-m-Y', strtotime($toDay)) : 'Order placed Date'?></h4>
                                            <p class="text-sm font-normal <?php echo $toDay <= date('Y-m-d') ? htmlspecialchars('text-indigo-600') : htmlspecialchars('text-gray-500')?>">Order placed - Receipt #<?php echo isset($res['order_id']) ? $res['order_id'] : '' ?></p>
                                        </div>
                                    </li>
                                </ol>
                            <?php
                        }else{
                            ?>
                                <h1 class="font-bold text-2xl">Error: No Product Found</h1>
                                <span class="text-gray-400 mt-2">It seems you haven't selected a product to track. Please go back and select a product to view its tracking information.</span>
                            <?php
                        }
                    ?>


                    <div class="flex flex-col items-center gap-4 gap-y-4 sm:flex-row">
                        <?php
                            if(isset($_COOKIE['user_id'])){
                                $todays_dates = date('Y-m-d', strtotime('today'));

                                $today_date = DateTime::createFromFormat('Y-m-d', $todays_dates);
                                $fifth_date = DateTime::createFromFormat('Y-m-d', $fifth);
                                $product_return_date = DateTime::createFromFormat('Y-m-d', $return_date);

                                if ($today_date < $fifth_date) {
                                    ?>
                                        <a href="cancel_order.php?order_id=<?php echo isset($_COOKIE['user_id']) ? $res['order_id'] : 'order_id' ?>" class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-red-600 px-5 py-2.5 text-sm font-medium text-white">Cancel the order</a>
                                        <h1 class="w-full flex items-center justify-center rounded-tl-xl rounded-br-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white opacity-50 select-none cursor-not-allowed">Return Order</h1>
                                    <?php
                                } elseif ($today_date < $product_return_date) {
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