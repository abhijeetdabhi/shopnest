<?php
if (!isset($_GET['product_id'])) {
    header("Location: view_products.php");
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

    $product_id = $_GET['product_id'];

    $get_product = "SELECT * FROM products WHERE product_id = '$product_id'";
    $get_query = mysqli_query($con, $get_product);

    $res = mysqli_fetch_assoc($get_query);

    $same_id = $res['same_id'];
    $company_name = $res['company_name'];
    $Category = $res['Category'];
    $Type = $res['Type'];

    $cover_image_1 = $res['cover_image_1'];
    $cover_image_2 = $res['cover_image_2'];
    $cover_image_3 = $res['cover_image_3'];
    $cover_image_4 = $res['cover_image_4'];


    $retrieve_data = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);
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
    <title>Add Product Color</title>

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

        @keyframes clock-wise {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes anti-clock-wise {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .outer-line {
            animation: clock-wise 1s linear infinite;
        }

        .inner-line {
            animation: anti-clock-wise 1.3s linear infinite;
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
            <a class="flex items-center" href="">
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
            <h1 class="bg-gray-100 text-2xl font-bold flex items-center justify-center mb-6">Add Color For Product</h1>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 lg:grid-cols-1">
                    <div class="lg:col-span-2">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="grid gap-4 gap-y-4 items-center text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5">
                                    <label for="full_name" class="require">Product tital:</label>
                                    <input type="text" name="full_name" id="full_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : ''; ?>" />
                                </div>

                                <div class="md:col-span-3">
                                    <label for="MRP" class="require">Sell Price:</label>
                                    <div class="relative">
                                        <input type="number" name="MRP" id="MRP" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 pl-10 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['MRP']) ? $_SESSION['MRP'] : ''; ?>" placeholder="" />
                                        <div class="absolute left-0 rounded-l top-1 w-9 h-10 bg-white border border-gray-500 m-auto text-center flex items-center justify-center">₹</div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="your_price" class="require">MRP:</label>
                                    <div class="relative">
                                        <input type="number" name="your_price" id="your_price" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 pl-10 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['your_price']) ? $_SESSION['your_price'] : ''; ?>" placeholder="" />
                                        <div class="absolute left-0 rounded-l top-1 w-9 h-10 bg-white border border-gray-500 m-auto text-center flex items-center justify-center">₹</div>
                                    </div>
                                </div>

                                <div class="md:col-span-3">
                                    <label for="quantity" class="require">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['quantity']) ? $_SESSION['quantity'] : ''; ?>" placeholder="" />
                                </div>

                                <div class="md:col-span-2">
                                    <label for="condition" class="require">Item condition:</label>
                                    <select name="condition" id="condition" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" value="<?php echo isset($_SESSION['condition']) ? $_SESSION['condition'] : ''; ?>">
                                        <option value="New Condition">New condition</option>
                                        <option value="Old Condition">Old condition</option>
                                    </select>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="description" class="require">Description:</label>
                                    <textarea name="description" id="description" class="h-32 border mt-1 rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600 resize-none" value="" placeholder=""><?php echo isset($_SESSION['description']) ? $_SESSION['description'] : ''; ?></textarea>
                                </div>

                                <div class="md:col-span-5 mt-5">
                                    <label for="keyword" class="require">Keywords:</label>
                                    <div id="keyword-container" class="grid grid-cols-2 md:grid-cols-3 mt-2 gap-3">
                                        <div class="flex items-center relative">
                                            <input type="text" name="keyword[]" placeholder="Enter keyword" class="relative h-10 border rounded px-4 md:w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600">
                                        </div>
                                    </div>
                                    <button id="add-keyword" class="px-4 py-2 bg-gray-600 text-white rounded-tl-lg rounded-br-lg mt-2">Add more keyword</button>
                                </div>

                                <div class="md:col-span-5 mt-5">
                                    <label for="size" class="require">Size:</label>
                                    <div id="size-container" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 mt-2 gap-3">

                                    </div>
                                    <button id="add-size" class="px-4 py-2 bg-gray-600 text-white rounded-tl-lg rounded-br-lg mt-2">Add more size</button>
                                </div>

                                <div class="md:col-span-5 mt-5">
                                    <label for="color">Color:</label>
                                    <div class="relative mt-2">
                                        <input type="text" id="colorInput" name="color" placeholder="Type a color..." class="h-10 border rounded px-4 w-full bg-gray-50 focus:ring-gray-600 focus:border-gray-600" autocomplete="off" value="<?php echo isset($_SESSION['color']) ? $_SESSION['color'] : ''; ?>">
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
                            </div>
                            <div class="flex justify-between mt-7">
                                <div>
                                    <a href="view_products.php" class="bg-black text-white font-semibold py-2 px-6 sm:px-8 rounded-tl-lg rounded-br-lg cursor-pointer inline-flex items-center gap-1">
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

    <!-- Successfully message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-[18rem] min-[410px]:w-[22rem] min-[760px]:w-max border-2 m-auto rounded-lg border-green-500 py-3 px-6 bg-green-100 z-50" id="SpopUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-green-500" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 21 21" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                <g>
                    <path fill="currentColor" d="M10.504 1.318a9.189 9.189 0 0 1 0 18.375 9.189 9.189 0 0 1 0-18.375zM8.596 13.49l-2.25-2.252a.986.986 0 0 1 0-1.392.988.988 0 0 1 1.393 0l1.585 1.587 3.945-3.945a.986.986 0 0 1 1.392 0 .987.987 0 0 1 0 1.392l-4.642 4.642a.987.987 0 0 1-1.423-.032z" opacity="1" data-original="currentColor"></path>
                </g>
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium text-center" id="Successfully"></div>
        </div>
    </div>


    <!-- Error message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-[18rem] min-[410px]:w-[22rem] min-[760px]:w-max border-2 rounded-lg border-red-500 py-3 px-6 bg-red-100 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-red-500">
            <svg class="flex-shrink-0 inline w-5 h-5 me-3" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <g>
                    <path d="M12 1a11 11 0 1 0 11 11A11.013 11.013 0 0 0 12 1zm4.242 13.829a1 1 0 1 1-1.414 1.414L12 13.414l-2.828 2.829a1 1 0 0 1-1.414-1.414L10.586 12 7.758 9.171a1 1 0 1 1 1.414-1.414L12 10.586l2.828-2.829a1 1 0 1 1 1.414 1.414L13.414 12z" data-name="Layer 2" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                </g>
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium text-center" id="errorMessage"></div>
        </div>
    </div>

    <!-- loader  -->
    <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm z-40" style="display: none;">
        <div class="w-24 h-24 border-4 border-transparent outer-line border-t-gray-700 rounded-full flex items-center justify-center"></div>
        <div class="w-20 h-20 border-4 border-transparent rotate-180 inner-line border-t-gray-900 rounded-full absolute"> </div>
        <img class="w-10 absolute" src="../src/logo/black_cart_logo.svg" alt="Cart Logo">
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
                window.location.href = "view_products.php";
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

        document.addEventListener('DOMContentLoaded', () => {
            const sizeContainer = document.getElementById('size-container');

            // Create the first size input without remove button, MRP, and Your Price
            const initialSizeItem = createSizeItem(true);
            sizeContainer.appendChild(initialSizeItem);
        });

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

    $sameId = $same_id;
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $Company_name = $company_name;
    $Categorys = $Category;
    $type = $Type;
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

    $keyword = $_POST['keyword'];

    $kwrd = [];
    foreach ($keyword as $kwrd) {
        $kwrd = $_POST['keyword'];
        $myKwrd = str_replace("'", "`", $kwrd);
    }
    $keywords_value = implode(', ', $myKwrd);


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

    $profileImage1 = $profileImages[0];
    $profileImage2 = $profileImages[1];
    $profileImage3 = $profileImages[2];
    $profileImage4 = $profileImages[3];

    $color = $_POST['color'];

    if (!empty($_POST['color'])) {
        $pcolor = $_POST['color'];
    } else {
        $pcolor = '-';
    }

    $avg_rating = '0.0';
    $total_reviews = '0';

    $_SESSION['full_name'] = $full_name;
    $_SESSION['your_price'] = $your_price;
    $_SESSION['MRP'] = $MRP;
    $_SESSION['quantity'] = $quantity;
    $_SESSION['condition'] = $condition;
    $_SESSION['description'] = $description;
    $_SESSION['color'] = $pcolor;

    if (empty($full_name)) {
        echo '<script>displayErrorMessage("Please fill Product Title.");</script>';
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
        empty($full_name) || empty($your_price) || empty($MRP) || empty($quantity) || empty($condition) || empty($keywords_value) || empty($profileImage1) || empty($profileImage2)
    ) {
        echo '<script>displayErrorMessage("Please fill in all required fields.");</script>';
    } else {
        if ($allFilesUploaded) {
            $product_insert = "INSERT INTO products(same_id, vendor_id, title, profile_image_1, profile_image_2, profile_image_3, profile_image_4, cover_image_1, cover_image_2, cover_image_3, cover_image_4, company_name, Category, Type, MRP, vendor_mrp, vendor_price, Quantity, Item_Condition, Description, color, size, keywords, avg_rating, total_reviews, date) VALUES ('$sameId','$vendor_id','$full_name','$profileImage1','$profileImage2','$profileImage3','$profileImage4','$cover_image_1','$cover_image_2','$cover_image_3','$cover_image_4','$Company_name','$Categorys','$type','$json_size_encode','$MRP','$your_price','$quantity','$condition','$description','$pcolor','$size_filter','$keywords_value','$avg_rating','$total_reviews','$Product_insert_Date')";
            $product_query = mysqli_query($con, $product_insert);

            if ($product_query) {
                unset($_SESSION['full_name']);
                unset($_SESSION['your_price']);
                unset($_SESSION['MRP']);
                unset($_SESSION['quantity']);
                unset($_SESSION['condition']);
                unset($_SESSION['description']);
                unset($_SESSION['color']);

                echo '<script>loader()</script>';
                echo '<script>displaySuccessMessage("Data Inserted.");</script>';
            } else {
                echo '<script>displayErrorMessage("Data not Inserted Properly.");</script>';
            }
        } else {
            echo '<script>displayErrorMessage("Some files could not be uploaded.");</script>';
        }
    }
}
?>