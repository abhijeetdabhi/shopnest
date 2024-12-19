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
    $order_id = $_GET['order_id'];

    $retrieve_order = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $retrieve_order_query = mysqli_query($con, $retrieve_order);

    $res = mysqli_fetch_assoc($retrieve_order_query);

    $user_id = $_COOKIE['user_id'];
    $vendor_id = $res['vendor_id'];
    $product_id  = $res['product_id'];

    $user_info = "SELECT * FROM user_registration WHERE user_id = '$user_id'";
    $user_info_query = mysqli_query($con, $user_info);

    $row = mysqli_fetch_assoc($user_info_query);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

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

    <!-- title -->
    <title>Return Order</title>
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
                    <img class="object-cover w-full h-full" src="<?php echo isset($_COOKIE['user_id']) ? '/src/user_dp/' . $row['profile_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png'; ?>" alt="Your avatar">
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
    

    <div class="max-w-screen-lg m-auto px-4 py-12">
        <div class="grid grid-col-1 gap-y-4">
            <h2 class="font-bold text-2xl text-black">Return Order</h2>
            <div class="flex flex-col items-center gap-5 md:flex-row">
                <div>
                    <img class="w-full h-32 object-contain" src="<?php echo isset($_COOKIE['user_id']) ? '../src/product_image/product_profile/' . $res['order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="">
                </div>
                <div>
                    <h2 class="text-xl font-semibold mb-7 line-clamp-2"><?php echo isset($_COOKIE['user_id']) ? $res['order_title'] : 'product title' ?></h2>
                    <div>
                        <div class="flex items-center">
                            <p class="font-medium text-base leading-7 text-black pr-4 mr-4 border-r border-gray-200"> Qty: <span class="text-gray-500"><?php echo isset($_COOKIE['user_id']) ? $res['qty'] : 'qty' ?></span></p> 
                            <p class="font-medium text-base leading-7 text-black">Price: <span class="text-gray-500">₹<?php echo isset($_COOKIE['user_id']) ? $res['total_price'] : 'total_price' ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-5">
        <form action="" id="returnForm" method="post">
            <div>
                <div class="headline">
                    <p class="cursor-default font-semibold text-2xl">Billing Email</p>
                    <input class="w-full h-12 border-2 border-[#cccccc] rounded-md focus:border-black focus:ring-0 mt-2" type="email" id="billingEmail" name="billingEmail" value="<?php echo isset($_COOKIE['user_id']) ? $res['user_email'] : 'user_email' ?>" required>
                </div>
                <hr class="my-6">
                <div>
                    <p class="cursor-default font-semibold text-2xl">Receive Payment Via?</p>
                    <div class="flex flex-col gap-2 px-3 mt-3">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="Preceive" id="type_1" value="UPI" class="text-gray-600 focus:ring-gray-600">
                            <label for="type_1">
                                <p>COD</p>
                            </label>
                        </div>
                    </div>
                </div>
                <hr class="my-6">
                <div class="review">
                    <p class="cursor-default font-semibold text-2xl">Why are you Retrun the order?</p>
                    <div class="flex flex-col gap-2 px-3 mt-3">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_1" value="Received Incorrect Item (Does Not Match Description or Order Specifications)" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_1">
                                <p>Received Incorrect Item (Does Not Match Description or Order Specifications)</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_2" value="Product Arrived Defective (Functional Problems or Faults)" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_2">
                                <p>Product Arrived Defective (Functional Problems or Faults)</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_3" value="Return Due to Change in Preferences or Priorities" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_3">
                                <p>Return Due to Change in Preferences or Priorities</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_4" value="Quality Issues (Poor Construction, Subpar Materials, or Below-Expected Performance)" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_4">
                                <p>Quality Issues (Poor Construction, Subpar Materials, or Below-Expected Performance)</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_5" value="Wrong Size or Fit (Does Not Meet Expected Measurements or Specifications)" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_5">
                                <p>Wrong Size or Fit (Does Not Meet Expected Measurements or Specifications)</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_6" value="Inaccurate or Misleading Product Description" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_6">
                                <p>Inaccurate or Misleading Product Description</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_7" value="Multiple Orders of the Same Item by Mistake (Duplicates Received)" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_7">
                                <p>Multiple Orders of the Same Item by Mistake (Duplicates Received)</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_8" value="Shipping Problems (Delays, Missing Packages, or Delivery Issues)" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_8">
                                <p>Shipping Problems (Delays, Missing Packages, or Delivery Issues)</p>
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="radio" name="OrderReturn" id="Return_9" value="Found Better Price After Purchase" class="text-gray-600 focus:ring-gray-600">
                            <label for="Return_9">
                                <p>Found Better Price After Purchase</p>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="submit mt-6">
                    <button id="ReturnProduct" type="submit" class="rounded-tl-xl rounded-br-xl text-center bg-gray-600 py-3 px-6 text-white transition duration-300 group-invalid:pointer-events-none group-invalid:opacity-30 cursor-pointer hover:bg-gray-800">Return Order</button>
                </div>
            </div>
        </form>
    </div>

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
        <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-gray-700 rounded-full">
            <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-gray-900 rounded-full"></div>
        </div>
    </div>

    <script>
        function loader() {
            let loader = document.getElementById('loader');
            let body = document.body;

            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
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

            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = "../user/show_return_order.php";
            }, 2000);
        }
    </script>
    
    <script>
        $(document).ready(function () {
            $('#returnForm').on('submit', function(e){
                e.preventDefault();

                let billingEmail = $('#billingEmail').val().trim()
                            
                let Preceive = $('input[name="Preceive"]:checked').val();
                let OrderReturn = $('input[name="OrderReturn"]:checked').val();


                if (!billingEmail) {
                    displayErrorMessage('Please Enter Your Billing Email.')
                    return;
                }else if (!Preceive) {
                    displayErrorMessage('Please Select Receive Payment Method.')
                    return;
                }else if (!OrderReturn) {
                    displayErrorMessage('Please Select Why are you Retrun the order?')
                    return;
                }

                $.ajax({
                    url: "",
                    type: "POST",
                    data: {
                        order_id: "<?php echo $order_id?>",
                        product_id: "<?php echo $product_id?>",
                        user_id: "<?php echo $user_id?>",
                        vendor_id: "<?php echo $vendor_id?>",

                        billingEmail: billingEmail,
                        Preceive: Preceive,
                        OrderReturn: OrderReturn,
                        
                        user_name: "<?php echo $res['user_first_name']?>",
                        user_phone: "<?php echo $res['user_mobile']?>",

                        return_order_title: "<?php echo $res['order_title']?>",
                        return_order_image: "<?php echo $res['order_image']?>",
                        return_order_price: "<?php echo $res['total_price']?>",
                        return_order_qty: "<?php echo $res['qty']?>",
                        return_order_color: "<?php echo $res['order_color']?>",
                        return_order_size: "<?php echo $res['order_size']?>",
                    },
                    success: function (response) {
                        loader();
                        $('input[name="Preceive"]:checked').prop('checked', false);
                        $('input[name="OrderReturn"]:checked').prop('checked', false);
                        displaySuccessMessage("Your order has been successfully Return.")
                    }
                });
            });
        });
        
    </script>
            

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>
</html>

