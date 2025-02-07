<?php
include "../include/connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Contact Us</title>

    <style>
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

<body style="font-family: 'Outfit', sans-serif;">

    <!-- navbar -->
    <?php
    include "_navbar.php";
    ?>

    <div class="max-w-screen-xl m-auto px-2 grid grid-cols-1 gap-y-7 gap-2 text-gray-900 mt-8 min-[879px]:grid-cols-2">
        <div class="text-center w-full md:w-[80%] m-auto">
            <div>
                <h1 class="text-5xl font-bold">Contact us</h1>
                <p class="text-lg font-medium mt-7">Our friendly team is always here to chat.</p>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="grid grid-cols-1 gap-2">
                    <svg class="m-auto" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 473.806 473.806" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path d="M374.456 293.506c-9.7-10.1-21.4-15.5-33.8-15.5-12.3 0-24.1 5.3-34.2 15.4l-31.6 31.5c-2.6-1.4-5.2-2.7-7.7-4-3.6-1.8-7-3.5-9.9-5.3-29.6-18.8-56.5-43.3-82.3-75-12.5-15.8-20.9-29.1-27-42.6 8.2-7.5 15.8-15.3 23.2-22.8 2.8-2.8 5.6-5.7 8.4-8.5 21-21 21-48.2 0-69.2l-27.3-27.3c-3.1-3.1-6.3-6.3-9.3-9.5-6-6.2-12.3-12.6-18.8-18.6-9.7-9.6-21.3-14.7-33.5-14.7s-24 5.1-34 14.7l-.2.2-34 34.3c-12.8 12.8-20.1 28.4-21.7 46.5-2.4 29.2 6.2 56.4 12.8 74.2 16.2 43.7 40.4 84.2 76.5 127.6 43.8 52.3 96.5 93.6 156.7 122.7 23 10.9 53.7 23.8 88 26 2.1.1 4.3.2 6.3.2 23.1 0 42.5-8.3 57.7-24.8.1-.2.3-.3.4-.5 5.2-6.3 11.2-12 17.5-18.1 4.3-4.1 8.7-8.4 13-12.9 9.9-10.3 15.1-22.3 15.1-34.6 0-12.4-5.3-24.3-15.4-34.3l-54.9-55.1zm35.8 105.3c-.1 0-.1.1 0 0-3.9 4.2-7.9 8-12.2 12.2-6.5 6.2-13.1 12.7-19.3 20-10.1 10.8-22 15.9-37.6 15.9-1.5 0-3.1 0-4.6-.1-29.7-1.9-57.3-13.5-78-23.4-56.6-27.4-106.3-66.3-147.6-115.6-34.1-41.1-56.9-79.1-72-119.9-9.3-24.9-12.7-44.3-11.2-62.6 1-11.7 5.5-21.4 13.8-29.7l34.1-34.1c4.9-4.6 10.1-7.1 15.2-7.1 6.3 0 11.4 3.8 14.6 7l.3.3c6.1 5.7 11.9 11.6 18 17.9 3.1 3.2 6.3 6.4 9.5 9.7l27.3 27.3c10.6 10.6 10.6 20.4 0 31-2.9 2.9-5.7 5.8-8.6 8.6-8.4 8.6-16.4 16.6-25.1 24.4-.2.2-.4.3-.5.5-8.6 8.6-7 17-5.2 22.7l.3.9c7.1 17.2 17.1 33.4 32.3 52.7l.1.1c27.6 34 56.7 60.5 88.8 80.8 4.1 2.6 8.3 4.7 12.3 6.7 3.6 1.8 7 3.5 9.9 5.3.4.2.8.5 1.2.7 3.4 1.7 6.6 2.5 9.9 2.5 8.3 0 13.5-5.2 15.2-6.9l34.2-34.2c3.4-3.4 8.8-7.5 15.1-7.5 6.2 0 11.3 3.9 14.4 7.3l.2.2 55.1 55.1c10.3 10.2 10.3 20.7.1 31.3zM256.056 112.706c26.2 4.4 50 16.8 69 35.8s31.3 42.8 35.8 69c1.1 6.6 6.8 11.2 13.3 11.2.8 0 1.5-.1 2.3-.2 7.4-1.2 12.3-8.2 11.1-15.6-5.4-31.7-20.4-60.6-43.3-83.5s-51.8-37.9-83.5-43.3c-7.4-1.2-14.3 3.7-15.6 11s3.5 14.4 10.9 15.6zM473.256 209.006c-8.9-52.2-33.5-99.7-71.3-137.5s-85.3-62.4-137.5-71.3c-7.3-1.3-14.2 3.7-15.5 11-1.2 7.4 3.7 14.3 11.1 15.6 46.6 7.9 89.1 30 122.9 63.7 33.8 33.8 55.8 76.3 63.7 122.9 1.1 6.6 6.8 11.2 13.3 11.2.8 0 1.5-.1 2.3-.2 7.3-1.1 12.3-8.1 11-15.4z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    <span class="font-medium text-sm">Customer service</span>
                    <a href="tel:7863843776" class="font-medium text-sm underline">+91 7863843776</a>
                    <p class="font-normal text-xs text-gray-400">Call us from 8 am to 12 pm ET.</p>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <svg class="m-auto" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 60 60" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path d="M10 25.465h13a1 1 0 1 0 0-2H10a1 1 0 1 0 0 2zM36 29.465H10a1 1 0 1 0 0 2h26a1 1 0 1 0 0-2zM36 35.465H10a1 1 0 1 0 0 2h26a1 1 0 1 0 0-2z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                            <path d="m54.072 2.535-34.142-.07c-3.27 0-5.93 2.66-5.93 5.93v5.124l-8.07.017c-3.27 0-5.93 2.66-5.93 5.93v21.141c0 3.27 2.66 5.929 5.93 5.929H12v10a1 1 0 0 0 1.74.673l9.704-10.675 16.626-.068c3.27 0 5.93-2.66 5.93-5.929v-.113l5.26 5.786a1.002 1.002 0 0 0 1.74-.673v-10h1.07c3.27 0 5.93-2.66 5.93-5.929V8.465a5.937 5.937 0 0 0-5.928-5.93zM44 40.536a3.934 3.934 0 0 1-3.934 3.929l-17.07.07a1 1 0 0 0-.736.327L14 53.949v-8.414a1 1 0 0 0-1-1H5.93A3.934 3.934 0 0 1 2 40.606V19.465a3.935 3.935 0 0 1 3.932-3.93L15 15.516h.002l25.068-.052a3.934 3.934 0 0 1 3.93 3.93v21.142zm14-10.93a3.934 3.934 0 0 1-3.93 3.929H52a1 1 0 0 0-1 1v8.414l-5-5.5V19.395c0-3.27-2.66-5.93-5.932-5.93L16 13.514v-5.12a3.934 3.934 0 0 1 3.928-3.93l34.141.07h.002a3.934 3.934 0 0 1 3.93 3.93v21.142z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    <span class="font-medium text-sm">Customer service</span>
                    <a href="mailto:shopnest2603@gmail.com" class="font-medium text-sm underline">Chat with us</a>
                    <p class="font-noEmail-2 text-gray-400">Daily: 8 am to 11 pm CT</p>
                </div>
            </div>
            <div class="mt-12">
                <div>
                    <h1 class="text-3xl font-medium">Contact information</h1>
                    <span class="text-sm font-normal">Surat, Gujarat</span>
                    <p class="text-sm font-medium">India</p>
                </div>
                <div class="flex flex-wrap items-center justify-evenly gap-2 md:gap-4 mt-5">
                    <div class="grid grid-cols-1 gap-2">
                        <span class="font-medium text-xs uppercase">Phone</span>
                        <a href="tel:7863843776" class="font-medium text-sm">+91 7863843776</a>
                        <a href="tel:123456789" class="font-medium text-sm">+91 8141391797</a>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <span class="font-medium text-xs uppercase">Email</span>
                        <a href="mailto:abhijeetdabhi9304@gmail.com" class="font-medium text-xs md:text-sm underline">abhijeetdabhi9304@gmail.com</a>
                        <a href="mailto:vishvjitchauhan2284@gmail.com" class="font-medium text-xs md:text-sm underline">vishvjitchauhan2284@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-200 rounded-xl w-full md:w-[80%] m-auto py-12 px-5 md:px-12">
            <div class="text-center mb-5">
                <h2 class="text-3xl font-medium">Contact form</h2>
                <p class="text-lg font-medium mt-2">We look forward to hearing from you and will try to respond within three days.</p>
            </div>
            <form action="" id="Contect" method="post" class="m-auto">
                <div class="grid grid-cols-1 md:gap-2 lg:grid-cols-2 lg:gap-5">
                    <div class="flex flex-col gap-1 mt-4">
                        <label for="username" class="text-sm font-medium require">Name:</label>
                        <input type="text" name="name" id="username" class="border-none w-full focus:border-0 focus:ring-0 rounded-md h-12" placeholder="What's you name?">
                    </div>
                    <div class="flex flex-col gap-1 mt-4">
                        <label for="useremail" class="text-sm font-medium require">Email:</label>
                        <input type="email" name="user_email" id="useremail" class="border-none w-full focus:border-0 focus:ring-0 rounded-md h-12" placeholder="What's you E-mail?">
                    </div>
                </div>
                <div>
                    <div class="flex flex-col gap-1 mt-4">
                        <label for="subject" class="text-sm font-medium require">Subject:</label>
                        <input type="text" name="subject" id="subject" class="border-none w-full focus:border-0 focus:ring-0 rounded-md h-12" placeholder="What's you Subject?">
                    </div>
                </div>
                <div>
                    <div class="flex flex-col gap-1 mt-4">
                        <label for="message" class="text-sm font-medium require">Message:</label>
                        <textarea name="message" id="message" rows="5" class="border-none w-full focus:border-0 focus:ring-0 rounded-md resize-none" placeholder="Can You Provide Some More Details?"></textarea>
                    </div>
                </div>
                <input type="submit" name="contact" value="Get in touch" class=" font-medium text-center rounded-tl-xl rounded-br-xl w-full bg-gray-700 text-white mt-5 py-4 cursor-pointer hover:bg-gray-800">
            </form>
        </div>
    </div>


    <!-- footer -->
    <?php
    include "_footer.php";
    ?>

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

        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');

            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = "vendor_account.php";
            }, 2000);
        }
    </script>

    <!-- ajax -->
    <script>
        $(document).ready(function() {
            $('#Contect').on("submit", function(e) {
                e.preventDefault();

                let username = $('#username').val().trim();
                let useremail = $('#useremail').val().trim();
                let subject = $('#subject').val().trim();
                let message = $('#message').val().trim();

                if (!username) {
                    displayErrorMessage("Please enter your Name before submitting the form.");
                    return;
                }
                if (!useremail) {
                    displayErrorMessage("Please enter your Email before submitting the form.");
                    return;
                }
                if (!subject) {
                    displayErrorMessage("Please enter your Subject before submitting the form.");
                    return;
                }
                if (!message) {
                    displayErrorMessage("Please enter your Message before submitting the form.");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "",
                    data: {
                        username: username,
                        useremail: useremail,
                        subject: subject,
                        message: message
                    },
                    success: function(response) {
                        loader();;
                        displaySuccessMessage("Thank you! Your message has been successfully sent. We'll get back to you soon!")
                    }
                });
            });
        });
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>


<?php
include "../include/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $user_email = $_POST['useremail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $date = date('d-m-Y');

    $insert_contact_date = "INSERT INTO contact_us(name, user_email, subject, message, date) VALUES ('$name','$user_email','$subject','$message','$date')";
    $insert_query = mysqli_query($con, $insert_contact_date);
}

?>