<?php
session_start();

unset($_SESSION['vendorEmail']);

unset(
    $_SESSION['fname'],
    $_SESSION['lname'],
    $_SESSION['user_email'],
    $_SESSION['user_address'],
    $_SESSION['user_mobileno'],
    $_SESSION['user_state'],
    $_SESSION['user_city'],
    $_SESSION['user_pincode']
);
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Registration</title>

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="../../src/logo/favIcon.svg">

    <!-- alpinejs CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js" defer></script>

    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>

    <style>
        .require:after {
            content: " *";
            font-weight: bold;
            color: red;
            margin-left: 3px;
        }

        #map {
            width: 60vw;
            height: 60vh;
            display: none;
        }

        .tt-search-box {
            width: 100%;
            margin: auto;
        }

        .tt-search-box input {
            font-size: 16px;
            width: 100%;
            height: 50px;
        }

        .tt-search-box input:focus {
            outline: none;
            box-shadow: none;
        }

        .tt-search-box-input-container {
            width: 100%;
            height: 50px;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            margin: auto;
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


<body class="flex justify-center outfit h-[100%] py-2 px-6">

    <div class="w-full md:w-[85%] lg:w-[70%] 2xl:w-[50%]">
        <!-- header -->
        <div class="p-2 flex items-center justify-center">
            <a class="flex items-center mb-2 focus:outline-none" href="../../index.php">
                <!-- icon logo div -->
                <div>
                    <img class="w-9 sm:w-12 mt-0.5" src="../../src/logo/black_cart_logo.svg" alt="">
                </div>
                <!-- text logo -->
                <div>
                    <img class="w-28 sm:w-32" src="../../src/logo/black_text_logo.svg" alt="">
                </div>
            </a>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="border-2 rounded-md">
                <h1 class="border-b-2 p-2 text-2xl font-semibold">Vendor Registration</h1>
                <!-- Profile Picture -->
                <div class="w-full p-5 mt-3">
                    <div class="w-full relative">
                        <div id="CoverPreviewWrapper" class="w-full relative border border-gray-600 border-dashed rounded-tl-xl rounded-br-xl overflow-hidden cursor-pointer h-40">
                            <img id="CoverPreview" class="w-full h-40 z-50 object-cover object-center hidden" src="" alt="Cover Image">
                            <h2 id="coverText" class="absolute left-0 top-0 flex items-center justify-center w-full h-full">
                                Insert Cover image
                            </h2>
                        </div>

                        <input class="hidden" name="CoverImage" accept="image/jpg, image/png, image/jpeg" type="file" id="Coverimage" onchange="coverImagePreview(event)">

                        <!-- Error message -->
                        <small id="error-message" class="text-red-500 mt-10 absolute text-xs hidden">The cover image must be a file type of: PNG, JPG, or JPEG.</small>
                    </div>

                    <!-- profile image -->
                    <div class="relative flex items-stretch justify-center -mt-8">
                        <img id="previewImage" class="w-16 h-16 rounded-full border object-cover object-center border-black" alt="" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png">
                        <input class="hidden" name="ProfileImage" type="file" id="imageInput" accept="image/jpg, image/png, image/jpeg" onchange="previewSelectedImage()">
                        <label for="imageInput" class="absolute bottom-0 translate-y-3 translate-x-[2px] rounded-full bg-white p-1 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <g data-name="Layer 53">
                                        <path d="M22 9.25a.76.76 0 0 0-.75.75v6l-4.18-4.78a2.84 2.84 0 0 0-4.14 0l-2.87 3.28-.94-1.14a2.76 2.76 0 0 0-4.24 0l-2.13 2.57V6A3.26 3.26 0 0 1 6 2.75h8a.75.75 0 0 0 0-1.5H6A4.75 4.75 0 0 0 1.25 6v12a.09.09 0 0 0 0 .05A4.75 4.75 0 0 0 6 22.75h12a4.75 4.75 0 0 0 4.74-4.68V10a.76.76 0 0 0-.74-.75Zm-4 12H6a3.25 3.25 0 0 1-3.23-3L6 14.32a1.29 1.29 0 0 1 1.92 0l1.51 1.82a.74.74 0 0 0 .57.27.86.86 0 0 0 .57-.26l3.44-3.94a1.31 1.31 0 0 1 1.9 0l5.27 6A3.24 3.24 0 0 1 18 21.25Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M4.25 7A2.75 2.75 0 1 0 7 4.25 2.75 2.75 0 0 0 4.25 7Zm4 0A1.25 1.25 0 1 1 7 5.75 1.25 1.25 0 0 1 8.25 7ZM16 5.75h2.25V8a.75.75 0 0 0 1.5 0V5.75H22a.75.75 0 0 0 0-1.5h-2.25V2a.75.75 0 0 0-1.5 0v2.25H16a.75.75 0 0 0 0 1.5Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </g>
                            </svg>
                        </label>
                    </div>

                    <!-- script for profile image preview -->
                    <script>
                        // Trigger file input click when the CoverPreview div is clicked
                        document.getElementById('CoverPreviewWrapper').addEventListener('click', function() {
                            document.getElementById('Coverimage').click();
                        });

                        // Common error message element for both images
                        const errorMessage = document.getElementById('error-message');

                        // Cover image preview
                        function coverImagePreview(event) {
                            const input = event.target;
                            const file = input.files[0];
                            const coverPreview = document.getElementById('CoverPreview');
                            const coverText = document.getElementById('coverText');

                            if (file) {
                                const fileType = file.type;

                                // Validate file type for cover image
                                if (fileType === "image/png" || fileType === "image/jpeg" || fileType === "image/jpg") {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        coverPreview.src = e.target.result;
                                        coverPreview.style.display = 'block';
                                        coverPreview.classList.remove('hidden');
                                        coverText.classList.add('hidden');
                                    };
                                    reader.readAsDataURL(file);
                                    errorMessage.classList.add('hidden'); // Hide error message if valid
                                } else {
                                    // Invalid cover image file type
                                    coverPreview.classList.add('hidden');
                                    coverPreview.src = '';
                                    coverText.classList.remove('hidden');
                                    showErrorForImages(false, true); // Show error for cover image
                                }
                            }
                        }

                        // Profile image preview
                        const imageInput = document.getElementById('imageInput');
                        const previewImage = document.getElementById('previewImage');

                        function previewSelectedImage() {
                            const file = imageInput.files[0];

                            if (file) {
                                const fileType = file.type;

                                // Validate file type for profile image
                                if (fileType === "image/png" || fileType === "image/jpeg" || fileType === "image/jpg") {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        previewImage.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                    errorMessage.classList.add('hidden'); // Hide error message if valid
                                } else {
                                    // Invalid profile image file type
                                    previewImage.src = 'https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png'; // Reset to default
                                    showErrorForImages(true, false); // Show error for profile image
                                }
                            }
                        }

                        // Function to handle errors for both images
                        function showErrorForImages(isProfileError, isCoverError) {
                            if (isProfileError && isCoverError) {
                                // Show one combined error for both images
                                errorMessage.textContent = "Both cover and profile images must be file PNG, JPG, or JPEG.";
                            } else if (isProfileError) {
                                // Show error for profile image
                                errorMessage.textContent = "Profile image must be PNG, JPG, or JPEG.";
                            } else if (isCoverError) {
                                // Show error for cover image
                                errorMessage.textContent = "Cover image must be PNG, JPG, or JPEG.";
                            }
                            errorMessage.classList.remove('hidden'); // Show error message
                        }

                        // Event listeners for image inputs
                        imageInput.addEventListener('change', previewSelectedImage);
                        document.getElementById('Coverimage').addEventListener('change', coverImagePreview);
                    </script>
                </div>
                <div class="grid grid-cols-4 gap-5 p-5">
                    <div class="col-span-4 md:col-span-2">
                        <div class="flex flex-col gap-1 ">
                            <label for="name" class="require font-semibold">Name :</label>
                            <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="name" value="<?php echo isset($_SESSION['vendor_name']) ? $_SESSION['vendor_name'] : '' ?>" id="name">
                            <small id="vendorName" class="text-red-500 hidden">Enter Valid Name</small>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <div class="flex flex-col gap-1 ">
                            <label for="email" class="require font-semibold">Email :</label>
                            <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="email" name="email" value="<?php echo isset($_SESSION['vendor_email']) ? $_SESSION['vendor_email'] : '' ?>" id="email">
                            <small id="vendorEmail" class="text-red-500 hidden">Enter Valid Email</small>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2 relative" x-data="{ showPassword: false }">
                        <div class="flex flex-col gap-1 ">
                            <label for="password" class="require font-semibold">Password :</label>
                            <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" :type="showPassword ? 'text' : 'password'" name="password" id="password">
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
                            <small id="vendorPass" class="text-red-500 hidden">Enter Valid Password</small>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <div class="flex flex-col gap-1 ">
                            <label for="username" class="require font-semibold">Username :</label>
                            <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>" id="username">
                            <small id="vendorUsername" class="text-red-500 hidden">Enter Valid Username</small>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <div class="flex flex-col gap-1 ">
                            <label for="phone" class="require font-semibold">Phone :</label>
                            <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="tel" maxlength="10" name="phone" value="<?php echo isset($_SESSION['vendor_phone']) ? $_SESSION['vendor_phone'] : '' ?>" id="phone">
                            <small id="vendorPhone" class="text-red-500 hidden">Enter Valid Phone Number</small>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-2">
                        <div class="flex flex-col gap-1 ">
                            <label for="gst" class="require font-semibold">GST :</label>
                            <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="tel" name="gst" value="<?php echo isset($_SESSION['vendor_gst']) ? $_SESSION['vendor_gst'] : '' ?>" id="gst">
                            <small id="vendorGst" class="text-red-500 hidden">Enter Valid GST Number</small>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="flex flex-col gap-1">
                            <label for="gst" class="require font-semibold">Enter Location :</label>
                            <div id="map" class="map"></div>
                            <div id="searchBox"></div>
                            <input type="text" name="lat" id="lat" class="hidden">
                            <input type="text" name="lng" id="lng" class="hidden">
                        </div>
                        <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
                        <script>
                            tt.setProductInfo("hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw", "6.25.0");
                            let map = tt.map({
                                key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                                container: "map",
                            });

                            var options = {
                                searchOptions: {
                                    key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                                    language: "en-GB",
                                    limit: 5,
                                },
                                autocompleteOptions: {
                                    key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                                    language: "en-GB",
                                },
                            };

                            let searchBox = document.getElementById('searchBox');
                            var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
                            var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
                            searchBox.append(searchBoxHTML);

                            // // Handle search result selection
                            ttSearchBox.on('tomtom.searchbox.resultselected', function(event) {
                                const selectedResult = event.data.result;
                                const coordinates = selectedResult.position;

                                let clat = coordinates.lat;
                                let clng = coordinates.lng;

                                console.log(clat);
                                console.log(clng);

                                document.getElementById('lat').value = clat;
                                document.getElementById('lng').value = clng;
                            });
                        </script>
                    </div>
                    <div class="col-span-4">
                        <div class="flex flex-col gap-1 ">
                            <label for="bio" class="require font-semibold">Bio :</label>
                            <textarea class="h-16 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition resize-none" name="bio" id="bio"><?php echo isset($_SESSION['vendor_bio']) ? $_SESSION['vendor_bio'] : '' ?></textarea>
                            <small id="vendorBio" class="text-red-500 hidden">Enter Bio</small>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center w-full mb-5">
                    <input type="submit" name="submitBtn" value="Register" class="bg-gray-700 hover:bg-gray-800 hover:transition h-10 w-72 text-lg rounded-tl-xl rounded-br-xl text-white cursor-pointer">
                </div>
            </div>
        </form>
        <div class="flex flex-col items-center gap-2 mt-5">
            <a class="underline font-semibold" href="vendor_login.php">Already a vendor? Login</a>
            <a href="../../index.php" class="font-semibold tracking-wide flex justify-center gap-1 underline">
                <svg class="w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve">
                    <g>
                        <path d="M420.361 192.229a31.967 31.967 0 0 0-5.535-.41H99.305l6.88-3.2a63.998 63.998 0 0 0 18.08-12.8l88.48-88.48c11.653-11.124 13.611-29.019 4.64-42.4-10.441-14.259-30.464-17.355-44.724-6.914a32.018 32.018 0 0 0-3.276 2.754l-160 160c-12.504 12.49-12.515 32.751-.025 45.255l.025.025 160 160c12.514 12.479 32.775 12.451 45.255-.063a32.084 32.084 0 0 0 2.745-3.137c8.971-13.381 7.013-31.276-4.64-42.4l-88.32-88.64a64.002 64.002 0 0 0-16-11.68l-9.6-4.32h314.24c16.347.607 30.689-10.812 33.76-26.88 2.829-17.445-9.019-33.88-26.464-36.71z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                    </g>
                </svg>
                Return to home page
            </a>
        </div>
    </div>

    <!-- Successfully message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 m-auto rounded-lg border-green-400 py-3 px-6 bg-gray-800 z-[100]" id="SpopUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="Successfully"></div>
        </div>
    </div>

    <!-- Error message container -->
    <div class="validInfo fixed top-3 left-1/2 transform -translate-x-1/2 w-max border-t-4 rounded-lg border-red-500 py-3 px-6 bg-gray-800 z-50" id="popUp" style="display: none;">
        <div class="flex items-center m-auto justify-center text-sm text-red-400">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="capitalize font-medium" id="errorMessage"></div>
        </div>
    </div>

    <!-- loader  -->
    <div id="loader" class="flex-col gap-4 w-full flex items-center justify-center bg-black/30 fixed top-0 h-full backdrop-blur-sm z-40" style="display: none;">
        <div class="w-24 h-24 border-4 border-transparent outer-line border-t-gray-700 rounded-full flex items-center justify-center"></div>
        <div class="w-20 h-20 border-4 border-transparent rotate-180 inner-line border-t-gray-900 rounded-full absolute"> </div>
        <img class="w-10 absolute" src="../../src/logo/black_cart_logo.svg" alt="Cart Logo">
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
                window.location.href = '';
            }, 1800);
        }

        function displaySuccessMessage(message) {
            let SpopUp = document.getElementById('SpopUp');
            let Successfully = document.getElementById('Successfully');

            setTimeout(() => {
                Successfully.innerHTML = '<span class="font-medium">' + message + '</span>';
                SpopUp.style.display = 'flex';
                SpopUp.style.opacity = '100';
                window.location.href = 'vendor_login.php';
            }, 2000);
        }
    </script>


    <!-- script -->
    <script src="vendor_validation.js"></script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>
