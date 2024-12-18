<?php

    if(!isset($_GET['product_id'])){
        header("Location: /index.php");
        exit;
    }

    if(isset($_COOKIE['vendor_id'])){
        header("Location: /vendor/vendor_dashboard.php");
        exit;
    }

    if(isset($_COOKIE['adminEmail'])){
        header("Location: /admin/dashboard.php");
        exit;
    }
?>

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
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Item Already in Cart.</span>
                        </div>
                    </div>
                </div>
    
                <script>
                    let EpopUp = document.getElementById('EpopUp');
    
                    EpopUp.style.display = 'flex';
                    EpopUp.style.opacity = '100';
    
                    setTimeout(() => {
                        EpopUp.style.display = 'none';
                        EpopUp.style.opacity = '0';
                        window.location.href = '/shopping/cart.php';
                    }, 1500);
                </script>
            <?php
        } else {
            array_push($cart_products, $cart_items);
            setcookie('Cart_products', json_encode($cart_products), time() +  (365 * 24 * 60 * 60), "/");
            
            ?>
                <!-- Tailwind Script  -->
                <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
                <!-- Successfully -->
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="popUp" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Product Added to Cart Successfully.</span>
                        </div>
                    </div>
                </div>
    
                <script>
                    let popUp = document.getElementById('popUp');
    
                    popUp.style.display = 'flex';
                    popUp.style.opacity = '100';
    
                    setTimeout(() => {
                        popUp.style.display = 'none';
                        popUp.style.opacity = '0';
                        window.location.href = '/shopping/cart.php';
                    }, 1500);
                </script>
            <?php
        }
        
    }
}