<?php 

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $order_id = $_POST['order_id'];
        $product_id  = $_POST['product_id'];
        $user_id = $_POST['user_id'];
        $vendor_id = $_POST['vendor_id'];
            
        $user_name = $_POST['user_name'];
        $user_phone = $_POST['user_phone'];

        $user_email = $_POST['billingEmail'];
        $receive_payment = $_POST['Preceive'];
        $reason = $_POST['OrderReturn'];
    
        $return_order_title = $_POST['return_order_title'];
        $return_order_image = $_POST['return_order_image'];
        $return_order_price = $_POST['return_order_price'];
        $return_order_qty = $_POST['return_order_qty'];
        $return_order_color = $_POST['return_order_color'];
        $return_order_size = $_POST['return_order_size'];
    
        $date = date('d-m-Y');

        $insert_return_order = "INSERT INTO return_orders(order_id, product_id, user_id, vendor_id, user_name, user_email, user_phone, return_order_image, return_order_title, return_order_price, return_order_color, return_order_size, return_order_qty, payment_type, reason, date) VALUES ('$order_id','$product_id','$user_id','$vendor_id','$user_name','$user_email','$user_phone','$return_order_image','$return_order_title','$return_order_price','$return_order_color','$return_order_size','$return_order_qty','$receive_payment','$reason','$date')";
        $return_order_query = mysqli_query($con, $insert_return_order);

        $delete_order = "DELETE FROM orders WHERE order_id = '$order_id'";
        $delete_query = mysqli_query($con, $delete_order);

        // insert quantity of items
        $get_qty = "SELECT * FROM products WHERE product_id = '$product_id'";
        $get_qty_query = mysqli_query($con, $get_qty);
        
        // Check if the query was successful
        if ($get_qty_query) {
            // Fetch the result
            $qty = mysqli_fetch_assoc($get_qty_query);
        
            // Check if the result is not null
            if ($qty) {
                $product_qty = (int)$qty['Quantity'];
                $qty_replace = (int)str_replace(",", "", $return_order_qty);
                $update_qty = number_format($product_qty + $qty_replace);
            }
        }
 
        $update_qty = "UPDATE products SET Quantity='$update_qty' WHERE product_id = '$product_id'";
        $update_qty_quary = mysqli_query($con, $update_qty);
    }

?>