<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../../vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../../admin/dashboard.php");
    exit;
}
?>
<?php
function getAddressFromLatLng($lat, $lng, $apiKey) {
    $url = "https://api.tomtom.com/search/2/reverseGeocode/{$lat},{$lng}.json?key={$apiKey}";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "cURL Error: " . curl_error($ch);
        return null;
    }

    $data = json_decode($response, true);

    curl_close($ch);

    if (isset($data['addresses'][0]['address'])) {
        $address = $data['addresses'][0]['address'];
        $city = isset($address['municipality']) ? $address['municipality'] : 'Not available';
        $state = isset($address['countrySubdivision']) ? $address['countrySubdivision'] : 'Not available';
        $postalCode = isset($address['postalCode']) ? $address['postalCode'] : 'Not available';

        return [
            'city' => $city,
            'state' => $state,
            'postalCode' => $postalCode
        ];
    }

    return null;
}
$lat = $_COOKIE['latitude'];
$lng = $_COOKIE['longitude'];
$apiKey = 'hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw'; 

$address = getAddressFromLatLng($lat, $lng, $apiKey);

if ($address) {
    $usercity = $address['city'];
    $userstate = $address['state'];
    $userpostalCode = $address['postalCode'];
} else {
    $usercity = "";
    $userstate = "";
    $userpostalCode = "";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="../../src/logo/favIcon.svg">

    <!-- alpinejs CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js" defer></script>

    <!-- title -->
    <title>User Registration</title>

    <style>
        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
        }

        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body class="flex justify-center h-[100%] py-2 px-6" style="font-family: 'Outfit', sans-serif;">
    <div class="w-full md:w-[85%] lg:w-[70%] 2xl:w-[50%]">
        <!-- header -->
        <div class="p-2 flex items-center justify-center">
            <a class="flex items-center mb-2 focus:outline-none" href="../../index.php">
                <!-- icon logo div -->
                <div>
                    <img class="w-12 mt-0.5" src="../../src/logo/black_cart_logo.svg" alt="">
                </div>
                <!-- text logo -->
                <div>
                    <img class="w-32" src="../../src/logo/black_text_logo.svg" alt="">
                </div>
            </a>
        </div>


        <form enctype="multipart/form-data" action="" id="userRegi" method="post">
            <div class="border-2 rounded-md">
                <h1 class="border-b-2 p-2 text-2xl font-semibold">User Registration</h1>
                <div class="grid grid-cols-1 p-5 md:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1 ">
                        <label for="fname" class="require font-semibold">First Name :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="fname" value="<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : '' ?>" id="fname">
                        <small id="FnameValid" class="text-red-500 hidden translate-x-1">name must be 2-10 character long and shuld not start with a number</small>
                    </div>
                    <div class="flex flex-col gap-1 ">
                        <label for="lname" class="require font-semibold">Last Name :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="lname" value="<?php echo isset($_SESSION['lname']) ? $_SESSION['lname'] : '' ?>" id="lname">
                        <small id="LnameValid" class="text-red-500 hidden translate-x-1">name must be 2-10 character long and shuld not start with a number</small>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="email" class="require font-semibold">Email :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="email" name="email" value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '' ?>" id="email">
                        <small id="MailValid" class="text-red-500 hidden translate-x-1">Enter Valid Email</small>

                    </div>
                    <div class="flex flex-col gap-1 relative" x-data="{ showPassword: false }">
                        <label for="password" class="require font-semibold">Password :</label>
                        <input class="h-12 rounded-md border-2 pr-10 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" :type="showPassword ? 'text' : 'password'" name="password" value="" id="password">
                        <span class="absolute top-[2.50rem] right-2.5 cursor-pointer" @click="showPassword = !showPassword">
                            <!-- Show Icon (when password is hidden) -->
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>

                            <!-- Hide Icon (when password is visible) -->
                            <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 128 128" style="fill: rgba(0, 0, 0, 1);">
                                <path d="m79.891 65.078 7.27-7.27C87.69 59.787 88 61.856 88 64c0 13.234-10.766 24-24 24-2.144 0-4.213-.31-6.192-.839l7.27-7.27a15.929 15.929 0 0 0 14.813-14.813zm47.605-3.021c-.492-.885-7.47-13.112-21.11-23.474l-5.821 5.821c9.946 7.313 16.248 15.842 18.729 19.602C114.553 71.225 95.955 96 64 96c-4.792 0-9.248-.613-13.441-1.591l-6.573 6.573C50.029 102.835 56.671 104 64 104c41.873 0 62.633-36.504 63.496-38.057a3.997 3.997 0 0 0 0-3.886zm-16.668-39.229-88 88C22.047 111.609 21.023 112 20 112s-2.047-.391-2.828-1.172a3.997 3.997 0 0 1 0-5.656l11.196-11.196C10.268 83.049 1.071 66.964.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24c10.827 0 20.205 2.47 28.222 6.122l12.95-12.95c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656zM34.333 88.011 44.46 77.884C41.663 73.96 40 69.175 40 64c0-13.234 10.766-24 24-24 5.175 0 9.96 1.663 13.884 4.459l8.189-8.189C79.603 33.679 72.251 32 64 32 32.045 32 13.447 56.775 8.707 63.994c3.01 4.562 11.662 16.11 25.626 24.017zm15.934-15.935 21.809-21.809C69.697 48.862 66.958 48 64 48c-8.822 0-16 7.178-16 16 0 2.958.862 5.697 2.267 8.076z"></path>
                            </svg>
                        </span>
                        <small id="passValid" class="text-red-500 hidden translate-x-1">password contains At least 8 digits</small>
                    </div>
                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label for="address" class="require font-semibold">Address :</label>
                        <textarea class="h-full rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition resize-none" name="address" id="address"><?php echo isset($_SESSION['user_address']) ? $_SESSION['user_address'] : '' ?></textarea>
                        <small id="addressValid" class="text-red-500 hidden translate-x-1">Enter Valid Address</small>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="mobileno" class="require font-semibold">Mobile No :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="tel" name="mobileno" value="<?php echo isset($_SESSION['user_mobileno']) ? $_SESSION['user_mobileno'] : '' ?>" id="mobileno" maxlength="10">
                        <small id="mobilenoValid" class="text-red-500 hidden translate-x-1">Enter Valid Numbers</small>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="state" class="require font-semibold">State :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="state" value="<?php echo isset($address) ? $userstate: '' ?>" id="state" readonly>
                        <small id="stateValid" class="text-red-500 hidden translate-x-1">Enter Valid State</small>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="city" class="require font-semibold">City :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="city" value="<?php echo isset($address) ? $usercity: '' ?>" id="city" readonly>
                        <small id="cityValid" class="text-red-500 hidden translate-x-1">Enter Valid City</small>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="pincode" class="require font-semibold">Pincode :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="tel" name="pincode" value="<?php echo isset($address) ? $userpostalCode: '' ?>" id="pincode" maxlength="6" readonly>
                        <small id="pincodeValid" class="text-red-500 hidden translate-x-1">Enter Valid Pincode</small>
                    </div>
                </div>
                <div class="flex justify-center mb-5">
                    <input type="submit" value="Register" name="regBtn" class="bg-gray-700 hover:bg-gray-800 hover:transition h-10 w-72 text-lg rounded-tl-xl rounded-br-xl text-white cursor-pointer">
                </div>
            </div>
        </form>
        <div class="flex flex-col items-center gap-2 mt-5">
            <a class="underline font-semibold" href="../vendor_auth/vendor_register.php">Become a Vendor</a>
            <a class="underline font-semibold" href="user_login.php">Already a member? Login</a>
            <a href="../../index.php" class=" font-semibold tracking-wide flex justify-center gap-1 underline">
                <svg class="w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path d="M420.361 192.229a31.967 31.967 0 0 0-5.535-.41H99.305l6.88-3.2a63.998 63.998 0 0 0 18.08-12.8l88.48-88.48c11.653-11.124 13.611-29.019 4.64-42.4-10.441-14.259-30.464-17.355-44.724-6.914a32.018 32.018 0 0 0-3.276 2.754l-160 160c-12.504 12.49-12.515 32.751-.025 45.255l.025.025 160 160c12.514 12.479 32.775 12.451 45.255-.063a32.084 32.084 0 0 0 2.745-3.137c8.971-13.381 7.013-31.276-4.64-42.4l-88.32-88.64a64.002 64.002 0 0 0-16-11.68l-9.6-4.32h314.24c16.347.607 30.689-10.812 33.76-26.88 2.829-17.445-9.019-33.88-26.464-36.71z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                    </g>
                </svg>
                Return to home page
            </a>
        </div>
    </div>


    <!-- loader  -->
    <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm" style="display: none;">
        <div class="w-20 h-20 border-4 border-transparent text-blue-400 text-4xl animate-spin flex items-center justify-center border-t-gray-700 rounded-full">
            <div class="w-16 h-16 border-4 border-transparent text-red-400 text-2xl animate-spin flex items-center justify-center border-t-gray-900 rounded-full"></div>
        </div>
    </div>

    <!-- Successfully message container -->
    <div class="validInfo fixed top-0 mt-2 w-max border-t-4 rounded-lg border-green-400 py-3 px-6 bg-gray-800 z-50" id="SpopUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="Successfully">login successfully</div>
        </div>
    </div>

    <!-- Error message container -->
    <div class="validInfo fixed top-0 mt-2 w-max border-t-4 rounded-lg border-red-500 py-3 px-6 bg-gray-800 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-red-400">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="errorMessage">enter Valid email address</div>
        </div>
    </div>

    <!-- JavaScript function -->
    <script>
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

        function loader(){
            let loader =document.getElementById('loader');
            let body = document.body;

            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
        }

        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');
            
            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = "user_login.php";
            }, 2200);
        }
    </script>

    <!-- script for user registration page -->
    <script>
        $(document).ready(function () {
            $("#userRegi").on("submit", function(e){
                e.preventDefault();

                let fname = $('#fname').val().trim();
                let lname = $('#lname').val().trim();
                let email = $('#email').val().trim();
                let password = $('#password').val().trim();
                let address = $('#address').val().trim();
                let mobileno = $('#mobileno').val().trim();
                let state = $('#state').val().trim();
                let city = $('#city').val().trim();
                let pincode = $('#pincode').val().trim();

                // patterns
                let firstname_pattern = /^[a-zA-Z]([0-9a-zA-Z]){2,10}$/;
                let lastname_pattern = /^[a-zA-Z]([0-9a-zA-Z]){2,10}$/;
                let email_pattern = /^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                let password_pattern = /^.{8,}$/;
                let address_pattern = /^[\w\d\s#.,'-]{5,}$/i;
                let number_pattern = /^[6-9]\d{9}$/;
                let state_pattern = /^[a-zA-Z\s'-]+$/;
                let city_pattern = /^[a-zA-Z\s'-]+$/;
                let pincode_pattern = /^[1-9][0-9]{5}$/;

                if(fname === "" || lname === "" || email === "" || password === "" || address === "" || mobileno === "" || state === "" || city === "" || pincode === ""){
                    displayErrorMessage("Please Fill the Input fields");
                    return
                }else if(fname === "" || !firstname_pattern.test(fname)){
                    displayErrorMessage("Enter Valid First Name");
                    return
                }else if(lname === "" || !lastname_pattern.test(lname)){
                    displayErrorMessage("Enter Valid Last Name");
                    return
                }else if(email === "" || !email_pattern.test(email)){
                    displayErrorMessage("Enter Valid Email");
                    return
                }else if(password === "" || !password_pattern.test(password)){
                    displayErrorMessage("Enter Valid Password");
                    return
                }else if(address === "" || !address_pattern.test(address)){
                    displayErrorMessage("Enter Valid Address");
                    return
                }else if(mobileno === "" || !number_pattern.test(mobileno)){
                    displayErrorMessage("Enter Valid Mobile Number");
                    return
                }else if(state === "" || !state_pattern.test(state)){
                    displayErrorMessage("Enter Valid State");
                    return
                }
                else if(city === "" || !city_pattern.test(city)){
                    displayErrorMessage("Enter Valid City");
                    return
                }
                else if(pincode === "" || !pincode_pattern.test(pincode)){
                    displayErrorMessage("Enter Valid Pincode");
                    return
                }
            

                $.ajax({
                    type: "post",
                    url: "user_regi_ajax.php",
                    data: {
                        fname: fname,
                        lname: lname,
                        email: email,
                        password: password,
                        address: address,
                        mobileno: mobileno,
                        state: state,
                        city: city,
                        pincode: pincode
                    },
                    success: function (response) {
                        if (response === 'email_exists') {
                            displayErrorMessage("Email is already used. Please choose another email.");
                        }else if(response === 'phone_exists'){
                            displayErrorMessage("Mobile Number is already used. Please choose another Number.");
                        } else if (response === 'success') {
                            loader();
                            displaySuccessMessage("Login Successfully.");
                        } 
                    }
                });

            })
        });
    </script>


    <!-- scriopt -->
    <script src="validation.js"></script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>