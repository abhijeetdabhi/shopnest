<?php

if (!isset($_GET['order_id']) || !isset($_COOKIE['user_id'])) {
    header("Location: /shopnest/index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /shopnest/vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /shopnest/admin/dashboard.php");
    exit;
}
?>

<?php

session_start();

include "../include/connect.php";

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
} else {
    header("Location: ../user/show_orders.php");
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $retrieve_order = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $retrieve_order_query = mysqli_query($con, $retrieve_order);

    $res = mysqli_fetch_assoc($retrieve_order_query);


    $product_colo = $res['order_color'];
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

    <!-- pdf download link -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Invoice</title>

</head>

<body style="font-family: 'Outfit', sans-serif;">
    <div id="invoice" class="max-w-4xl mx-auto p-8 bg-white shadow-xl rounded-lg mt-10">
        <!-- Header -->
        <header class="flex items-center justify-between flex-wrap gap-x-12 gap-y-5 border-b-2 border-gray-300 pb-4 mb-8">
            <div class="flex items-center">
                <!-- icon logo div -->
                <div>
                    <img class="w-7 sm:w-14 mt-0.5" src="../src/logo/black_cart_image.png" alt="">
                </div>
                <!-- text logo -->
                <div>
                    <img class="w-16 sm:w-36" src="../src/logo/black_text_image.png" alt="">
                </div>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-800">Invoice</h1>
        </header>
        <!-- Product Details -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Product details</h2>
            <div class="flex flex-wrap items-center p-4 bg-gray-50 ring-2 ring-gray-300 gap-y-5 rounded-lg shadow-md">
                <img src="<?php echo isset($_COOKIE['user_id']) ? '../src/product_image/product_profile/' . $res['order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="Product Image" class="w-32 h-32 object-cover rounded-md border border-gray-300 mr-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 line-clamp-2"><?php echo isset($_COOKIE['user_id']) ? $res['order_title'] : 'product title' ?></h3>
                    <p class="text-gray-700 mt-4 font-semibold">Price: <span class="font-normal text-green-500">₹<?php echo isset($_COOKIE['user_id']) ? $res['total_price'] : 'total_price' ?></span></p>
                    <div class="text-gray-700 flex items-center gap-2 mt-1">
                        <span class="max-w-max font-semibold">Color:</span>
                        <h1 class="my-auto"><?php echo isset($_COOKIE['user_id']) ? htmlspecialchars($product_colo) : 'Product Color' ?></h1>
                    </div>
                    <p class="text-gray-700 mt-1 font-semibold">Size: <span class="font-normal"><?php echo isset($_COOKIE['user_id']) ? $res['order_size'] : 'Product size' ?></span></p>
                    <p class="text-gray-700 mt-1 font-semibold">Quantity: <span class="font-normal"><?php echo isset($_COOKIE['user_id']) ? $res['qty'] : 'Product size' ?></span></p>
                </div>
            </div>
        </section>

        <!-- User Information -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">User information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 ring-2 ring-gray-300 rounded-lg shadow-sm space-y-4">
                    <p class="text-gray-700"><span class="font-semibold">First name:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_first_name'] : 'user first name' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Last name:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_last_name'] : 'user last name' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Email:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_email'] : 'user email' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Address:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_address'] : 'user address' ?></p>
                </div>
                <div class="p-4 bg-gray-50 ring-2 ring-gray-300 rounded-lg shadow-sm space-y-4">
                    <p class="text-gray-700"><span class="font-semibold">Mobile number:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_mobile'] : 'user mobile number' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">State:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_state'] : 'user state' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">City:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_city'] : 'user city' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Pincode:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_pin'] : 'user pincode' ?></p>
                </div>
            </div>
        </section>

        <!-- Payment Type -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Payment type</h2>
            <div class="p-4 bg-gray-50 border border-gray-300 rounded-lg shadow-sm border-l-4 border-l-gray-600">
                <p class="text-gray-700 text-sm">Payment method: <span class="font-semibold"><?php echo isset($_COOKIE['user_id']) ? $res['payment_type'] : 'user first name' ?></span></p>
            </div>
        </section>

        <!-- Total Price -->
        <section class="border-t-2 border-gray-300 pt-6">
            <div class="flex justify-between text-xl font-semibold text-gray-800 mb-2">
                <span>Total price:</span>
                <span class="tracking-wide text-green-500">₹<?php echo isset($_COOKIE['user_id']) ? $res['total_price'] : 'total price' ?></span>
            </div>
        </section>

        <!-- Download PDF Button -->
        <div class="mt-8">
            <button id="downloadPdf" class="bg-gray-700 text-white py-2 px-4 rounded-tl-xl rounded-br-xl shadow-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                Download PDF
            </button>
        </div>
    </div>

    <script>
        document.getElementById('downloadPdf').addEventListener('click', () => {
            const element = document.getElementById('invoice');
            const btn = document.getElementById('downloadPdf');
            
            btn.style.display = 'none';

            html2pdf().from(element).toPdf().get('pdf').then(function(pdf) {
                btn.style.display = 'block';
                pdf.save('<?php echo $res['order_title'] ?>.pdf');
            });
        });
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>