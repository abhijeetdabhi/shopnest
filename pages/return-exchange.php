<?php
    include "../include/connect.php";

    if(isset($_COOKIE['vendor_id'])){
        header("Location: ../vendor/vendor_dashboard.php");
        exit;
    }
    
    if(isset($_COOKIE['adminEmail'])){
        header("Location: ../admin/dashboard.php");
        exit;
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
    <title>Return & Exchange</title>
</head>
<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
        include "_navbar.php";
    ?>

    <div class="max-w-screen-lg m-auto px-6 py-12">
        <div class="title mb-8">
            <h1 class="text-4xl md:text-6xl font-bold text-center">Return & Exchange</h1>
        </div>
        <div>
            <p class="text-lg font-medium mb-4">At shopNest, we strive to ensure your complete satisfaction with every purchase. If, for any reason, you are dissatisfied with your order, we will gladly accept returns and exchanges under the following conditions:</p>

            <div class="mt-7">
                <h1 class="text-2xl font-bold">Returns:</h1>
                <ul class="list-disc pl-8 mt-3">
                    <li><span class="font-semibold">Initiating a Return:</span> You may initiate a return within 5 days of receiving your order. Please contact our customer service team to start the return process.</li>
                    <li><span class="font-semibold">Condition of Items:</span> Returned items must be unused, unworn, unwashed, and undamaged. They must also be in their original packaging with all tags attached.</li>
                    <li><span class="font-semibold">Refund Processing:</span> Once your return is received and inspected, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed and a credit will automatically be applied to your original method of payment within [number] days.</li>
                </ul>
            </div>

            <div class="mt-7">
                <h1 class="text-2xl font-bold">Exchanges:</h1>
                <ul class="list-disc pl-8 mt-3">
                    <li><span class="font-semibold">Initiating an Exchange:</span> Exchanges are permitted within 6 days of receiving your order. Please contact our customer service team to initiate an exchange.</li>
                    <li><span class="font-semibold">Exchange Process:</span> You may exchange an item for a different size or color, subject to availability. If the desired item is not available, we will issue a refund or store credit.</li>
                    <li><span class="font-semibold">Condition of Items:</span> Exchange items must be unused, unworn, unwashed, and undamaged. They must also be in their original packaging with all tags attached.</li>
                </ul>
            </div>

            <div class="mt-7">
                <h1 class="text-2xl font-bold">Return Shipping:</h1>
                <ul class="list-disc pl-8 mt-3">
                    <li><span class="font-semibold">Customer Responsibility:</span> If you receive a damaged or defective item, please contact us immediately. We will provide instructions on returning the item for a replacement or refund.</li>
                </ul>
            </div>

            <div class="mt-7">
                <h1 class="text-2xl font-bold">Damaged or Defective Items:</h1>
                <ul class="list-disc pl-8 mt-3">
                    <li><span class="font-semibold">Reporting:</span> Customers are responsible for return shipping costs unless the item received is incorrect, damaged, or defective.</li>
                    <li><span class="font-semibold">Shipping Fees:</span>  Shipping fees are non-refundable, except in cases where we have made a shipping error.</li>
                </ul>
            </div>

            <div class="mt-7">
                <h1 class="text-2xl font-bold">How to Initiate a Return or Exchange:</h1>
                <ul class="list-disc pl-8 mt-3">
                    <li>To initiate a return or exchange, please contact our customer service team at <a href="tel:123456789" class="text-gray-500 underline">+91 8141391797</a>. Please have your order number and details of the issue ready.</li>
                </ul>
            </div>
        </div>
    </div>


    <!-- footer -->
    <?php
        include "_footer.php";
    ?>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>
</html>