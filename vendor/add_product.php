<?php

if (!isset($_GET['name'])) {
    header("Location: choose_product.php");
    exit;
}

if (isset($_COOKIE['user_id'])) {
    header("Location: ../user/profile.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<?php
session_start();

include "../include/connect.php";


if (isset($_COOKIE['vendor_id'])) {
    $vendor_id = $_COOKIE['vendor_id'];

    $retrieve_data = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);
}

if (isset($_GET['name'])) {
    $product = $_GET['name'];
}

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    $findProduct = "SELECT * FROM products WHERE product_id = '$productId'";
    $findProductQuery = mysqli_query($con, $findProduct);

    if(mysqli_num_rows($findProductQuery)){
        while($prdc = mysqli_fetch_assoc($findProductQuery)){
            $productTitle = $prdc['title'];
            $productCompanyName = $prdc['company_name'];
            $productType = $prdc['Type'];
            $productMRP = $prdc['vendor_mrp'];
            $productVendorPrice = $prdc['vendor_price'];
            $productCondition = $prdc['Item_Condition'];
            $productDescription = $prdc['Description'];
            $productColor = $prdc['color'];
            $size = $prdc['size'];
            $sizeExplode = explode(',', $size);
            $productSize = $sizeExplode[0];
        }
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Add Products</title>

    <style>
        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
            font-size: medium;
        }

        #logoutPopUp {
            display: none;
        }
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <div>
        <?php
        include "vendor_logout.php";
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-600">
        <div class="flex items-center justify-center">
            <a class="flex items-center" href="choose_product.php">
                <!-- icon logo div -->
                <div class="mr-2">
                    <img class="w-7 sm:w-14" src="../src/logo/black_cart_logo.svg" alt="Cart Logo">
                </div>
                <!-- text logo -->
                <div>
                    <img class="w-20 sm:w-36" src="../src/logo/black_text_logo.svg" alt="Shopnest Logo">
                </div>
            </a>
        </div>
        <div class="flex items-center">
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="relative block w-8 h-8 md:w-10 md:h-10 overflow-hidden rounded-full shadow-lg focus:outline-none transition-transform transform hover:scale-105">
                    <img class="object-cover w-full h-full" src="<?php echo isset($_COOKIE['vendor_id']) ? '../src/vendor_images/vendor_profile_image/' . $row['dp_image'] : 'https://cdn-icons-png.freepik.com/512/3682/3682323.png'; ?>" alt="Your avatar">
                </button>
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 z-10 w-48 mt-2 bg-white rounded-md shadow-xl ring-1 ring-gray-300 divide-y-2 divide-gray-200 overflow-hidden" style="display: none;">
                    <a href="vendor_profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white transition-colors">Profile</a>
                    <a href="view_products.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white transition-colors">Products</a>
                    <a id="logoutButton1" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white transition-colors">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <!-- script for logout popup -->
    <script>
        // Select elements
        const logoutPopUp = document.getElementById('logoutPopUp');
        const logoutButton1 = document.getElementById('logoutButton1');

        // Function to show the logout popup
        function showLogoutPopup() {
            logoutPopUp.style.display = 'flex'; // Show the popup
        }

        // Function to hide the logout popup
        function closePopup() {
            logoutPopUp.style.display = 'none'; // Hide the popup
        }

        // Add click event listeners to logout buttons
        logoutButton1.addEventListener('click', (event) => {
            event.preventDefault();
            showLogoutPopup();
        });

        // Add a global event listener to the Cancel button
        document.addEventListener('click', (event) => {
            if (event.target.matches('.cancel-button')) {
                closePopup();
            }
        });
    </script>

    <!-- component -->
    <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
        <div class="container max-w-screen-lg font-medium text-gray-800 mx-auto">
            <h1 class="bg-gray-100 text-2xl font-bold flex items-center justify-center mb-6">Add products</h1>
            <div class="space-y-4 my-5">
                <div>
                    <label for="ListingProducts" class="text-green-500 text-sm block mb-2">
                        This box is for adding a product. Search for the product name, and if available, suggestions will appear. Click on a product, and all important details will be filled in automatically.
                    </label>
                    <input type="search" name="ListingProducts" id="ListingProducts" class="h-10 border mt-1 rounded-md px-4 w-full bg-white focus:ring-gray-600 focus:border-gray-600 transition" placeholder="Search For Listing Products" />
                </div>
                <div style="display: none;" id="suggestions" class="w-full overflow-y-auto bg-white p-4 space-y-4 rounded-md mt-3 shadow-md" style="max-height: calc(3 * 10rem + 2 * 1rem);">
                    
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $("#ListingProducts").on('input', function() {
                        let word = $(this).val();

                        if(word.length > 2){
                            $("#suggestions").css('display', 'block');

                            $.ajax({
                                type: "post",
                                url: "search.php",
                                data: {searchWord: word},
                                success: function (response) {
                                    $("#suggestions").html(response);
                                }
                            });
                        }else{
                            $("#suggestions").css('display', 'none');
                        }
                    });
                });
            </script>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 lg:grid-cols-1">
                    <div class="lg:col-span-2">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="grid gap-4 gap-y-4 items-center text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5">
                                    <label for="same_id" class="require">Product Id:</label>
                                    <input type="text" name="same_id" id="same_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['same_id']) ? $_SESSION['same_id'] : ''; ?>" />

                                    <p id="showError" class="text-red-600 mt-1" style="display:none;">* This Product ID is already in use. Please choose a different one.</p>
                                    <p id="showsuccess" class="text-green-600 mt-1" style="display:none;">* This Product ID is available and can be used.</p>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="full_name" class="require">Product tital:</label>
                                    <input type="text" name="full_name" id="full_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : (isset($_GET['productId']) ? $productTitle : '');?>" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="Company_name" class="require">Company name:</label>
                                    <input type="text" name="Company_name" id="Company_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['Company_name']) ? $_SESSION['Company_name'] : (isset($_GET['productId']) ? $productCompanyName : '') ;?>" placeholder="" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="category" class="require">Category:</label>
                                    <input type="text" name="Category" id="Category" class="hover:cursor-not-allowed opacity-60 h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($product) ? $product : 'Category' ?>" placeholder="" disabled />
                                </div>

                                <div class="md:col-span-1">
                                    <label for="type" class="require">Type:</label>
                                    <input type="text" name="type" id="type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['type']) ? $_SESSION['type'] : (isset($_GET['productId']) ? $productType : ''); ?>" placeholder="" />
                                </div>

                                <div class="md:col-span-3">
                                    <label for="MRP" class="require">Sell Price:</label>
                                    <div class="relative">
                                        <input type="number" name="MRP" id="MRP" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 pl-10 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['MRP']) ? $_SESSION['MRP'] : (isset($_GET['productId']) ? $productMRP : ''); ?>" placeholder="" />
                                        <div class="absolute left-0 rounded-l top-1 w-9 h-10 bg-white border border-gray-500 m-auto text-center flex items-center justify-center">₹</div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="your_price" class="require">MRP:</label>
                                    <div class="relative">
                                        <input type="number" name="your_price" id="your_price" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 pl-10 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['your_price']) ? $_SESSION['your_price'] : (isset($_GET['productId']) ? $productVendorPrice : ''); ?>" placeholder="" />
                                        <div class="absolute left-0 rounded-l top-1 w-9 h-10 bg-white border border-gray-500 m-auto text-center flex items-center justify-center">₹</div>
                                    </div>
                                </div>

                                <div class="md:col-span-3">
                                    <label for="quantity" class="require">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['quantity']) ? $_SESSION['quantity'] : ''; ?>" placeholder="" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="condition" class="require">Item condition:</label>
                                    <select name="condition" id="condition" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['condition']) ? $_SESSION['condition'] : (isset($_GET['productId']) ? $productCondition : ''); ?>">
                                        <option value="New Condition">New condition</option>
                                        <option value="Old Condition">Old condition</option>
                                    </select>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="description" class="require">Description:</label>
                                    <textarea name="description" id="description" class="h-32 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600 resize-none" value="" placeholder=""><?php echo isset($_SESSION['description']) ? $_SESSION['description'] : (isset($_GET['productId']) ? $productDescription : ''); ?></textarea>
                                </div>

                                <div class="md:col-span-5 mt-5">
                                    <label for="size" class="require">Size:</label>
                                    <div id="size-container" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 mt-2 gap-3">
                                        <input type="text" name="size[]" value="<?php echo isset($_GET['productId']) ? $productSize : ''; ?>" placeholder="Enter size" class="h-10 border rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600">
                                    </div>
                                    <button id="add-size" class="px-4 py-2 bg-gray-600 text-white rounded-tl-lg rounded-br-lg mt-2">Add more size</button>
                                </div>

                                <div class="md:col-span-5 mt-5">
                                    <label for="color">Color:</label>
                                    <div class="relative mt-2">
                                        <input type="text" id="colorInput" name="color" placeholder="Type a color..." class="h-10 border rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" autocomplete="off" value="<?php echo isset($_SESSION['color']) ? $_SESSION['color'] : (isset($_GET['productId']) ? $productColor : ''); ?>">
                                        <div id="colorSuggestions" class="absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-lg z-10 hidden"></div>
                                    </div>
                                </div>

                                <div class="md:col-span-5 mt-4 mb-10">
                                    <label for="" class=" require">Images:</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-y-12 gap-5 mt-5">
                                        <div class="w-full relative">
                                            <div id="previewWrapper1" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('imageInput1').click();">
                                                <img id="previewImage1" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 1">
                                                <h2 id="imageText1" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert product image 1
                                                </h2>
                                            </div>
                                            <input class="hidden" name="ProfileImage1" accept="image/jpg, image/png, image/jpeg" type="file" id="imageInput1" onchange="productImagePreview(event, 'previewImage1', 'imageText1')">
                                            <small id="error-message1" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>

                                        <div class="w-full relative">
                                            <div id="previewWrapper2" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('imageInput2').click();">
                                                <img id="previewImage2" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 2">
                                                <h2 id="imageText2" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert product image 2
                                                </h2>
                                            </div>
                                            <input class="hidden" name="ProfileImage2" accept="image/jpg, image/png, image/jpeg" type="file" id="imageInput2" onchange="productImagePreview(event, 'previewImage2', 'imageText2')">
                                            <small id="error-message2" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>

                                        <div class="w-full relative">
                                            <div id="previewWrapper3" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('imageInput3').click();">
                                                <img id="previewImage3" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 3">
                                                <h2 id="imageText3" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert product image 3
                                                </h2>
                                            </div>
                                            <input class="hidden" name="ProfileImage3" accept="image/jpg, image/png, image/jpeg" type="file" id="imageInput3" onchange="productImagePreview(event, 'previewImage3', 'imageText3')">
                                            <small id="error-message3" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>

                                        <div class="w-full relative">
                                            <div id="previewWrapper4" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('imageInput4').click();">
                                                <img id="previewImage4" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 4">
                                                <h2 id="imageText4" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert product image 4
                                                </h2>
                                            </div>
                                            <input class="hidden" name="ProfileImage4" accept="image/jpg, image/png, image/jpeg" type="file" id="imageInput4" onchange="productImagePreview(event, 'previewImage4', 'imageText4')">
                                            <small id="error-message4" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-5 mb-10">
                                    <label for="" class="require">Cover images:</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-y-12 gap-5 mt-5">
                                        <div class="w-full relative">
                                            <div id="coverImageWrapper1" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('coverImageInput1').click();">
                                                <img id="coverPreviewImage1" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 1">
                                                <label id="coverImageText1" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert cover image 1
                                                </label>
                                            </div>
                                            <input class="hidden" name="CoverImage1" accept="image/jpg, image/png, image/jpeg" type="file" id="coverImageInput1" onchange="productImagePreview(event, 'coverPreviewImage1', 'coverImageText1')">
                                            <small id="coverImage-error-message1" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>

                                        <div class="w-full relative">
                                            <div id="coverImageWrapper2" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('coverImageInput2').click();">
                                                <img id="coverPreviewImage2" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 1">
                                                <label id="coverImageText2" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert cover image 2
                                                </label>
                                            </div>
                                            <input class="hidden" name="CoverImage2" accept="image/jpg, image/png, image/jpeg" type="file" id="coverImageInput2" onchange="productImagePreview(event, 'coverPreviewImage2', 'coverImageText2')">
                                            <small id="coverImage-error-message2" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>

                                        <div class="w-full relative">
                                            <div id="coverImageWrapper3" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('coverImageInput3').click();">
                                                <img id="coverPreviewImage3" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 1">
                                                <label id="coverImageText3" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert cover image 3
                                                </label>
                                            </div>
                                            <input class="hidden" name="CoverImage3" accept="image/jpg, image/png, image/jpeg" type="file" id="coverImageInput3" onchange="productImagePreview(event, 'coverPreviewImage3', 'coverImageText3')">
                                            <small id="coverImage-error-message3" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>

                                        <div class="w-full relative">
                                            <div id="coverImageWrapper4" class="relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-48" onclick="document.getElementById('coverImageInput4').click();">
                                                <img id="coverPreviewImage4" class="w-full h-48 z-50 object-cover object-center hidden" src="" alt="Product Image 1">
                                                <label id="coverImageText4" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                                    Insert cover image 4
                                                </label>
                                            </div>
                                            <input class="hidden" name="CoverImage4" accept="image/jpg, image/png, image/jpeg" type="file" id="coverImageInput4" onchange="productImagePreview(event, 'coverPreviewImage4', 'coverImageText4')">
                                            <small id="coverImage-error-message4" class="text-red-500 mt-2 absolute text-xs hidden">The product image must be a file type of: PNG, JPG, or JPEG.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-7">
                                <div>
                                    <a href="choose_product.php" class="bg-black text-white font-semibold py-2 px-6 sm:px-8 rounded-tl-lg rounded-br-lg cursor-pointer inline-flex items-center gap-1">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 31.418 31.418" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-3">
                                                <g>
                                                    <path d="M26.585 3v25.418a3.002 3.002 0 0 1-4.883 2.335L5.949 18.044a2.999 2.999 0 0 1 0-4.67L21.703.665a3.004 3.004 0 0 1 3.178-.372A3.003 3.003 0 0 1 26.585 3z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                                                </g>
                                            </svg>
                                        </span>
                                        <span>Back</span>
                                    </a>
                                </div>
                                <div>
                                    <input type="submit" value="Submit" name="submitBtn" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 sm:px-8 rounded-tl-lg rounded-br-lg cursor-pointer inline-flex items-center gap-1">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#same_id').on("input", function(e) {
                e.preventDefault();

                let sameId = $('#same_id').val();

                $.ajax({
                    type: "POST",
                    url: "checkId.php",
                    data: {
                        sameId: sameId
                    },
                    success: function(response) {
                        if (response === 'taken') {
                            // ID is already taken
                            $('#showError').show();
                            $('#showsuccess').hide();
                        } else if (response === 'available') {
                            // ID is available
                            $('#showsuccess').show();
                            $('#showError').hide();
                        }
                    },
                    error: function() {
                        console.log("AJAX request failed.");
                    }
                });
            });
        });
    </script>


    <!-- Successfully message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 m-auto rounded-lg border-green-400 py-3 px-6 bg-gray-800 z-50" id="SpopUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="Successfully"></div>
        </div>
    </div>


    <!-- Error message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 rounded-lg border-red-500 py-3 px-6 bg-gray-800 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-red-400">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="errorMessage"></div>
        </div>
    </div>

    <!-- loader  -->
    <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm z-40" style="display: none;">
        <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-gray-700 rounded-full">
            <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-gray-900 rounded-full"></div>
        </div>
    </div>

    <script>
        function loader() {
            let loader = document.getElementById('loader');
            let body = document.body;

            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
        }

        function displayErrorMessage(message) {
            let popUp = document.getElementById('popUp');
            let errorMessage = document.getElementById('errorMessage');

            errorMessage.innerHTML = '<span class="font-medium">' + message + '</span>';
            popUp.style.display = 'flex';
            popUp.style.opacity = '100';

            setTimeout(() => {
                popUp.style.display = 'none';
                popUp.style.opacity = '0';
            }, 1800);
        }

        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');

            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = "choose_product.php";
            }, 2000);
        } 
    </script>

    <script src="product.js"></script>

    <script>
        const suggestionsData = [
            'XS (Extra Small)', 'S (Small)', 'M (Medium)', 'L (Large)', 'XL (Extra Large)', 'XXL (Double Extra Large)', 'XXXL (Triple Extra Large)',
            '4 UK', '5 UK', '6 UK', '7 UK', '8 UK', '9 UK', '10 UK', '11 UK', '12 UK',
            '32 inches', '40 inches', '43 inches', '50 inches', '55 inches', '65 inches', '75 inches', '85 inches',
            '100L', '200L', '300L', '400L', '500L', '600L',
            '6 kg', '7 kg', '8 kg', '9 kg', '10 kg', '12 kg',
            '16GB', '32GB', '64GB', '128GB', '256GB', '512GB', '1TB', '2TB',
            '2GB - 32GB', '4GB - 64GB', '6GB - 128GB', '8GB - 256GB', '12GB - 512GB', '16GB - 1TB',
            '4GB - 128GB', '8GB - 256GB', '8GB - 1TB', '16GB - 512GB', '16GB - 2TB', '32GB - 1TB', '32GB - 2TB', '64GB - 1TB', '64GB - 2TB',
            '3GB - 64GB', '4GB - 256GB', '6GB - 512GB', '8GB - 1TB'
        ];

        document.getElementById('add-size').addEventListener('click', function(event) {
            event.preventDefault();

            const sizeContainer = document.getElementById('size-container');
            const sizeInputs = sizeContainer.querySelectorAll('input[name="size[]"]');
            const mrpInputs = sizeContainer.querySelectorAll('input[name="mrp[]"]');
            const priceInputs = sizeContainer.querySelectorAll('input[name="your_price[]"]');

            // Check if all size, MRP, and Price input fields are filled
            for (const input of sizeInputs) {
                if (!input.value || isInvalidSize(input.value)) {
                    alert("Please enter valid size values (not empty, '-' or 'none').");
                    return; // Exit if any input is empty or invalid
                }
            }

            for (const input of mrpInputs) {
                if (!input.value) {
                    alert("Please fill in all MRP fields before adding more sizes.");
                    return; // Exit if any MRP input is empty
                }
            }

            for (const input of priceInputs) {
                if (!input.value) {
                    alert("Please fill in all Your Price fields before adding more sizes.");
                    return; // Exit if any Price input is empty
                }
            }

            // Create a new size item if all inputs are filled and valid
            const sizeItem = createSizeItem(false);
            sizeContainer.appendChild(sizeItem);
        });

        function isInvalidSize(size) {
            const invalidValues = ['-', 'none', 'NONE', 'None']; // Add any other variations as needed
            return invalidValues.includes(size);
        }

        function createSizeItem(isFirst) {
            const sizeItem = document.createElement('div');
            sizeItem.className = 'size-item mb-4 relative';

            const sizeInput = document.createElement('input');
            sizeInput.type = 'text';
            sizeInput.name = 'size[]';
            sizeInput.value = '';
            sizeInput.placeholder = 'Enter size';
            sizeInput.className = 'h-10 border rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600';

            const suggestionsContainer = document.createElement('div');
            suggestionsContainer.className = 'absolute bg-white border border-gray-300 mt-1 z-10 w-full rounded-lg hidden';

            // Handle input event for suggestions
            sizeInput.addEventListener('input', () => {
                const query = sizeInput.value.toLowerCase();
                suggestionsContainer.innerHTML = ''; // Clear existing suggestions
                if (query) {
                    const filteredSuggestions = suggestionsData.filter(item => item.toLowerCase().includes(query));
                    if (filteredSuggestions.length) {
                        filteredSuggestions.forEach(suggestion => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'p-2 cursor-pointer hover:bg-gray-100';
                            suggestionItem.textContent = suggestion;
                            suggestionItem.addEventListener('click', () => {
                                sizeInput.value = suggestion;
                                suggestionsContainer.innerHTML = '';
                                suggestionsContainer.classList.add('hidden');
                            });
                            suggestionsContainer.appendChild(suggestionItem);
                        });
                        suggestionsContainer.classList.remove('hidden');
                    } else {
                        suggestionsContainer.classList.add('hidden');
                    }
                } else {
                    suggestionsContainer.classList.add('hidden');
                }
            });

            // Close suggestions if clicking outside
            document.addEventListener('click', (event) => {
                if (!sizeItem.contains(event.target) && !sizeInput.contains(event.target)) {
                    suggestionsContainer.classList.add('hidden');
                }
            });

            // Append the inputs to the size item
            sizeItem.appendChild(sizeInput);
            sizeItem.appendChild(suggestionsContainer);

            // Only add MRP, Your Price, and Remove button if not the first input
            if (!isFirst) {
                // Create the input element for MRP
                const mrpInput = document.createElement('input');
                mrpInput.type = 'number';
                mrpInput.name = 'MRP2[]';
                mrpInput.placeholder = 'Enter MRP';
                mrpInput.className = 'h-10 border rounded px-4 w-full bg-gray-50 mt-2 focus:ring-gray-600 focus:border-gray-600';

                // Create the input element for Your Price
                const priceInput = document.createElement('input');
                priceInput.type = 'number';
                priceInput.name = 'your_price2[]';
                priceInput.placeholder = 'Enter Your Price';
                priceInput.className = 'h-10 border rounded px-4 w-full bg-gray-50 mt-2 focus:ring-gray-600 focus:border-gray-600';

                // Create the remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'p-2 text-red-500 bg-red-100 rounded focus:outline-none mt-2 focus:ring-gray-600 focus:border-gray-600';
                removeButton.innerHTML = 'Remove';

                // Unique remove button functionality
                removeButton.addEventListener('click', function() {
                    sizeItem.remove();
                });

                // Append MRP and Price inputs and remove button to the size item
                sizeItem.appendChild(mrpInput);
                sizeItem.appendChild(priceInput);
                sizeItem.appendChild(removeButton);
            }

            return sizeItem;
        }

        // color suggetions
        const colors = [
            "Amber", "Almond", "Aqua", "Apricot", "Ash", "Beige", "Black", "Blush", "Bone", "Bordeaux",
            "Brown", "Burgundy", "Burnt Orange", "Cabernet", "Canary", "Champagne", "Charcoal", "Chocolate",
            "Cocoa", "Coffee", "Copper", "Cordovan", "Coral", "Cream", "Crimson", "Cobalt", "Cyan",
            "Deep Teal", "Ebony", "Eggplant", "Eggshell", "Emerald", "Fuchsia", "Forest Green", "Gold",
            "Gold Leaf", "Goldenrod", "Graphite", "Gray", "Green", "Hot Pink", "Ivory", "Khaki",
            "Lavender", "Lemon", "Lilac", "Lime", "Maroon", "Magenta", "Mint", "Midnight", "Mustard",
            "Navy", "Olive", "Onyx", "Orange", "Orchid", "Peach", "Pearl", "Periwinkle", "Plum",
            "Powder Blue", "Purple", "Raspberry", "Red", "Rose", "Rust", "Salmon", "Sand", "Scarlet",
            "Seafoam", "Sea Green", "Silver", "Sky Blue", "Slate", "Steel", "Tan", "Tangerine", "Teal",
            "Thistle", "Turquoise", "Violet", "White", "Wine", "Wintergreen", "Wisteria", "Yellow"
        ];


        const colorInput = document.getElementById('colorInput');
        const colorSuggestions = document.getElementById('colorSuggestions');

        colorInput.addEventListener('input', () => {
            const query = colorInput.value.toLowerCase();
            colorSuggestions.innerHTML = ''; // Clear existing suggestions
            if (query) {
                const filteredColors = colors.filter(color => color.toLowerCase().includes(query));
                if (filteredColors.length) {
                    filteredColors.forEach(color => {
                        const colorItem = document.createElement('div');
                        colorItem.className = 'p-2 cursor-pointer hover:bg-gray-100 ';
                        colorItem.textContent = color;
                        colorItem.addEventListener('click', () => {
                            colorInput.value = color;
                            colorSuggestions.innerHTML = '';
                            colorSuggestions.classList.add('hidden');
                        });
                        colorSuggestions.appendChild(colorItem);
                    });
                    colorSuggestions.classList.remove('hidden');
                } else {
                    colorSuggestions.classList.add('hidden');
                }
            } else {
                colorSuggestions.classList.add('hidden');
            }
        });

        document.addEventListener('click', (event) => {
            if (!colorSuggestions.contains(event.target) && event.target !== colorInput) {
                colorSuggestions.classList.add('hidden');
            }
        });
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>

