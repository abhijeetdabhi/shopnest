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

    $vendor_id = $res['vendor_id'];

    $retrieve_vendor = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_vendor_query = mysqli_query($con, $retrieve_vendor);

    $ven = mysqli_fetch_assoc($retrieve_vendor_query);
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
    <style>
        #invoice {
            padding: 20px;
        }

        .pdf-container {
            max-width: 100%;
            width: auto;
            margin: 0;
            padding: 0;
        }

        /* Fixing text overflow issues */
        .pdf-title {
            word-wrap: break-word;
            word-break: break-word;
        }
    </style>

</head>

<body style="font-family: 'Outfit', sans-serif;">
    <div id="invoice" class="max-w-4xl mx-auto p-8 bg-white shadow-xl rounded-lg mt-10 pdf-container">
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
        <section class="mb-20 md:mb-8 mt-10 md:mt-0">
            <h2 class="text-2xl font-semibold text-gray-800 mb-10">Product details</h2>
            <div class=" p-4 bg-gray-50 border-2 border-gray-300 gap-y-3 rounded-lg shadow-md">
                <div class="flex flex-col md:flex-row md:items-center md:justify-normal gap-y-2 md:gap-y-0">
                    <img src="<?php echo isset($_COOKIE['user_id']) ? '../src/product_image/product_profile/' . $res['order_image'] : '../src/sample_images/product_1.jpg' ?>" alt="Product Image" class="w-32 h-32 object-cover rounded-md md:mr-6 mix-blend-multiply">
                    <h3 class="text-xl font-bold text-gray-800 break-words w-full">
                        <?php echo isset($_COOKIE['user_id']) ? htmlspecialchars($res['order_title']) : 'product title' ?>
                    </h3>
                </div>
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg mt-3">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200 text-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Color</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Size</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Quantity</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Order Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Vendor</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap"><?php echo isset($_COOKIE['user_id']) ? htmlspecialchars($product_colo) : 'Product Color' ?></td>
                                <td class="px-4 py-3 whitespace-nowrap"><?php echo isset($_COOKIE['user_id']) ? $res['order_size'] : 'Product size' ?></td>
                                <td class="px-4 py-3 whitespace-nowrap"><?php echo isset($_COOKIE['user_id']) ? $res['qty'] : 'Product quantity' ?></td>
                                <td class="px-4 py-3 whitespace-nowrap"><?php echo isset($_COOKIE['user_id']) ? $res['date'] : 'Order Date' ?></td>
                                <td class="px-4 py-3 whitespace-nowrap"><?php echo isset($_COOKIE['user_id']) ? $ven['username'] : 'Vendor name' ?></td>
                                <td class="px-4 py-3 whitespace-nowrap font-semibold">₹<?php echo isset($_COOKIE['user_id']) ? $res['total_price'] : 'total_price' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </section>

        <!-- User Information -->
        <section class="mb-16 md:mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">User information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 md:gap-y-0 md:gap-6">
                <div class="p-4 bg-gray-50 border-2 border-gray-300 rounded-lg shadow-sm space-y-4">
                    <p class="text-gray-700"><span class="font-semibold">First name:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_first_name'] : 'user first name' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Last name:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_last_name'] : 'user last name' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Email:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_email'] : 'user email' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Address:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_address'] : 'user address' ?></p>
                </div>
                <div class="p-4 bg-gray-50 border-2 border-gray-300 rounded-lg shadow-sm space-y-4">
                    <p class="text-gray-700"><span class="font-semibold">Mobile number:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_mobile'] : 'user mobile number' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">State:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_state'] : 'user state' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">City:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_city'] : 'user city' ?></p>
                    <p class="text-gray-700"><span class="font-semibold">Pincode:</span> <?php echo isset($_COOKIE['user_id']) ? $res['user_pin'] : 'user pincode' ?></p>
                </div>
            </div>
        </section>

        <!-- payment type -->
        <section class="mb-16 md:mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Payment Type</h2>
            <div class="flex items-center gap-x-1 border-2 rounded-lg p-2 bg-gray-50 w-fit shadow-md shadow-gray-200">
                <p class="text-gray-500">Payment Method:</p>
                <p class="font-semibold text-gray-700">
                    <?php echo isset($_COOKIE['user_id']) ? $res['payment_type'] : 'User payment method' ?>
                </p>
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

            const options = {
                margin: 0,
                filename: '<?php echo $res['order_title'] ?>.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 3, // Higher scale for better resolution
                    useCORS: true, // Handle cross-origin content
                    windowWidth: element.scrollWidth, // Set dynamic content width
                    windowHeight: element.scrollHeight, // Set dynamic content height
                },
                jsPDF: {
                    unit: 'in',
                    format: [8.27, 11.69], // A4 size format
                    orientation: 'portrait'
                }
            };

            html2pdf().from(element).set(options).toPdf().get('pdf').then((pdf) => {
                btn.style.display = 'block';
                pdf.save('<?php echo $res['order_title'] ?>.pdf');
            });
        });
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>