</body>

</html>

<?php

include "../../include/connect.php";

if (isset($_POST['submitBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $gst = $_POST['gst'];
    $bio = $_POST['bio'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $Vendor_reg_date = date('d-m-Y');

    // Validate other inputs (same as before)
    $name_pattern = "/^[a-zA-Z]([0-9a-zA-Z\s]){1,14}$/";
    $email_pattern = "/^[a-zA-Z][a-zA-Z0-9._-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $password_pattern = "/^.{8,}$/";
    $username_pattern = "/^[a-zA-Z0-9_-]{3,20}$/";
    $phone_pattern = "/^[6-9]\d{9}$/";
    $gst_pattern = "/^[a-zA-Z0-9]{1,15}$/";
    $bio_pattern = "/^.{10,1500}$/";

    // Validate each field using preg_match
    if (!preg_match($name_pattern, $name)) {
        echo '<script>displayErrorMessage("Enter Valid Name");</script>';
    } else {
        $_SESSION['vendor_name'] = $name;
    }

    if (!preg_match($email_pattern, $email)) {
        echo '<script>displayErrorMessage("Enter Valid Email");</script>';
    } else {
        $_SESSION['vendor_email'] = $email;
    }
    if (!preg_match($password_pattern, $password)) {
        echo '<script>displayErrorMessage("Enter Valid Password");</script>';
    }

    if (!preg_match($username_pattern, $username)) {
        echo '<script>displayErrorMessage("Enter Valid Username");</script>';
    } else {
        $_SESSION['username'] = $username;
    }

    if (!preg_match($phone_pattern, $phone)) {
        echo '<script>displayErrorMessage("Enter Valid Phone");</script>';
    } else {
        $_SESSION['vendor_phone'] = $phone;
    }

    if (!preg_match($gst_pattern, $gst)) {
        echo '<script>displayErrorMessage("Enter Valid GST");</script>';
    } else {
        $_SESSION['vendor_gst'] = $gst;
    }

    if (!preg_match($bio_pattern, $bio)) {
        echo '<script>displayErrorMessage("Enter Valid Bio");</script>';
    } else {
        $_SESSION['vendor_bio'] = $bio;
    }

    if ($lat === "" || $lat === "") {
        echo '<script>displayErrorMessage("Please Enter Your Location");</script>';
    }

    // Validate images
    if (empty($_FILES['CoverImage']['name']) || empty($_FILES['ProfileImage']['name'])) {
        echo '<script>displayErrorMessage("Error: Please select both cover and profile images.");</script>';
        exit();
    }

    // Allowed file types
    $allowedFileExtensions = ['jpg', 'jpeg', 'png'];

    // Function to validate image file type
    function validateImageType($file, $allowedExtensions)
    {
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            return "Invalid file type for {$fileName}. Allowed types are: " . implode(", ", $allowedExtensions);
        }

        return true; // Valid
    }

    // Validate Cover Image
    $coverImageValidation = validateImageType($_FILES['CoverImage'], $allowedFileExtensions);
    if ($coverImageValidation !== true) {
        echo '<script>displayErrorMessage("' . $coverImageValidation . '");</script>';
        exit();
    }

    // Validate Profile Image
    $profileImageValidation = validateImageType($_FILES['ProfileImage'], $allowedFileExtensions);
    if ($profileImageValidation !== true) {
        echo '<script>displayErrorMessage("' . $profileImageValidation . '");</script>';
        exit();
    }

    $CoverImage = $_FILES['CoverImage']['name'];
    $tempname = $_FILES['CoverImage']['tmp_name'];
    $folder = '../../src/vendor_images/vendor_cover_image/' . $CoverImage;

    $ProfileImage = $_FILES['ProfileImage']['name'];
    $tempname2 = $_FILES['ProfileImage']['tmp_name'];
    $folder2 = '../../src/vendor_images/vendor_profile_image/' . $ProfileImage;


    // Hash password
    $pass = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $email_check = "SELECT * FROM vendor_registration WHERE email = '$email'";
    $check_query = mysqli_query($con, $email_check);
    $emailCount = mysqli_num_rows($check_query);


    // Check if phone Number already exists
    $phone_check = "SELECT * FROM vendor_registration WHERE phone = '$phone'";
    $phone_check_query = mysqli_query($con, $phone_check);
    $phoneCount = mysqli_num_rows($phone_check_query);

    // Check if userName already exists
    $username_check = "SELECT * FROM vendor_registration WHERE username = '$username'";
    $username_check_query = mysqli_query($con, $username_check);
    $usernameCount = mysqli_num_rows($username_check_query);

    // Check if GST already exists
    $gst_check = "SELECT * FROM vendor_registration WHERE GST = '$gst'";
    $gst_check_query = mysqli_query($con, $gst_check);
    $gstCount = mysqli_num_rows($gst_check_query);

    if ($emailCount > 0) {
        echo '<script>displayErrorMessage("Email already Exists.");</script>';
        exit();
    }

    if ($phoneCount > 0) {
        echo '<script>displayErrorMessage("Phone Number already Exists.");</script>';
        exit();
    }

    if ($usernameCount > 0) {
        echo '<script>displayErrorMessage("Username already Exists.");</script>';
        exit();
    }

    if ($gstCount > 0) {
        echo '<script>displayErrorMessage("GST already Exists.");</script>';
        exit();
    }

    // Move uploaded files
    if (move_uploaded_file($tempname, $folder) && move_uploaded_file($tempname2, $folder2) && $lat != "" || $lat != "" && !preg_match($name_pattern, $name) || !preg_match($email_pattern, $email) || !preg_match($password_pattern, $password) || !preg_match($username_pattern, $username) || !preg_match($phone_pattern, $phone) || !preg_match($gst_pattern, $gst) || !preg_match($bio_pattern, $bio)) {
        $vendorName = $name;
        $vendorEmail = $email;
        $vendorPassword = $pass;
        $vendorUsername = $username;
        $vendorPhone = $phone;
        $vendorBio = $bio;
        $vendorGST = $gst;
        $vendorCover_image = $CoverImage;
        $vendorDp_image = $ProfileImage;
        $vendorLatitude = $lat;
        $vendorLongitude = $lng;
        $vendorRegiDate = $Vendor_reg_date;

        $insert_data = "INSERT INTO vendor_registration(name, email, password, username, phone, Bio, GST, cover_image, dp_image, latitude, longitude, action, date) VALUES ('$vendorName','$vendorEmail','$vendorPassword','$vendorUsername','$vendorPhone','$vendorBio','$vendorGST','$vendorCover_image','$vendorDp_image','$vendorLatitude','$vendorLongitude', 'Not Accept','$vendorRegiDate')";
        $insert_sql = mysqli_query($con, $insert_data);

        unset(
            $_SESSION['vendor_name'],
            $_SESSION['vendor_email'],
            $_SESSION['username'],
            $_SESSION['vendor_phone'],
            $_SESSION['vendor_gst'],
            $_SESSION['vendor_bio']
        );

        if ($insert_sql) {
            echo '<script>loader()</script>';
            echo '<script>displaySuccessMessage("Register successful.");</script>';
        } else {
            echo '<script>displayErrorMessage("Register Failed.");</script>';
        }
    } else {
        echo '<script>displayErrorMessage("Error uploading files.");</script>';
    }
}
?>