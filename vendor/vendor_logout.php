<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: /index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /admin/dashboard.php");
    exit;
}
?>



<?php
$userLogout = false;

if (isset($_POST['userLogout'])) {
    setcookie('vendor_id', '', time() - 3600, '/');

    $userLogout = true;
}
?>

<style>
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

<!-- Tailwind Script  -->
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

<!-- logout -->
<form method="post" class="fixed w-full h-full bg-black/50 backdrop-blur-md z-50 m-auto flex items-center justify-center overflow-hidden" id="logoutPopUp">
    <div class="bg-white text-left rounded-lg max-w-xs shadow-md m-auto fz-50">
        <div class="p-4">
            <div class="flex m-auto bg-red-100 shrink-0 justify-center items-center w-12 h-12 rounded-full">
                <svg class="text-red-500 w-6 h-6" aria-hidden="true" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" fill="none">
                    <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
            </div>
            <div class="mt-3 text-center">
                <span class="text-gray-900 text-base font-semibold leading-6">Logout</span>
                <p class="mt-2 text-gray-400 text-sm leading-5">Are you sure you want to logout your account? All of your data will be permanently removed. This action cannot be undone.</p>
            </div>
            <div class="mx-4 my-3">
                <input type="submit" name="userLogout" value="Logout" class="inline-flex px-4 py-2 text-white bg-red-500 text-base font-medium justify-center w-full rounded-md border-2 border-transparent shadow-sm cursor-pointer">
                <div onClick="closePopup()" class="inline-flex mt-3 px-4 py-2 bg-white text-gray-500 text-base leading-6 font-medium justify-center w-full rounded-md border border-gray-400 shadow-sm cursor-pointer">Cancel</div>
            </div>
        </div>
    </div>
</form>

<!-- Successfully message container -->
<div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 m-auto rounded-lg border-green-400 py-3 px-6 bg-gray-800 z-50" id="LpopUp" style="display: none;">
    <div class="flex items-center m-auto justify-center text-sm text-green-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div class="capitalize font-medium" id="loginSuccess"></div>
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

    function loginPopUp(message) {
        let LpopUp = document.getElementById('LpopUp');
        let loginSuccess = document.getElementById('loginSuccess');

        setTimeout(() => {
            loginSuccess.innerHTML = '<span class="font-medium">' + message + '</span>';
            LpopUp.style.display = 'flex';
            LpopUp.style.opacity = '100';
            window.location.href = "../index.php";
        }, 2000);
    }

    function closePopup() {
        let logoutPopUp = document.getElementById('logoutPopUp');
        logoutPopUp.style.display = 'none';
    }
</script>

<?php

if ($userLogout === true) {
?>
    <script>
        let logoutPopUp = document.getElementById('logoutPopUp');
        logoutPopUp.style.display = 'none';
    </script>
<?php
    echo '<script>loader()</script>';
    echo '<script>loginPopUp("Logout Successfully.");</script>';
}

?>