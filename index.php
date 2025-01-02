<?php

if (isset($_COOKIE['vendor_id'])) {
    header("Location: vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: admin/dashboard.php");
    exit;
}

?>

<?php
include "include/connect.php";

session_start();

$sessionKeys = [
    'totalCartPrice',
    'qty',
    'travelTime',
    'checkoutId',
    'checkoutSize',
    'checkoutQty',
    'checkoutMRP',
    'checkoutTravelTime',
    'order_id',
    'reOrderId',
    'reOrderColor',
    'reOrderSize',
    'reOrderQty',
    'reOrderMRP',
    'reOrderTravelTime',
    'searchWord',
    'sort',
    'selectedSize'
];

foreach ($sessionKeys as $key) {
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

if (isset($_SESSION['views'])) {
    $_SESSION['views'] = $_SESSION['views'] + 1;
} else {
    $_SESSION['views'] = 1;
}

$page_view = $_SESSION['views'];
$view_date = date('d-m-y');

$view_count = "INSERT INTO page_count(view_count, view_date) VALUES ('$page_view','$view_date')";
$view_query = mysqli_query($con, $view_count);

$get_lat_lng = "SELECT * FROM vendor_registration";
$lat_lng_query = mysqli_query($con, $get_lat_lng);

$latitude = [];
$longitude = [];

while ($fatchLatLng = mysqli_fetch_assoc($lat_lng_query)) {
    if ($fatchLatLng['latitude'] === "" && $fatchLatLng['longitude'] === "") {
        continue;
    }

    $vendor_latitude = $fatchLatLng['latitude'];
    $vendor_longitude = $fatchLatLng['longitude'];

    $latitude[] = $vendor_latitude;
    $longitude[] = $vendor_longitude;
}

function haversine($lat1, $lon1, $lat2, $lon2)
{
    $R = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $R * $c;
    return $distance;
}

$current_lat = $_COOKIE['latitude'] ?? 0;
$current_lon = $_COOKIE['longitude'] ?? 0;

$nearbyLocation = [];
$nearLocation = false;


for ($i = 0; $i < count($latitude); $i++) {
    $distance = haversine($latitude[$i], $longitude[$i], $current_lat, $current_lon);

    if ($distance <= 15) {
        $nearbyLocation[] = ['lat' => $latitude[$i], 'lng' => $longitude[$i], 'distance' => $distance];
    } else {
        if ($current_lat != 0 && $current_lon != 0) {
            $nearLocation = true;
            break;
        }
    }
}

if ($nearLocation === true) {
    setcookie('latitude', '', time() - 3600, "/");
    setcookie('longitude', '', time() - 3600, "/");
}

if (count($nearbyLocation) > 0) {
    $i = 1;
    foreach ($nearbyLocation as $locations) {
        $distance = number_format($locations['distance'], 2);

        $vendorLatitude = $locations['lat'];
        $vendorLongitude = $locations['lng'];

        setcookie("vendorLat" . $i, $vendorLatitude, time() + (365 * 24 * 60 * 60), "/");
        setcookie("vendorLng" . $i, $vendorLongitude, time() + (365 * 24 * 60 * 60), "/");

        $get_vendor = "SELECT * FROM vendor_registration WHERE latitude = '$vendorLatitude' AND longitude = '$vendorLongitude'";
        $query = mysqli_query($con, $get_vendor);

        $vendorCount = mysqli_fetch_assoc($query);
        $i++;
    }
}

function displayRandomProducts($con, $limit)
{
    $vendorLatitudes = [];
    $vendorLongitudes = [];

    foreach ($_COOKIE as $cookieName => $cookieValue) {

        if (strpos($cookieName, 'vendorLat') === 0) {
            $index = substr($cookieName, 9);
            $vendorLatitudes[$index] = $cookieValue;
        }

        if (strpos($cookieName, 'vendorLng') === 0) {
            $index = substr($cookieName, 9);
            $vendorLongitudes[$index] = $cookieValue;
        }
    }

    foreach ($vendorLatitudes as $index => $lat) {
        $lng = isset($vendorLongitudes[$index]) ? $vendorLongitudes[$index] : 'N/A'; // Get longitude for the same index

        $get_vendor = "SELECT * FROM vendor_registration WHERE latitude = '$lat' AND longitude = '$lng'";
        $query = mysqli_query($con, $get_vendor);

        $vendorCount = mysqli_fetch_assoc($query);
        $vendorId = $vendorCount['vendor_id'];


        $product_find = "SELECT * FROM products WHERE vendor_id = '$vendorId' ORDER BY RAND() LIMIT $limit";
        $product_query = mysqli_query($con, $product_find);

        while ($res = mysqli_fetch_assoc($product_query)) {
            $product_id = $res['product_id'];

            $MRP = $res['vendor_mrp'];

            // for qty
            if ($res['Quantity'] > 0) {
                $qty = 1;
            } else {
                $qty = 0;
            }

            // for the size
            $size = $res['size'];
            $filter_size = explode(',', $size);
            foreach ($filter_size as $product_size) {
                $product_size;
                break;
            }
?>

            <div class="swiper-slide">
                <div class=" flex justify-center">
                    <div class="product-card ring-2 ring-gray-300  rounded-tl-xl rounded-br-xl h-[23.7rem] w-60 overflow-hidden relative">
                        <div class="p-2" onclick="window.location.href = 'product/product_detail.php?product_id=<?php echo $res['product_id']; ?>'">
                            <img src="<?php echo 'src/product_image/product_profile/' . $res['profile_image_1'] ?>" alt="" class="product-card__hero-image css-1fxh5tw h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl mix-blend-multiply" loading="lazy" sizes="">
                        </div>
                        <div class="mt-2 space-y-3" onclick="window.location.href = 'product/product_detail.php?product_id=<?php echo $res['product_id']; ?>'">
                            <a href="product/product_detail.php?product_id=<?php echo $res['product_id'] ?>" class="text-sm font-medium line-clamp-2 cursor-pointer px-2"><?php echo $res['title'] ?></a>
                            <div class="flex justify-between px-2">
                                <p class="space-x-1">
                                    <span class="text-lg font-medium text-gray-900">₹<?php echo number_format($MRP) ?></span>
                                    <del class="text-xs font-medium">₹<?php echo number_format($res['vendor_price']) ?></del>
                                </p>
                                <div class="flex items-center">
                                    <span class="bg-gray-900 rounded-tl-md rounded-br-md px-2 py-0.5 flex items-center gap-1">
                                        <h1 class="font-semibold text-xs text-white"><?php echo isset($res['avg_rating']) ? $res['avg_rating'] : '0.0' ?></h1>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.991 511" class="w-2.5 h-2.5 m-auto fill-current text-white">
                                            <path d="M510.652 185.883a27.177 27.177 0 0 0-23.402-18.688l-147.797-13.418-58.41-136.75C276.73 6.98 266.918.497 255.996.497s-20.738 6.483-25.023 16.53l-58.41 136.75-147.82 13.418c-10.837 1-20.013 8.34-23.403 18.688a27.25 27.25 0 0 0 7.937 28.926L121 312.773 88.059 457.86c-2.41 10.668 1.73 21.7 10.582 28.098a27.087 27.087 0 0 0 15.957 5.184 27.14 27.14 0 0 0 13.953-3.86l127.445-76.203 127.422 76.203a27.197 27.197 0 0 0 29.934-1.324c8.851-6.398 12.992-17.43 10.582-28.098l-32.942-145.086 111.723-97.964a27.246 27.246 0 0 0 7.937-28.926zM258.45 409.605"></path>
                                        </svg>
                                    </span>
                                    <span class="text-sm ml-2 text-gray-900 tracking-wide">(<?php echo $res['total_reviews'] ?>)</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-600 w-full mt-2 py-1.5 flex justify-center absolute bottom-0">
                            <?php
                            if ($qty > 0) {
                            ?>
                                <a href="<?php echo $qty > 0 ? 'shopping/add_to_cart.php?product_id=' . urlencode($product_id) . '&size=' . $product_size . '&qty=' . $qty . '&MRP=' . $MRP : '#'; ?>" class="bg-white border-2 border-gray-800 text-gray-900 rounded-tl-xl rounded-br-xl w-40 py-1 text-sm font-semibold text-center">Add to cart</a>
                            <?php
                            } else {
                            ?>
                                <h1 class="bg-white border-2 border-gray-800 text-red-600 rounded-tl-xl rounded-br-xl w-40 py-1 text-sm font-semibold text-center cursor-not-allowed select-none">Out of stock</h1>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopNest</title>

    <!-- Include Splide CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- alpinejs CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js" defer></script>


    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="src/logo/favIcon.svg">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- splide link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js" defer></script>


    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        .custom-hover-bg {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .custom-hover-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: inherit;
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease-in-out;
            z-index: 0;
        }

        .card:hover {
            box-shadow: 1px 1px 10px #4b5563;
            /* card shadow transition */
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 0.2s;
        }

        .custom-hover-bg:hover::before {
            transform: scale(1.05);
        }

        .custom-hover-bg>div {
            position: relative;
            z-index: 1;
        }

        .splide__slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .style-2::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e6e6e6;
        }

        .style-2::-webkit-scrollbar {
            width: 12px;
            height: 5px;
            background-color: #F5F5F5;
        }

        .style-2::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #bfbfbf;
        }

        .cursor-not-allowed {
            cursor: not-allowed;
        }
    </style>

</head>

<body class="<?php echo isset($_COOKIE['latitude']) && isset($_COOKIE['longitude']) ? '' : 'overflow-hidden' ?>">

    <!-- navbar -->
    <?php
    include "pages/_navbar.php";
    ?>
    <div id="main-content" class="p-4 flex flex-col max-w-screen-xl m-auto outfit">
        <div class="flex justify-center">
            <div class="style-2 flex overflow-x-auto xl:justify-center gap-9 text-sm py-5 px-6">
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Furniture">
                        <img class="rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/FurnitureImage.webp" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Furniture</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Electronics Item">
                        <img class="rounded-full object-cover object-center transform transition-all group-hover:ring-2 h-24 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/ElectronicsImage.jpg" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Electronics</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Headphone">
                        <img class="rounded-full object-cover transform transition-all group-hover:ring-2 h-24 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/HeadphoneImage.jpg" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Headphone</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Stationery">
                        <img class="rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/StationeryImage.avif" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Stationery</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Toys">
                        <img class="rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/ToysImage.webp" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Toys</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Sports">
                        <img class="rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/SportsImage.webp" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Sports</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Phones">
                        <img class="rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/PhoneImage.webp" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Phones</span>
                    </a>
                </div>
                <div class="group">
                    <a class="flex justify-center flex-col gap-y-2 w-24" href="pages/product_category.php?Category=Women accessories">
                        <img class="rounded-full object-cover transform transition-all group-hover:ring-2 h-24 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/BeautyImage.avif" alt="">
                        <span class="text-center text-ellipsis overflow-hidden truncate group-hover:text-gray-600 transition-colors">Beauty & Heathy</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Swiper -->
        <div class="swiper mySwiper w-full h-[12rem] md:h-[22rem] xl:h-[28rem] rounded-lg mt-3">
            <div class="swiper-wrapper">
                <div class="swiper-slide flex items-center justify-center">
                    <img class="relative w-full h-full rounded-md object-cover" src="https://i.pinimg.com/originals/db/12/fe/db12fea16a6836ac1a7580921983fa06.jpg" alt="">
                    <div class="bg-gradient-to-r from-black/95 to-black/10 h-full absolute bottom-4 left-0 px-7 md:px-20 top-0 max-w-max flex justify-center flex-col gap-1 text-white">
                        <h1 class="text-base md:text-3xl font-bold">Timeless elegance awaits</h1>
                        <p class="text-sm md:text-lg font-normal my-2 w-full md:w-[60%]">Discover the perfect watch to elevate your style and keep you on time.</p>
                        <a href="pages/product_category.php?Category=Watch" class="bg-gray-600 text-white text-sm md:text-base py-1 px-2 md:py-2 md:px-5 rounded-tl-xl rounded-br-xl max-w-max font-semibold tracking-wider">Click here</a>
                    </div>
                </div>
                <div class="swiper-slide flex items-center justify-center">
                    <img class="relative w-full h-full rounded-md object-cover" src="https://rog.asus.com/Microsite/ROG-X-INTEL-UNLEASH-THE-LEGEND-INSIDE/in/assets/img/list/ROG-STRIX-SCAR-15-17.jpg" alt="">
                    <div class="bg-gradient-to-r from-black/95 to-black/10 h-full absolute bottom-4 left-0 px-7 md:px-20 top-0 max-w-max flex justify-center flex-col gap-1 text-white">
                        <h1 class="text-base md:text-3xl font-bold">Unleash your productivity</h1>
                        <p class="text-sm md:text-lg font-normal my-2 w-full md:w-[60%]">Experience unparalleled performance and style with our cutting-edge laptops.</p>
                        <a href="pages/product_category.php?Category=Laptops/MacBook" class="bg-gray-600 text-white text-sm md:text-base py-1 px-2 md:py-2 md:px-5 rounded-tl-xl rounded-br-xl max-w-max font-semibold tracking-wider">Click here</a>
                    </div>
                </div>
                <div class="swiper-slide flex items-center justify-center">
                    <img class="relative w-full h-full rounded-md object-cover" src="https://global.hisense.com/dam/jcr:3beab097-18ec-497a-acef-b5660937c0fb/uled-8k-tv-u80g-banner.jpg" alt="">
                    <div class="bg-gradient-to-r from-black/95 h-full absolute bottom-4 left-0 px-7 md:px-20 top-0 max-w-max flex justify-center flex-col gap-1 text-white">
                        <h1 class="text-base md:text-3xl font-bold">Elevate your viewing experience</h1>
                        <p class="text-sm md:text-lg font-normal my-2 w-full md:w-[60%]">Immerse yourself in stunning clarity and vibrant colors with our latest TVs.</p>
                        <a href="pages/product_category.php?Category=TV" class="bg-gray-600 text-white text-sm md:text-base py-1 px-2 md:py-2 md:px-5 rounded-tl-xl rounded-br-xl max-w-max font-semibold tracking-wider">Click here</a>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="bg-white rounded-full previous-button w-8 h-8 z-50 absolute top-[50%] text-center flex items-center justify-center left-3">
                    <svg class="w-4 h-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 492 492" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M198.608 246.104 382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                </div>
                <div class="bg-white rounded-full next-button w-8 h-8 z-50 absolute top-[50%] text-center flex items-center justify-center right-3">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>


        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper(".mySwiper", {
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".next-button",
                    prevEl: ".previous-button",
                },
                on: {
                    init: function() {
                        updateNavButtons(this);
                    },
                    slideChange: function() {
                        updateNavButtons(this);
                    }
                }
            });

            function updateNavButtons(swiperInstance) {
                const prevButton = document.querySelector(".previous-button");
                const nextButton = document.querySelector(".next-button");

                // Handle 'prev' button state
                if (swiperInstance.isBeginning) {
                    prevButton.classList.add("opacity-50");
                    prevButton.classList.remove("cursor-pointer");
                    prevButton.setAttribute("disabled", "true");
                    prevButton.style.cursor = "not-allowed"; // Add this line to change the cursor
                } else {
                    prevButton.classList.remove("opacity-50");
                    prevButton.classList.add("cursor-pointer");
                    prevButton.removeAttribute("disabled");
                    prevButton.style.cursor = "pointer"; // Reset to pointer when enabled
                }

                // Handle 'next' button state
                if (swiperInstance.isEnd) {
                    nextButton.classList.add("opacity-50");
                    nextButton.classList.remove("cursor-pointer");
                    nextButton.setAttribute("disabled", "true");
                    nextButton.style.cursor = "not-allowed"; // Add this line to change the cursor
                } else {
                    nextButton.classList.remove("opacity-50");
                    nextButton.classList.add("cursor-pointer");
                    nextButton.removeAttribute("disabled");
                    nextButton.style.cursor = "pointer"; // Reset to pointer when enabled
                }
            }
        </script>




        <!-- card splide 1 -->
        <section class="swiper-container mySwiper1 relative px-3 overflow-hidden mt-5">
            <h1 class="text-2xl">You might also like</h1>
            <div class="swiper-wrapper mt-5">
                <?php
                // Ensure that each product is wrapped in a 'swiper-slide' div
                displayRandomProducts($con, 10); // Example function to display products
                ?>
            </div>

            <div class="w-full absolute top-[50%]">
                <button class="bg-gray-300 rounded-full prev-button-swiper1 w-8 h-8 z-50 absolute left-0 text-center flex items-center justify-center">
                    <svg class="w-4 h-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 492 492" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M198.608 246.104 382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                </button>
                <button class="bg-gray-300 rounded-full next-button-swiper1 w-8 h-8 z-50 absolute right-6 text-center flex items-center justify-center ">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var swiper = new Swiper(".mySwiper1", {
                    autoplay: false,
                    navigation: {
                        nextEl: ".next-button-swiper1",
                        prevEl: ".prev-button-swiper1",
                    },
                    slidesPerView: 1,
                    slidesPerGroup: 1, // Move one slide at a time
                    spaceBetween: 15,
                    breakpoints: {
                        1125: { // For 1125px and above
                            slidesPerView: 4,
                            spaceBetween: 25,
                        },
                        825: { // For 825px to 1124px
                            slidesPerView: 3,
                            spaceBetween: 25,
                        },
                        630: { // For 630px to 824px
                            slidesPerView: 2,
                            spaceBetween: 25,
                        },
                    },
                    on: {
                        init: function() {
                            // Short delay to ensure Swiper fully initializes
                            setTimeout(() => {
                                updateNavButtons(this); // Check buttons status on init
                            }, 100);
                        },
                        slideChange: function() {
                            updateNavButtons(this); // Update buttons on slide change
                        },
                    },
                });

                // Function to update button states based on swiper status
                function updateNavButtons(swiperInstance) {
                    const prevButton = document.querySelector(".prev-button-swiper1");
                    const nextButton = document.querySelector(".next-button-swiper1");

                    // Handle 'prev' button state
                    if (swiperInstance.isBeginning) {
                        prevButton.classList.add("cursor-not-allowed", "opacity-50");
                        prevButton.classList.remove("cursor-pointer");
                        prevButton.setAttribute("disabled", "true");
                    } else {
                        prevButton.classList.remove("cursor-not-allowed", "opacity-50");
                        prevButton.classList.add("cursor-pointer");
                        prevButton.removeAttribute("disabled");
                    }

                    // Handle 'next' button state
                    if (swiperInstance.isEnd) {
                        nextButton.classList.add("cursor-not-allowed", "opacity-50");
                        nextButton.classList.remove("cursor-pointer");
                        nextButton.setAttribute("disabled", "true");
                    } else {
                        nextButton.classList.remove("cursor-not-allowed", "opacity-50");
                        nextButton.classList.add("cursor-pointer");
                        nextButton.removeAttribute("disabled");
                    }
                }
            });
        </script>





        <!-- tranding deals -->
        <div class="mt-12">
            <h1 class="text-2xl w-full">Trending deals</h1>
            <div class="style-2 flex overflow-x-scroll xl:overflow-hidden gap-8 py-5">
                <a href="pages/product_category.php?Category=Game Item">
                    <div class="relative w-56 bg-[url('../src/categories_image/GamersImage.jpg')] text-center h-[22rem] bg-center bg-cover py-5 cursor-pointer custom-hover-bg rounded">
                        <div>
                            <div class="relative">
                                <h1 class="text-[#36e318] text-center text-xs font-semibold">LIMITED TIME OFFER</h1>
                                <span class="flex justify-center my-3">
                                    <svg class="w-32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 81 32">
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M11.084 3.833v7.741h6.407v-4.283h1.961v6.128h-10.329v-11.431h10.329v1.845h-8.368z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M31.7 1.988v11.438h-1.961v-4.623h-6.407v4.623h-1.954v-11.438h10.322zM29.74 6.952v-3.118h-6.407v3.118h6.407z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M46.393 1.988h1.961v11.438h-1.961v-8.613l-4.099 4.317 2.975 3.118-1.341 1.368-2.928-3.091-2.941 3.091-1.341-1.375 2.975-3.118-4.099-4.317v8.613h-1.961v-11.431h1.961l5.406 5.719 5.392-5.719z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M60.003 3.833h-7.762v2.792h7.666v1.845h-7.666v3.105h7.762v1.845h-9.723v-11.431h9.723v1.845z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M69.644 3.833h-6.291v9.593h-1.961v-11.438h10.213v6.536h-1.961v-4.691zM66.832 6.856l5.263 5.392-1.355 1.369-5.263-5.392 1.355-1.369z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M28.14 18.328v5.426l-6.257 6.012h-4.364v-11.438h10.621zM26.179 22.965v-2.791h-6.7v7.741h1.539l5.161-4.95z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M40.116 18.328v11.438h-1.961v-4.623h-6.407v4.623h-1.961v-11.438h10.329zM38.155 23.292v-3.118h-6.407v3.118h6.407z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M51.867 18.131l1.355 1.375-10.179 10.451-1.341-1.375 4.214-4.33-4.609-4.752 1.341-1.375 4.609 4.739 4.609-4.732z"></path>
                                        <path fill="#36e318" style="fill: var(--color2, #36e318)" d="M63.503 20.174h-7.714v2.73h7.714v6.863h-9.675v-1.852h7.714v-3.173h-7.714v-6.42h9.675v1.852z"></path>
                                    </svg>
                                </span>
                                <p class="text-[#36e318] text-center underline underline-offset-4 text-sm">Shop now</p>
                            </div>
                        </div>
                    </div>
                </a>


                <a href="pages/product_category.php?Category=TV">
                    <div class="relative w-56 bg-[url('../src/categories_image/TvImage.jpg')] text-center h-[22rem] bg-center bg-cover py-5 cursor-pointer custom-hover-bg rounded">
                        <div>
                            <div class="relative">
                                <h1 class="text-black text-center text-xs font-semibold">BEST TV DEALS</h1>
                                <span class="flex justify-center my-3">
                                    <svg class="w-32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 81 32">
                                        <path d="M24.579 12.957v-11.391h2.24l5.46 7.074v-7.074h2.437v11.391h-2.056l-5.644-7.271v7.271h-2.437z"></path>
                                        <path d="M36.276 12.957v-11.391h7.775v2.288h-5.263v2.138h4.916v2.24h-4.916v2.437h5.379v2.288h-7.891z"></path>
                                        <path d="M46.604 3.105c1.191-1.144 2.628-1.716 4.317-1.716 1.682 0 3.118 0.572 4.296 1.716 1.191 1.144 1.784 2.533 1.784 4.18s-0.586 3.057-1.763 4.201c-1.178 1.13-2.614 1.702-4.317 1.702-1.682 0-3.118-0.572-4.317-1.702-1.178-1.144-1.763-2.546-1.763-4.201s0.586-3.037 1.763-4.18zM48.388 9.866c0.688 0.688 1.532 1.028 2.533 1.028 0.994 0 1.831-0.34 2.519-1.049 0.701-0.701 1.048-1.566 1.048-2.567 0-0.994-0.34-1.845-1.028-2.546-0.694-0.701-1.546-1.055-2.54-1.055s-1.845 0.361-2.533 1.062c-0.688 0.701-1.028 1.552-1.028 2.546-0.007 1.028 0.34 1.879 1.028 2.58z"></path>
                                        <path d="M22.046 20.119c1.192-1.144 2.648-1.716 4.33-1.716s3.105 0.572 4.283 1.716c1.178 1.13 1.763 2.519 1.763 4.167 0 1.389-0.477 2.614-1.423 3.677l1.049 1.226-1.682 1.423-1.096-1.273c-0.803 0.524-1.763 0.783-2.894 0.783-1.682 0-3.139-0.558-4.33-1.682-1.192-1.13-1.784-2.519-1.784-4.153 0-1.648 0.592-3.037 1.784-4.167zM27.67 27.574l-1.423-1.634 1.682-1.437 1.457 1.682c0.34-0.524 0.524-1.157 0.524-1.893 0-0.994-0.34-1.831-1.028-2.533s-1.518-1.062-2.499-1.062c-0.994 0-1.845 0.34-2.546 1.049-0.701 0.701-1.049 1.552-1.049 2.546s0.34 1.845 1.028 2.533c0.701 0.667 1.552 1.014 2.567 1.014 0.497-0.007 0.926-0.088 1.287-0.266z"></path>
                                        <path d="M33.45 29.978v-11.391h2.519v9.103h4.446v2.288h-6.965z"></path>
                                        <path d="M41.294 29.978v-11.391h7.782v2.288h-5.263v2.138h4.916v2.24h-4.916v2.437h5.379v2.288h-7.898z"></path>
                                        <path d="M50.397 29.978v-11.391h4.317c1.927 0 3.418 0.524 4.46 1.586 1.062 1.049 1.586 2.417 1.586 4.133s-0.524 3.105-1.566 4.133c-1.028 1.028-2.519 1.539-4.46 1.539h-4.337zM52.909 27.69h1.648c2.683 0 3.663-1.294 3.663-3.384 0-1.062-0.279-1.913-0.831-2.519-0.538-0.606-1.484-0.912-2.846-0.912h-1.634v6.815z"></path>
                                    </svg>
                                </span>
                                <p class="text-black text-center underline underline-offset-4 text-sm">Shop now</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="pages/product_category.php?Category=Laptops/MacBook">
                    <div class="relative w-56 bg-[url('../src/categories_image/LaptopImage.jpg')] text-center h-[22rem] bg-center bg-cover py-5 cursor-pointer custom-hover-bg rounded">
                        <div>
                            <div class="relative">
                                <h1 class="text-black text-center text-xs font-semibold">NEW ARRIVALS</h1>
                                <span class="flex justify-center my-3">
                                    <svg class="w-32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 80 32">
                                        <path d="M26.12 13.267c-0.727 0-1.307-0.22-1.747-0.653-0.44-0.44-0.653-1.020-0.653-1.747v-6.4c0-0.727 0.22-1.307 0.653-1.747 0.44-0.44 1.020-0.653 1.747-0.653h6.080v2.080l-0.88 0.96h-3.92v5.12h1.6v-3.36h3.68v6.4h-6.56z"></path>
                                        <path d="M42.92 4.147l-0.96 0.96h-3.84v1.12h3.2v2.88h-3.2v1.12h4.8v3.040h-8.48v-11.2h8.48v2.080z"></path>
                                        <path d="M43.48 2.067h9.12v2.24l-0.96 0.96h-1.76v8h-3.68v-8h-2.72v-3.2z"></path>
                                        <path d="M3.8 29.933v-11.2h3.68v11.2h-3.68z"></path>
                                        <path d="M14.84 29.933l-1.92-4.96h-0.16l0.32 3.36v1.6h-3.68v-11.2h3.84l1.92 4.96h0.16l-0.32-3.36v-1.6h3.68v11.2h-3.84z"></path>
                                        <path d="M20.12 21.133c0-0.727 0.22-1.307 0.653-1.747 0.44-0.44 1.020-0.653 1.747-0.653h6.080v2.080l-0.96 0.96h-3.84v0.72l2.88 0.56c0.64 0.127 1.173 0.413 1.6 0.867 0.427 0.447 0.64 1.013 0.64 1.693v1.92c0 0.727-0.22 1.307-0.653 1.747-0.44 0.44-1.020 0.653-1.747 0.653h-6.4v-3.040h5.12v-0.88l-2.88-0.56c-0.64-0.127-1.173-0.413-1.6-0.867s-0.64-1.013-0.64-1.693v-1.76z"></path>
                                        <path d="M30.36 29.933v-11.2h6.72c0.727 0 1.307 0.22 1.747 0.653s0.653 1.020 0.653 1.747v3.36c0 0.727-0.22 1.307-0.653 1.747-0.44 0.44-1.020 0.653-1.747 0.653h-3.040v3.040h-3.68zM34.040 21.773v2.080h1.76v-2.080h-1.76z"></path>
                                        <path d="M40.92 29.933v-11.2h3.68v11.2h-3.68z"></path>
                                        <path d="M46.52 29.933v-11.2h6.72c0.727 0 1.307 0.22 1.747 0.653 0.44 0.44 0.653 1.020 0.653 1.747v2.72c0 0.36-0.067 0.667-0.2 0.913s-0.28 0.44-0.44 0.593c-0.193 0.173-0.407 0.307-0.64 0.413l1.6 2.56v1.6h-3.68l-1.36-3.68h-0.72v3.68h-3.68zM50.2 21.773v1.44h1.76v-1.44h-1.76z"></path>
                                        <path d="M65.88 20.813l-0.96 0.96h-3.84v1.12h3.2v2.88h-3.2v1.12h4.8v3.040h-8.48v-11.2h8.48v2.080z"></path>
                                        <path d="M76.2 27.533c0 0.727-0.22 1.307-0.653 1.747s-1.020 0.653-1.747 0.653h-6.56v-11.2h6.56c0.727 0 1.307 0.22 1.747 0.653s0.653 1.020 0.653 1.747v6.4zM70.92 21.773v5.12h1.6v-5.12h-1.6z"></path>
                                    </svg>
                                </span>
                                <p class="text-black text-center underline underline-offset-4 text-sm">Shop now</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="pages/product_category.php?Category=Kitchen">
                    <div class="relative w-56 bg-[url('../src/categories_image/KitchenImage.webp')] text-center h-[22rem] bg-center bg-cover py-5 cursor-pointer custom-hover-bg rounded">
                        <div>
                            <div class="relative text-gray-300">
                                <h1 class="text-center text-xs font-semibold">KITCHEN</h1>
                                <span class="flex justify-center my-2">
                                    <h1 class="text-xl uppercase font-bold">Cooking made catchy.</h1>
                                </span>
                                <p class="text-gray-300 text-center underline underline-offset-4 text-sm">Shop now</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="pages/product_category.php?Category=Clothes">
                    <div class="relative w-56 bg-[url('../src/categories_image/FashionImage.webp')] text-center h-[22rem] bg-center bg-cover py-5 cursor-pointer custom-hover-bg rounded">
                        <div>
                            <div class="relative text-[#9d1244]">
                                <h1 class="text-center text-xs font-semibold">CLOTHING</h1>
                                <span class="flex justify-center my-2">
                                    <h1 class="text-xl uppercase font-bold line-clamp-2 w-32">DREAM FASHION</h1>
                                </span>
                                <p class="text-center underline underline-offset-4 text-sm">Shop now</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <!-- card splide 2 -->
        <section class="swiper-container mySwiper2 relative px-3 overflow-hidden mt-5">
            <h1 class="text-2xl">You might also like</h1>
            <div class="swiper-wrapper mt-5">
                <?php
                // Ensure that each product is wrapped in a 'swiper-slide' div
                displayRandomProducts($con, 10); // Example function to display products
                ?>
            </div>

            <div class="w-full absolute top-[50%]">
                <button class="bg-gray-300 rounded-full prev-button-swiper2 w-8 h-8 z-50 absolute left-0 text-center flex items-center justify-center">
                    <svg class="w-4 h-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 492 492" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M198.608 246.104 382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                </button>
                <button class="bg-gray-300 rounded-full next-button-swiper2 w-8 h-8 z-50 absolute right-6 text-center flex items-center justify-center ">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var swiper = new Swiper(".mySwiper2", {
                    autoplay: false,
                    navigation: {
                        nextEl: ".next-button-swiper2",
                        prevEl: ".prev-button-swiper2",
                    },
                    slidesPerView: 1,
                    slidesPerGroup: 1, // Move one slide at a time
                    spaceBetween: 15,
                    breakpoints: {
                        1125: { // For 1125px and above
                            slidesPerView: 4,
                            spaceBetween: 25,
                        },
                        825: { // For 825px to 1124px
                            slidesPerView: 3,
                            spaceBetween: 25,
                        },
                        630: { // For 630px to 824px
                            slidesPerView: 2,
                            spaceBetween: 25,
                        },
                    },
                    on: {
                        init: function() {
                            // Short delay to ensure Swiper fully initializes
                            setTimeout(() => {
                                updateNavButtons(this); // Check buttons status on init
                            }, 100);
                        },
                        slideChange: function() {
                            updateNavButtons(this); // Update buttons on slide change
                        },
                    },
                });

                // Function to update button states based on swiper status
                function updateNavButtons(swiperInstance) {
                    const prevButton = document.querySelector(".prev-button-swiper2");
                    const nextButton = document.querySelector(".next-button-swiper2");

                    // Handle 'prev' button state
                    if (swiperInstance.isBeginning) {
                        prevButton.classList.add("cursor-not-allowed", "opacity-50");
                        prevButton.classList.remove("cursor-pointer");
                        prevButton.setAttribute("disabled", "true");
                    } else {
                        prevButton.classList.remove("cursor-not-allowed", "opacity-50");
                        prevButton.classList.add("cursor-pointer");
                        prevButton.removeAttribute("disabled");
                    }

                    // Handle 'next' button state
                    if (swiperInstance.isEnd) {
                        nextButton.classList.add("cursor-not-allowed", "opacity-50");
                        nextButton.classList.remove("cursor-pointer");
                        nextButton.setAttribute("disabled", "true");
                    } else {
                        nextButton.classList.remove("cursor-not-allowed", "opacity-50");
                        nextButton.classList.add("cursor-pointer");
                        nextButton.removeAttribute("disabled");
                    }
                }
            });
        </script>

        <div class="my-5 mt-12">
            <h1 class="text-2xl">Explore more categories</h1>
            <div class="flex justify-center w-full">
                <div class="style-2 flex overflow-x-auto gap-10 py-5 px-2">
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Men accessories">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/MenaccessoriesImage.webp" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">Men accessories</p>
                        </a>
                    </div>
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Tabs/Ipad">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/IpadImage.webp" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">iPads & Tablets</p>
                        </a>
                    </div>
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Earphone">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3 border-2" src="../src/categories_image/EarphoneImage.jpg" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">Earphones</p>
                        </a>
                    </div>
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Cameras">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/CameraImage.webp" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">Cameras</p>
                        </a>
                    </div>
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Watch">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/WatchImage.webp" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">Wearable tech</p>
                        </a>
                    </div>
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Shoes">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/ShoesImage.webp" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">Shoes</p>
                        </a>
                    </div>
                    <div class="group">
                        <a class="flex flex-col items-center space-y-2 w-32" href="pages/product_category.php?Category=Tech Accessories">
                            <img class="w-32 h-32 object-cover object-top rounded-full transform transition-all group-hover:ring-2 group-hover:ring-gray-500 group-hover:-translate-y-3" src="../src/categories_image/TechImage.webp" alt="">
                            <p class="text-center group-hover:text-gray-600 transition-colors">Accessories</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- card splide 3 -->
        <section class="swiper-container mySwiper3 relative px-3 overflow-hidden mt-5">
            <h1 class="text-2xl">You might also like</h1>
            <div class="swiper-wrapper mt-5">
                <?php
                // Ensure that each product is wrapped in a 'swiper-slide' div
                displayRandomProducts($con, 10); // Example function to display products
                ?>
            </div>

            <div class="w-full absolute top-[50%]">
                <button class="bg-gray-300 rounded-full prev-button-swiper3 w-8 h-8 z-50 absolute left-0 text-center flex items-center justify-center">
                    <svg class="w-4 h-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 492 492" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M198.608 246.104 382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                </button>
                <button class="bg-gray-300 rounded-full next-button-swiper3 w-8 h-8 z-50 absolute right-6 text-center flex items-center justify-center ">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </section>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var swiper = new Swiper(".mySwiper3", {
                    autoplay: false,
                    navigation: {
                        nextEl: ".next-button-swiper3",
                        prevEl: ".prev-button-swiper3",
                    },
                    slidesPerView: 1,
                    slidesPerGroup: 1, // Move one slide at a time
                    spaceBetween: 15,
                    breakpoints: {
                        1125: { // For 1125px and above
                            slidesPerView: 4,
                            spaceBetween: 15,
                        },
                        825: { // For 825px to 1124px
                            slidesPerView: 3,
                            spaceBetween: 15,
                        },
                        630: { // For 630px to 824px
                            slidesPerView: 2,
                            spaceBetween: 0,
                        },
                    },
                    on: {
                        init: function() {
                            // Short delay to ensure Swiper fully initializes
                            setTimeout(() => {
                                updateNavButtons(this); // Check buttons status on init
                            }, 100);
                        },
                        slideChange: function() {
                            updateNavButtons(this); // Update buttons on slide change
                        },
                    },
                });

                // Function to update button states based on swiper status
                function updateNavButtons(swiperInstance) {
                    const prevButton = document.querySelector(".prev-button-swiper3");
                    const nextButton = document.querySelector(".next-button-swiper3");

                    // Handle 'prev' button state
                    if (swiperInstance.isBeginning) {
                        prevButton.classList.add("cursor-not-allowed", "opacity-50");
                        prevButton.classList.remove("cursor-pointer");
                        prevButton.setAttribute("disabled", "true");
                    } else {
                        prevButton.classList.remove("cursor-not-allowed", "opacity-50");
                        prevButton.classList.add("cursor-pointer");
                        prevButton.removeAttribute("disabled");
                    }

                    // Handle 'next' button state
                    if (swiperInstance.isEnd) {
                        nextButton.classList.add("cursor-not-allowed", "opacity-50");
                        nextButton.classList.remove("cursor-pointer");
                        nextButton.setAttribute("disabled", "true");
                    } else {
                        nextButton.classList.remove("cursor-not-allowed", "opacity-50");
                        nextButton.classList.add("cursor-pointer");
                        nextButton.removeAttribute("disabled");
                    }
                }
            });
        </script>

        <!-- partner -->
        <div class="w-full flex flex-col items-center mt-12 mb-8">
            <h1 class="text-2xl mt-3">Trending brands</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-x-20 gap-y-10 px-10">
                <!-- asus -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Asus">
                        <img src="src/company_partner/asus.svg" alt="">
                    </a>
                </div>

                <!-- sony -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Sony">
                        <img src="src/company_partner/sony.svg" alt="">
                    </a>
                </div>

                <!-- canon -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Canon">
                        <img src="src/company_partner/canon.svg" alt="">
                    </a>
                </div>

                <!-- casio -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Casio">
                        <img src="src/company_partner/casio.svg" alt="">
                    </a>
                </div>

                <!-- Bose -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Bose">
                        <img src="src/company_partner/bose.svg" alt="">
                    </a>
                </div>

                <!-- hyperX -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=HyperX">
                        <img class="pt-2" src="src/company_partner/hyperx.svg" alt="">
                    </a>
                </div>

                <!-- citizen -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=citizen">
                        <img class="pt-1" src="src/company_partner/citizen.svg" alt="">
                    </a>
                </div>

                <!-- puma -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Puma">
                        <img src="src/company_partner/puma.svg" alt="">
                    </a>
                </div>

                <!-- msi -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Msi">
                        <img class="pt-1" src="src/company_partner/msi.svg" alt="">
                    </a>
                </div>

                <!-- louis philippe -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Louis Philippe">
                        <img src="src/company_partner/louisphilippe.svg" alt="">
                    </a>
                </div>

                <!-- lenovo -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=Lenovo">
                        <img src="src/company_partner/lenovo.svg" alt="">
                    </a>
                </div>

                <!-- nvidia -->
                <div class="cursor-pointer">
                    <a href="pages/brands_products.php?brandName=nvidia">
                        <img src="src/company_partner/nvidia.svg" alt="">
                    </a>
                </div>
            </div>
        </div>

    </div>


    <div x-data="{ showLocation: false }" class="<?php echo isset($_COOKIE['latitude']) && isset($_COOKIE['longitude']) ? 'hidden' : '' ?>">
        <div id="locationPopup" class="fixed top-0 bg-black/30 backdrop-blur-md h-full w-full z-50">
            <div class="fixed top-7 left-5 bg-white rounded-lg p-3 w-72 space-y-5 z-50">
                <div class="flex items-center gap-3">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-7">
                            <g>
                                <path d="M256 0C166.035 0 91 72.47 91 165c0 35.202 10.578 66.592 30.879 96.006l121.494 189.58c5.894 9.216 19.372 9.198 25.254 0l122.021-190.225C410.512 232.28 421 199.307 421 165 421 74.019 346.981 0 256 0zm0 240c-41.353 0-75-33.647-75-75s33.647-75 75-75 75 33.647 75 75-33.647 75-75 75z" fill="currentColor" opacity="1" data-original="#000000"></path>
                                <path d="m373.264 344.695-75.531 118.087c-19.551 30.482-64.024 30.382-83.481.029l-75.654-118.085C72.034 360.116 31 388.309 31 422c0 58.462 115.928 90 225 90s225-31.538 225-90c0-33.715-41.091-61.923-107.736-77.305z" fill="currentColor" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="text-sm">To deliver as quickly as possible, we would like your current location</span>
                </div>
                <div class="w-full flex flex-col space-y-3">
                    <a href="pages/map.php" id="manualLocationBtn" @click="showLocation = true" class=" flex items-center justify-center gap-2 rounded-tl-lg rounded-br-lg py-1.5 bg-gray-300 text-gray-700 px-3 cursor-pointer">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-6 mt-0.5">
                                <g>
                                    <path d="M28 7H4c-2.201 0-3 1.794-3 3v12c0 2.201 1.794 3 3 3h24c2.201 0 3-1.794 3-3V10c0-2.201-1.794-3-3-3zm1 14.988c-.012.462-.194 1.012-1 1.012H4.012C3.55 22.988 3 22.806 3 22V10.012C3.012 9.55 3.195 9 4 9h23.988c.462.012 1.012.195 1.012 1zM9 19h14v2H9zm16 0h2v2h-2zm0-4h2v2h-2zm-4 0h2v2h-2zm-2 2h-2v-2h2zm-4 0h-2v-2h2zm-4 0H9v-2h2zm-6-2h2v2H5zm0 4h2v2H5zm20-8h2v2h-2zm-4 0h2v2h-2zm-2 2h-2v-2h2zm-4 0h-2v-2h2zm-4 0H9v-2h2zm-6-2h2v2H5z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                                </g>
                            </svg>
                        </span>
                        <span>
                            Type Manually
                        </span>
                    </a>
                    <a id="currentLocation" class="flex items-center justify-center gap-2 rounded-tl-lg rounded-br-lg py-1.5 bg-pink-300 text-pink-700 px-3 cursor-pointer" href="#">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 469.333 469.333" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-5">
                                <g>
                                    <path d="M234.667 149.333c-47.147 0-85.333 38.187-85.333 85.333S187.52 320 234.667 320 320 281.813 320 234.667s-38.187-85.334-85.333-85.334zm190.72 64C415.573 124.373 344.96 53.76 256 43.947V0h-42.667v43.947C124.373 53.76 53.76 124.373 43.947 213.333H0V256h43.947c9.813 88.96 80.427 159.573 169.387 169.387v43.947H256v-43.947C344.96 415.573 415.573 344.96 425.387 256h43.947v-42.667h-43.947zM234.667 384c-82.453 0-149.333-66.88-149.333-149.333s66.88-149.333 149.333-149.333S384 152.213 384 234.667 317.12 384 234.667 384z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                </g>
                            </svg>
                        </span>
                        <span>
                            Current Location
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentLocation = document.getElementById('currentLocation');

        currentLocation.addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    console.log("lat: ", lat);
                    console.log("lng: ", lng);

                    fetch('pages/set_location.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'latitude=' + lat + '&longitude=' + lng,
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            location.reload();
                        })
                        .catch(error => console.error('Error:', error));

                }, function(error) {
                    alert('Could not get location. Please allow location access in your browser settings.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });
    </script>

    <div style="display: none;" class="w-full h-[100vh] fixed top-0 bg-white z-50 flex flex-col items-center justify-center px-5 gap-y-4" id="chooseLocation">
        <span>
            <img class="w-96" src="src/logo/longDistance.svg" alt="">
        </span>
        <span class="space-y-3">
            <h1 class="text-2xl text-center">Sit Tight! We're Comming Soon!</h1>
            <p class="text-center">Our team is working tirelessly to bring faster deliveries to your location.</p>
        </span>
        <span>
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-tl-lg rounded-br-lg font-semibold flex items-center justify-center gap-2">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-5">
                        <g>
                            <path d="M256 0C166.035 0 91 72.47 91 165c0 35.202 10.578 66.592 30.879 96.006l121.494 189.58c5.894 9.216 19.372 9.198 25.254 0l122.021-190.225C410.512 232.28 421 199.307 421 165 421 74.019 346.981 0 256 0zm0 240c-41.353 0-75-33.647-75-75s33.647-75 75-75 75 33.647 75 75-33.647 75-75 75z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                            <path d="m373.264 344.695-75.531 118.087c-19.551 30.482-64.024 30.382-83.481.029l-75.654-118.085C72.034 360.116 31 388.309 31 422c0 58.462 115.928 90 225 90s225-31.538 225-90c0-33.715-41.091-61.923-107.736-77.305z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                        </g>
                    </svg>
                </span>
                <span onclick="hideLocaionPopup()">
                    Choose Other Location
                </span>
            </button>
            <script>
                let chooseLocation = document.getElementById('chooseLocation');

                function hideLocaionPopup() {
                    window.location.href = "";
                    chooseLocation.style.display = 'none';
                }
            </script>
            <?php
            if ($nearLocation == true) {
            ?>
                <script>
                    chooseLocation = document.getElementById('chooseLocation');
                    chooseLocation.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                </script>
            <?php
            }
            ?>
        </span>
    </div>

    <!-- footer -->
    <?php
    include "pages/_footer.php";
    ?>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>