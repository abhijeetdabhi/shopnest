<?php
if (isset($_COOKIE['vendor_id'])) {
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /admin/dashboard.php");
    exit;
}
?>

<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $cookie_value = $_COOKIE['Cart_products'];

    $cart_products = json_decode($cookie_value, true);

    if (!empty($cart_products)) {
        foreach ($cart_products as $key => $Citems) {
            if ($Citems['cart_id'] === $product_id) {
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
?>