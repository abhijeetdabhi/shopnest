<?php
include "../include/connect.php";


if (isset($_GET['vendor_id'])) {
    $vendor_id = $_GET['vendor_id'];
    $retrieve_data = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);

    $vendor_coverImg = $row['cover_image'];
    $vendor_profileImg = $row['dp_image'];
    $vendor_userName = $row['username'];
    $vendor_Bio = $row['Bio'];
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
    <title>Vendor Store</title>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
    include "../pages/_navbar.php";
    ?>


    <div class="max-w-screen-xl m-auto">
        <div class="my-12 bg-white shadow-lg">
            <div class="relative">
                <div class="relative">
                    <img class="h-40 md:h-64 w-full object-cover" src="<?php echo '../src/vendor_images/vendor_cover_image/' . $vendor_coverImg ?>" alt="">
                </div>
            </div>
            <div class="relative m-auto -translate-y-20">
                <img class="bg-white/20 filter backdrop-blur-xl p-3 w-28 h-28 md:w-40 md:h-40 m-auto rounded-full object-cover" src="<?php echo  '../src/vendor_images/vendor_profile_image/' . $vendor_profileImg ?>" alt="">
                <input type="file" id="dpImage" name="dp" class="hidden">
            </div>
            <div class="m-auto text-center -mt-28 py-8">
                <div class="mt-3">
                    <h2 class="text-2xl font-medium text-gray-950"><?php echo isset($_GET['vendor_id']) ? $vendor_userName : 'vendor_userName' ?></h2>
                    <span class="text-base font-medium text-gray-400 mt-2 mb-7">Seller</span>
                </div>
                <div class="mt-6">
                    <h3 class="text-base font-medium text-gray-950">About me</h3>
                    <p class="text-sm font-normal text-gray-800 mt-4 max-w-3xl m-auto"><?php echo isset($_GET['vendor_id']) ? $vendor_Bio : 'vendor_Bio' ?></p>
                </div>
            </div>
        </div>

        <div>
            <h1 class="text-2xl font-bold">All Products</h1>
            <div class="grid grid-cols-4 gap-4">
                <?php
                if (isset($_GET['vendor_id'])) {
                    $vendor_products = "SELECT * FROM products WHERE vendor_id = '$vendor_id'";
                    $vendorProduct_query = mysqli_query($con, $vendor_products);

                    while ($res = mysqli_fetch_assoc($vendorProduct_query)) {
                        $product_id = $res['product_id'];

                        $MRP = $res['vendor_mrp'];

                        $get_reviews = "SELECT * FROM user_review WHERE product_id = '$product_id'";
                        $review_query = mysqli_query($con, $get_reviews);

                        $totalReviews = mysqli_num_rows($review_query);

                        $sum = 0;
                        $count = 0;
                        if ($totalReviews > 0) {         
                            while ($data = mysqli_fetch_assoc($review_query)) {
                                $rating = str_replace(",", "", $data['Rating']);
                                $sum += (float)$rating;
                                $count++;
                            }
                            
                            $average = $sum / $count;
                            $formatted_average = number_format($average, 1);
                        }else {
                            $formatted_average = "0.0";
                        }

                        // for qty
                        $qty = 1;
            
                        // for the size
                        $size = $res['size'];
                        $filter_size = explode(',', $size);
                        foreach ($filter_size as $product_size) {
                            $product_size;
                            break;
                        }
                ?>
                            <li class="splide__slide flex justify-center mt-3">
                                <div class="card flex flex-col items-center ring-2 ring-gray-300 rounded-tl-2xl rounded-br-2xl hover:ring-none w-64 overflow-hidden">
                                    <div class="p-2" onclick="window.location.href = '../product/product_detail.php?product_id=<?php echo $res['product_id']; ?>'">
                                        <img src="<?php echo '../src/product_image/product_profile/' . $res['profile_image_1']; ?>" alt="" class="product-card__hero-image css-1fxh5tw h-56 w-64 object-fill rounded-tl-2xl rounded-br-2xl" loading="lazy" sizes="">
                                    </div>
                                    <div class="mt-2 space-y-3" onclick="window.location.href = '../product/product_detail.php?product_id=<?php echo $res['product_id']; ?>'">
                                        <a href="../product/product_detail.php?product_id=<?php echo $res['product_id'] ?>" class="text-sm font-medium line-clamp-2 cursor-pointer px-2"><?php echo $res['title'] ?></a>
                                        <div class="flex justify-between px-2">
                                            <p class="space-x-1">
                                                <span class="text-lg font-medium text-gray-900">₹<?php echo $MRP ?></span>
                                                <del class="text-xs font-medium">₹<?php echo $res['vendor_price'] ?></del>
                                            </p>
                                            <div class="flex items-center">
                                                <span class="bg-gray-900 rounded-tl-md rounded-br-md px-2 py-0.5 flex items-center gap-1">
                                                    <h1 class="font-semibold text-xs text-white"><?php echo isset($formatted_average) ? $formatted_average : '0.0' ?></h1>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.991 511" class="w-2.5 h-2.5 m-auto fill-current text-white">
                                                        <path d="M510.652 185.883a27.177 27.177 0 0 0-23.402-18.688l-147.797-13.418-58.41-136.75C276.73 6.98 266.918.497 255.996.497s-20.738 6.483-25.023 16.53l-58.41 136.75-147.82 13.418c-10.837 1-20.013 8.34-23.403 18.688a27.25 27.25 0 0 0 7.937 28.926L121 312.773 88.059 457.86c-2.41 10.668 1.73 21.7 10.582 28.098a27.087 27.087 0 0 0 15.957 5.184 27.14 27.14 0 0 0 13.953-3.86l127.445-76.203 127.422 76.203a27.197 27.197 0 0 0 29.934-1.324c8.851-6.398 12.992-17.43 10.582-28.098l-32.942-145.086 111.723-97.964a27.246 27.246 0 0 0 7.937-28.926zM258.45 409.605"></path>
                                                    </svg>
                                                </span>
                                                <span class="text-sm ml-2 text-gray-900 tracking-wide">(<?php echo $totalReviews ?>)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-600 w-full mt-2 py-1.5 flex justify-center">
                                        <?php
                                            if($qty > 0){
                                                ?>
                                                    <a href="<?php echo $qty > 0 ? '../shopping/add_to_cart.php?product_id=' . urlencode($product_id) . '&size=' . $product_size . '&qty=' . $qty . '&MRP=' . $MRP : '#'; ?>" class="bg-white border-2 border-gray-800 text-gray-900 rounded-tl-xl rounded-br-xl w-40 py-1 text-sm font-semibold text-center">Add to cart</a>
                                                <?php
                                            }else{
                                                ?>
                                                    <h1 class="bg-white border-2 border-gray-800 text-red-600 rounded-tl-xl rounded-br-xl w-40 py-1 text-sm font-semibold text-center cursor-default select-none">Out of Stock</h1>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </li>
                <?php
                    }
                }
                ?>
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