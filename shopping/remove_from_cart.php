<?php
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
    session_start();
    
    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];

        $cookie_value = $_COOKIE['Cart_products'];

        $cart_products = json_decode($cookie_value,true);

        if(!empty($cart_products)){
            foreach($cart_products as $key => $Citems){
                if($Citems['cart_id'] === $product_id){
                    unset($cart_products[$key]);
                }
            }

            $update_cart = json_encode($cart_products);

            setcookie('Cart_products', $update_cart, time() +  (365 * 24 * 60 * 60), "/");

            $product_id = (int)$_GET['product_id'];
        
            // Check if the product ID exists in the session before attempting to delete it
            if (isset($_SESSION['selected_qty'][$product_id])) {
                unset($_SESSION['selected_qty'][$product_id]); // Remove the specific product from the session
            }
            
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
            <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 m-auto rounded-lg border-green-400 py-3 px-6 bg-gray-800 z-[100]" id="SpopUp" style="display: none;">
                <div class="flex items-center m-auto justify-center text-sm text-green-400" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="capitalize font-medium">Product Added to Cart Successfully.</div>
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
?>