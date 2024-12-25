<?php
    include "../include/connect.php";
    session_start();

    if(isset($_SESSION['searchWord'])){
        unset($_SESSION['searchWord']);
    }
    
    if(isset($_SESSION['selectedSize'])){
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

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- title -->
    <title>Help Center</title>
</head>
<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
        include "_navbar.php";
    ?> 

    <div class="bg-[#b4f4de] text-center flex flex-col gap-6 py-20">
        <div class="max-w-screen-xl m-auto">
            <h1 class="text-6xl font-bold text-[rgb(29,33,40)]">How can we help you?</h1>
            <p class="text-lg font-normal">Our crew of superheroes are standing by for Help & Support!</p>
        </div>
    </div>

    <div class="max-w-screen-xl m-auto mt-8 py-12 px-5">
        <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
            <h2 id="accordion-color-heading-1">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-b-0 border-gray-300 rounded-t-lg dark:text-gray-900 hover:bg-gray-700 hover:text-white gap-3" data-accordion-target="#accordion-color-body-1" aria-expanded="true" aria-controls="accordion-color-body-1">
                    <span>Orders & Purchases</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
                <div class="p-5 text-gray-900 border-gray-200 dark:border-gray-700 bg-[#b4f4de]">
                    <div class="grid grid-cols-1 gap-4 gap-y-6 md:grid-cols-2">
                        <div>
                            <h1 class="text-lg font-semibold">Cancel an order:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Changed your mind? No problem! Easily cancel your order before it ships with just a few clicks on ShopNest. We make managing your purchases as simple as possible, giving you peace of mind.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Track a package:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Stay updated with real-time tracking. From Order Placed to Packed, On the Way, and Delivered, you’ll know exactly where your package is and when to expect it.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Vendor Support:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>As a vendor on ShopNest, we offer dedicated support to help you succeed. Whether you need assistance with product listings or navigating our platform, our team is here to guide you, ensuring that your products are visible and ready to meet customer demand.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Fast Delivery:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>At ShopNest, we prioritize fast delivery for both vendors and customers. Our platform supports rapid fulfillment, ensuring that products are delivered within 40 to 50 minutes from order placement. This speed makes ShopNest an ideal marketplace for vendors who want to provide customers with an exceptional, quick-turnaround shopping experience.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <h2 id="accordion-color-heading-2">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-b-0 border-gray-300 dark:text-gray-900 hover:bg-gray-700 hover:text-white gap-3" data-accordion-target="#accordion-color-body-2" aria-expanded="false" aria-controls="accordion-color-body-2">
                    <span>Returns & Refunds</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
                <div class="p-5 text-gray-900 border-gray-200 dark:border-gray-700 bg-[#b4f4de]">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <h1 class="text-lg font-semibold">I would like to return my order:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Initiate the return process through your account for a hassle-free experience</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">What if my order is damaged?:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Contact us immediately with details and photos for a quick resolution.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">I've received a faulty/damaged item:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Notify us promptly; we'll arrange a replacement or refund.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">How will I be refunded?:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Refunds are processed to your original payment method.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <h2 id="accordion-color-heading-3">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-gray-300 dark:text-gray-900 hover:bg-gray-700 hover:text-white gap-3" data-accordion-target="#accordion-color-body-3" aria-expanded="false" aria-controls="accordion-color-body-3">
                    <span>Shipping & Tracking</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                <div class="p-5 text-gray-900 border-gray-200 dark:border-gray-700 bg-[#b4f4de]">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <h1 class="text-lg font-semibold">Saving through combined shipping:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Combine purchases to save on shipping fees.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Shipping rates for buyers:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>View shipping costs upfront before purchasing.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Tracking your item:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Stay updated with real-time tracking for your order.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <h2 id="accordion-color-heading-4">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-gray-300 dark:text-gray-900 hover:bg-gray-700 hover:text-white gap-3" data-accordion-target="#accordion-color-body-4" aria-expanded="false" aria-controls="accordion-color-body-4">
                    <span>Fees & Billing</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-4" class="hidden" aria-labelledby="accordion-color-heading-4">
                <div class="p-5 text-gray-900 border-gray-200 dark:border-gray-700 bg-[#b4f4de]">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <h1 class="text-lg font-semibold">Refunds and Disputes:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Handle refunds and manage disputes efficiently through our customer support system.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Getting Paid:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Receive payments securely and promptly for your sales through our payment processing options.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Fees and Reporting:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Understand our transparent fee structure and access detailed sales reports to track your business performance.</li>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold">Getting Started:</h1>
                            <ul class="list-disc pl-6 mt-3">
                                <li>Start selling quickly and easily with our user-friendly setup process and helpful guides.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#fff9e0] text-[rgb(29,33,40)] w-[90%] flex flex-col items-center justify-center gap-10 m-auto ring-2 ring-[#1d2128] text-center py-10 md:w-[70%] mb-12">
        <p class="text-lg font-medium">Still need help?</p>
        <h1 class="text-3xl md:text-4xl font-medium lg:text-5xl">Get help with common <br> questions or reach out to our <br> support team.</h1>
        <a href="contact_us.php" class="text-white font-semibold text-sm bg-black px-8 py-3 rounded-tl-xl rounded-br-xl">Contact Us</a>
    </div>
    

    <!-- footer -->
    <?php
        include "_footer.php";
    ?>

    <!-- flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>
</html>