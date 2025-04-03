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
    <?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $otp1 = $_POST['otp1'];
        $otp2 = $_POST['otp2'];
        $otp3 = $_POST['otp3'];
        $otp4 = $_POST['otp4'];
        $otp5 = $_POST['otp5'];
        $otp6 = $_POST['otp6'];


        $inputOtp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

        // Check if the OTP matches and hasn't expired
        if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
            if ($inputOtp == $_SESSION['otp'] && time() < $_SESSION['otp_expiry']) {
                // Proceed to the next step (e.g., redirect or show a message)
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expiry']);
    ?>
                <!-- Successfully -->
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="ApopUp" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium"> OTP verified successfully!</span>
                        </div>
                    </div>
                </div>
                <a href=""></a>

                <script>
                    let ApopUp = document.getElementById('ApopUp');

                    ApopUp.style.display = 'flex';
                    ApopUp.style.opacity = '100';

                    setTimeout(() => {
                        ApopUp.style.display = 'none';
                        ApopUp.style.opacity = '0';
                        window.location.href = "forgotPassword_user.php";
                    }, 1500);
                </script>
            <?php
            } else {
            ?>
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp_2" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Invalid OTP or OTP has expired</span>
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
        } else {
            ?>
            <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp_2" style="display: none;">
                <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">No OTP found</span>
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
    }
    ?>
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
    <div class="w-96 border-2 border-gray-300 space-y-3 rounded-xl bg-white overflow-hidden" id="forgotPass-container">
        <h1 class="text-2xl py-2 px-4 font-semibold border-b-2 border-gray-300">Forgot Password</h1>
        <form action="" method="post" id="form2" class="flex flex-col items-center pb-5">
            <div class="flex flex-col space-y-3">
                <label for="OTP" class="require">OTP:</label>
                <div class="flex space-x-3" id="otp-container">
                    <input type="text" name="otp1" maxlength="1" class="otp-box w-11 h-11 text-center text-lg rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0" autocomplete="off" />
                    <input type="text" name="otp2" maxlength="1" class="otp-box w-11 h-11 text-center text-lg rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0" autocomplete="off" />
                    <input type="text" name="otp3" maxlength="1" class="otp-box w-11 h-11 text-center text-lg rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0" autocomplete="off" />
                    <input type="text" name="otp4" maxlength="1" class="otp-box w-11 h-11 text-center text-lg rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0" autocomplete="off" />
                    <input type="text" name="otp5" maxlength="1" class="otp-box w-11 h-11 text-center text-lg rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0" autocomplete="off" />
                    <input type="text" name="otp6" maxlength="1" class="otp-box w-11 h-11 text-center text-lg rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0" autocomplete="off" />
                </div>
            </div>
            <div class="space-x-5 mt-5">
                <button id="back1" onclick="window.location.href='forgotPass_email_user.php'" type="button" class="bg-gray-700 hover:bg-gray-800 px-2 w-32 text-white tracking-wide h-10 rounded-tl-xl rounded-br-xl">Back</button>
                <button id="next2" type="submit" class="bg-gray-700 hover:bg-gray-800 px-2 w-32 text-white tracking-wide h-10 rounded-tl-xl rounded-br-xl">Next</button>
            </div>
            <a href="../user_auth/user_login.php" class="mt-5 flex justify-center items-center">
                <svg class="w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path d="M420.361 192.229a31.967 31.967 0 0 0-5.535-.41H99.305l6.88-3.2a63.998 63.998 0 0 0 18.08-12.8l88.48-88.48c11.653-11.124 13.611-29.019 4.64-42.4-10.441-14.259-30.464-17.355-44.724-6.914a32.018 32.018 0 0 0-3.276 2.754l-160 160c-12.504 12.49-12.515 32.751-.025 45.255l.025.025 160 160c12.514 12.479 32.775 12.451 45.255-.063a32.084 32.084 0 0 0 2.745-3.137c8.971-13.381 7.013-31.276-4.64-42.4l-88.32-88.64a64.002 64.002 0 0 0-16-11.68l-9.6-4.32h314.24c16.347.607 30.689-10.812 33.76-26.88 2.829-17.445-9.019-33.88-26.464-36.71z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                    </g>
                </svg>
                Return to Login
            </a>
        </form>
    </div>

    <!-- script for OTP -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll("#otp-container .otp-box");

            otpInputs.forEach((input, index) => {
                let timeoutId;

                // Function to handle input and transition
                const handleInput = (e) => {
                    const value = e.target.value;

                    // Allow only numeric input
                    if (isNaN(value) || value.length > 1) {
                        e.target.value = "";
                        return;
                    }

                    clearTimeout(timeoutId);

                    // Move to the next input if a number is entered
                    if (value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }

                    // Show the text form for a few seconds
                    timeoutId = setTimeout(() => {
                        e.target.type = "password";
                    }, 500);

                    // Ensure the input box is in text form if a value is entered
                    e.target.type = "text";
                };

                const handleFocus = (e) => {
                    // Clear previous timeout when an input is focused
                    clearTimeout(timeoutId);

                    // Show text form immediately when focused
                    e.target.type = "text";
                };

                // Handle input and focus events
                input.addEventListener("input", handleInput);
                input.addEventListener("focus", handleFocus);

                // Handle backspace to move to the previous input
                input.addEventListener("keydown", (e) => {
                    if (e.key === "Backspace" && input.value === "" && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                // Prevent non-numeric input (allow only numbers and backspace)
                input.addEventListener("keypress", (e) => {
                    if (e.key < "0" || e.key > "9") {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

    <a href="/shoopnest/page"></a>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>