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

    <!-- alpine script -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>

    <!-- title -->
    <title>FAQ</title>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
    include "_navbar.php";
    ?>

    <div x-data="{ openItem: null }" class="max-w-xl mx-auto bg-white shadow-lg rounded-lg my-12">
        <h2 class="text-2xl font-bold text-center p-5">Frequently asked questions</h2>

        <div class="faq-item border-b" @click="openItem === 1 ? openItem = null : openItem = 1">
            <div class="faq-question p-4 cursor-pointer flex justify-between items-center">
                <span>What is shopNest?</span>
                <svg :class="{ 'transform rotate-180': openItem === 1 }" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <div x-show="openItem === 1" x-transition class="faq-answer p-4 text-gray-500">
                shopNest is your one-stop online shopping destination for top-quality products at unbeatable prices.
            </div>
        </div>

        <div class="faq-item border-b" @click="openItem === 2 ? openItem = null : openItem = 2">
            <div class="faq-question p-4 cursor-pointer flex justify-between items-center">
                <span>How do I place an order?</span>
                <svg :class="{ 'transform rotate-180': openItem === 2 }" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <div x-show="openItem === 2" x-transition class="faq-answer p-4 text-gray-500">
                To place an order, simply add items to your cart, proceed to checkout, and complete the payment process.
            </div>
        </div>

        <div class="faq-item border-b" @click="openItem === 3 ? openItem = null : openItem = 3">
            <div class="faq-question p-4 cursor-pointer flex justify-between items-center">
                <span>What payment methods do you accept?</span>
                <svg :class="{ 'transform rotate-180': openItem === 3 }" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <div x-show="openItem === 3" x-transition class="faq-answer p-4 text-gray-500">
                We accept Cash On Delivery payment methods .
            </div>
        </div>

        <div class="faq-item border-b" @click="openItem === 4 ? openItem = null : openItem = 4">
            <div class="faq-question p-4 cursor-pointer flex justify-between items-center">
                <span>How can I track my order?</span>
                <svg :class="{ 'transform rotate-180': openItem === 4 }" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <div x-show="openItem === 4" x-transition class="faq-answer p-4 text-gray-500">
                You can track your order by logging into your account and visiting the 'Track Orders' section.
            </div>
        </div>

        <div class="faq-item" @click="openItem === 5 ? openItem = null : openItem = 5">
            <div class="faq-question p-4 cursor-pointer flex justify-between items-center">
                <span>What is your return policy?</span>
                <svg :class="{ 'transform rotate-180': openItem === 5 }" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
            <div x-show="openItem === 5" x-transition class="faq-answer p-4 text-gray-500">
                We offer a 7-day return policy on most items. To return order go to track order section and then Choose Return Order.
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