<?php 
if(isset($_COOKIE['vendor_id'])){
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}

if(isset($_COOKIE['adminEmail'])){
    header("Location: /admin/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favicon.svg">

    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        .link {
            position: relative;
        }

        .link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 1.5px;
            display: block;
            margin-top: 0;
            right: 0;
            background: #fff;
            /* Adjust color as needed */
            transition: width .2s ease;
            -webkit-transition: width 0.2s ease;
        }

        .link:hover:after {
            width: 100%;
            left: 0;
            background: #fff;
            /* Adjust color as needed */
        }
    </style>
</head>

<body class="outfit">
    <footer class="p-2 outfit bg-gray-950 text-white mt-5">
        <div class="md:flex justify-between gap-10 px-2 md:px-8 py-4 space-y-5 sm:space-y-0">
            <div>
                <a class="flex w-fit py-2" href="/index.php">
                    <!-- icon logo div -->
                    <div>
                        <img class="w-7 sm:w-12 mt-0.5" src="/src/logo/white_cart_logo.svg" alt="">
                    </div>
                    <!-- text logo -->
                    <div>
                        <img class="w-16 sm:w-32" src="/src/logo/white_text_logo.svg" alt="">
                    </div>
                </a>
                <div class="md:w-60 lg:w-[30rem] 2xl:w-[40rem] mt-3">
                    <p class="text-sm">shopNest: Elevate your shopping experience with a vast selection of premium products, exceptional deals, and seamless service. Your nest for everything you need.</p>
                </div>
            </div>
            <div>
                <div>
                    <!-- help -->
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-10 xl:grid-cols-3 md:gap-20">
                        <div class="space-y-3">
                            <h1 class="text-lg sm:text-xl">Get to know us</h1>
                            <ul class="space-y-3 text-xs sm:text-sm">
                                <li><a class="link" href="/pages/about_us.php">About us</a></li>
                                <li><a class="link" href="/pages/contact_us.php">Contact us</a></li>
                                <li><a class="link" href="/pages/Investor.php">Investors</a></li>
                            </ul>
                        </div>

                        <div class="space-y-3">
                            <h1 class="text-lg sm:text-xl">Customer service</h1>
                            <ul class="space-y-3 text-xs sm:text-sm">
                                <li><a class="link" href="/pages/help_center.php">Help center</a></li>
                                <li><a class="link" href="/pages/FAQ.php">FAQ's</a></li>
                                <li><a class="link" href="/pages/payment_method.php">Payment method</a></li>
                            </ul>
                        </div>

                        <div class="space-y-3">
                            <h1 class="text-lg sm:text-xl">Orders & Returns</h1>
                            <ul class="space-y-3 text-xs sm:text-sm">
                                <li><a class="link" href="/pages/track_order.php">Track orders</a></li>
                                <li><a class="link" href="/pages/shipping_&_delivery.php">Shipping & Dilivery</a></li>
                                <li><a class="link" href="/pages/return-exchange.php">Return & Exchange</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-3"><br>
        <div class="sm:flex sm:items-center sm:justify-between sm:gap-10 px-2 py-2 space-y-3 sm:space-y-0">
            <div>
                <p class="text-sm">Copyright &copy; <?php echo date('Y') ?> shopNest. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-1">
                <svg class="w-8" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 68 68" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                    <g>
                        <path d="M60.8 15.19H7.21C3.79 15.19 1 17.98 1 21.4v25.21c0 3.42 2.79 6.2 6.21 6.2H60.8c3.42 0 6.2-2.78 6.2-6.2V21.4c0-3.42-2.78-6.21-6.2-6.21zM65 46.61a4.2 4.2 0 0 1-4.2 4.2H7.21c-2.32 0-4.21-1.88-4.21-4.2V21.4c0-2.32 1.89-4.21 4.21-4.21H60.8c2.32 0 4.2 1.89 4.2 4.21z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                        <path d="M61 25.27a4.08 4.08 0 0 1-4.07-4.07c0-.55-.45-1-1-1H12.07c-.55 0-1 .45-1 1A4.08 4.08 0 0 1 7 25.27c-.55 0-1 .45-1 1v15.47c0 .55.45 1 1 1 2.24 0 4.07 1.82 4.07 4.07 0 .55.45 1 1 1h43.86c.55 0 1-.45 1-1 0-2.25 1.83-4.07 4.07-4.07.55 0 1-.45 1-1V26.27c0-.55-.45-1-1-1zm-1 15.55c-2.55.42-4.56 2.44-4.99 4.99H12.99A6.099 6.099 0 0 0 8 40.82V27.19a6.099 6.099 0 0 0 4.99-4.99h42.02A6.099 6.099 0 0 0 60 27.19z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                        <path d="M17.963 30.066A3.938 3.938 0 0 0 14.03 34a3.941 3.941 0 0 0 3.933 3.94 3.945 3.945 0 0 0 3.94-3.94 3.941 3.941 0 0 0-3.94-3.934zm0 5.874A1.939 1.939 0 0 1 16.03 34c0-1.067.867-1.934 1.933-1.934 1.07 0 1.94.867 1.94 1.934 0 1.07-.87 1.94-1.94 1.94zM49.917 30.066A3.938 3.938 0 0 0 45.984 34a3.941 3.941 0 0 0 3.933 3.94 3.945 3.945 0 0 0 3.94-3.94 3.941 3.941 0 0 0-3.94-3.934zm0 5.874A1.939 1.939 0 0 1 47.984 34c0-1.067.867-1.934 1.933-1.934 1.07 0 1.94.867 1.94 1.934 0 1.07-.87 1.94-1.94 1.94zM40.26 30.53c0 .55-.44 1-1 1h-1.89a5.257 5.257 0 0 1-5.15 4.24h-1.45l4.14 5.35c.33.43.25 1.06-.18 1.4a1.002 1.002 0 0 1-1.41-.18l-5.38-6.95c-.33-.44-.25-1.07.18-1.41.18-.14.39-.21.6-.21h3.5c1.44 0 2.65-.94 3.08-2.24h-6.56c-.56 0-1-.45-1-1 0-.56.44-1 1-1h6.56c-.43-1.31-1.64-2.25-3.08-2.25h-3.48a.96.96 0 0 1-.68-.28.952.952 0 0 1-.32-.72c0-.55.44-1 1-1h10.52c.56 0 1 .45 1 1s-.44 1-1 1h-2.95c.52.64.89 1.4 1.06 2.25h1.89c.56 0 1 .44 1 1z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                    </g>
                </svg>
                <p class="text-sm"> -INR</p>
            </div>
        </div>
    </footer>
</body>

</html>