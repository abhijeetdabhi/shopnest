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
            
            <!-- Successfully -->
            <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="popUp" style="display: none;">
                <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" >
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Item remove successfully.</span>
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
                    window.location.href = 'cart.php'
                }, 1500);
            </script>
        <?php
        }
    }
?>