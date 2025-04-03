<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Account</title>
    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- alpinejs CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js" defer></script>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

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

<body class="bg-gray-200 outfit">

    <header class="w-full flex items-center py-4 px-4 border-b-[2.5px] border-gray-700 shadow-md shadow-gray-400 bg-white">
        <a href="vendor_profile.php">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-7 md:w-10">
                <g>
                    <path fill="#000000" fill-rule="evenodd" d="M15 4a1 1 0 1 1 1.414 1.414l-5.879 5.879a1 1 0 0 0 0 1.414l5.88 5.879A1 1 0 0 1 15 20l-7.293-7.293a1 1 0 0 1 0-1.414z" clip-rule="evenodd" opacity="1" data-original="#000000"></path>
                </g>
            </svg>
        </a>
        <h2 class="font-manrope font-bold text-xl md:text-4xl leading-10 text-black w-full text-center">Add Account</h2>
    </header>

    <div class="bg-blue-100 mt-5 mx-4 px-4 py-2 border border-blue-700 rounded-lg border-l-4 space-y-1 shadow-lg">
        <h1 class="text-blue-700 font-semibold text-lg flex items-center gap-2">
            <span>
                <svg class="w-4 h-4 mb-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
            </span>
            <span>
                Important
            </span>
        </h1>
        <p class="text-blue-700 text-sm">
            You can create multiple accounts using different email and password combinations. When you logging into a new account, all products from your main account will be automatically transferred to the new account, allowing you to manage and organize them effortlessly across both accounts while maintaining their independence.
        </p>
    </div>

    <div class="p-4 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-x-4 gap-y-5" id="container">

    </div>
    <div class="w-full flex justify-center gap-3 px-2 mb-5">
        <button id="addBox" class="w-52 h-10 font-medium ring-1 ring-blue-800 shadow-lg text-blue-800 rounded-tl-lg rounded-br-lg bg-blue-200 transition duration-200 cursor-pointer flex items-center justify-center gap-2">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-5">
                    <g>
                        <defs>
                            <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                <path d="M0 512h512V0H0Z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                            </clipPath>
                        </defs>
                        <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                            <path d="M0 0v-160" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(412 180)" fill="none" stroke="currentColor" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="currentColor" class=""></path>
                            <path d="M0 0h160" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(332 100)" fill="none" stroke="currentColor" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="currentColor" class=""></path>
                            <path d="M0 0c0 70.692 57.308 128 128 128 70.692 0 128-57.308 128-128 0-70.692-57.308-128-128-128C57.308-128 0-70.692 0 0Z" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(128 364)" fill="none" stroke="currentColor" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="currentColor" class=""></path>
                            <path d="M0 0h-272c-22.091 0-40 17.909-40 40v37c0 28.683 12.265 56.034 33.813 74.966C-241.704 184.021-175.165 216-76 216" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(332 20)" fill="none" stroke="currentColor" stroke-width="40" stroke-linecap="round" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="currentColor" class=""></path>
                        </g>
                    </g>
                </svg>
            </span>
            <span class="mt-0.5">
                Add Account
            </span>
        </button>
        <button id="submit" class="w-56 h-10 font-medium ring-1 ring-green-800 shadow-lg text-green-800 rounded-tl-lg rounded-br-lg bg-green-200 transition duration-200 cursor-pointer hidden">Submit Form</button>
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
                window.location.href = 'vendor_profile.php';
            }, 2000);
        }
    </script>

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
    <script>
        let container = document.getElementById('container');
        let addBox = document.getElementById('addBox');
        let submit = document.getElementById('submit');

        let divCount = 0;

        addBox.addEventListener("click", function() {
            divCount++

            if (divCount >= 1) {
                submit.classList.remove('hidden');
            }

            let newSection = document.createElement('div');
            newSection.classList.add('map-container', 'ring-2', 'ring-gray-600', 'rounded-md', 'shadow-md', 'p-5', 'bg-white', 'mt-2');
            newSection.innerHTML = `
                <div class="grid grid-cols-1 min-[600px]:grid-cols-2 gap-5 w-full">
                    <div class="flex flex-col">
                        <label for="email${divCount}" class="require font-semibold">Email :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="email" name="email[]" id="email${divCount}">
                    </div>
                    <div class="flex flex-col relative" x-data="{ showPassword: false }">
                        <label for="password${divCount}" class="require font-semibold">Password :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" :type="showPassword ? 'text' : 'password'" name="password[]" id="password${divCount}">
                        <span class="absolute top-[2.35rem] right-2.5 cursor-pointer" @click="showPassword = !showPassword">
                            <!-- Show Icon (when password is hidden) -->
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>

                            <!-- Hide Icon (when password is visible) -->
                            <svg x-show="!showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 128 128" style="fill: rgba(0, 0, 0, 1);">
                                <path d="m79.891 65.078 7.27-7.27C87.69 59.787 88 61.856 88 64c0 13.234-10.766 24-24 24-2.144 0-4.213-.31-6.192-.839l7.27-7.27a15.929 15.929 0 0 0 14.813-14.813zm47.605-3.021c-.492-.885-7.47-13.112-21.11-23.474l-5.821 5.821c9.946 7.313 16.248 15.842 18.729 19.602C114.553 71.225 95.955 96 64 96c-4.792 0-9.248-.613-13.441-1.591l-6.573 6.573C50.029 102.835 56.671 104 64 104c41.873 0 62.633-36.504 63.496-38.057a3.997 3.997 0 0 0 0-3.886zm-16.668-39.229-88 88C22.047 111.609 21.023 112 20 112s-2.047-.391-2.828-1.172a3.997 3.997 0 0 1 0-5.656l11.196-11.196C10.268 83.049 1.071 66.964.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24c10.827 0 20.205 2.47 28.222 6.122l12.95-12.95c1.563-1.563 4.094-1.563 5.656 0s1.563 4.094 0 5.656zM34.333 88.011 44.46 77.884C41.663 73.96 40 69.175 40 64c0-13.234 10.766-24 24-24 5.175 0 9.96 1.663 13.884 4.459l8.189-8.189C79.603 33.679 72.251 32 64 32 32.045 32 13.447 56.775 8.707 63.994c3.01 4.562 11.662 16.11 25.626 24.017zm15.934-15.935 21.809-21.809C69.697 48.862 66.958 48 64 48c-8.822 0-16 7.178-16 16 0 2.958.862 5.697 2.267 8.076z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <label for="shopname${divCount}" class="require font-semibold">shopname :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="text" name="shopname[]" id="shopname${divCount}">
                    </div>
                    <div class="flex flex-col">
                        <label for="phone${divCount}" class="require font-semibold">Phone :</label>
                        <input class="h-12 rounded-md border-2 border-gray-300 hover:border-gray-500 focus:border-gray-700 focus:ring-0 hover:transition" type="tel" maxlength="10" name="phone[]" id="phone${divCount}">
                    </div>
                    <div class="flex flex-col  min-[600px]:col-span-2">
                        <label for="location" class="require font-semibold">Enter Location #${divCount}:</label>
                        <div id="map${divCount}" class="map"></div>
                        <div id="searchBox${divCount}"></div>
                        <input type="text" name="lat[]" id="lat${divCount}" class="hidden">
                        <input type="text" name="lng[]" id="lng${divCount}" class="hidden">
                    </div>
                    <div class="mt-4 flex justify-center min-[600px]:col-span-2">
                        <button id="remove${divCount}" class="p-3 text-red-800 bg-red-200 ring-1 ring-red-800 rounded-tl-lg rounded-br-lg my-2 w-full min-[600px]:w-72 transition-all duration-200 cursor-pointer">Remove</button>
                    </div>
                </div>
            `;

            container.append(newSection);

            var map = tt.map({
                key: "hMLEkomeHUGPEdhMWuKMYX9pXh8eZgVw",
                container: `map${divCount}`,
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

            var searchBox = document.getElementById(`searchBox${divCount}`);
            var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
            var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
            searchBox.append(searchBoxHTML);

            ttSearchBox.on('tomtom.searchbox.resultselected', function(event) {
                const selectedResult = event.data.result;
                const coordinates = selectedResult.position;

                let latInput = document.getElementById(`lat${divCount}`);
                let lngInput = document.getElementById(`lng${divCount}`);

                latInput.value = coordinates.lat;
                lngInput.value = coordinates.lng;

                // Optionally, you can add a marker here if needed
                new tt.Marker().setLngLat([coordinates.lng, coordinates.lat]).addTo(map);
            });

            let removeBtn = document.getElementById(`remove${divCount}`);
            removeBtn.addEventListener("click", function() {
                container.removeChild(newSection);
            });
        });


        submit.addEventListener("click", function(e) {
            e.preventDefault();

            let formData = [];
            let vendorId = <?php echo $_COOKIE['vendor_id'] ?>;

            document.querySelectorAll(".map-container").forEach((container, index) => {
                let email = container.querySelector(`#email${index + 1}`).value;
                let password = container.querySelector(`#password${index + 1}`).value;
                let shopname = container.querySelector(`#shopname${index + 1}`).value;
                let phone = container.querySelector(`#phone${index + 1}`).value;
                let lat = container.querySelector(`#lat${index + 1}`).value;
                let lng = container.querySelector(`#lng${index + 1}`).value;

                if (email === "") {
                    displayErrorMessage("Please Enter Email Address");
                    return;
                }

                if (password === "") {
                    displayErrorMessage("Please Enter Password");
                    return;
                }

                if (shopname === "") {
                    displayErrorMessage("Please Enter Shopname");
                    return;
                }

                if (phone === "") {
                    displayErrorMessage("Please Enter Phone Number");
                    return;
                }

                if (lat === "") {
                    displayErrorMessage("Please Enter Your Shop Location");
                    return;
                }


                formData.push({
                    vendorId,
                    email,
                    password,
                    shopname,
                    phone,
                    lat,
                    lng
                });
            });

            $.ajax({
                url: 'multiAccountAjax.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    loader();
                    displaySuccessMessage('Account Added Successfully');
                }
            });
        });
    </script>

</body>

</html>