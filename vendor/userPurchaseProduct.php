<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: /shopnest/index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /shopnest/admin/dashboard.php");
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
    <title>Purchase Product By User</title>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <div class="flex h-screen bg-gray-200">

            <div class="flex flex-col flex-1 overflow-hidden">

                <div class="w-full flex items-center py-4 px-4 border-b-[2.5px] border-gray-700 shadow-md shadow-gray-500">
                    <a href="productPurchasers.php" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-7 md:w-10">
                            <g>
                                <path fill="#000000" fill-rule="evenodd" d="M15 4a1 1 0 1 1 1.414 1.414l-5.879 5.879a1 1 0 0 0 0 1.414l5.88 5.879A1 1 0 0 1 15 20l-7.293-7.293a1 1 0 0 1 0-1.414z" clip-rule="evenodd" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </a>
                    <h2 class="font-manrope font-bold text-xl md:text-4xl leading-10 text-black w-full text-center">Purchase Product By Users</h2>
                </div>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 mt-3">
                    <!-- place orders -->
                    <section class="container mx-auto p-6">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg" id="place">
                            <div class="w-full overflow-x-auto h-max text-center">
                                <?php
                                $get_orders = "SELECT * FROM orders WHERE vendor_id = '$vendor_id'";
                                $get_orders_query = mysqli_query($con, $get_orders);
                                if (mysqli_num_rows($get_orders_query) > 0) {
                                ?>
                                    <table class="w-full">
                                        <thead>
                                            <tr class="text-md font-semibold tracking-wide text-center text-gray-900 bg-gray-100 border-b border-gray-600">
                                                <th class="px-4 py-3">No.</th>
                                                <th class="px-4 py-3">User&nbsp;Name</th>
                                                <th class="px-4 py-3">User&nbsp;Email</th>
                                                <th class="px-4 py-3">User&nbsp;Mobile</th>
                                                <th class="px-4 py-3">User&nbsp;Address</th>
                                                <th class="px-4 py-3">User&nbsp;State</th>
                                                <th class="px-4 py-3">User&nbsp;City</th>
                                                <th class="px-4 py-3">Total&nbsp;Orders</th>
                                                <th class="px-4 py-3">Total&nbsp;Cancle&nbsp;Orders</th>
                                                <th class="px-4 py-3">Total Return&nbsp;Orders</th>
                                            </tr>
                                        </thead>
                                        <?php
                                    }

                                    if (isset($_COOKIE['vendor_id'])) {
                                        $get_orders = "SELECT * FROM orders WHERE vendor_id = '$vendor_id'";
                                        $get_orders_query = mysqli_query($con, $get_orders);
                                        if (mysqli_num_rows($get_orders_query) > 0) {
                                            $i = 1;
                                            while ($items = mysqli_fetch_assoc($get_orders_query)) {
                                            
                                            $user_id = $items['user_id'];

                                            // count orders
                                            $getOrders = "SELECT * FROM orders WHERE user_id = $user_id";
                                            $getOrdersQuery = mysqli_query($con, $getOrders);
                                            $totalOrders = mysqli_num_rows($getOrdersQuery);

                                            // count cancel Orders
                                            $getCancelOrders = "SELECT * FROM cancel_orders WHERE user_id = $user_id";
                                            $CancelOrderQuery = mysqli_query($con, $getCancelOrders);
                                            $totalCancelOrders = mysqli_num_rows($CancelOrderQuery);

                                            // count return Orders
                                            $getReturnOrders = "SELECT * FROM return_orders WHERE user_id = $user_id";
                                            $ReturnOrderQuery = mysqli_query($con, $getReturnOrders);
                                            $totalReturnOrders = mysqli_num_rows($ReturnOrderQuery);
                                        ?>
                                                <tbody class="bg-white border">
                                                    <tr class="text-gray-700">
                                                        <td class="px-4 py-3 border"><?php echo $i ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['vendor_id']) ? $items['user_first_name'] . ' ' . $items['user_last_name'] : 'user name' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['vendor_id']) ? $items['user_email'] : 'user_email' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['vendor_id']) ? $items['user_mobile'] : 'user_mobile' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['vendor_id']) ? $items['user_address'] : 'user_address' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['vendor_id']) ? $items['user_state'] : 'user_state' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo isset($_COOKIE['vendor_id']) ? $items['user_city'] : 'user_city' ?></td>
                                                        <td class="px-4 py-3 border"><?php echo $totalOrders?></td>
                                                        <td class="px-4 py-3 border"><?php echo $totalCancelOrders?></td>
                                                        <td class="px-4 py-3 border"><?php echo $totalReturnOrders?></td>
                                                    </tr>
                                                </tbody>

                                            <?php
                                            $i++;
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