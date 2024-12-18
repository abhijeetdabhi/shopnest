<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: /shopnest/index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}

if(!isset($_GET['vendor_id'])){
    header("Location: view_vendors.php");
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
            <section class="py-4 px-6 overflow-auto">
            <?php
                include "../include/connect.php";
                if (isset($_COOKIE['adminEmail'])) {
                    $vendor_id = $_GET['vendor_id'];
                    $product_find = "SELECT * FROM products WHERE vendor_id = '$vendor_id'";
                    $product_query = mysqli_query($con, $product_find);

                ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-y-8 gap-x-8 text-[#1d2128] mt-4">
                        <?php
                        if(mysqli_num_rows($product_query) > 0){
                            while ($res = mysqli_fetch_assoc($product_query)) {
                                $vendor_id = $res['vendor_id'];
                                
                                $get_vendor = "SELECT * FROM `vendor_registration` WHERE vendor_id = '$vendor_id'";
                                $vendor_query = mysqli_query($con, $get_vendor);
                                $row = mysqli_fetch_assoc($vendor_query);

                                ?>
                                    <div class="bg-white rounded-tl-xl rounded-br-xl shadow-sm overflow-hidden max-w-xs w-full h-[33.5rem] relative">
                                        <div class="relative flex justify-center p-2">
                                            <a href="../src/product_image/"></a>
                                            <img src="<?php echo isset($_COOKIE['adminEmail']) ? '../src/product_image/product_profile/' . $res['profile_image_1'] : '../src/sample_images/product_1.jpg' ?>" alt="Product Image" class="h-56 w-full object-contain rounded-tl-2xl rounded-br-2xl">
                                            <?php
                                            $conditionClass = isset($_COOKIE['adminEmail']) ? ($res['Item_Condition'] === 'Old Condition' ? 'bg-orange-500' : 'bg-green-500'): 'bg-green-500';
                                            ?>
                                            <span class="absolute top-2 right-2 <?php echo $conditionClass; ?> px-2 pt-0.5 pb-1 text-white text-xs font-semibold tracking-wide rounded-tl-lg rounded-br-lg">
                                                <?php echo isset($_COOKIE['adminEmail']) ? $res['Item_Condition'] : 'Item_Condition'; ?>
                                            </span>
                                            <!-- php for change background color for item condition -->
                                        </div>
                                        <div class="px-4 pt-2">
                                            <h2 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-2"><?php echo isset($_COOKIE['adminEmail']) ? $res['title'] : 'title' ?></h2>
                                            <a href="../vendor/vendor_store.php?vendor_id=<?php echo $res['vendor_id'] ?>" class="text-sm text-gray-600 mb-3">By: <span class="font-bold text-base text-gray-600"><?php echo isset($_COOKIE['adminEmail']) ? $row['username'] : 'username' ?></span></a>
                                            <div class="text-gray-600 text-sm mb-2 space-y-1">
                                                <p>Company: <span class="font-medium"><?php echo isset($_COOKIE['adminEmail']) ? $res['company_name'] : 'company_name' ?></span></p>
                                                <p>Category: <span class="font-medium"><?php echo isset($_COOKIE['adminEmail']) ? $res['Category'] : 'Category' ?></span></p>
                                                <p>Date: <span class="font-medium"><?php echo isset($_COOKIE['adminEmail']) ? $res['date'] : 'date' ?></span></p>
                                            </div>
                                            <div>
                                                <p class="text-md font-semibold text-gray-900">₹<?php echo isset($_COOKIE['adminEmail']) ? $res['vendor_mrp'] : 'MRP' ?></p>
                                                <p class="text-sm font-medium text-gray-500 line-through">₹<?php echo isset($_COOKIE['adminEmail']) ? $res['vendor_price'] : 'Delete Price' ?></p>
                                            </div>
                                        </div>
                                        <div class="w-full flex justify-between h-10 divide-x-2 border-t-2 mt-2 absolute bottom-0">
                                            <a href="edit_vendor_products.php?product_id=<?php echo $res['product_id'] ?>&name=<?php echo $res['Category'] ?>" class="px-1 w-full inline-flex justify-center items-center gap-1 text-green-500 hover:text-green-600 transition duration-200 cursor-pointer">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                                <span>Edit</span>
                                            </a>
                                            <a href="remove_product.php?product_id=<?php echo $res['product_id'] ?>" class="px-1 w-full inline-flex justify-center items-center gap-1 text-red-500 hover:text-red-600 transition duration-200 cursor-pointer">
                                                <i class="fa-solid fa-trash text-base"></i>
                                                <span>Remove</span>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                            }
                        }else{
                            ?>
                                <div class="col-span-full font-bold text-xl md:text-2xl w-max m-auto py-4">No Product Found for this period.</div>
                            <?php
                        }
                        ?>
                    </div>
                <?php
                } else{
                    ?>
                        <div class="font-bold text-xl md:text-2xl w-max m-auto py-4">No Product Found for this period.</div>
                    <?php
                }
                ?>
            </section>
        </div>
    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>