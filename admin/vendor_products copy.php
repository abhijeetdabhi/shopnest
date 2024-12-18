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
    <title>Vendor Products</title>
</head>

<body style="font-family: 'Outfit', sans-serif;">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <div class="flex flex-col h-screen bg-gray-200">


                <div class="w-full flex items-center py-4 px-4 border-b-[2.5px] border-gray-700 shadow-md shadow-gray-500 bg-white">
                    <a href="view_vendors.php" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-7 md:w-10">
                            <g>
                                <path fill="#000000" fill-rule="evenodd" d="M15 4a1 1 0 1 1 1.414 1.414l-5.879 5.879a1 1 0 0 0 0 1.414l5.88 5.879A1 1 0 0 1 15 20l-7.293-7.293a1 1 0 0 1 0-1.414z" clip-rule="evenodd" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </a>
                    <h2 class="font-manrope font-bold text-xl md:text-4xl leading-10 text-black w-full text-center">Vendor Products</h2>
                </div>
                <section class="py-4 px-6 overflow-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-tl-xl rounded-br-xl shadow-sm overflow-hidden w-full h-[33.5rem] relative">
                        <div class="relative flex justify-center p-2">
                            <a href="../src/product_image/"></a>
                            <img src="../src/product_image/product_profile/61VuVU94RnL._SL1500_.jpg" alt="Product Image" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl">
                            <span class="absolute top-2 right-2 bg-green-500 px-2 pt-0.5 pb-1 text-white text-xs font-semibold tracking-wide rounded-tl-lg rounded-br-lg">
                                New Condition
                            </span>
                        </div>
                        <div class="px-4 pt-2">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">Apple iPhone 13 pro - Midnight</h2>
                            <a href="../vendor/vendor_store.php?vendor_id=24" class="text-sm text-gray-600 mb-3">By: <span class="font-bold text-base text-gray-600">Markets</span></a>
                            <div class="text-gray-600 text-sm mb-2 space-y-1">
                                <p>Company: <span class="font-medium">Apple</span></p>
                                <p>Category: <span class="font-medium">Phones</span></p>
                                <p>Date: <span class="font-medium">22-11-2024</span></p>
                            </div>
                            <div>
                                <p class="text-md font-semibold text-gray-900">₹45490</p>
                                <p class="text-sm font-medium text-gray-500 line-through">₹59900</p>
                            </div>
                        </div>
                        <div class="w-full flex justify-between h-10 divide-x-2 border-t-2 mt-2 absolute bottom-0">
                            <a href="edit_vendor_products.php?product_id=13&amp;name=Phones" class="px-1 w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <a href="remove_product.php?product_id=13" class="px-1 w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                <i class="fa-solid fa-trash text-base"></i>
                                <span>Remove</span>
                            </a>
                        </div>
                    </div>
                    <!-- Card 1 -->
                    <div class="bg-white rounded-tl-xl rounded-br-xl shadow-sm overflow-hidden w-full h-[33.5rem] relative">
                        <div class="relative flex justify-center p-2">
                            <a href="../src/product_image/"></a>
                            <img src="../src/product_image/product_profile/61VuVU94RnL._SL1500_.jpg" alt="Product Image" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl">
                            <span class="absolute top-2 right-2 bg-green-500 px-2 pt-0.5 pb-1 text-white text-xs font-semibold tracking-wide rounded-tl-lg rounded-br-lg">
                                New Condition
                            </span>
                        </div>
                        <div class="px-4 pt-2">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">Apple iPhone 13 pro max (128gb) - Midnight</h2>
                            <a href="../vendor/vendor_store.php?vendor_id=24" class="text-sm text-gray-600 mb-3">By: <span class="font-bold text-base text-gray-600 hover:underline">Markets</span> <span></span></a>
                            <div class="text-gray-600 text-sm mb-2 space-y-1">
                                <p>Company: <span class="font-medium">Apple</span></p>
                                <p>Category: <span class="font-medium">Phones</span></p>
                                <p>Date: <span class="font-medium">22-11-2024</span></p>
                            </div>
                            <div>
                                <p class="text-md font-semibold text-gray-900">₹45490</p>
                                <p class="text-sm font-medium text-gray-500 line-through">₹59900</p>
                            </div>
                        </div>
                        <div class="w-full flex justify-between h-10 divide-x-2 border-t-2 mt-2 absolute bottom-0">
                            <a href="edit_vendor_products.php?product_id=13&amp;name=Phones" class="px-1 w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <a href="remove_product.php?product_id=13" class="px-1 w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                <i class="fa-solid fa-trash text-base"></i>
                                <span>Remove</span>
                            </a>
                        </div>
                    </div>
                    <!-- Card 1 -->
                    <div class="bg-white rounded-tl-xl rounded-br-xl shadow-sm overflow-hidden w-full h-[33.5rem] relative">
                        <div class="relative flex justify-center p-2">
                            <a href="../src/product_image/"></a>
                            <img src="../src/product_image/product_profile/61VuVU94RnL._SL1500_.jpg" alt="Product Image" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl">
                            <span class="absolute top-2 right-2 bg-green-500 px-2 pt-0.5 pb-1 text-white text-xs font-semibold tracking-wide rounded-tl-lg rounded-br-lg">
                                New Condition
                            </span>
                        </div>
                        <div class="px-4 pt-2">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">Apple iPhone 13 plus - Midnight</h2>
                            <a href="../vendor/vendor_store.php?vendor_id=24" class="text-sm text-gray-600 mb-3">By: <span class="font-bold text-base text-gray-600">Markets</span></a>
                            <div class="text-gray-600 text-sm mb-2 space-y-1">
                                <p>Company: <span class="font-medium">Apple</span></p>
                                <p>Category: <span class="font-medium">Phones</span></p>
                                <p>Date: <span class="font-medium">22-11-2024</span></p>
                            </div>
                            <div>
                                <p class="text-md font-semibold text-gray-900">₹45490</p>
                                <p class="text-sm font-medium text-gray-500 line-through">₹59900</p>
                            </div>
                        </div>
                        <div class="w-full flex justify-between h-10 divide-x-2 border-t-2 mt-2 absolute bottom-0">
                            <a href="edit_vendor_products.php?product_id=13&amp;name=Phones" class="px-1 w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <a href="remove_product.php?product_id=13" class="px-1 w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                <i class="fa-solid fa-trash text-base"></i>
                                <span>Remove</span>
                            </a>
                        </div>
                    </div>
                    <!-- Card 1 -->
                    <div class="bg-white rounded-tl-xl rounded-br-xl shadow-sm overflow-hidden w-full h-[33.5rem] relative">
                        <div class="relative flex justify-center p-2">
                            <a href="../src/product_image/"></a>
                            <img src="../src/product_image/product_profile/61VuVU94RnL._SL1500_.jpg" alt="Product Image" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl">
                            <span class="absolute top-2 right-2 bg-green-500 px-2 pt-0.5 pb-1 text-white text-xs font-semibold tracking-wide rounded-tl-lg rounded-br-lg">
                                New Condition
                            </span>
                        </div>
                        <div class="px-4 pt-2">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">Apple iPhone 13 - Midnight</h2>
                            <a href="../vendor/vendor_store.php?vendor_id=24" class="text-sm text-gray-600 mb-3">By: <span class="font-bold text-base text-gray-600">Markets</span></a>
                            <div class="text-gray-600 text-sm mb-2 space-y-1">
                                <p>Company: <span class="font-medium">Apple</span></p>
                                <p>Category: <span class="font-medium">Phones</span></p>
                                <p>Date: <span class="font-medium">22-11-2024</span></p>
                            </div>
                            <div>
                                <p class="text-md font-semibold text-gray-900">₹45490</p>
                                <p class="text-sm font-medium text-gray-500 line-through">₹59900</p>
                            </div>
                        </div>
                        <div class="w-full flex justify-between h-10 divide-x-2 border-t-2 mt-2 absolute bottom-0">
                            <a href="edit_vendor_products.php?product_id=13&amp;name=Phones" class="px-1 w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <a href="remove_product.php?product_id=13" class="px-1 w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                <i class="fa-solid fa-trash text-base"></i>
                                <span>Remove</span>
                            </a>
                        </div>
                    </div>
                    <!-- Card 1 -->
                    <div class="bg-white rounded-tl-xl rounded-br-xl shadow-sm overflow-hidden w-full h-[33.5rem] relative">
                        <div class="relative flex justify-center p-2">
                            <a href="../src/product_image/"></a>
                            <img src="../src/product_image/product_profile/61VuVU94RnL._SL1500_.jpg" alt="Product Image" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl">
                            <span class="absolute top-2 right-2 bg-green-500 px-2 pt-0.5 pb-1 text-white text-xs font-semibold tracking-wide rounded-tl-lg rounded-br-lg">
                                New Condition
                            </span>
                        </div>
                        <div class="px-4 pt-2">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2">Apple macBookAir 13inch - Midnight</h2>
                            <a href="../vendor/vendor_store.php?vendor_id=24" class="text-sm text-gray-600 mb-3">By: <span class="font-bold text-base text-gray-600">Markets</span></a>
                            <div class="text-gray-600 text-sm mb-2 space-y-1">
                                <p>Company: <span class="font-medium">Apple</span></p>
                                <p>Category: <span class="font-medium">Phones</span></p>
                                <p>Date: <span class="font-medium">22-11-2024</span></p>
                            </div>
                            <div>
                                <p class="text-md font-semibold text-gray-900">₹45490</p>
                                <p class="text-sm font-medium text-gray-500 line-through">₹59900</p>
                            </div>
                        </div>
                        <div class="w-full flex justify-between h-10 divide-x-2 border-t-2 mt-2 absolute bottom-0">
                            <a href="edit_vendor_products.php?product_id=13&amp;name=Phones" class="px-1 w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>
                            <a href="remove_product.php?product_id=13" class="px-1 w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                <i class="fa-solid fa-trash text-base"></i>
                                <span>Remove</span>
                            </a>
                        </div>
                    </div>
                    <!-- Additional cards go here -->
                </section>

        </div>
    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>