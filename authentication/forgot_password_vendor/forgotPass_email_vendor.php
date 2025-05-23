<?php
session_start();

if (isset($_COOKIE['user_id'])) {
    header("Location: /shopnest/index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /shopnest/vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: /shopnest/admin/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- alpinejs CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js" defer></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="../../src/logo/favicon.svg">

    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        #forgotPass-container {
            transition: height 0.5s ease-in-out;
        }

        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
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

<body class="h-[100vh] flex flex-col justify-center items-center outfit">
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
        <div class="w-20 h-20 border-4 border-transparent rotate-180 inner-line border-t-gray-900 rounded-full absolute"></div>
        <img class="w-10 absolute" src="../../src/logo/black_cart_logo.svg" alt="Cart Logo">
    </div>

    <script>
        function loader() {
            let loader = document.getElementById('loader');
            let body = document.body;
            let dataForm = document.getElementById('dataForm');

            // Display the loader
            loader.style.display = 'flex';
            body.style.overflow = 'hidden';
            dataForm.style.opacity = '0.4';
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
    </script>
        
    <div class="p-2 flex items-center justify-center">
        <a class="flex items-center mb-2" href="/shopnest/index.php">
            <!-- icon logo div -->
            <div>
                <img class="w-7 sm:w-12 mt-0.5" src="/shopnest/src/logo/black_cart_logo.svg" alt="">
            </div>
            <!-- text logo -->
            <div>
                <img class="w-16 sm:w-32" src="/shopnest/src/logo/black_text_logo.svg" alt="">
            </div>
        </a>
    </div>
    <div class="w-96 border-2 border-gray-300 space-y-3 rounded-xl h-fit bg-white overflow-hidden" id="forgotPass-container">
        <h1 class="text-2xl py-2 px-4 font-semibold border-b-2 border-gray-300">Forgot Password</h1>
        <form action="" method="post" class="flex flex-col items-center gap-3 pb-3">
            <div class="flex flex-col">
                <label for="userEmail" class="require">Email:</label>
                <input type="email" name="userEmail" id="userEmail" class="w-80 mt-2 h-12 rounded-md border-2 border-gray-400 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" placeholder="user@gmail.com">
                <small id="MailValid" class="text-red-500 hidden translate-x-1">Enter Valid Email</small>
            </div>
            <input type="submit" value="Next" name="GetMail" class="mt-3 bg-gray-700 hover:bg-gray-800 px-2 w-32 text-white tracking-wide h-10 rounded-tl-xl rounded-br-xl cursor-pointer">

            <a href="../vendor_auth/vendor_login.php" class="mt-2 flex justify-center items-center">
                <svg class="w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path d="M420.361 192.229a31.967 31.967 0 0 0-5.535-.41H99.305l6.88-3.2a63.998 63.998 0 0 0 18.08-12.8l88.48-88.48c11.653-11.124 13.611-29.019 4.64-42.4-10.441-14.259-30.464-17.355-44.724-6.914a32.018 32.018 0 0 0-3.276 2.754l-160 160c-12.504 12.49-12.515 32.751-.025 45.255l.025.025 160 160c12.514 12.479 32.775 12.451 45.255-.063a32.084 32.084 0 0 0 2.745-3.137c8.971-13.381 7.013-31.276-4.64-42.4l-88.32-88.64a64.002 64.002 0 0 0-16-11.68l-9.6-4.32h314.24c16.347.607 30.689-10.812 33.76-26.88 2.829-17.445-9.019-33.88-26.464-36.71z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                    </g>
                </svg>
                Return to Login
            </a>
        </form>
    </div>
    <script>
        // E-mail
        const mails = document.getElementById('userEmail')
        const Mailvalid = document.getElementById('MailValid');

        mails.addEventListener('blur', () => {
            console.log('mail blur')
            let regx = /^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            let str = mails.value;

            if (regx.test(str)) {
                console.log('it match');
                Mailvalid.classList.add('hidden');
            } else {
                Mailvalid.classList.remove('hidden');;
            }
        })
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body> 
</html>

<?php
    if (isset($_POST['GetMail'])) {
        $email = $_POST['userEmail'];
        $email_pattern = "/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        if (!preg_match($email_pattern, $email)) {
            ?>
                <script>
                    displayErrorMessage('Enter Valid Email.')  
                </script>
            <?php
        }

        function generateOTP($length = 6)
        {
            $otp = random_int(100000, 999999); // Generates a 6-digit OTP
            return $otp;
        }

        $otp = generateOTP();
        $_SESSION['otp'] = $otp;
        $_SESSION['vendorEmail'] = $email;
        $_SESSION['otp_expiry'] = time() + 300;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ?>
                <script>
                    loader();
                </script>
            <?php

            include "mailOTP_verify_vendor.php";

            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Body = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Password Reset OTP</title>
                <style>
                    h2 {
                        color: #333333;
                    }
                    .otp {
                        font-size: 24px;
                        font-weight: bold;
                        color: #4CAF50;
                    }
                </style>
            </head>
            <body>
    
            <div class='container'>
                <h2>Password Reset Request</h2>
                <p>Dear Customer,</p>
                <p>We received a request to reset your password. To proceed, please use the one-time password (OTP) below:</p>
    
                <p class='otp'>Your OTP: $otp</p>
    
                <p>This OTP is valid for the next 10 minutes. Please enter it in the designated field on the password reset page.</p>
    
                <p>If you did not request a password reset, please ignore this email.</p>
    
                <div class='footer'>
                    <p>Thank you!</p>
                    <p>Best regards,<br>shopNest<br>shopNest2603@gmail.com</p>
                </div>
            </div>
    
            </body>
            </html>";
            $mail->send();

            ?>
                <script>
                    window.location.href = 'forgotPass_otp_vendor.php';
                </script>
            <?php

        } else {
            ?>
                <script>
                    displayErrorMessage('Enter Valid Email.')  
                </script>
            <?php
        }
    }    
?>