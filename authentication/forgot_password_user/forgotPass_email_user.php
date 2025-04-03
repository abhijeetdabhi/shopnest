<?php
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

<?php

if (isset($_POST['GetMail'])) {

    $email = $_POST['userEmail'];
    $email_pattern = "/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";


    if (!preg_match($email_pattern, $email)) {
?>
        <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp_2" style="display: none;">
            <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Enter Valid Email.</span>
                </div>
            </div>
        </div>

        <script>
            let EpopUp_2 = document.getElementById('EpopUp_2');

            EpopUp_2.style.display = 'flex';
            EpopUp_2.style.opacity = '100';

            setTimeout(() => {
                EpopUp_2.style.display = 'none';
                EpopUp_2.style.opacity = '0';
            }, 1500);
        </script>
    <?php
    }

    session_start();
    function generateOTP($length = 6)
    {
        $otp = random_int(100000, 999999); // Generates a 6-digit OTP
        return $otp;
    }

    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['otp_expiry'] = time() + 300;

    include "mailOTP_verify_user.php";

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail->addAddress($email);
    } else {
    ?>
        <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp_2" style="display: none;">
            <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Enter Valid Email.</span>
                </div>
            </div>
        </div>

        <script>
            let EpopUp_2 = document.getElementById('EpopUp_2');

            EpopUp_2.style.display = 'flex';
            EpopUp_2.style.opacity = '100';

            setTimeout(() => {
                EpopUp_2.style.display = 'none';
                EpopUp_2.style.opacity = '0';
            }, 1500);
        </script>
<?php
    }
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

    header("Location: forgotPass_otp_user.php");
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
    </style>
</head>

<body class="h-[100vh] flex flex-col justify-center items-center outfit">
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

            <a href="../user_auth/user_login.php" class="mt-2 flex justify-center items-center">
                <svg class="w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path d="M420.361 192.229a31.967 31.967 0 0 0-5.535-.41H99.305l6.88-3.2a63.998 63.998 0 0 0 18.08-12.8l88.48-88.48c11.653-11.124 13.611-29.019 4.64-42.4-10.441-14.259-30.464-17.355-44.724-6.914a32.018 32.018 0 0 0-3.276 2.754l-160 160c-12.504 12.49-12.515 32.751-.025 45.255l.025.025 160 160c12.514 12.479 32.775 12.451 45.255-.063a32.084 32.084 0 0 0 2.745-3.137c8.971-13.381 7.013-31.276-4.64-42.4l-88.32-88.64a64.002 64.002 0 0 0-16-11.68l-9.6-4.32h314.24c16.347.607 30.689-10.812 33.76-26.88 2.829-17.445-9.019-33.88-26.464-36.71z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                    </g>
                </svg>
                Return to Login
            </a>
        </form>
    </div>

    <!-- Error message container -->
    <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div id="errorMessage"></div>
        </div>
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