<?php

include "../include/connect.php";

if (isset($_POST['submitBtn'])) {

    if (isset($_COOKIE['vendor_id'])) {
        $vendor_id = $_COOKIE['vendor_id'];
    }

    $Product_insert_Date = date('d-m-Y');

    $same_id = $_POST['same_id'];
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $Company_name = mysqli_real_escape_string($con, $_POST['Company_name']);
    $Category = mysqli_real_escape_string($con, $_GET['name']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $your_price = $_POST['your_price'];
    $MRP = $_POST['MRP'];
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $condition = mysqli_real_escape_string($con, $_POST['condition']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    if (isset($_POST['size']) && !empty($_POST['size'])) {
        $size = $_POST['size'];
        $size_filter = implode(",", $size);
        $normalized_size = array_map('strtolower', $size);

        if (is_array($size) && !empty($size) && !in_array('', $normalized_size) && !in_array('none', $normalized_size)) {
            $size_img = [];
            foreach ($size as $index => $psize) {
                if ($index === 0) {
                    // First size
                    $size_img[$psize] = [
                        'MRP' => $MRP,
                        'Your_Price' => $your_price,
                    ];
                } else {
                    $MRP2 = $_POST['MRP2'];
                    $your_price2 = $_POST['your_price2'];

                    if (isset($MRP2[$index - 1]) && isset($your_price2[$index - 1])) {
                        $size_img[$psize] = [
                            'MRP' => $MRP2[$index - 1],
                            'Your_Price' => $your_price2[$index - 1],
                        ];
                    }
                }
            }
            // Encode the size_img array to JSON
            $json_size_encode = json_encode($size_img);
        } else {
            $size_filter = '-';
            $size_img['N-A'] = [
                'MRP' => $MRP,
                'Your_Price' => $your_price,
            ];

            $json_size_encode = json_encode($size_img);
        }
    }

    function generateProductKeywords($product) {
        $category = $_GET['name'];
        $keywords = [];
    
        // Title & Brand Keywords
        $keywords[] = $product['title'];
        $keywords[] = $product['company_name'] . ' ' . strtolower($product['Type']);
        $keywords[] = 'best ' . $product['company_name'] . ' ' . strtolower($product['Type']);
        $keywords[] = $product['title'] . ' for sale';
    
    
        if ($category === 'Phones') {
            // Keywords for phones
            $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " phone under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " smartphone";
            $keywords[] = $product['Type'] . " with best features";
            $keywords[] = "Best " . $product['company_name'] . " phone for " . $product['MRP'];
            $keywords[] = "Affordable " . $product['company_name'] . " phone";
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for sale";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for men";
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " online";
            $keywords[] = "Buy " . $product['company_name'] . " phone under " . $product['MRP'];
            $keywords[] = "Latest " . $product['company_name'] . " smartphone for " . $product['Item_Condition'];
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for " . $product['MRP'];
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = "Best " . $product['company_name'] . " smartphone in " . $product['color'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
        } 
        elseif ($category === 'Tabs/Ipad') {
            // Keywords for tablets
            $keywords[] = "Best tablet under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " tablet for sale";
            $keywords[] = "Buy " . $product['company_name'] . " tablet online";
            $keywords[] = "Affordable " . $product['company_name'] . " tablet";
            $keywords[] = $product['company_name'] . " tablet under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " tablet for " . $product['MRP'];
            $keywords[] = $product['company_name'] . " tablet with features";
            $keywords[] = $product['company_name'] . " tablet for kids";
            $keywords[] = "Buy " . $product['company_name'] . " tablet for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " tablet for online classes";
            $keywords[] = $product['company_name'] . " tablet for students";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['Type'] . ' in ' . $product['color'];
                $keywords[] = "New " . $product['company_name'] . " tablet in " . $product['color'];
                $keywords[] = "Latest " . $product['company_name'] . " tablet in " . $product['color'];
                $keywords[] = "Stylish " . $product['company_name'] . " tablet in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['size'] . " Tablet";
                $keywords[] = "Best tablet in " . $product['size'];
            }
            
        } 
        elseif ($category === 'Laptops/MacBook') {
            // Keywords for laptops
            $keywords[] = "Best laptop under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " laptop with best features";
            $keywords[] = $product['company_name'] . " laptop sale";
            $keywords[] = "Buy " . $product['company_name'] . " laptop online";
            $keywords[] = "Best " . $product['company_name'] . " laptop for work";
            $keywords[] = $product['company_name'] . " laptop for students";
            $keywords[] = "Affordable " . $product['company_name'] . " laptop";
            $keywords[] = "Latest " . $product['company_name'] . " laptop for " . $product['MRP'];
            $keywords[] = $product['company_name'] . " laptop for gaming";
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " laptop under " . $product['MRP'];
            $keywords[] = "Best " . $product['company_name'] . " laptop for office work";
            $keywords[] = "New " . $product['company_name'] . " laptop with features";
            $keywords[] = $product['company_name'] . " laptop for professional use";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['Type'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " laptop in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . " laptop with " . $product['size'];
            }
            
        } 
        elseif ($category === 'TV') {
            // Keywords for TV
            $keywords[] = "Best TV under " . $product['MRP'];
            $keywords[] = "4K " . $product['Type'] . " TV for sale";
            $keywords[] = "Buy " . $product['company_name'] . " TV online";
            $keywords[] = "Latest " . $product['company_name'] . " TV";
            $keywords[] = "Affordable " . $product['company_name'] . " TV";
            $keywords[] = $product['company_name'] . " TV under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " smart TV for sale";
            $keywords[] = "Best smart TV under " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " smart TV online";
            $keywords[] = $product['company_name'] . " LED TV under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " TV for home theater";
            $keywords[] = "Latest " . $product['company_name'] . " 4K TV for " . $product['MRP'];
            $keywords[] = "Best TV for watching movies";
            $keywords[] = "Stylish " . $product['company_name'] . " TV for your living room";
    
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " TV in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
            
        } 
        elseif ($category === 'Headphone') {
            // Keywords for Headphones
            $keywords[] = "Best " . $product['Type'] . " headphones under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " headphones for sale";
            $keywords[] = "Buy " . $product['company_name'] . " headphones online";
            $keywords[] = "Comfortable " . $product['company_name'] . " headphones";
            $keywords[] = "Best quality " . $product['company_name'] . " headphones";
            $keywords[] = "New " . $product['company_name'] . " headphones with features";
            $keywords[] = $product['company_name'] . " noise-cancelling headphones";
            $keywords[] = "Affordable " . $product['company_name'] . " headphones";
            $keywords[] = $product['company_name'] . " sports headphones";
            $keywords[] = $product['company_name'] . " Bluetooth headphones under " . $product['MRP'];
            $keywords[] = "Stylish " . $product['company_name'] . " headphones for men";
            $keywords[] = "Latest " . $product['company_name'] . " headphones for " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " headphones for gaming";
            
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['type'] . " headphones in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
            
        } 
        elseif ($category === 'Earphone') {
            // Keywords for Earphones
            $keywords[] = "Best " . $product['Type'] . " earphones under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " earphones for sale";
            $keywords[] = "Buy " . $product['company_name'] . " earphones online";
            $keywords[] = "Affordable " . $product['company_name'] . " earphones";
            $keywords[] = $product['company_name'] . " Bluetooth earphones";
            $keywords[] = "New " . $product['company_name'] . " earphones with features";
            $keywords[] = $product['company_name'] . " wireless earphones under " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " earphones for " . $product['MRP'];
            $keywords[] = $product['company_name'] . " earphones for workouts";
            $keywords[] = "Best " . $product['company_name'] . " earphones for music";
            $keywords[] = "Comfortable " . $product['company_name'] . " earphones for men";
            $keywords[] = "Latest " . $product['company_name'] . " earphones for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " earphones for kids";
            $keywords[] = $product['company_name'] . " noise-cancelling earphones";
    
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = "Stylish " . $product['company_name'] . " earphones in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
            
        } 
        elseif ($category === 'Shoes') {
            // Keywords for Shoes
            $keywords[] = $product['company_name'] . " shoes under " . $product['MRP'];
            $keywords[] = "Best " . $product['company_name'] . " shoes";
            $keywords[] = "Buy " . $product['company_name'] . " shoes online";
            $keywords[] = "Stylish " . $product['company_name'] . " shoes";
            $keywords[] = "Comfortable " . $product['company_name'] . " shoes";
            $keywords[] = "Buy " . $product['company_name'] . " shoes for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " shoes for casual wear";
            $keywords[] = "Trendy " . $product['company_name'] . " shoes for men";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " shoes under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " shoes for everyday use";
            $keywords[] = "Best " . $product['company_name'] . " shoes for running";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " shoes in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
                $keywords[] = "Affordable " . $product['company_name'] . " shoes in " . $product['size'];
                $keywords[] = "Latest " . $product['company_name'] . " shoes for " . $product['size'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " shoes for " . $product['size'];
            }
            
        } 
        elseif ($category === 'Watch') {
            // Keywords for Watch
            $keywords[] = "Best " . $product['company_name'] . " watch under " . $product['MRP'];
            $keywords[] = "Stylish " . $product['company_name'] . " watch for men";
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " watch online";
            $keywords[] = $product['company_name'] . " wristwatch for sale";
            $keywords[] = "New " . $product['company_name'] . " watch with features";
            $keywords[] = "Affordable " . $product['company_name'] . " watch";
            $keywords[] = $product['company_name'] . " luxury watch under " . $product['MRP'];
            $keywords[] = "Best watch for " . $product['size'] . " wrists";
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " watch online";
            $keywords[] = $product['company_name'] . " men's watch for casual wear";
            $keywords[] = $product['company_name'] . " smartwatch for fitness";
            $keywords[] = "Latest " . $product['company_name'] . " watch for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " watch with best features";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " watch in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
            
        } 
        elseif ($category === 'Electronics Item') {
           // Keywords for Electronics Items
            $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'] . " for electronics";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for electronics under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " electronics";
            $keywords[] = "Affordable " . $product['company_name'] . " " . $product['Type'] . " for electronics";
            $keywords[] = "Best " . $product['company_name'] . " electronics for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " online";
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for sale";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " with best features";
            $keywords[] = "Latest " . $product['company_name'] . " " . $product['Type'] . " for " . $product['Item_Condition'];
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for " . $product['MRP'];
    
            // Color Keywords for Electronics Items
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']) . ' for electronics';
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'] . ' electronics';
                $keywords[] = "Best " . $product['company_name'] . " electronics in " . $product['color'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " electronics";
            }
    
            // Size Keywords for Electronics Items (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']) . ' for electronics';
                $keywords[] = $product['title'] . ' ' . $product['size'] . ' electronics';
            }
        } 
        elseif ($category === 'Tech Accessories') {
            // Keywords for Tech accessories
            $keywords[] = "Best " . $product['company_name'] . " tech accessories under " . $product['MRP'];
            $keywords[] = "Affordable " . $product['company_name'] . " tech accessories";
            $keywords[] = "Buy " . $product['company_name'] . " tech accessories online";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " tech accessories";
            $keywords[] = "Latest " . $product['company_name'] . " tech gadgets";
            $keywords[] = $product['company_name'] . " accessories";
            $keywords[] = "Best " . $product['company_name'] . " accessories";
            $keywords[] = "New " . $product['company_name'] . " tech accessories";
            $keywords[] = $product['company_name'] . " headphones and accessories";
            $keywords[] = $product['company_name'] . " laptop accessories for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " tech accessories for " . $product['Item_Condition'];
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " tech accessories in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
            
            
        } 
        elseif ($category === 'Cameras') {
            // Keywords for Cameras
            $keywords[] = $product['company_name'] . " camera under " . $product['MRP'];
            $keywords[] = "Best " . $product['Type'] . " camera for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " camera online";
            $keywords[] = "Latest " . $product['company_name'] . " camera for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " DSLR camera for sale";
            $keywords[] = $product['company_name'] . " camera with best features";
            $keywords[] = $product['company_name'] . " mirrorless camera under " . $product['MRP'];
            $keywords[] = "Affordable " . $product['company_name'] . " camera";
            $keywords[] = "New " . $product['company_name'] . " camera with features";
            $keywords[] = "Best " . $product['company_name'] . " camera for travel";
            $keywords[] = $product['company_name'] . " camera for photography";
            $keywords[] = "Buy " . $product['company_name'] . " camera for video recording";
            $keywords[] = $product['company_name'] . " camera with wide-angle lens";
            $keywords[] = $product['company_name'] . " camera for professional use";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " camera in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
        } 
        elseif ($category === 'Game Item') {
            // Keywords for Game item
            $keywords[] = "Best game items under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " gaming accessories for sale";
            $keywords[] = "Buy " . $product['company_name'] . " game item online";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " game item for " . $product['MRP'];
            $keywords[] = "Latest " . $product['company_name'] . " gaming gear";
            $keywords[] = "Affordable " . $product['company_name'] . " game accessories";
            $keywords[] = "New " . $product['company_name'] . " game item for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " game controllers for sale";
            $keywords[] = "Buy " . $product['company_name'] . " gaming headset for " . $product['MRP'];
            $keywords[] = $product['company_name'] . " game items for PS5";
            $keywords[] = "Best gaming console for " . $product['MRP'];
            $keywords[] = "Latest " . $product['company_name'] . " game items for " . $product['MRP'];
            $keywords[] = $product['company_name'] . " gaming items for competitive gaming";
            $keywords[] = "Best " . $product['company_name'] . " game accessories for streamers";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
        } 
        elseif ($category === 'Kitchen') {
            // Keywords for Kitchen
            $keywords[] = "Best kitchen items under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " kitchen appliances for sale";
            $keywords[] = "Buy " . $product['company_name'] . " kitchen items online";
            $keywords[] = "New " . $product['company_name'] . " kitchen gadgets";
            $keywords[] = $product['company_name'] . " kitchen utensils for " . $product['MRP'];
            $keywords[] = "Affordable " . $product['company_name'] . " kitchen accessories";
            $keywords[] = "Latest " . $product['company_name'] . " kitchen products";
            $keywords[] = $product['company_name'] . " kitchen tools for " . $product['Item_Condition'];
            $keywords[] = $product['company_name'] . " cooking gadgets for sale";
            $keywords[] = "Best " . $product['company_name'] . " kitchen tools";
            $keywords[] = $product['company_name'] . " kitchen appliances for home use";
            $keywords[] = $product['company_name'] . " kitchen accessories for professionals";
            $keywords[] = "Best " . $product['company_name'] . " cooking items for gifting";
            $keywords[] = $product['company_name'] . " smart kitchen appliances";
            $keywords[] = $product['company_name'] . " kitchen products under " . $product['MRP'];
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
        } 
        elseif ($category === 'Clothes') {
            // Keywords for clothes    
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = "Best " . $product['Type'] . " for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " online";
            $keywords[] = "Affordable " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " latest collection";
            $keywords[] = "Top " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = "Buy " . $product['Type'] . " online with discounts";
            $keywords[] = "Trendy " . $product['Type'] . " from " . $product['company_name'];
            $keywords[] = "Shop for " . $product['Type'] . " online now";
            $keywords[] = $product['Type'] . " from " . $product['company_name'] . " at best price";
            $keywords[] = "Stylish " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = "New arrivals in " . $product['Type'];
            $keywords[] = "Buy " . $product['Type'] . " online in India";
            $keywords[] = "Exclusive deals on " . $product['company_name'] . " " . $product['Type'];
            
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['color'];
                $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " online";
                $keywords[] = "Latest " . $product['Type'] . " from " . $product['company_name'] . " in " . $product['color'];
                $keywords[] = $product['Type'] . " in " . $product['color'] . " from " . $product['company_name'];
                $keywords[] = "Stylish " . $product['Type'] . " in " . $product['color'] . " under " . $product['MRP'];
                $keywords[] = "Buy " . $product['Type'] . " online in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
                $keywords[] = "Best " . $product['Type'] . " in " . $product['size'] . " size for " . $product['MRP'];
                $keywords[] = "Affordable " . $product['Type'] . " in " . $product['size'] . " size under " . $product['MRP'];
                $keywords[] = "Trendy " . $product['Type'] . " for " . $product['MRP'] . " in " . $product['size'];
                $keywords[] = "Shop " . $product['size'] . " size " . $product['Type'] . " online";
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['size'] . " for " . $product['MRP'];
                $keywords[] = "Exclusive " . $product['Type'] . " in " . $product['size'] . " size online";
                $keywords[] = "Top " . $product['Type'] . " in " . $product['size'] . " size under " . $product['MRP'];
                $keywords[] = "Fashionable " . $product['Type'] . " in " . $product['color'] . " and " . $product['size'];
            }
            
        } 
        elseif ($category === 'Toys') {
            // Keywords for Toys
            $keywords[] = "Best electronics under " . $product['MRP'];
            $keywords[] = "Affordable " . $product['company_name'] . " electronics";
            $keywords[] = "Buy " . $product['company_name'] . " electronics online";
            $keywords[] = "Latest " . $product['company_name'] . " electronics for sale";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " electronics for " . $product['MRP'];
            $keywords[] = "Best quality electronics under " . $product['MRP'];
            $keywords[] = "New " . $product['company_name'] . " electronics with features";
            $keywords[] = $product['company_name'] . " electronics for home use";
            $keywords[] = $product['company_name'] . " electronics for office";
            $keywords[] = "Buy " . $product['company_name'] . " electronics for " . $product['Item_Condition'];
            $keywords[] = "Latest " . $product['company_name'] . " gadgets for sale";
            $keywords[] = "Affordable " . $product['company_name'] . " gadgets online";
            $keywords[] = $product['company_name'] . " tech gadgets for home";
            $keywords[] = "Best " . $product['company_name'] . " electronics";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
                $keywords[] = $product['company_name'] . " electronics in " . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
            
        } 
        elseif ($category === 'Stationary') {
            // Keywords for Stationery Items
            $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'] . " for stationery";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for stationery under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " stationery";
            $keywords[] = "Affordable " . $product['company_name'] . " " . $product['Type'] . " for stationery";
            $keywords[] = "Best " . $product['company_name'] . " stationery for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " online";
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for stationery";
            $keywords[] = "Latest " . $product['company_name'] . " " . $product['Type'] . " for " . $product['Item_Condition'];
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for " . $product['MRP'];
    
            // Color Keywords for Stationery Items
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']) . ' for stationery';
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'] . ' stationery';
                $keywords[] = "Best " . $product['company_name'] . " stationery in " . $product['color'];
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " stationery";
            }
    
            // Size Keywords for Stationery Items (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']) . ' for stationery';
                $keywords[] = $product['title'] . ' ' . $product['size'] . ' stationery';
            }
    
        } 
        elseif ($category === 'Sports') {
            // Keywords for Sports Items
            $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'] . " for sports";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for sports under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " sports gear";
            $keywords[] = "Affordable " . $product['company_name'] . " " . $product['Type'] . " for sports";
            $keywords[] = "Best " . $product['company_name'] . " sports equipment for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " for sports online";
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for sale";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " with best features for sports";
            $keywords[] = "Latest " . $product['company_name'] . " " . $product['Type'] . " for " . $product['Item_Condition'];
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for " . $product['MRP'] . " in sports";
    
            // Color Keywords for Sports Items
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']) . ' for sports';
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'] . ' for sports';
                $keywords[] = "Best " . $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " for sports";
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " for sports in " . $product['color'];
            }
    
            // Size Keywords for Sports Items (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']) . ' for sports';
                $keywords[] = $product['title'] . ' ' . $product['size'] . ' for sports';
            }
    
        } 
        elseif ($category === 'Men accessories') {
            // Keywords for Men's Accessories
            $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'] . " for men";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for men under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for men";
            $keywords[] = "Affordable " . $product['company_name'] . " " . $product['Type'] . " for men";
            $keywords[] = "Best " . $product['company_name'] . " accessories for men";
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " for men online";
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for men";
            $keywords[] = "Best " . $product['company_name'] . " " . $product['Type'] . " for men under " . $product['MRP'];
            $keywords[] = "Latest " . $product['company_name'] . " accessories for men";
            $keywords[] = "Men's " . $product['Type'] . " for " . $product['MRP'];
    
            // Color Keywords for Men's Accessories
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']) . ' for men';
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'] . ' for men';
                $keywords[] = "Best " . $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " for men";
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " for men in " . $product['color'];
            }
    
            // Size Keywords for Men's Accessories (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']) . ' for men';
                $keywords[] = $product['title'] . ' ' . $product['size'] . ' for men';
            }
    
        } 
        elseif ($category === 'Women accessories') {
            // Keywords for Women's Accessories
            $keywords[] = "Best " . $product['Type'] . " under " . $product['MRP'] . " for women";
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for women under " . $product['MRP'];
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " for women";
            $keywords[] = "Affordable " . $product['company_name'] . " " . $product['Type'] . " for women";
            $keywords[] = "Best " . $product['company_name'] . " accessories for women";
            $keywords[] = "Buy " . $product['company_name'] . " " . $product['Type'] . " for women online";
            $keywords[] = "New " . $product['company_name'] . " " . $product['Type'] . " for women";
            $keywords[] = "Best " . $product['company_name'] . " " . $product['Type'] . " for women under " . $product['MRP'];
            $keywords[] = "Latest " . $product['company_name'] . " accessories for women";
            $keywords[] = "Women's " . $product['Type'] . " for " . $product['MRP'];
    
            // Color Keywords for Women's Accessories
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']) . ' for women';
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'] . ' for women';
                $keywords[] = "Best " . $product['company_name'] . " " . $product['Type'] . " in " . $product['color'] . " for women";
                $keywords[] = $product['company_name'] . " " . $product['Type'] . " for women in " . $product['color'];
            }
    
            // Size Keywords for Women's Accessories (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']) . ' for women';
                $keywords[] = $product['title'] . ' ' . $product['size'] . ' for women';
            }
    
        } 
        elseif($category === 'Furniture'){
            // Keywords for Furniture
            $keywords[] = $product['company_name'] . " " . $product['Type'] . " furniture under " . $product['MRP'];
            $keywords[] = "Best " . $product['Type'] . " furniture for " . $product['MRP'];
            $keywords[] = "Buy " . $product['company_name'] . " furniture online";
            $keywords[] = "Top " . $product['Type'] . " furniture at best prices";
            $keywords[] = "Affordable " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = "Modern " . $product['Type'] . " furniture for your home";
            $keywords[] = "Latest " . $product['Type'] . " furniture from " . $product['company_name'];
            $keywords[] = "Premium " . $product['Type'] . " furniture online";
            $keywords[] = $product['Type'] . " for " . $product['MRP'] . " by " . $product['company_name'];
            $keywords[] = "Best deals on " . $product['company_name'] . " " . $product['Type'];
            $keywords[] = "Stylish " . $product['Type'] . " under " . $product['MRP'];
            $keywords[] = "Shop for " . $product['Type'] . " furniture now";
            $keywords[] = "Buy " . $product['Type'] . " furniture online in India";
            $keywords[] = "Exclusive offers on " . $product['company_name'] . " furniture";
    
            // Color Keywords
            if (isset($product['color'])) {
                $keywords[] = $product['color'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['company_name'] . ' ' . $product['title'] . ' in ' . $product['color'];
            }
    
            // Size Keywords (if applicable)
            if (isset($product['size'])) {
                $keywords[] = $product['size'] . ' ' . strtolower($product['Category']);
                $keywords[] = $product['title'] . ' ' . $product['size'];
            }
        }
    
    
        return array_unique($keywords);
    }


    $product = [
        'title' => $full_name,
        'company_name' => $Company_name,
        'Category' => $Category,
        'Type' => $type,
        'MRP' => $MRP,
        'Item_Condition' => $condition,
        'color' => $pcolor,
        'size' => $size[0]
    ];
    
    // Generate keywords
    $keywords = generateProductKeywords($product);
    $keywords_value = implode(', ', $keywords);


    // main images 
    function isValidImage($filename)
    {
        $validExtensions = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $validExtensions);
    }

    $allFilesUploaded = true;

    $profileImages = [];
    // Process main images
    for ($i = 1; $i <= 4; $i++) {
        $profileImageKey = "ProfileImage$i";
        if (isset($_FILES[$profileImageKey]) && $_FILES[$profileImageKey]['error'] === UPLOAD_ERR_OK) {
            $filename = $_FILES[$profileImageKey]['name'];
            $tempName = $_FILES[$profileImageKey]['tmp_name'];
            $folder = '../src/product_image/product_profile/' . $filename;

            if (isValidImage($filename)) {
                if (!move_uploaded_file($tempName, $folder)) {
                    $allFilesUploaded = false;
                } else {
                    $profileImages[] = $filename;
                }
            } else {
                $allFilesUploaded = false; // Invalid file type
            }
        }
    }

    $profileImage1 = isset($profileImages[0]) ? $profileImages[0] : '';
    $profileImage2 = isset($profileImages[1]) ? $profileImages[1] : '';
    $profileImage3 = isset($profileImages[2]) ? $profileImages[2] : '';
    $profileImage4 = isset($profileImages[3]) ? $profileImages[3] : '';

    // Process cover images
    $coverImages = [];

    // Loop through the four possible cover images
    for ($i = 1; $i <= 4; $i++) {
        $coverImageKey = "CoverImage$i";

        if (isset($_FILES[$coverImageKey]) && $_FILES[$coverImageKey]['error'] === UPLOAD_ERR_OK) {
            $filename = $_FILES[$coverImageKey]['name'];
            $tempName = $_FILES[$coverImageKey]['tmp_name'];
            $folder = '../src/product_image/product_cover/' . $filename;

            if (isValidImage($filename)) {
                // Move the uploaded file to the target directory
                if (!move_uploaded_file($tempName, $folder)) {
                    $allFilesUploaded = false;
                } else {
                    // Store the file name in an array to display later
                    $coverImages[] = $filename;
                }
            } else {
                $allFilesUploaded = false; // Invalid file type
            }
        }
    }

    $coverImage1 = isset($coverImages[0]) ? $coverImages[0] : '';
    $coverImage2 = isset($coverImages[1]) ? $coverImages[1] : '';
    $coverImage3 = isset($coverImages[2]) ? $coverImages[2] : '';
    $coverImage4 = isset($coverImages[3]) ? $coverImages[3] : '';


    $color = $_POST['color'];

    if (!empty($_POST['color'])) {
        $pcolor = $_POST['color'];
    } else {
        $pcolor = '-';
    }

    $normalized_color = array_map('strtolower', (array)$color); // Ensure $color is treated as an array

    // Validation for colors

    $avg_rating = '0.0';
    $total_reviews = '0';

    $_SESSION['same_id'] = $same_id;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['Company_name'] = $Company_name;
    $_SESSION['type'] = $type;
    $_SESSION['your_price'] = $your_price;
    $_SESSION['MRP'] = $MRP;
    $_SESSION['quantity'] = $quantity;
    $_SESSION['condition'] = $condition;
    $_SESSION['description'] = $description;
    $_SESSION['color'] = $pcolor;

    if (empty($same_id)) {
        echo '<script>displayErrorMessage("Please fill Product Id.");</script>';
        exit();
    }


    if (isset($_SESSION['productSameId'])) {
        echo '<script>displayErrorMessage("Please Select Different Product Id.");</script>';
        exit();
    }


    if (empty($full_name)) {
        echo '<script>displayErrorMessage("Please fill Product Title.");</script>';
        exit();
    }

    if (empty($Company_name)) {
        echo '<script>displayErrorMessage("Please fill Company Name.");</script>';
        exit();
    }

    if (empty($Category)) {
        echo '<script>displayErrorMessage("Please fill Category.");</script>';
        exit();
    }

    if (empty($type)) {
        echo '<script>displayErrorMessage("Please fill Type.");</script>';
        exit();
    }

    if (empty($your_price)) {
        echo '<script>displayErrorMessage("Please fill Your Price.");</script>';
        exit();
    }

    if (empty($MRP)) {
        echo '<script>displayErrorMessage("Please fill MRP.");</script>';
        exit();
    }

    if (empty($quantity)) {
        echo '<script>displayErrorMessage("Please fill Quantity.");</script>';
        exit();
    }

    if (empty($condition)) {
        echo '<script>displayErrorMessage("Please fill Condition.");</script>';
        exit();
    }

    if (empty($keywords_value)) {
        echo '<script>displayErrorMessage("Please fill Keywords.");</script>';
        exit();
    }

    if (empty($profileImage1)) {
        echo '<script>displayErrorMessage("Please Insert first Image.");</script>';
        exit();
    }

    if (empty($profileImage2)) {
        echo '<script>displayErrorMessage("Please Insert Second Image Image.");</script>';
        exit();
    }

    if (
        empty($same_id) || empty($full_name) || empty($Company_name) || empty($type) ||
        empty($your_price) || empty($MRP) || empty($quantity) || empty($condition) || empty($keywords_value) || empty($profileImage1) || empty($profileImage2) || isset($_SESSION['productSameId'])
    ) {
        echo '<script>displayErrorMessage("Please fill in all required fields.");</script>';
    } else {
        if ($allFilesUploaded) {
            $product_insert = "INSERT INTO products(same_id, vendor_id, title, profile_image_1, profile_image_2, profile_image_3, profile_image_4, cover_image_1, cover_image_2, cover_image_3, cover_image_4, company_name, Category, Type, MRP, vendor_mrp, vendor_price, Quantity, Item_Condition, Description, color, size, keywords, avg_rating, total_reviews, date) VALUES ('$same_id','$vendor_id','$full_name','$profileImage1','$profileImage2','$profileImage3','$profileImage4','$coverImage1','$coverImage2','$coverImage3','$coverImage4','$Company_name','$Category','$type','$json_size_encode','$MRP','$your_price','$quantity','$condition','$description','$pcolor','$size_filter','$keywords_value','$avg_rating','$total_reviews','$Product_insert_Date')";
            $product_query = mysqli_query($con, $product_insert);

            if ($product_query) {
                unset($_SESSION['same_id']);
                unset($_SESSION['full_name']);
                unset($_SESSION['Company_name']);
                unset($_SESSION['type']);
                unset($_SESSION['your_price']);
                unset($_SESSION['MRP']);
                unset($_SESSION['quantity']);
                unset($_SESSION['condition']);
                unset($_SESSION['description']);
                unset($_SESSION['color']);

                echo '<script>loader()</script>';
                echo '<script>displaySuccessMessage("Your Product Added Successfully.");</script>';
            } else {
                echo '<script>displayErrorMessage("Your Product not Added Properly.");</script>';
            }
        } else {
            echo '<script>displayErrorMessage("Some files could not be uploaded.");</script>';
        }
    }
}
?>