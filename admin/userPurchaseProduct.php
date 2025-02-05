<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: /shopnest/index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}

if (!isset($_GET['user_id'])) {
    header("Location: view_users.php");
    exit;
}
?>

<?php
include "../include/connect.php";

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
    <title>Purchase Product By User</title>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <div class="flex h-screen bg-gray-200">

            <div class="flex flex-col flex-1 overflow-hidden">

                <div class="w-full flex items-center py-4 px-4 border-b-[2.5px] border-gray-700 shadow-md shadow-gray-500">
                    <a href="view_users.php" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-7 md:w-10">
                            <g>
                                <path fill="#000000" fill-rule="evenodd" d="M15 4a1 1 0 1 1 1.414 1.414l-5.879 5.879a1 1 0 0 0 0 1.414l5.88 5.879A1 1 0 0 1 15 20l-7.293-7.293a1 1 0 0 1 0-1.414z" clip-rule="evenodd" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </a>
                    <h2 class="font-manrope font-bold text-xl md:text-4xl leading-10 text-black w-full text-center">Purchase Product By Users</h2>
                </div>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <section class="container mx-auto p-6">
                        <h2 class="font-manrope font-bold text-4xl leading-10 text-black mb-5">Place Orders</h2>
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg" id="place">
                            <div class="w-full overflow-x-auto h-max text-center bg-white">
                                <?php
                                $user_id = $_GET['user_id'];
                                $get_orders = "SELECT * FROM orders WHERE user_id = '$user_id'";
                                $get_orders_query = mysqli_query($con, $get_orders);
                                if (mysqli_num_rows($get_orders_query) > 0) {
                                ?>
                                    <table class="w-full">
                                        <thead>
                                            <tr class="text-md font-semibold tracking-wide text-center text-gray-900 bg-gray-100 border-b border-gray-600">
                                                <th class="px-4 py-3">Order&nbsp;ID</th>
                                                <th class="px-4 py-3 w-96">Order&nbsp;Name</th>
                                                <th class="px-4 py-3 w-96">Order&nbsp;Image</th>
                                                <th class="px-4 py-3">Order&nbsp;Price</th>
                                                <th class="px-4 py-3">Order&nbsp;Color</th>
                                                <th class="px-4 py-3">Order&nbsp;Size</th>
                                                <th class="px-4 py-3">Order&nbsp;QTY</th>
                                                <th class="px-4 py-3">User&nbsp;Name</th>
                                                <th class="px-4 py-3">User&nbsp;Email</th>
                                                <th class="px-4 py-3">User&nbsp;Mobile</th>
                                                <th class="px-4 py-3">User&nbsp;Address</th>
                                                <th class="px-4 py-3">User&nbsp;State</th>
                                                <th class="px-4 py-3">User&nbsp;City</th>
                                                <th class="px-4 py-3">User&nbsp;Pincode</th>
                                                <th class="px-4 py-3">Payment&nbsp;Type</th>
                                                <th class="px-4 py-3">Order&nbsp;Date</th>
                                            </tr>
                                        </thead>
                                        <?php
                                    }

                                    if (isset($_COOKIE['adminEmail'])) {
                                        $get_orders = "SELECT * FROM orders WHERE user_id = '$user_id'";
                                        $get_orders_query = mysqli_query($con, $get_orders);
                                        if (mysqli_num_rows($get_orders_query) > 0) {

                                            while ($items = mysqli_fetch_assoc($get_orders_query)) {
                                        ?>
                                                <tbody class="bg-white border">
                                                    <tr class="text-gray-700">
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['order_id'] : 'order_id' ?></td>
                                                        <td class="px-4 py-3 leading-9 line-clamp-3"><?php echo isset($_COOKIE['adminEmail']) ? $items['order_title'] : 'order_title' ?></td>
                                                        <td class="px-3 py-2 border w-96"><img src="<?php echo isset($_COOKIE['adminEmail']) ? '../src/product_image/product_profile/' . $items['order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="" class="w-full h-full object-contain m-auto"></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['total_price'] : 'total_price' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['order_color'] : 'order_color' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['order_size'] : 'order_size' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['qty'] : 'qty' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_first_name'] . ' ' . $items['user_last_name'] : 'user name' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_email'] : 'user_email' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_mobile'] : 'user_mobile' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_address'] : 'user_address' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_state'] : 'user_state' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_city'] : 'user_city' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['user_pin'] : 'user_pin' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['payment_type'] : 'payment_type' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $items['date'] : 'date' ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="font-bold text-xl md:text-2xl w-max m-auto py-4">No data available for this period.</div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </table>
                            </div>
                        </div>
                    </section>

                    <!-- cancle orders -->
                    <section class="container mx-auto p-6">
                        <h2 class="font-manrope font-bold text-4xl leading-10 text-black mb-5">Cancel Orders</h2>
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg" id="place">
                            <div class="w-full overflow-x-auto h-max text-center bg-white">
                                <?php
                                $get_cancle_orders = "SELECT * FROM cancel_orders WHERE user_id = '$user_id'";
                                $get_cancle_orders_query = mysqli_query($con, $get_cancle_orders);

                                if (mysqli_num_rows($get_cancle_orders_query) > 0) {
                                ?>
                                    <table class="w-full">
                                        <thead>
                                            <tr class="text-md font-semibold tracking-wide text-center text-gray-900 bg-gray-100 border-b border-gray-600">
                                                <th class="px-4 py-3">Cancel&nbsp;Order&nbsp;ID</th>
                                                <th class="px-4 py-3">Cancel&nbsp;Order&nbsp;Title</th>
                                                <th class="px-4 py-3 w-96">Cancel&nbsp;Order&nbsp;Image</th>
                                                <th class="px-4 py-3">Cancel&nbsp;Order&nbsp;price</th>
                                                <th class="px-4 py-3">Cancel&nbsp;Order&nbsp;Color</th>
                                                <th class="px-4 py-3">Cancel&nbsp;Order&nbsp;Size </th>
                                                <th class="px-4 py-3">user&nbsp;Name</th>
                                                <th class="px-4 py-3">user&nbsp;Email</th>
                                                <th class="px-4 py-3">user&nbsp;Phone</th>
                                                <th class="px-4 py-3">receive&nbsp;Payment</th>
                                                <th class="px-4 py-3">Reason</th>
                                                <th class="px-4 py-3">Cancel&nbsp;Order&nbsp;date</th>
                                            </tr>
                                        </thead>
                                        <?php
                                    }

                                    if (isset($_COOKIE['adminEmail'])) {
                                        $get_cancle_orders = "SELECT * FROM cancel_orders WHERE user_id = '$user_id'";
                                        $get_cancle_orders_query = mysqli_query($con, $get_cancle_orders);
                                        if (mysqli_num_rows($get_cancle_orders_query) > 0) {

                                            while ($co = mysqli_fetch_assoc($get_cancle_orders_query)) {
                                        ?>
                                                <tbody class="bg-white border">
                                                    <tr class="text-gray-700">
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['cancel_order_id'] : 'cancel_order_id' ?></td>
                                                        <td class="px-4 py-3 leading-9 line-clamp-3"><?php echo isset($_COOKIE['adminEmail']) ? $co['cancle_order_title'] : 'cancle_order_title' ?></td>
                                                        <td class="px-3 py-2 border"><img src="<?php echo isset($_COOKIE['adminEmail']) ? '../src/product_image/product_profile/' . $co['cancle_order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="" class="w-28 h-full object-contain m-auto"></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['cancle_order_price'] : 'cancle_order_price' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['cancle_order_color'] : 'cancle_order_color' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['cancle_order_size'] : 'cancle_order_size' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['user_name'] : 'user_name' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['user_email'] : 'user_email' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['user_phone'] : 'user_phone' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['receive_payment'] : 'receive_payment' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['reason'] : 'reason' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $co['date'] : 'date' ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="font-bold text-xl md:text-2xl w-max m-auto py-4">No data available for this period.</div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </table>
                            </div>
                        </div>
                    </section>

                    <!-- return orders -->
                    <section class="container mx-auto p-6">
                        <h2 class="font-manrope font-bold text-4xl leading-10 text-black mb-5">Return Orders</h2>
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto h-max text-center bg-white">
                                <?php
                                $get_return_orders = "SELECT * FROM return_orders WHERE user_id = '$user_id'";
                                $get_return_orders_query = mysqli_query($con, $get_return_orders);

                                if (mysqli_num_rows($get_return_orders_query) > 0) {
                                ?>
                                    <table class="w-full">
                                        <thead>
                                            <tr class="text-md font-semibold tracking-wide text-center text-gray-900 bg-gray-100 border-b border-gray-600">
                                                <th class="px-4 py-3">Return&nbsp;order&nbsp;ID</th>
                                                <th class="px-4 py-3 w-96">Return&nbsp;order&nbsp;Title</th>
                                                <th class="px-4 py-3">Return&nbsp;Order&nbsp;Image</th>
                                                <th class="px-4 py-3">Return&nbsp;Order&nbsp;Price</th>
                                                <th class="px-4 py-3">Return&nbsp;Order&nbsp;Color</th>
                                                <th class="px-4 py-3">Return&nbsp;Order&nbsp;Size</th>
                                                <th class="px-4 py-3">User&nbsp;Name</th>
                                                <th class="px-4 py-3">User&nbsp;Email</th>
                                                <th class="px-4 py-3">User&nbsp;Phone</th>
                                                <th class="px-4 py-3">Payment&nbsp;Type</th>
                                                <th class="px-4 py-3">Return&nbsp;Order&nbsp;Date</th>
                                            </tr>
                                        </thead>
                                        <?php
                                    }
                                    if (isset($_COOKIE['adminEmail'])) {
                                        $get_return_orders = "SELECT * FROM return_orders WHERE user_id = '$user_id'";
                                        $get_return_orders_query = mysqli_query($con, $get_return_orders);

                                        if (mysqli_num_rows($get_return_orders_query) > 0) {
                                            while ($ro = mysqli_fetch_assoc($get_return_orders_query)) {
                                        ?>
                                                <tbody class="bg-white border">
                                                    <tr class="text-gray-700">
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['return_order_id'] : 'return_order_id' ?></td>
                                                        <td class="px-4 py-3 leading-9 line-clamp-3"><?php echo isset($_COOKIE['adminEmail']) ? $ro['return_order_title'] : 'return_order_title' ?></td>
                                                        <td class="px-3 py-2 border"><img src="<?php echo isset($_COOKIE['adminEmail']) ? '../src/product_image/product_profile/' . $ro['return_order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="" class="w-28 h-full object-contain m-auto"></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['return_order_price'] : 'return_order_price' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['return_order_color'] : 'return_order_color' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['return_order_size'] : 'return_order_size' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['user_name'] : 'user_name' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['user_email'] : 'user_email' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['user_phone'] : 'user_phone' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['payment_type'] : 'payment_type' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['adminEmail']) ? $ro['date'] : 'date' ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="font-bold text-xl md:text-2xl w-max m-auto py-4">No data available for this period.</div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </table>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>