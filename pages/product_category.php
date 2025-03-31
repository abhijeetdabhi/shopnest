<?php
if (!isset($_GET['Category'])) {
    header("Location: ../index.php");
    exit;
}

if(isset($_COOKIE['vendor_id'])){
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}

if(isset($_COOKIE['adminEmail'])){
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<?php
session_start();

if (isset($_GET['sort'])) {
    $_SESSION['sort'] = $_GET['sort'];
}

$selected = isset($_SESSION['sort']) ? $_SESSION['sort'] : 'All';
?>

<?php
include "../include/connect.php";

if (isset($_SESSION['searchWord'])) {
    unset($_SESSION['searchWord']);
}

if (isset($_SESSION['selectedSize'])) {
    unset($_SESSION['selectedSize']);
}
$Category = $_GET['Category'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($Category) ? $Category : 'Product Categorys' ?></title>

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
    <link rel="shortcut icon" href="/src/logo/favIcon.svg">

    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        .card:hover {
            box-shadow: 1px 1px 10px #4b5563;
            /* card shadow transition */
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 0.2s;
        }

        .opacityTransition {
            transition: opacity 0.4s ease;
        }

        [x-cloak] {
            display: none;
        }

        @keyframes openFilterSidebar {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .filter-sidebar-open {
            animation: openFilterSidebar 0.4s ease-in-out;
        }

        @keyframes closeFilterSidebar {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .filter-sidebar-close {
            animation: closeFilterSidebar 0.4s ease-in-out;
        }

        .sidebarScroll::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e6e6e6;
        }

        .sidebarScroll::-webkit-scrollbar {
            width: 6px;
            height: 5px;
            background-color: #F5F5F5;
        }

        .sidebarScroll::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #bfbfbf;
        }


        .product-card {
            display: none;
            /* Hide all cards initially */
            box-sizing: border-box;
            /* Include padding and border in the element's total width and height */
        }

        .pagination-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-btn {
            padding: 0 0.5rem;
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .pagination-btn.active {
            background-color: #0066ff;
            color: #ffffff;
        }

        .arrow-button button {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Only apply styles to buttons with the pagination-button class */
        .pagination-button:disabled {
            cursor: not-allowed;
            /* Indicate the button is not clickable */
            opacity: 0.5;
            /* Dim the appearance */
            pointer-events: none;
            /* Ensure no interactions */
        }
    </style>

    <script>
        function filterSideBarOpen() {
            // $("#sidebarContainer").addClass('block');
            activePopup = 'filterSidebarContainer';
            let sidebarContainer = $('#filterSidebarContainer');
            sidebarContainer.show();
            sidebarContainer.addClass('filter-sidebar-open');

            $('body').css('overflowY', 'hidden');

            $('#header, #main-content, #topBar').addClass('disabled-content opacityTransition');

            event.preventDefault();
        }

        // close sidebarContainer using Esc key
        $(document).keydown(function(event) {
            if (event.key === 'Escape') {
                if (activePopup === 'filterSidebarContainer') {
                    filterSideBarClose();
                }
            }
        });

        function filterSideBarClose() {
            let closeSidebar = $('#filterSidebarContainer');
            closeSidebar.addClass('filter-sidebar-close');

            $('body').css('overflow', 'visible');

            $('#header, #main-content, #topBar').removeClass('disabled-content');

            setTimeout(function() {
                closeSidebar.removeClass('filter-sidebar-close').hide();
            }, 300);
            // $('body').fadeTo(800,1);   
        }
    </script>
</head>

<body class="outfit">
    <?php
    include "../pages/_navbar.php";
    ?>
    <div class="px-3 sm:px-16 outfit mt-5" id="main-content">
        <div class="flex justify-between items-center border-b-2 border-gray-300 pb-3">
            <div>
                <h1 class="text-lg sm:text-3xl text-gray-800"><?php echo isset($Category) ? $Category : 'Product Categorys' ?></h1>
            </div>
            <div class="flex gap-2 relative">
                <div x-data="{ open: false, selected: '<?php echo $selected; ?>' }" class="relative inline-block text-sm text-gray-800">
                    <!-- Dropdown Button -->
                    <button @click="open = !open" class="w-fit focus:outline-none cursor-pointer">
                        <span x-text="selected"></span>
                        <svg class="inline w-5 h-5 ml-2" fill="none" stroke="#808080" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @keydown.escape.window="open = false" @click.outside="open = false" class="transition absolute right-0 mt-2 w-40 bg-white border-2 border-gray-300 text-gray-700 rounded-xl shadow-lg z-10 overflow-hidden text-sm divide-y-2 divide-gray-300" x-cloak>
                        <!-- Loop through options and render each one -->
                        <a @click="selected = 'All'; open = false; window.location.href = `?Category=<?php echo $Category; ?>&sort=All`" class="block px-4 py-2 hover:bg-gray-200 cursor-pointer">All</a>
                        <a @click="selected = 'Most Popular'; open = false; window.location.href = `?Category=<?php echo $Category; ?>&sort=Most Popular`" class="block px-4 py-2 hover:bg-gray-200 cursor-pointer">Most Popular</a>
                        <a @click="selected = 'Best Rating'; open = false; window.location.href = `?Category=<?php echo $Category; ?>&sort=Best Rating`" class="block px-4 py-2 hover:bg-gray-200 cursor-pointer">Best Rating</a>
                        <a @click="selected = 'Newest'; open = false; window.location.href = `?Category=<?php echo $Category; ?>&sort=Newest`" class="block px-4 py-2 hover:bg-gray-200 cursor-pointer">Newest</a>
                        <a @click="selected = 'Low to High'; open = false; window.location.href = `?Category=<?php echo $Category; ?>&sort=Low to High`" class="block px-4 py-2 hover:bg-gray-200 cursor-pointer">Low to High</a>
                        <a @click="selected = 'High to Low'; open = false; window.location.href = `?Category=<?php echo $Category; ?>&sort=High to Low`" class="block px-4 py-2 hover:bg-gray-200 cursor-pointer">High to Low</a>
                    </div>
                </div>

                <!-- sidebar button -->
                <button onclick="filterSideBarOpen()" class="lg:hidden focus:outline-none">
                    <svg class="w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M53.39 8H10.61a5.61 5.61 0 0 0-4.15 9.38L25 37.77V57a2 2 0 0 0 1.13 1.8 1.94 1.94 0 0 0 .87.2 2 2 0 0 0 1.25-.44l3.75-3 6.25-5A2 2 0 0 0 39 49V37.77l18.54-20.39A5.61 5.61 0 0 0 53.39 8z" fill="#4b5563" opacity="1" data-original="#4b5563"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex jutify-center">
            <div class="mt-7 w-64 hidden lg:block">
                <form method="post" action="product_category.php?Category=<?php echo $Category ?>">
                    <!-- Price -->
                    <div class="border-b-2 border-gray-300 pb-4">
                        <h1 class="text-gray-800 font-medium text-sm">Price:</h1>
                        <div class="mt-3 text-gray-600">
                            <ul class="space-y-2 text-sm text-gray-800">
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="1000" name="price" id="under_1k">
                                    <label class="text-sm" for="under_1k">Under ₹1000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="5000" name="price" id="under_5k">
                                    <label class="text-sm" for="under_5k">Under ₹5000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="10000" name="price" id="under_10k">
                                    <label class="text-sm" for="under_10k">Under ₹10,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="30000" name="price" id="under_30k">
                                    <label class="text-sm" for="under_30k">Under ₹30,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="50000" name="price" id="under_50k">
                                    <label class="text-sm" for="under_50k">Under ₹50,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="100000" name="price" id="under_100k">
                                    <label class="text-sm" for="under_100k">Under ₹1,00,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="over_100k" name="price" id="over_100k">
                                    <label class="text-sm" for="over_100k">Over ₹1,00,000</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- color -->
                    <div class="border-b-2 border-gray-300 pb-4 mt-3">
                        <h1 class="text-gray-800 font-medium text-sm">Color:</h1>
                        <div class="mt-3 text-gray-600">
                            <ul class="space-y-2 text-gray-700">
                                <?php
                                $select_color = "SELECT * FROM products WHERE Category = '$Category'";
                                $color_query = mysqli_query($con, $select_color);

                                $color_array = [];

                                while ($row = mysqli_fetch_array($color_query)) {
                                    $colors = explode(",", $row["color"]);
                                    foreach ($colors as $clr) {
                                        $clr = trim($clr);
                                        if ($clr === '-' || empty($clr)) {
                                            continue;
                                        }
                                        if (!empty($clr) && !in_array($clr, $color_array)) {
                                            $color_array[] = $clr;
                                        }
                                    }
                                }

                                sort($color_array);

                                foreach ($color_array as $clr) {
                                    $checkbox_id = 'color_' . $clr;
                                ?>
                                    <li class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700"
                                            name="color[]"
                                            id="<?php echo $checkbox_id; ?>"
                                            value="<?php echo $clr; ?>">
                                        <label class="text-sm" for="<?php echo $checkbox_id; ?>">
                                            <?php echo $clr; ?>
                                        </label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- size -->
                    <div class="border-b-2 border-gray-300 pb-4 mt-3">
                        <h1 class="text-gray-800 font-medium text-sm">Size:</h1>
                        <div class="mt-2 text-gray-700">
                            <ul class="space-y-2">
                                <?php
                                $select_size = "SELECT * FROM products WHERE Category = '$Category'";
                                $size_query = mysqli_query($con, $select_size);


                                if ($size_query) {
                                    $size_array = [];
                                    if (mysqli_num_rows($size_query) > 0) {

                                        while ($row = mysqli_fetch_assoc($size_query)) {
                                            $sizes = explode(',', $row['size']);

                                            foreach ($sizes as $sz) {
                                                $size = trim($sz);
                                                if ($size === '-' || empty($size)) {
                                                    continue;
                                                }

                                                if (!in_array($size, $size_array)) {
                                                    $size_array[] = $size;
                                                }
                                            }
                                        }

                                        if (empty($size_array)) {
                                            echo "-";
                                        } else {
                                            // Display sizes if available
                                            implode(', ', $size_array);
                                        }
                                    } else {
                                        echo "-";
                                    }
                                }

                                foreach ($size_array as $size) {
                                    $checkbox_id = 'size_' . $size;
                                ?>
                                    <li class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700"
                                            name="size[]"
                                            id="<?php echo $checkbox_id; ?>"
                                            value="<?php echo $size ?>">
                                        <label class="text-sm" for="<?php echo $checkbox_id ?>"><?php echo $size; ?></label>
                                    </li>
                                <?php
                                }

                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- rating -->
                    <div class="border-b-2 border-gray-300 pb-4 mt-3">
                        <h1 class="text-gray-800 font-medium text-sm">Rating:</h1>
                        <div class="mt-2 text-gray-700">
                            <ul class="space-y-2">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                ?>
                                    <li class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700"
                                            value="<?php echo $i . '.0' ?>"
                                            name="stars[]"
                                            id="<?php echo 'star_' . $i ?>">
                                        <label class="text-sm" for="<?php echo 'star_' . $i ?>"><?php echo $i . " & above" ?></label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="flex justify-center items-center gap-2 rounded-tl-xl rounded-br-xl mt-2 text-center w-full bg-gray-700 py-2 text-white hover:bg-gray-800 cursor-pointer transition duration-300">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-5">
                                <g>
                                    <path d="M53.39 8H10.61a5.61 5.61 0 0 0-4.15 9.38L25 37.77V57a2 2 0 0 0 1.13 1.8 1.94 1.94 0 0 0 .87.2 2 2 0 0 0 1.25-.44l3.75-3 6.25-5A2 2 0 0 0 39 49V37.77l18.54-20.39A5.61 5.61 0 0 0 53.39 8z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                                </g>
                            </svg>
                        </span>
                        <span>
                            Apply Filter
                        </span>
                    </button>
                </form>
                <?php
                $filters = [];
                $orFilters = []; // This will hold the OR conditions

                if (isset($_POST['submit'])) {
                    // For the price
                    if (isset($_POST['price'])) {
                        $selected_price = $_POST['price'];
                        $price_limit_num = str_replace(',', '', $selected_price);
                        $price_limit_numeric = (int)$price_limit_num;

                        $MRP = 'vendor_mrp';
                        // Add appropriate filter based on the price value
                        if ($selected_price === 'over_100k') {
                            $price_over_numeric = 100000;
                            $orFilters[] = "CAST(REPLACE($MRP, ',', '') AS UNSIGNED) > $price_over_numeric";
                        } else {
                            $orFilters[] = "CAST(REPLACE($MRP, ',', '') AS UNSIGNED) < $price_limit_numeric";
                        }
                    }

                    // For the colors
                    if (isset($_POST['color'])) {
                        $selected_colors = $_POST['color'];
                        foreach ($selected_colors as $color) {
                            $orFilters[] = "color LIKE ('%$color%')";
                        }
                    }

                    // For the size
                    if (isset($_POST['size'])) {
                        $selected_size = $_POST['size'];
                        foreach ($selected_size as $size) {
                            $orFilters[] = "size LIKE ('%$size%')";
                        }
                    }

                    // For the rating
                    $range = 0.9;
                    if (isset($_POST['stars'])) {
                        $selected_rating = $_POST['stars'];
                        foreach ($selected_rating as $rating) {
                            if (is_numeric($rating)) {
                                $rating = floatval($rating);
                                $orFilters[] = "avg_rating BETWEEN " . ($rating) . " AND " . ($rating + $range);
                            }
                        }
                    }
                }

                // Combine filters
                $filter_query = '';
                if (!empty($orFilters)) {
                    $filter_query = '(' . implode(" OR ", $orFilters) . ')';
                }

                $sort_column = 'vendor_mrp'; // Column to sort by
                $sort_order = 'ASC';

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

                $vendorIds = [];
                $vendorLat = [];
                $vendorLng = [];
                foreach ($vendorLatitudes as $index => $lat) {
                    $lng = isset($vendorLongitudes[$index]) ? $vendorLongitudes[$index] : 'N/A';

                    $get_vendor = "SELECT * FROM vendor_registration WHERE latitude = '$lat' AND longitude = '$lng'";
                    $query = mysqli_query($con, $get_vendor);

                    if (mysqli_num_rows($query) > 0) {
                        while ($vendorCount = mysqli_fetch_assoc($query)) {
                            $vendorIds[] = $vendorCount['vendor_id']; // Store vendor IDs

                            $vendorLat[] = $lat; 
                            $vendorLng[] = $lng; 
                        }
                    }
                }

                if(!empty($vendorIds)){
                    if ($filter_query) {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category' AND $filter_query ORDER BY CAST(REPLACE($sort_column, ',', '') AS UNSIGNED) $sort_order";
                    } elseif ($selected === 'Newest') {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category'";
                    } elseif ($selected === 'All') {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category'";
                    } elseif ($selected === 'Low to High') {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category' ORDER BY CAST(REPLACE($sort_column, ',', '') AS UNSIGNED) $sort_order";
                    } elseif ($selected === 'High to Low') {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category' ORDER BY CAST(REPLACE($sort_column, ',', '') AS UNSIGNED) DESC";
                    } elseif ($selected === 'Most Popular') {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT
                                pr.product_id,
                                pr.profile_image_1,
                                pr.title,
                                pr.MRP,
                                pr.vendor_mrp,
                                pr.vendor_price,
                                pr.size,
                                pr.color,
                                pr.Quantity,
                                pr.avg_rating,
                                pr.total_reviews,
                                COUNT(v.vendor_id) AS order_count
                            FROM products pr
                            LEFT JOIN vendor_registration v ON pr.vendor_id = v.vendor_id
                            WHERE v.vendor_id IN ($vendorIdList) AND pr.Category = '$Category'
                            GROUP BY pr.product_id, pr.profile_image_1, pr.title, pr.MRP, pr.vendor_mrp, pr.vendor_price, pr.size, pr.color, pr.Quantity, pr.avg_rating, pr.total_reviews, v.vendor_id
                            ORDER BY order_count DESC";
                    } elseif ($selected === 'Best Rating') {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category' ORDER BY avg_rating DESC";
                    } else {
                        $vendorIdList = implode(',', $vendorIds);
                        $products = "SELECT * FROM products WHERE vendor_id IN ($vendorIdList) AND Category = '$Category'";
                    }
    
                    $Product_query = mysqli_query($con, $products);
                }
                ?>
            </div>

            <!-- card div -->
            <div class="flex flex-col items-center mt-10 lg:ml-10 w-full">
                <!-- Product cards will be displayed here -->
                <?php

                if(!empty($vendorIds)){
                    if (mysqli_num_rows($Product_query) > 0) {
                        ?>
                            <div class="product-container grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-10">
                                <?php
                                while ($res = mysqli_fetch_assoc($Product_query)) {
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
                                    <div class="product-card ring-2 ring-gray-300  rounded-tl-xl rounded-br-xl h-[23.7rem] w-60 overflow-hidden relative">
                                        <div class="p-2 " onclick="window.location.href = '../product/product_detail.php?product_id=<?php echo $res['product_id']; ?>'">
                                            <img src="<?php echo '../src/product_image/product_profile/' . $res['profile_image_1']; ?>" alt="" class="product-card__hero-image css-1fxh5tw h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl mix-blend-multiply" loading="lazy" sizes="">
                                        </div>
                                        <div class="mt-2 space-y-3" onclick="window.location.href = '../product/product_detail.php?product_id=<?php echo $res['product_id']; ?>'">
                                            <a href="../product/product_detail.php?product_id=<?php echo $res['product_id'] ?>" class="text-sm font-medium line-clamp-2 cursor-pointer px-2"><?php echo $res['title'] ?></a>
                                            <div class="flex justify-between px-2">
                                                <p class="space-x-1">
                                                    <span class="text-lg font-medium text-gray-900">₹<?php echo number_format($MRP) ?></span>
                                                    <del class="text-xs font-medium">₹<?php echo number_format($res['vendor_price']) ?></del>
                                                </p>
                                                <div class="flex items-center">
                                                    <span class="bg-gray-900 rounded-tl-md rounded-br-md px-2 py-0.5 flex items-center gap-1">
                                                        <h1 class="font-semibold text-xs text-white"><?php echo $res['avg_rating'] ?></h1>
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
                                                <a href="<?php echo $qty > 0 ? '../shopping/add_to_cart.php?product_id=' . urlencode($product_id) . '&size=' . $product_size . '&qty=' . $qty . '&MRP=' . $MRP : '#'; ?>" class="bg-white border-2 border-gray-800 text-gray-900 rounded-tl-xl rounded-br-xl w-40 py-1 text-sm font-semibold text-center">Add to cart</a>
                                            <?php
                                            } else {
                                            ?>
                                                <h1 class="bg-white border-2 border-gray-800 text-red-600 rounded-tl-xl rounded-br-xl w-40 py-1 text-sm font-semibold text-center cursor-default select-none">Out of Stock</h1>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
        
                                }
                                ?>
                            </div>
                        <?php
                    } else {
                    ?>
                        <div class="flex flex-col justify-center items-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 66 66" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-24 mb-3 text-gray-700">
                                <g>
                                    <path d="M22.71 31.52H8.72l-7.22 8.6h13.99zM48.67 29.11c5.48-5.48 5.48-14.37 0-19.85s-14.37-5.48-19.85 0-5.48 14.37 0 19.85 14.37 5.48 19.85 0zM30.94 11.38c2.08-2.08 4.86-3.23 7.8-3.23 2.95 0 5.72 1.15 7.8 3.23 4.3 4.3 4.3 11.3 0 15.6-2.08 2.08-4.85 3.23-7.8 3.23s-5.72-1.15-7.8-3.23c-4.3-4.3-4.3-11.3 0-15.6z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    <path d="M38.74 28.22c2.41 0 4.68-.94 6.39-2.65 3.52-3.52 3.52-9.25 0-12.78a8.962 8.962 0 0 0-6.39-2.65c-2.41 0-4.68.94-6.39 2.65-3.52 3.52-3.52 9.25 0 12.78a8.98 8.98 0 0 0 6.39 2.65zm-5.11-12.74a.996.996 0 1 1 1.41-1.41l3.7 3.7 3.7-3.7a.996.996 0 1 1 1.41 1.41l-3.7 3.7 3.7 3.7a.996.996 0 0 1-.71 1.7c-.26 0-.51-.1-.71-.29l-3.7-3.7-3.7 3.7c-.2.2-.45.29-.71.29s-.51-.1-.71-.29a.996.996 0 0 1 0-1.41l3.7-3.7zM7.72 42.12v18.73h14.99V34.63l-6.29 7.49zM47.33 32.94l-.15-.15a15.868 15.868 0 0 1-8.45 2.42c-3.78 0-7.36-1.3-10.23-3.69h-3.8l7.22 8.59h20.52l-3.63-3.63a5.135 5.135 0 0 1-1.48-3.54zM63.59 39.64l-8.96-8.96a3.114 3.114 0 0 0-2.88-.83l-.56-.56a16.002 16.002 0 0 1-2.34 2.34l.56.56c-.23 1 .05 2.1.83 2.88l8.96 8.96c1.21 1.21 3.18 1.21 4.39 0s1.21-3.18 0-4.39z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    <path d="M24.71 34.63v26.22h26.62V42.12H31zm11.37 22.69h-7.84c-.55 0-1-.45-1-1s.45-1 1-1h7.84c.55 0 1 .45 1 1s-.45 1-1 1zm1-4.91c0 .55-.45 1-1 1h-7.84c-.55 0-1-.45-1-1s.45-1 1-1h7.84c.55 0 1 .45 1 1z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                </g>
                            </svg>
                            <h1 class="text-3xl font-semibold text-gray-800">No products found</h1>
                            <p class="text-gray-600 mt-2">It looks like no products match your selected filters.</p>
                        </div>
                    <?php
                    }
                }else {
                ?>
                    <div class="flex flex-col justify-center items-center w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 66 66" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-24 mb-3 text-gray-700">
                            <g>
                                <path d="M22.71 31.52H8.72l-7.22 8.6h13.99zM48.67 29.11c5.48-5.48 5.48-14.37 0-19.85s-14.37-5.48-19.85 0-5.48 14.37 0 19.85 14.37 5.48 19.85 0zM30.94 11.38c2.08-2.08 4.86-3.23 7.8-3.23 2.95 0 5.72 1.15 7.8 3.23 4.3 4.3 4.3 11.3 0 15.6-2.08 2.08-4.85 3.23-7.8 3.23s-5.72-1.15-7.8-3.23c-4.3-4.3-4.3-11.3 0-15.6z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                <path d="M38.74 28.22c2.41 0 4.68-.94 6.39-2.65 3.52-3.52 3.52-9.25 0-12.78a8.962 8.962 0 0 0-6.39-2.65c-2.41 0-4.68.94-6.39 2.65-3.52 3.52-3.52 9.25 0 12.78a8.98 8.98 0 0 0 6.39 2.65zm-5.11-12.74a.996.996 0 1 1 1.41-1.41l3.7 3.7 3.7-3.7a.996.996 0 1 1 1.41 1.41l-3.7 3.7 3.7 3.7a.996.996 0 0 1-.71 1.7c-.26 0-.51-.1-.71-.29l-3.7-3.7-3.7 3.7c-.2.2-.45.29-.71.29s-.51-.1-.71-.29a.996.996 0 0 1 0-1.41l3.7-3.7zM7.72 42.12v18.73h14.99V34.63l-6.29 7.49zM47.33 32.94l-.15-.15a15.868 15.868 0 0 1-8.45 2.42c-3.78 0-7.36-1.3-10.23-3.69h-3.8l7.22 8.59h20.52l-3.63-3.63a5.135 5.135 0 0 1-1.48-3.54zM63.59 39.64l-8.96-8.96a3.114 3.114 0 0 0-2.88-.83l-.56-.56a16.002 16.002 0 0 1-2.34 2.34l.56.56c-.23 1 .05 2.1.83 2.88l8.96 8.96c1.21 1.21 3.18 1.21 4.39 0s1.21-3.18 0-4.39z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                <path d="M24.71 34.63v26.22h26.62V42.12H31zm11.37 22.69h-7.84c-.55 0-1-.45-1-1s.45-1 1-1h7.84c.55 0 1 .45 1 1s-.45 1-1 1zm1-4.91c0 .55-.45 1-1 1h-7.84c-.55 0-1-.45-1-1s.45-1 1-1h7.84c.55 0 1 .45 1 1z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                            </g>
                        </svg>
                        <h1 class="text-3xl font-semibold text-gray-800">No products found</h1>
                        <p class="text-gray-600 mt-2">It looks like no products match your selected filters.</p>
                    </div>
                <?php
                }
                ?>

                <!-- Pagination Section -->
                <div x-data="pagination()" x-init="showPage(currentPage)" class="pagination flex justify-center items-center gap-2 mt-5" x-cloak>
                    <!-- Left Arrow -->
                    <div class="arrow-button mr-1" x-show="totalPages > 1" x-transition>
                        <button :disabled="currentPage === 1" @click="showPage(currentPage - 1)" class="pagination-button bg-gray-600 h-6 w-6 flex justify-center items-center text-white rounded-tl-md rounded-br-md" x-cloak>
                            <svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492 492">
                                <path d="M198.608 246.104L382.664 62.04c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12C361.476 2.792 354.712 0 347.504 0s-13.964 2.792-19.028 7.864L109.328 227.008c-5.084 5.08-7.868 11.868-7.848 19.084-.02 7.248 2.76 14.028 7.848 19.112l218.944 218.932c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06L198.608 246.104z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="pagination-buttons" x-html="paginationButtons"></div>

                    <!-- Right Arrow -->
                    <div class="arrow-button ml-1" x-show="totalPages > 1" x-transition>
                        <button :disabled="currentPage === totalPages" @click="showPage(currentPage + 1)" class="pagination-button bg-gray-600 h-6 w-6 flex justify-center items-center text-white rounded-tl-md rounded-br-md" x-cloak>
                            <svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 492.004 492.004">
                                <path d="M382.678 226.804L163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="currentColor"></path>
                            </svg>
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- pagination js -->
    <script>
        function pagination() {
            return {
                currentPage: 1,
                totalPages: 0,
                rowsPerPage: 2,
                productCards: document.querySelectorAll('.product-card'),

                getCardsPerRow() {
                    if (window.innerWidth >= 1536) return 6;
                    if (window.innerWidth >= 1280) return 5;
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 768) return 2;
                    return 1;
                },

                showPage(page) {
                    let cardsPerRow = this.getCardsPerRow();
                    let itemsPerPage = cardsPerRow * this.rowsPerPage;
                    let totalItems = this.productCards.length;

                    // Recalculate total pages based on screen size
                    this.totalPages = Math.ceil(totalItems / itemsPerPage);

                    // Ensure current page is valid
                    if (page > this.totalPages) page = this.totalPages;
                    if (page < 1) page = 1;

                    this.currentPage = page;

                    // Hide all cards
                    this.productCards.forEach(card => card.style.display = 'none');

                    // Calculate visible range
                    let startIndex = (page - 1) * itemsPerPage;
                    let endIndex = startIndex + itemsPerPage;

                    // Show visible cards
                    for (let i = startIndex; i < endIndex; i++) {
                        if (this.productCards[i]) {
                            this.productCards[i].style.display = 'block';
                        }
                    }

                    // Scroll to the top of the page
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                    // Update pagination buttons
                    this.updatePagination();
                },


                updatePagination() {
                    let paginationButtons = '';

                    // Only show pagination if there is more than one page
                    if (this.totalPages > 1) {
                        // Always show the first page
                        paginationButtons += `<button :class="{'bg-blue-600 text-white': currentPage === 1,'bg-gray-200 text-black': currentPage !== 1,'flex justify-center items-center h-6 w-6 rounded-tl-md rounded-br-md border-2 border-gray-500': true}" @click="showPage(1)">1</button>`;

                        // Add dots after the first page if there are more than 2 pages and the current page is greater than 3
                        if (this.currentPage >= 3) {
                            paginationButtons += `<span class="dots">...</span>`;
                        }

                        // Show pages between the first and last
                        if (this.currentPage >= 2) {
                            paginationButtons += `<button :class="{'bg-blue-600 text-white': currentPage === ${this.currentPage},'bg-gray-200 text-black': currentPage !== ${this.currentPage},'flex justify-center items-center h-6 w-6 rounded-tl-md rounded-br-md border-2 border-gray-500': true}" @click="showPage(${this.currentPage})">${this.currentPage}</button>`;
                        }

                        // Add dots before the last page if there are more than 2 pages and the current page is less than totalPages - 2
                        if (this.currentPage < this.totalPages - 1) {
                            paginationButtons += `<span class="dots">...</span>`;
                        }

                        // Always show the last page if it's not already shown
                        if (this.currentPage !== this.totalPages) {
                            paginationButtons += `<button :class="{'bg-blue-600 text-white': currentPage === ${this.totalPages},'bg-gray-200 text-black': currentPage !== ${this.totalPages},'flex justify-center items-center h-6 w-6 rounded-tl-md rounded-br-md border-2 border-gray-500': true}" @click="showPage(${this.totalPages})">${this.totalPages}</button>`;
                        }
                    }

                    // Bind the pagination buttons to the element
                    this.paginationButtons = paginationButtons;
                }
            };
        }
    </script>

    <!-- sidebar -->
    <div id="filterSidebarContainer" class="hidden bg-gray-50 pb-3 font-medium fixed top-0 right-0 w-fit h-[100vh] overflow-y-auto z-50 sidebarScroll" x-cloak>
        <div id="filterSidebarHeader" class="p-2 bg-gray-200 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h1 class="text-black"><a href="">Hello, <?php echo isset($_COOKIE['fname']) ? $_COOKIE['fname'] : 'User' ?></a></h1>
            </div>
            <div>
                <button onclick="filterSideBarClose()" class="focus:outline-none">
                    <svg class="relative top-0.5 right-0.5 text-[#ff0000] transition rounded-md" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" style="fill: currentColor;">
                        <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div id="sidebarBody" class="felx justify-center px-4">
            <div class="mt-7 w-60">
                <form method="post">
                    <!-- Price -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4 mt-3">
                        <button @click="open = !open" type="button" class="flex w-full justify-between items-center text-left text-gray-800 font-medium text-lg">
                            <span class="text-sm">Price</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5" x-show="!open" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path>
                                </svg>
                                <svg class="h-5 w-5" x-show="open" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" class="mt-2 text-gray-600" style="display: none;">
                            <ul class="space-y-2 text-sm text-gray-800">
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="1000" name="price" id="under_1k">
                                    <label class="text-sm" for="under_1k">Under ₹1000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="5000" name="price" id="under_5k">
                                    <label class="text-sm" for="under_5k">Under ₹5000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="10000" name="price" id="under_10k">
                                    <label class="text-sm" for="under_10k">Under ₹10,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="30000" name="price" id="under_30k">
                                    <label class="text-sm" for="under_30k">Under ₹30,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="50000" name="price" id="under_50k">
                                    <label class="text-sm" for="under_50k">Under ₹50,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="100000" name="price" id="under_100k">
                                    <label class="text-sm" for="under_100k">Under ₹1,00,000</label>
                                </li>
                                <li class="flex items-center gap-2">
                                    <input type="radio" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700" value="over_100k" name="price" id="over_100k">
                                    <label class="text-sm" for="over_100k">Over ₹1,00,000</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- color -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4 mt-3">
                        <button @click="open = !open" type="button" class="flex w-full justify-between items-center text-left text-gray-800 font-medium text-lg">
                            <span class="text-sm">Color</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5" x-show="!open" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path>
                                </svg>
                                <svg class="h-5 w-5" x-show="open" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" class="mt-2 text-gray-600" style="display: none;">
                            <ul class="space-y-2 text-gray-700">
                                <?php
                                foreach ($color_array as $clr) {
                                    $checkbox_id = 'color_' . $clr;
                                ?>
                                    <li class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700"
                                            name="color[]"
                                            id="<?php echo $checkbox_id; ?>"
                                            value="<?php echo $clr; ?>">
                                        <label class="text-sm" for="<?php echo $checkbox_id; ?>">
                                            <?php echo $clr; ?>
                                        </label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Size -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4 mt-3">
                        <button @click="open = !open" type="button" class="flex w-full justify-between items-center text-left text-gray-800 font-medium text-lg">
                            <span class="text-sm">Size</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5" x-show="!open" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path>
                                </svg>
                                <svg class="h-5 w-5" x-show="open" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" class="mt-2 text-gray-600" style="display: none;">
                            <ul class="space-y-2">
                                <?php
                                $select_size = "SELECT * FROM products WHERE Category = '$Category'";
                                $size_query = mysqli_query($con, $select_size);


                                if ($size_query) {
                                    $size_array = [];
                                    if (mysqli_num_rows($size_query) > 0) {

                                        while ($row = mysqli_fetch_assoc($size_query)) {
                                            $sizes = explode(',', $row['size']);

                                            foreach ($sizes as $sz) {
                                                $size = trim($sz);
                                                if ($size === '-' || empty($size)) {
                                                    continue;
                                                }

                                                if (!in_array($size, $size_array)) {
                                                    $size_array[] = $size;
                                                }
                                            }
                                        }

                                        if (empty($size_array)) {
                                            echo "-";
                                        } else {
                                            // Display sizes if available
                                            implode(', ', $size_array);
                                        }
                                    } else {
                                        echo "-";
                                    }
                                }

                                foreach ($size_array as $size) {
                                    $checkbox_id = 'size_' . $size;
                                ?>
                                    <li class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700"
                                            name="size[]"
                                            id="<?php echo $checkbox_id; ?>"
                                            value="<?php echo $size ?>">
                                        <label class="text-sm" for="<?php echo $checkbox_id ?>"><?php echo $size; ?></label>
                                    </li>
                                <?php
                                }

                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div x-data="{ open: false }" class="border-b border-gray-200 pb-4 mt-3">
                        <button @click="open = !open" type="button" class="flex w-full justify-between items-center text-left text-gray-800 font-medium text-lg">
                            <span class="text-sm">Rating</span>
                            <span class="ml-6 flex items-center">
                                <svg class="h-5 w-5" x-show="!open" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"></path>
                                </svg>
                                <svg class="h-5 w-5" x-show="open" viewBox="0 0 20 20" fill="currentColor" style="display: none;">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" class="mt-2 text-gray-600" style="display: none;">
                            <ul class="space-y-2">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                ?>
                                    <li class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded h-[15px] w-[15px] text-gray-700 focus:ring-gray-700"
                                            value="<?php echo $i . '.0' ?>"
                                            name="stars[]"
                                            id="<?php echo 'star_' . $i ?>">
                                        <label class="text-sm" for="<?php echo 'star_' . $i ?>"><?php echo $i . " & above" ?></label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="flex justify-center items-center gap-2 rounded-tl-xl rounded-br-xl mt-2 text-center w-full bg-gray-700 py-2 text-white hover:bg-gray-800 cursor-pointer transition duration-300">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-5">
                                <g>
                                    <path d="M53.39 8H10.61a5.61 5.61 0 0 0-4.15 9.38L25 37.77V57a2 2 0 0 0 1.13 1.8 1.94 1.94 0 0 0 .87.2 2 2 0 0 0 1.25-.44l3.75-3 6.25-5A2 2 0 0 0 39 49V37.77l18.54-20.39A5.61 5.61 0 0 0 53.39 8z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                                </g>
                            </svg>
                        </span>
                        <span>
                            Apply Filter
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php
    include "../pages/_footer.php";
    ?>


    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>