<?php

if (!isset($_GET['product_id'])) {
    header("Location: /index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /admin/dashboard.php");
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

    <!-- alpine CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
    <title>Add To Cart</title>
</head>

<body>

</body>

</html>
<?php

include "../include/connect.php";

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $product_find = "SELECT * FROM products WHERE product_id = '$product_id'";
    $product_query = mysqli_query($con, $product_find);

    while ($res = mysqli_fetch_assoc($product_query)) {

        $product_id = $res['product_id'];
        $product_title = $res['title'];
        $product_image = $res['profile_image_1'];
        $product_color = $res['color'];
        $product_qty = $_GET['qty'];
        $product_size = $_GET['size'];
        $product_price_per_unit = $_GET['MRP'];

        $product_price_per_unit = str_replace(",", "", $product_price_per_unit);

        if (is_numeric($product_price_per_unit)) {

            $product_price_per_unit = (int) $product_price_per_unit;
        } else {
            $product_price_per_unit = 0;
        }

        $formated_num =  number_format($product_price_per_unit);

        $cart_products = [];

        if (isset($_COOKIE['Cart_products'])) {
            $decoded_cookie = json_decode($_COOKIE['Cart_products'], true);

            if (is_array($decoded_cookie)) {
                $cart_products = $decoded_cookie;
            }
        }

        $cart_items = array(
            'cart_id' => $product_id,
            'cart_image' => $product_image,
            'cart_title' => $product_title,
            'cart_price' => $formated_num,
            'cart_price_per_unit' => $product_price_per_unit,
            'cart_color' => $product_color,
            'cart_size' => $product_size,
            'cart_qty' => $product_qty
        );


        $cart_id = '';

        if (!empty($cart_products) && is_array($cart_products)) {
            foreach ($cart_products as $item) {
                $cart_id = $item['cart_id'];
            }
        }
        if ($cart_id === $product_id) {
?>
            <!-- Tailwind Script  -->
            <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
            <!-- Error -->
            <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 rounded-lg border-red-500 py-3 px-6 bg-gray-800 z-50" id="popUp" style="display: none;">
                <div class="flex items-center m-auto justify-center text-sm text-red-400">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="capitalize font-medium">This Product Already In Cart.</div>
                </div>
            </div>

            <script>
                let popUp = document.getElementById('popUp');

                popUp.style.display = 'flex';
                popUp.style.opacity = '100';

                setTimeout(() => {
                    popUp.style.display = 'none';
                    popUp.style.opacity = '0';
                    window.location.href = '../shopping/cart.php';
                }, 1800);
            </script>
        <?php
        } else {
            array_push($cart_products, $cart_items);
            setcookie('Cart_products', json_encode($cart_products), time() +  (365 * 24 * 60 * 60), "/");

        ?>
            <!-- Tailwind Script  -->
            <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
            <!-- loader -->
            <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm z-40" style="display: none;">
                <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-gray-700 rounded-full">
                    <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-gray-900 rounded-full"></div>
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

            <script>
                let loader = document.getElementById('loader');
                let body = document.body;

                loader.style.display = 'flex';
                body.style.overflow = 'hidden';

                let SpopUp = document.getElementById('SpopUp');

                setTimeout(() => {
                    SpopUp.style.display = 'flex';
                    SpopUp.style.opacity = '100';
                    window.location.href = '../shopping/cart.php';
                }, 2000);
            </script>
<?php
        }
    }
}
