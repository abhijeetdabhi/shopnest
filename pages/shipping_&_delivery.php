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
    <title>Shipping & Delivery</title>
</head>
<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
        include "_navbar.php";
    ?>


    <div class="max-w-screen-lg m-auto px-6 py-12">
        <div class="title mb-8">
            <h1 class="text-4xl md:text-6xl font-bold text-center">Shipping & Delivery</h1>
        </div>
        <div>
            <p class="text-lg font-medium mb-4">Shipping and delivery are crucial aspects of the e-commerce experience. Here's a detailed description to include on an e-commerce website:</p>

            <div class="mt-7">
                <div>
                    <h1 class="text-2xl font-bold">Shipping Information</h1>
                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Shipping Options:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>At ShopNest, we prioritize fast and efficient delivery, ensuring your products arrive quickly and hassle-free.</li>
                        </ul>
                    </div>

                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Shipping Costs:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>Shipping costs are based on the weight of your order and the delivery destination.</li>
                            <li>Enjoy free shipping on orders up to ₹599! For orders above this amount, regular shipping fees apply. Check out our Promotions page for more details.</li>
                        </ul>
                    </div>

                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Order Processing Time:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>We process all orders swiftly, and the processing time for each product is displayed in minutes on the product detail page. </li>
                            <li>Rest assured, we aim for quick fulfillment to ensure your order reaches you in no time.</li>
                        </ul>
                    </div>
                </div>


                <div class="mt-7">
                    <h1 class="text-2xl font-bold">Delivery Information</h1>
                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Estimated Delivery Times:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>Typically within 40-50 minutes (for local deliveries and fast order fulfillment).</li>
                            <li>Note: Delivery times may vary based on location or unforeseen circumstances such as weather or carrier delays</li>
                        </ul>
                    </div>

                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Delivery Tracking:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>Track your order in real-time by accessing the Track Order page in your ShopNest account.</li>
                            <li>Alternatively, you can visit the Track Order page on our website and enter your product ID and email address to view the status of your order.</li>
                            <li>Please note that logging into your account is compulsory for this feature.</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-7">
                    <h1 class="text-2xl font-bold">Returns and Exchanges</h1>
                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Easy Returns:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>If you're not fully satisfied with your purchase, you can return it within 7 days of receiving your order for a full refund.</li>
                            <li>For more details on how to process your return, visit our Returns page.</li>
                        </ul>
                    </div>

                    <div class="pl-6">
                        <h2 class="text-lg font-semibold mt-3">Shipping Costs:</h2>
                        <ul class="list-disc pl-6 mt-3">
                            <li>Refunds are processed within 5-7 business days after we receive and inspect your returned item.</li>
                        </ul>
                    </div>
                </div>

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