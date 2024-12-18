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

session_start();

if (isset($_SESSION['searchWord'])) {
    unset($_SESSION['searchWord']);
}

if (isset($_SESSION['selectedSize'])) {
    unset($_SESSION['selectedSize']);
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

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Track Order</title>

    <style>
        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
        }
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
    include "_navbar.php";
    ?>


    <!-- track order -->
    <div class="flex flex-col items-center justify-center px-3 py-8 m-auto w-[100%] md:px-8 lg:w-[70%] xl:w-[55%]">
        <div class="header text-center mt-8 flex flex-col gap-2">
            <h1 class="text-3xl font-bold md:text-5xl">Track your order</h1>
            <p class="text-base font-normal m-auto">To track your order please enter "Order ID" and "Billing email" in the box below and press the "Track order" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
        </div>
        <form action="" method="post" class="flex flex-col gap-8 border mt-8 p-8 w-full lg:p-12">
            <div class="order_id">
                <label for="order_id" class="require">Order ID:</label>
                <div class="relative">
                    <input type="number" name="order_id" id="order_id" class="w-full h-14 border rounded-md mt-1 px-4 pl-12 focus:border-gray-500 focus:ring-2 focus:ring-gray-500" value="" placeholder="Enter Your Order ID" />
                    <div class="absolute left-0 rounded-l top-1 w-10 h-14 bg-white border border-gray-500 m-auto text-center flex items-center justify-center">#</div>
                </div>
            </div>
            <div class="billing_email">
                <label for="belling_email" class="require">Billing email:</label>
                <input name="billing_email" id="belling_email" class="w-[100%] h-14 border rounded-md mt-2 focus:border-gray-500 focus:ring-2 focus:ring-gray-500" type="email" placeholder="Email you see during checkout.">
            </div>
            <input name="track_order" type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold h-14 text-center rounded-tl-xl rounded-br-xl cursor-pointer" value="Track order">
        </form>


        <?php
        include "../include/connect.php";
        if (isset($_POST['track_order'])) {
            $order_id = $_POST['order_id'];
            $billing_email = $_POST['billing_email'];

            $find_id = "SELECT * FROM orders WHERE order_id = '$order_id' AND user_email = '$billing_email'";
            $find_query = mysqli_query($con, $find_id);

            if (mysqli_num_rows($find_query) > 0) {
        ?>
                <script>
                    window.location.href = '../order/track_order.php?order_id=<?php echo $order_id ?>'
                </script>
            <?php
            } else {
            ?>
                <!-- Error -->
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp_2" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Enter valid Order ID or Billing email.</span>
                        </div>
                    </div>
                </div>

                <script>
                    let EpopUp_2 = document.getElementById('EpopUp_2');

                    EpopUp_2.style.display = 'flex';
                    EpopUp_2.style.opacity = '100';

                    setTimeout(() => {
                        EpopUp_2.style.display = 'none';
                        EpopUp_2.style.opacity = '0';
                    }, 1500);
                </script>
        <?php
            }
        }
        ?>
    </div>

    <!-- footer -->
    <?php
    include "_footer.php";
    ?>


    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>