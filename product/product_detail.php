<?php

if (!isset($_GET['product_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<?php
include "../include/connect.php";

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $product_find = "SELECT * FROM products WHERE product_id = '$product_id'";
    $product_query = mysqli_query($con, $product_find);

    $res = mysqli_fetch_assoc($product_query);
    $colors = $res['color'];

    $first_img1 = $res['profile_image_1'];
    $first_img2 = $res['profile_image_2'];
    $first_img3 = $res['profile_image_3'];
    $first_img4 = $res['profile_image_4'];


    // for the title
    $title = $res['title'];

    // for the price
    $json_mrp = $res['MRP'];
    $decodemrp = json_decode($json_mrp, true);

    // for the size
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['size'])) {
        $_SESSION['selectedSize'] = $_POST['size'];
    }

    // for the size
    $json_size = $res['MRP'];
    $decodesize = json_decode($json_size, true);

    foreach ($decodesize as $key => $value) {
        $first_size = $key;
        break;
    }

    $selectedSize = isset($_SESSION['selectedSize']) ? $_SESSION['selectedSize'] : $first_size;

    if (isset($selectedSize) && isset($decodemrp[$selectedSize])) {
        $first_price = $decodemrp[$selectedSize];
    } else {
        reset($decodemrp);
        $first_price = current($decodemrp);
    }

    $MRP = isset($first_price['MRP']) ? $first_price['MRP'] : null;
    $Your_Price = isset($first_price['Your_Price']) ? $first_price['Your_Price'] : null;


    if (isset($selectedSize) && isset($decodemrp[$selectedSize])) {
        $first_price = $decodemrp[$selectedSize];
    } else {
        reset($decodemrp);
        $first_price = current($decodemrp);
    }


    $vendor_id = $res['vendor_id'];

    $vendor_find = "SELECT * FROM vendor_registration WHERE vendor_id  = '$vendor_id'";
    $vendor_query = mysqli_query($con, $vendor_find);
    $ven = mysqli_fetch_assoc($vendor_query);

    // find distance
    function getDistance($startLat, $startLng, $endLat, $endLng, $apiKey)
    {
        $url = "https://api.tomtom.com/routing/1/calculateRoute/{$startLat},{$startLng}:{$endLat},{$endLng}/json?key={$apiKey}";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['routes'][0]['summary'])) {
            $travelTimeInSeconds = $data['routes'][0]['summary']['travelTimeInSeconds'];

            // Convert travel time from seconds to minutes
            $travelTimeInMinutes = $travelTimeInSeconds / 60;

            return [
                'travelTime' => $travelTimeInMinutes
            ];
        } else {
            echo "Error: No route found or invalid response.";
            return null;
        }
    }

    $startLat = $_COOKIE['latitude'];
    $startLon = $_COOKIE['longitude'];
    $endLat = $ven['latitude'];
    $endLon = $ven['longitude'];
    $apiKey = 'hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw';

    $result = getDistance($startLat, $startLon, $endLat, $endLon, $apiKey);

    $TravelTime = number_format($result['travelTime']) + 25;


    $get_reviews = "SELECT * FROM user_review WHERE product_id = '$product_id'";
    $review_query = mysqli_query($con, $get_reviews);

    $rev = mysqli_fetch_assoc($review_query);
    $totalReviews = mysqli_num_rows($review_query);

    // for add to cart Button
    if (isset($_POST['buyBtn'])) {
        $size = isset($_POST['size']) ? $_POST['size'] : null;
        $qty = isset($_POST['qty']) ? $_POST['qty'] : null;

        if (isset($_COOKIE['user_id'])) {
            $encoded_qty = urlencode($qty);
?>
            <script>
                window.location.href = 'checkout.php?product_id=<?php echo urlencode($product_id); ?>&size=<?php echo $selectedSize; ?>&qty=<?php echo $qty; ?>&MRP=<?php echo $MRP ?>&TravelTime=<?php echo $TravelTime ?>'
            </script>
        <?php
            unset($_SESSION['selectedSize'][$product_id]);
        } else {
        ?>
            <script>
                window.location.href = '../authentication/user_auth/user_login.php'
            </script>
        <?php
            unset($_SESSION['selectedSize']);
        }
    }


    // for add to cart Button
    if (isset($_POST['AddtoCart'])) {
        $size = isset($_POST['size']) ? $_POST['size'] : null;
        $qty = isset($_POST['qty']) ? $_POST['qty'] : null;

        $encoded_product_id = urlencode($product_id);
        $encoded_qty = urlencode($qty);
        ?>
        <script>
            window.location.href = '../shopping/add_to_cart.php?product_id=<?php echo urlencode($product_id); ?>&size=<?php echo $selectedSize; ?>&qty=<?php echo $qty; ?>&MRP=<?php echo $MRP ?>'
        </script>
<?php
        unset($_SESSION['selectedSize'][$product_id]);
    }
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
    <title><?php echo isset($_GET['product_id']) ? $title : 'Product Details' ?></title>

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- swiper css -->
    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mySwiper .swiper-slide {
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .zoom-container {
            position: relative;
            overflow: hidden;
            cursor: zoom-in;
        }

        .zoom-image {
            transition: transform 0.1s ease;
        }

        /* When zooming in */
        .zoom-container.zoomed-in .zoom-image {
            transform: scale(2.5);
            /* Adjust this value for zoom intensity */
            cursor: zoom-out;
        }

        .scrollBar::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e6e6e6;
        }

        .scrollBar::-webkit-scrollbar {
            width: 10px;
            height: 5px;
            background-color: #F5F5F5;
        }

        .scrollBar::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #bfbfbf;
        }
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
    include "../pages/_navbar.php";
    ?>

    <!-- product -->
    <div class="max-w-screen-xl m-auto grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-5 mt-12 px-2 md:px-8">
        <div class="">
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 w-auto h-auto md:h-96">
                <div class="swiper-wrapper h-52 md:h-full">
                    <?php
                    if (!empty($first_img1)) {
                    ?>
                        <div class="swiper-slide w-auto h-auto zoom-container">
                            <img class="h-full zoom-image" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img1 : '../src/sample_images/product_1.jpg' ?>" />
                        </div>
                    <?php
                    }

                    if (!empty($first_img2)) {
                    ?>
                        <div class="swiper-slide h-auto zoom-container">
                            <img class="h-full zoom-image" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img2 : '../src/sample_images/product_2.jpg' ?>" />
                        </div>
                    <?php
                    }

                    if (!empty($first_img3)) {
                    ?>
                        <div class="swiper-slide h-auto zoom-container">
                            <img class="h-full zoom-image" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img3 : '../src/sample_images/product_3.jpg' ?>" />
                        </div>
                    <?php
                    }

                    if (!empty($first_img4)) {
                    ?>
                        <div class="swiper-slide h-auto zoom-container">
                            <img class="h-full zoom-image" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img4 : '../src/sample_images/product_4.jpg' ?>" />
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- image zoom effect js -->
            <script>
                document.querySelectorAll('.zoom-container').forEach(function(container) {
                    const zoomImage = container.querySelector('.zoom-image');

                    // Handle zoom on hover
                    container.addEventListener('mouseenter', function() {
                        container.classList.add('zoomed-in');
                    });

                    // Handle zoom out on mouse leave
                    container.addEventListener('mouseleave', function() {
                        container.classList.remove('zoomed-in');
                        zoomImage.style.transformOrigin = 'center center'; // Reset zoom origin
                    });

                    // Handle cursor move and zoom positioning
                    container.addEventListener('mousemove', function(e) {
                        // Get the position of the container
                        const containerRect = container.getBoundingClientRect();
                        const xPercent = ((e.clientX - containerRect.left) / containerRect.width) * 100;
                        const yPercent = ((e.clientY - containerRect.top) / containerRect.height) * 100;

                        // Set the transform origin of the image based on mouse position
                        zoomImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
                    });
                });
            </script>
            <div thumbsSlider="" class="swiper mySwiper md:w-80 h-auto mt-6 px-2">
                <div class="swiper-wrapper flex item-center justify-center">
                    <?php
                    if (!empty($first_img1)) {
                    ?>
                        <div class="swiper-slide border border-black p-1 cursor-pointer">
                            <img class="w-full h-full m-auto aspect-square" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img1 : '../src/sample_images/product_1.jpg' ?>" />
                        </div>
                    <?php
                    }

                    if (!empty($first_img2)) {
                    ?>
                        <div class="swiper-slide border border-black p-1 cursor-pointer">
                            <img class="w-full h-full m-auto aspect-square" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img2 : '../src/sample_images/product_1.jpg' ?>" />
                        </div>
                    <?php
                    }

                    if (!empty($first_img3)) {
                    ?>
                        <div class="swiper-slide border border-black p-1 cursor-pointer">
                            <img class="w-full h-full m-auto aspect-square" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img3 : '../src/sample_images/product_1.jpg' ?>" />
                        </div>
                    <?php
                    }

                    if (!empty($first_img4)) {
                    ?>
                        <div class="swiper-slide border border-black p-1 cursor-pointer">
                            <img class="w-full h-full m-auto aspect-square" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_profile/' . $first_img4 : '../src/sample_images/product_1.jpg' ?>" />
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <form action="" Method="post">
            <div class="flex flex-col gap-3 w-full mt-12 px-2">
                <div class="flex flex-col gap-2">
                    <h1 class="text-lg md:text-[20px] md:font-medium md:leading-8 2xl:text-xl font-medium text-[#1d2128] leading-6"><?php echo isset($_GET['product_id']) ? $title : 'Product title' ?></h1>
                </div>
                <!-- vendor Store -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-3 lg:space-y-0">
                    <a href="../vendor/vendor_store.php?vendor_id=<?php echo $ven['vendor_id']; ?>" class="text-base text-gray-600 font-bold hover:underline cursor-pointer max-w-max">Visit a <span><?php echo isset($product_id) ? $ven['username'] : 'vendor store Name'; ?></span> Store</a>
                    <div class="text-green-500 flex items-center gap-2">
                        <img class="w-8" src="../src/logo/fastTruck.svg" alt="">
                        <span class="text-sm font-medium mt-0.5">Delivered in Just <?php echo isset($TravelTime) ? $TravelTime . " minutes" : '' ?></span>
                    </div>
                </div>
                <!-- price -->
                <div class="flex justify-between items-center">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl text-red-700 font-light">-77%</span>
                            <span class="text-2xl font-medium flex gap-0.5"><span class="text-sm block text-start">₹</span><?php echo isset($_GET['product_id']) ? number_format($MRP) : 'MRP' ?></span>
                        </div>
                        <span class="text-sm">M.R.P.:
                            <del class="text-sm font-normal">₹<?php echo isset($_GET['product_id']) ? number_format($Your_Price) : 'Product price' ?></del>
                        </span>
                    </div>
                    <?php

                    $product_qty = $res['Quantity'];

                    if ($product_qty > 10) {
                    ?>
                        <p class="text-green-700 flex items-center gap-1 text-xs md:text-sm font-medium bg-green-200 px-3 py-2 rounded-2xl">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 31.955 31.955" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-2">
                                    <g>
                                        <path d="M27.25 4.655c-6.254-6.226-16.37-6.201-22.594.051-6.227 6.254-6.204 16.37.049 22.594 6.256 6.226 16.374 6.203 22.597-.051 6.224-6.254 6.203-16.371-.052-22.594z" fill="currentColor" data-original="currentColor" class=""></path>
                                        <path d="m13.288 23.896-1.768 5.207c2.567.829 5.331.886 7.926.17l-.665-5.416a8.382 8.382 0 0 1-5.493.039zM8.12 13.122l-5.645-.859a13.856 13.856 0 0 0 .225 8.143l5.491-1.375a8.391 8.391 0 0 1-.071-5.909zm20.643-1.789-4.965 1.675a8.39 8.39 0 0 1-.247 6.522l5.351.672a13.868 13.868 0 0 0-.139-8.869zm-17.369-8.45 1.018 5.528a8.395 8.395 0 0 1 6.442-.288l1.583-5.137a13.855 13.855 0 0 0-9.043-.103z" fill="currentColor" data-original="currentColor" class=""></path>
                                        <circle cx="15.979" cy="15.977" r="6.117" fill="currentColor" data-original="currentColor" class=""></circle>
                                    </g>
                                </svg>
                            </span>
                            <span>Available</span>
                        </p>
                    <?php
                    } elseif ($product_qty == 0) {
                    ?>
                        <p class="text-red-700 flex items-center gap-1 text-xs md:text-sm font-medium bg-red-200 px-3 py-2 rounded-2xl">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 31.955 31.955" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-2">
                                    <g>
                                        <path d="M27.25 4.655c-6.254-6.226-16.37-6.201-22.594.051-6.227 6.254-6.204 16.37.049 22.594 6.256 6.226 16.374 6.203 22.597-.051 6.224-6.254 6.203-16.371-.052-22.594z" fill="currentColor" data-original="currentColor" class=""></path>
                                        <path d="m13.288 23.896-1.768 5.207c2.567.829 5.331.886 7.926.17l-.665-5.416a8.382 8.382 0 0 1-5.493.039zM8.12 13.122l-5.645-.859a13.856 13.856 0 0 0 .225 8.143l5.491-1.375a8.391 8.391 0 0 1-.071-5.909zm20.643-1.789-4.965 1.675a8.39 8.39 0 0 1-.247 6.522l5.351.672a13.868 13.868 0 0 0-.139-8.869zm-17.369-8.45 1.018 5.528a8.395 8.395 0 0 1 6.442-.288l1.583-5.137a13.855 13.855 0 0 0-9.043-.103z" fill="currentColor" data-original="currentColor" class=""></path>
                                        <circle cx="15.979" cy="15.977" r="6.117" fill="currentColor" data-original="currentColor" class=""></circle>
                                    </g>
                                </svg>
                            </span>
                            <span>Sold out</span>
                        </p>
                    <?php
                    } elseif ($product_qty > 0 && $product_qty <= 10) {
                    ?>
                        <p class="text-yellow-700 flex items-center gap-1 text-xs md:text-sm font-medium bg-yellow-200 px-3 py-2 rounded-2xl h-fit">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 31.955 31.955" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-2">
                                    <g>
                                        <path d="M27.25 4.655c-6.254-6.226-16.37-6.201-22.594.051-6.227 6.254-6.204 16.37.049 22.594 6.256 6.226 16.374 6.203 22.597-.051 6.224-6.254 6.203-16.371-.052-22.594z" fill="currentColor" data-original="currentColor" class=""></path>
                                        <path d="m13.288 23.896-1.768 5.207c2.567.829 5.331.886 7.926.17l-.665-5.416a8.382 8.382 0 0 1-5.493.039zM8.12 13.122l-5.645-.859a13.856 13.856 0 0 0 .225 8.143l5.491-1.375a8.391 8.391 0 0 1-.071-5.909zm20.643-1.789-4.965 1.675a8.39 8.39 0 0 1-.247 6.522l5.351.672a13.868 13.868 0 0 0-.139-8.869zm-17.369-8.45 1.018 5.528a8.395 8.395 0 0 1 6.442-.288l1.583-5.137a13.855 13.855 0 0 0-9.043-.103z" fill="currentColor" data-original="currentColor" class=""></path>
                                        <circle cx="15.979" cy="15.977" r="6.117" fill="currentColor" data-original="currentColor" class=""></circle>
                                    </g>
                                </svg>
                            </span>
                            <span>Only <?php echo $product_qty; ?> products left</span>

                        </p>
                    <?php
                    }


                    ?>
                </div>
                <!-- color -->
                <?php
                $sameId = $res['same_id'];
                $color_product_find = "SELECT * FROM products WHERE same_id = '$sameId'";
                $color_product_query = mysqli_query($con, $color_product_find);

                // Check if there are any valid colors
                $hasColors = false;
                while ($clr = mysqli_fetch_assoc($color_product_query)) {
                    if ($clr['color'] != '-') {
                        $hasColors = true;
                        break;
                    }
                }

                // If there are valid colors, display the field
                if ($hasColors) {
                ?>
                    <div class="space-y-2">
                        <label for="color" class="text-xl font-medium">Color :</label>
                        <div class="flex items-center gap-5">
                            <?php
                            // Reset the query to fetch colors again
                            mysqli_data_seek($color_product_query, 0);

                            while ($clr = mysqli_fetch_assoc($color_product_query)) {
                                if ($clr['color'] != '-') {
                            ?>
                                    <a href="../product/product_detail.php?product_id=<?php echo $clr['product_id'] ?>" class="border-2 border-black flex items-center gap-2 py-1 px-2 rounded-tl-xl rounded-br-xl text-center hover:bg-gray-200 w-max cursor-pointer">
                                        <h1 class="text-lg"><?php echo $clr['color'] ?></h1>
                                    </a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- size -->
                <div class="space-y-5">
                    <div class="flex flex-col space-y-2">
                        <?php
                        if (isset($product_id)) {
                            if ($res['size'] == '-') {
                                echo '';
                            } else {
                        ?>
                                <label for="size" class="text-xl font-medium">Size:</label>
                                <form method="post" action="">
                                    <select name="size" id="size" class="h-10 w-full lg:w-56 border rounded px-4 bg-gray-50 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 <?php echo ($product_qty <= 0) ? 'cursor-not-allowed' : ''; ?>" onchange="this.form.submit();" <?php echo ($product_qty <= 0) ? 'disabled' : ''; ?>>
                                        <?php
                                        $product_size[] = $res['size'];
                                        foreach ($product_size as $productSize) {
                                            $size_array = explode(',', $productSize);
                                            foreach ($size_array as $size) {
                                                $sz = trim($size);
                                        ?>
                                                <option value="<?php echo htmlspecialchars($sz, ENT_QUOTES, 'UTF-8'); ?>" <?php if ($selectedSize === $sz) echo 'selected'; ?>>
                                                    <?php echo htmlspecialchars($sz, ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </form>
                        <?php
                            }
                        } else {
                            echo "Size of products";
                        }
                        ?>

                    </div>
                    <div class="flex flex-col space-y-2">
                        <label for="qty" class="text-xl font-medium">QTY:</label>
                        <select name="qty" id="qty" class="h-10 w-full lg:w-56 border rounded px-4 bg-gray-50 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 <?php echo ($product_qty <= 0) ? 'cursor-not-allowed' : ''; ?>" <?php echo ($product_qty == 0) ? 'disabled' : ''; ?>>
                            <?php
                            if ($product_qty > 0) {
                                // Determine the maximum quantity to display
                                $max_qty = ($product_qty > 10) ? 10 : $product_qty;

                                // Show options from 1 to the determined maximum quantity
                                for ($i = 1; $i <= $max_qty; $i++) {
                            ?>
                                    <option value="<?php echo $i; ?>" <?php if ($product_qty === $i) echo 'selected'; ?>>
                                        <?php echo $i; ?>
                                    </option>
                                <?php
                                }
                            } else {
                                // Show a single option if stock is zero
                                ?>
                                <option value="0" disabled selected>0</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6 mb-4">
                    <div class="flex item-center gap-1">
                        <span class="bg-gray-900 rounded-tl-lg rounded-br-lg px-2 py-1 flex items-center gap-1">
                            <h1 class="font-semibold text-base text-white"><?php echo $res['avg_rating'] ?></h1>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.991 511" class="w-3 h-3 m-auto fill-current text-white">
                                <path d="M510.652 185.883a27.177 27.177 0 0 0-23.402-18.688l-147.797-13.418-58.41-136.75C276.73 6.98 266.918.497 255.996.497s-20.738 6.483-25.023 16.53l-58.41 136.75-147.82 13.418c-10.837 1-20.013 8.34-23.403 18.688a27.25 27.25 0 0 0 7.937 28.926L121 312.773 88.059 457.86c-2.41 10.668 1.73 21.7 10.582 28.098a27.087 27.087 0 0 0 15.957 5.184 27.14 27.14 0 0 0 13.953-3.86l127.445-76.203 127.422 76.203a27.197 27.197 0 0 0 29.934-1.324c8.851-6.398 12.992-17.43 10.582-28.098l-32.942-145.086 111.723-97.964a27.246 27.246 0 0 0 7.937-28.926zM258.45 409.605"></path>
                            </svg>
                        </span>
                        <span class="text-sm ml-2 mt-1">(<?php echo $res['total_reviews'] ?>)</span>
                    </div>
                    <p class="text-sm font-medium text-[#0080ff]">Free delivery</p>
                </div>
                <hr>
                <div class="mt-4 flex flex-col gap-5 md:flex-row">
                    <input type="submit" name="AddtoCart" value="Add To Cart" class="md:w-40 text-center text-sm md:text-base font-medium text-white bg-gray-700 py-4 rounded-tl-xl rounded-br-xl transition duration-200 <?php echo ($product_qty == 0) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:bg-gray-800'; ?>" <?php echo ($product_qty == 0) ? 'disabled' : ''; ?>>
                    <input type="submit" name="buyBtn" value="Buy Now" class="md:w-40 text-center text-sm md:text-base font-medium text-gray-700 border-2 border-gray-700 py-4 rounded-tl-xl rounded-br-xl <?php echo ($product_qty == 0) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'; ?>" <?php echo ($product_qty == 0) ? 'disabled' : ''; ?>>
                </div>
            </div>
        </form>


    </div>

    <!-- product Details -->
    <div class="py-12 px-2 xl:px-52">
        <div class="border rounded-md p-8">
            <div>
                <h1 class="text-3xl font-semibold md:text-5xl"><?php echo isset($_GET['product_id']) ? $res['Type'] : 'Product Name' ?></h1>
                <hr class="my-6">
                <div class="">
                    <span class="text-xl font-medium"><?php echo isset($_GET['product_id']) ? $title : 'Product Name' ?></span>
                </div>
                <div class="grid grid-cols-1 mt-8 gap-2 md:grid-cols-1 m-auto">
                    <?php
                    if (!empty($res['cover_image_1'])) {
                    ?>
                        <img class="border w-full h-full object-cover m-auto" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_cover/' . $res['cover_image_1'] : '../src/sample_images/cover_1.jpg' ?>" alt="">
                    <?php
                    }

                    if (!empty($res['cover_image_2'])) {
                    ?>
                        <img class="border w-full h-full object-cover m-auto" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_cover/' . $res['cover_image_2'] : '../src/sample_images/cover_2.jpg' ?>" alt="">
                    <?php
                    }

                    if (!empty($res['cover_image_3'])) {
                    ?>
                        <img class="border w-full h-full object-cover m-auto" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_cover/' . $res['cover_image_3'] : '../src/sample_images/cover_3.jpg' ?>" alt="">
                    <?php
                    }

                    if (!empty($res['cover_image_4'])) {
                    ?>
                        <img class="border w-full h-full object-cover m-auto" src="<?php echo isset($_GET['product_id']) ? '../src/product_image/product_cover/' . $res['cover_image_4'] : '../src/sample_images/cover_4.jpg' ?>" alt="">
                    <?php
                    }
                    ?>

                </div>
                <div class="mt-12">
                    <h2 class="text-lg font-medium">More information</h2>
                    <div class="mt-3 flex flex-col gap-y-3">
                        <div class="flex">
                            <li></li>
                            <div>
                                <p><?php echo isset($_GET['product_id']) ? $res['Description'] : 'Product Description' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-12">
            <div class="grid grid-cols-1 gap-16 lg:grid-cols-3">
                <div class="col-span-2 md:col-span-1">
                    <span class="text-2xl font-medium">Rating</span>
                    <div class="ring-2 ring-gray-300 p-5 mt-3 rounded-md">
                        <div class="flex flex-col items-center my-6 md:items-start md:flex-row">
                            <?php
                            if (isset($product_id)) {
                                $get_reviews = "SELECT * FROM user_review WHERE product_id = '$product_id'";
                                $review_query = mysqli_query($con, $get_reviews);

                                if ($totalReviews = mysqli_num_rows($review_query)) {
                                    $sum = 0;
                                    $count = 0;

                                    while ($data = mysqli_fetch_assoc($review_query)) {
                                        $rating = str_replace(",", "", $data['Rating']);
                                        $sum += (float)$rating;
                                        $count++;
                                    }

                                    $average = $sum / $count;
                                    $formatted_average = number_format($average, 1);
                                }
                            }
                            ?>
                            <h1 class="text-7xl font-medium"><?php echo isset($formatted_average) ? $formatted_average : '0.0' ?></h1>
                        </div>
                        <div>
                            <?php
                            $get_rev = "SELECT Rating, COUNT(*) AS count FROM user_review WHERE product_id = '$product_id' GROUP BY Rating";
                            $get_query = mysqli_query($con, $get_rev);

                            $ratings = [
                                5 => 0,
                                4 => 0,
                                3 => 0,
                                2 => 0,
                                1 => 0
                            ];
                            $totalReviews = 0;

                            // Fetch the review counts and update the ratings array
                            while ($avg = mysqli_fetch_assoc($get_query)) {
                                $ratings[$avg['Rating']] = $avg['count'];
                                $totalReviews += $avg['count'];
                            }

                            function calculateRating($count, $total)
                            {
                                return ($total > 0) ? round(($count / $total) * 100, 2) : 0;
                            }
                            ?>
                            <?php
                            foreach (range(5, 1) as $star) {
                            ?>
                                <div class="flex items-center justify-between text-gray-600 text-sm font-medium">
                                    <div class="flex items-center gap-1">
                                        <p><?php echo isset($product_id) ? $star : '0'; ?></p><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="12" height="12" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                            <g>
                                                <path fill="#ffc107" d="m23.363 8.584-7.378-1.127L12.678.413c-.247-.526-1.11-.526-1.357 0L8.015 7.457.637 8.584a.75.75 0 0 0-.423 1.265l5.36 5.494-1.267 7.767a.75.75 0 0 0 1.103.777L12 20.245l6.59 3.643a.75.75 0 0 0 1.103-.777l-1.267-7.767 5.36-5.494a.75.75 0 0 0-.423-1.266z" opacity="1" data-original="#ffc107" class=""></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="relative w-full h-2 mx-3 m-auto rounded-md bg-gray-200">
                                        <div class="absolute top-0 left-0 w-full h-2 rounded-md bg-yellow-400" style="width: <?php echo calculateRating($ratings[$star], $totalReviews); ?>%;"></div>
                                    </div>
                                    <span><?php echo isset($product_id) ? $ratings[$star] : '0'; ?></span>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <hr class="my-6">
                        <div class="flex flex-col gap-y-3">
                            <h1 class="text-lg font-medium">Review this product</h1>
                            <span class="text-sm font-normal">Share your thoughts with other customers</span>

                            <?php
                            if (isset($_COOKIE['user_id'])) {
                            ?>
                                <a href="add_review.php?product_id=<?php echo $product_id; ?>" class="text-sm font-medium text-white text-center bg-gray-700 py-3 hover:bg-gray-800 rounded-tl-xl rounded-br-xl transition duration-200">Write a review</a>
                            <?php
                            } else {
                            ?>
                                <a href="../authentication/user_auth/user_login.php" class="text-sm font-medium text-white text-center bg-gray-700 py-3 hover:bg-gray-800 rounded-tl-xl rounded-br-xl transition duration-200">Write a review</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <?php
                    if (isset($product_id)) {

                    ?>
                        <span class="text-2xl font-medium">Customer reviews (<?php echo isset($totalReviews) ? $totalReviews : '0' ?>)</span>
                        <hr class="mt-3">
                        <?php
                        if (!$rev) {
                        ?>
                            <h1 class="text-gray-700 text-sm font-medium bg-gray-100 text-center py-3 border mt-3">Ther are no review yet.</h1>
                        <?php
                        }
                        ?>
                        <div class="mt-7 flex flex-col gap-8 overflow-y-scroll py-4 h-max md:px-4 scrollBar">
                            <?php
                            $retrive_reivew = "SELECT * FROM user_review WHERE product_id = '$product_id'";
                            $retrive_reivew_query = mysqli_query($con, $retrive_reivew);

                            while ($row = mysqli_fetch_assoc($retrive_reivew_query)) {
                            ?>
                                <div>
                                    <div class="flex flex-col gap-y-4 items-start justify-between md:flex-row">
                                        <div class="flex item-center justify-center gap-3">
                                            <img class="w-12 h-12 rounded-full object-cover" src="<?php echo isset($_GET['product_id']) ? '../src/user_dp/' . $row['profile_image'] : 'profile_image' ?>" alt="">
                                            <div class="flex flex-col gap-0">
                                                <h2 class="font-medium text-base text-neutral-800"><?php echo isset($_GET['product_id']) ? $row['public_name'] : 'user Name' ?></span></h2>
                                                <p class="font-medium text-sm text-gray-500"><?php echo isset($_GET['product_id']) ? $row['date'] : 'review date' ?></p>
                                            </div>
                                        </div>
                                        <div class="flex item-center gap-1">
                                            <span class="bg-gray-900 rounded-tl-lg rounded-br-lg px-2 py-1 flex items-center gap-1">
                                                <h1 class="font-semibold text-sm text-white"><?php echo isset($_GET['product_id']) ? floatval($row['Rating']) : 'Rating' ?></h1>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.991 511" class="w-3 h-3 m-auto fill-current text-white">
                                                    <path d="M510.652 185.883a27.177 27.177 0 0 0-23.402-18.688l-147.797-13.418-58.41-136.75C276.73 6.98 266.918.497 255.996.497s-20.738 6.483-25.023 16.53l-58.41 136.75-147.82 13.418c-10.837 1-20.013 8.34-23.403 18.688a27.25 27.25 0 0 0 7.937 28.926L121 312.773 88.059 457.86c-2.41 10.668 1.73 21.7 10.582 28.098a27.087 27.087 0 0 0 15.957 5.184 27.14 27.14 0 0 0 13.953-3.86l127.445-76.203 127.422 76.203a27.197 27.197 0 0 0 29.934-1.324c8.851-6.398 12.992-17.43 10.582-28.098l-32.942-145.086 111.723-97.964a27.246 27.246 0 0 0 7.937-28.926zM258.45 409.605"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <h1 class="font-medium mb-3"><?php echo isset($_GET['product_id']) ? $row['Headline'] : 'headline' ?></h1>
                                        <p><?php echo isset($_GET['product_id']) ? $row['description'] : 'reivew details' ?></p>
                                    </div>
                                </div>
                                <hr>
                            <?php
                            }
                            ?>

                        </div>
                    <?php
                    } else {
                    ?>
                        <span class="text-2xl font-medium">Customer Reviews (<?php echo isset($totalReviews) ? $totalReviews : '0' ?>)</span>
                        <hr class="mt-3">
                        <h1 class="text-gray-700 text-sm font-medium bg-gray-100 text-center py-3 border mt-3">Ther are no review yet.</h1>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php
    include "../pages/_footer.php";
    ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            thumbs: {
                swiper: swiper,
            },
        });
    </script>


    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>