<?php

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];

    $retrieve_data = "SELECT * FROM user_registration WHERE user_id = '$user_id'";
    $retrieve_query = mysqli_query($con, $retrieve_data);

    $row = mysqli_fetch_assoc($retrieve_query);

    if (isset($_SESSION['searchWord'])) {
        $_SESSION['searchWord'] = isset($_SESSION['searchWord']) ? $_SESSION['searchWord'] : '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Tailwind Script  -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <!-- alpinejs CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <script>
        function showSidebar() {
            // $("#sidebarContainer").addClass('block');
            activePopup = 'sidebarContainer';
            let sidebarContainer = $('#sidebarContainer');
            sidebarContainer.show();
            sidebarContainer.addClass('sidebar-open');

            $('body').css('overflowY', 'hidden');
            // $('body').fadeTo(700, 0.5);
            event.preventDefault();
        }

        // close sidebarContainer using Esc key
        $(document).keydown(function(event) {
            if (event.key === 'Escape') {
                if (activePopup === 'sidebarContainer') {
                    closeSidebar();
                }
            }
        });

        function closeSidebar() {
            let closeSidebar = $('#sidebarContainer');
            closeSidebar.addClass('sidebar-close');

            $('body').css('overflow', 'visible');

            setTimeout(function() {
                closeSidebar.removeClass('sidebar-close').hide();
            }, 300);
            // $('body').fadeTo(800,1);   
        }
    </script>

    <style>
        .outfit {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        [x-cloak] {
            display: none;
        }

        @keyframes openSideBar {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .sidebar-open {
            animation: openSideBar 0.4s ease-in-out;
        }

        @keyframes closeSideBar {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .scrollBar::-webkit-scrollbar-track {
            border-radius: 10px;
            background-color: #e6e6e6;
        }

        .scrollBar::-webkit-scrollbar {
            width: 10px;
            height: 5px;
            background-color: #F5F5F5;
        }

        .scrollBar::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #bfbfbf;
        }

        .sidebar-close {
            animation: closeSideBar 0.4s ease-in-out;
        }

        .wave {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #2563eb;
            /* Tailwind's blue-600 */
            animation: wave 1s infinite;
        }

        @keyframes wave {
            0% {
                transform: scale(1.5);
            }

            50% {
                transform: scale(2);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 1;
            }
        }

        #suggestions-list,
        #suggestions-list2 {
            max-height: 15rem;
            overflow-y: auto;
        }
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">
    <header class="bg-black px-2 py-4 outfit relative">
        <div class="flex items-center justify-between gap-10">
            <div class="flex xl:gap-5">
                <button class="focus:outline-none pr-4" onclick="showSidebar()">
                    <svg class="w-5 sm:w-9" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M30 7a1 1 0 0 1-1 1H3a1 1 0 0 1 0-2h26a1 1 0 0 1 1 1zm-5 8H3a1 1 0 0 0 0 2h22a1 1 0 0 0 0-2zm-9 9H3a1 1 0 0 0 0 2h13a1 1 0 0 0 0-2z" data-name="Layer 13" fill="#ffffff" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                </button>
                <!-- logo -->
                <div>
                    <a class="flex w-fit py-2 focus:outline-none" href="../index.php">
                        <!-- icon logo div -->
                        <div>
                            <img class="w-7 sm:w-12 mt-0.5" src="../src/logo/white_cart_logo.svg" alt="">
                        </div>
                        <!-- text logo -->
                        <div>
                            <img class="w-16 sm:w-32" src="../src/logo/white_text_logo.svg" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <!-- search -->
            <div class="relative h-full hidden lg:block" x-data="{showMic:false}">
                <form action="#" method="post">
                    <div class="flex items-center">
                        <div class="relative">
                            <!-- search input -->
                            <input id="search-input" value="<?php echo isset($_SESSION['searchWord']) ? $_SESSION['searchWord'] : ''; ?>" name="searchInputItems" class="lg:w-[26vw] xl:w-[40vw] h-12 pr-12 focus:ring-[#08091b] border-0 text-black focus:ring-0 focus:outline-none rounded-s-md text-lg" type="text" placeholder="search for anything..." autocomplete="off">
                            <!-- suggation -->
                            <input type="submit" id="searchBtn" name="searchBtn" class="hidden">
                            <ul id="suggestions-list" class="w-full h-60 bg-white absolute top-11 left-0 rounded-b-md z-[100] list-none hidden custom-scrollbar"></ul>
                            <!-- microphone button -->
                            <div class="absolute right-3 top-2.5 p-1 cursor-pointer" id="start-btn" @click="showMic=true">
                                <svg class="text-gray-400 h-5 w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 435.2 435.2" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M356.864 224.768c0-8.704-6.656-15.36-15.36-15.36s-15.36 6.656-15.36 15.36c0 59.904-48.64 108.544-108.544 108.544-59.904 0-108.544-48.64-108.544-108.544 0-8.704-6.656-15.36-15.36-15.36s-15.36 6.656-15.36 15.36c0 71.168 53.248 131.072 123.904 138.752v40.96h-55.808c-8.704 0-15.36 6.656-15.36 15.36s6.656 15.36 15.36 15.36h142.336c8.704 0 15.36-6.656 15.36-15.36s-6.656-15.36-15.36-15.36H232.96v-40.96c70.656-7.68 123.904-67.584 123.904-138.752z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                        <path d="M217.6 0c-47.104 0-85.504 38.4-85.504 85.504v138.752c0 47.616 38.4 85.504 85.504 86.016 47.104 0 85.504-38.4 85.504-85.504V85.504C303.104 38.4 264.704 0 217.6 0z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <!-- js for suggetion -->
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const searchInput = document.getElementById('search-input');
                                const suggestionsList = document.getElementById('suggestions-list');
                                let currentIndex = -1;

                                // Fetch search suggestions
                                const fetchSuggestions = (query) => {
                                    if (query.length === 0) {
                                        suggestionsList.classList.add('hidden');
                                        return;
                                    }

                                    fetch('../search/suggestion.php', {
                                            method: 'POST',
                                            body: new URLSearchParams({
                                                query
                                            }),
                                        })
                                        .then((response) => {
                                            if (!response.ok) {
                                                throw new Error(`HTTP error! status: ${response.status}`);
                                            }
                                            return response.text();
                                        })
                                        .then((data) => {
                                            suggestionsList.innerHTML = data;
                                            suggestionsList.classList.toggle('hidden', data.trim() === '');
                                            currentIndex = -1; // Reset index
                                        })
                                        .catch((error) => console.error('Error fetching suggestions:', error));
                                };

                                // Update suggestions on input
                                searchInput.addEventListener('input', (e) => {
                                    const query = e.target.value.trim();
                                    fetchSuggestions(query);
                                    currentIndex = -1;
                                });

                                // Handle key navigation and Enter
                                searchInput.addEventListener('keydown', (e) => {
                                    const items = suggestionsList.querySelectorAll('li');
                                    const query = searchInput.value.trim();

                                    if (e.key === 'ArrowDown') {
                                        // Move to the next suggestion
                                        if (currentIndex < items.length - 1) {
                                            currentIndex++;
                                        }
                                        highlightSuggestion();
                                        scrollToSuggestion();
                                    } else if (e.key === 'ArrowUp') {
                                        // Move to the previous suggestion
                                        if (currentIndex > 0) {
                                            currentIndex--;
                                        }
                                        highlightSuggestion();
                                        scrollToSuggestion();
                                    } else if (e.key === 'Enter') {
                                        if (query === '') {
                                            // If search input is empty, redirect to the index page
                                            e.preventDefault();
                                            window.location.href = '../index.php'; // Redirect to index page
                                        } else if (currentIndex >= 0 && currentIndex < items.length) {
                                            const selectedSuggestion = items[currentIndex];
                                            const link = selectedSuggestion.querySelector('a');
                                            if (link) {
                                                e.preventDefault();
                                                window.location.href = link.href;
                                            }
                                        } else if (query) {
                                            window.location.assign(`../search/search_items.php?query=${encodeURIComponent(query)}`);
                                        }
                                    }
                                });

                                // Highlight suggestions and update the input value
                                const highlightSuggestion = () => {
                                    const items = suggestionsList.querySelectorAll('li');
                                    items.forEach((item) => item.classList.remove('bg-gray-300'));
                                    if (currentIndex >= 0 && currentIndex < items.length) {
                                        const selectedItem = items[currentIndex];
                                        selectedItem.classList.add('bg-gray-300');
                                        // Update the input field with the current selected suggestion
                                        searchInput.value = selectedItem.textContent.trim();
                                    }
                                };

                                // Scroll to the selected suggestion
                                const scrollToSuggestion = () => {
                                    const items = suggestionsList.querySelectorAll('li');
                                    const selectedItem = items[currentIndex];
                                    if (selectedItem) {
                                        const container = suggestionsList;
                                        const itemRect = selectedItem.getBoundingClientRect();
                                        const containerRect = container.getBoundingClientRect();

                                        // Scroll the container to ensure the selected item is visible
                                        if (itemRect.top < containerRect.top) {
                                            container.scrollTop -= (containerRect.top - itemRect.top);
                                        } else if (itemRect.bottom > containerRect.bottom) {
                                            container.scrollTop += (itemRect.bottom - containerRect.bottom);
                                        }
                                    }
                                };

                                // Click suggestion to update input and search
                                suggestionsList.addEventListener('click', (e) => {
                                    if (e.target.tagName === 'LI') {
                                        searchInput.value = e.target.textContent;
                                        suggestionsList.classList.add('hidden');
                                    }
                                });

                                // Close suggestions if clicking outside
                                document.addEventListener('click', (e) => {
                                    if (!e.target.closest('.relative')) {
                                        suggestionsList.classList.add('hidden');
                                    }
                                });
                            });
                        </script>

                        <!-- search button -->
                        <label for="searchBtn">
                            <div id="searchBtns" class="search-btn bg-[#b7ff1d] px-3 h-12 flex items-center justify-center rounded-e-md hover:bg-[#81b909] transition duration-300 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 118.783 118.783" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M115.97 101.597 88.661 74.286a47.75 47.75 0 0 0 7.333-25.488c0-26.509-21.49-47.996-47.998-47.996S0 22.289 0 48.798c0 26.51 21.487 47.995 47.996 47.995a47.776 47.776 0 0 0 27.414-8.605l26.984 26.986a9.574 9.574 0 0 0 6.788 2.806 9.58 9.58 0 0 0 6.791-2.806 9.602 9.602 0 0 0-.003-13.577zM47.996 81.243c-17.917 0-32.443-14.525-32.443-32.443s14.526-32.444 32.443-32.444c17.918 0 32.443 14.526 32.443 32.444S65.914 81.243 47.996 81.243z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>
                        </label>
                    </div>

                    <div id="mic-popup" class="w-full h-full z-[100] fixed top-0 left-0 flex items-center justify-center bg-black bg-opacity-40 hidden" x-show="showMic">
                        <div class="w-max h-max z-[100] flex flex-col items-center justify-center p-8 bg-white border-2 border-blue-600 rounded-lg shadow-2xl relative">
                            <span class="absolute top-2 right-2">
                                <svg id="mic-close-btn" x-on:click="showMic=false" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 511.76 511.76" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M436.896 74.869c-99.84-99.819-262.208-99.819-362.048 0-99.797 99.819-99.797 262.229 0 362.048 49.92 49.899 115.477 74.837 181.035 74.837s131.093-24.939 181.013-74.837c99.819-99.818 99.819-262.229 0-362.048zm-75.435 256.448c8.341 8.341 8.341 21.824 0 30.165a21.275 21.275 0 0 1-15.083 6.251 21.277 21.277 0 0 1-15.083-6.251l-75.413-75.435-75.392 75.413a21.348 21.348 0 0 1-15.083 6.251 21.277 21.277 0 0 1-15.083-6.251c-8.341-8.341-8.341-21.845 0-30.165l75.392-75.413-75.413-75.413c-8.341-8.341-8.341-21.845 0-30.165 8.32-8.341 21.824-8.341 30.165 0l75.413 75.413 75.413-75.413c8.341-8.341 21.824-8.341 30.165 0 8.341 8.32 8.341 21.824 0 30.165l-75.413 75.413 75.415 75.435z" fill="#ff0000" opacity="1" data-original="#ff0000" class=""></path>
                                    </g>
                                </svg>
                            </span>
                            <h2 class="text-xl font-semibold text-center text-gray-800">Listening...</h2>
                            <div class="wave my-6 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="15" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="mt-[1px] ml-[1px]">
                                    <g>
                                        <defs>
                                            <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                                <path d="M0 512h512V0H0Z" fill="#ffffff" opacity="1" data-original="#ffffff"></path>
                                            </clipPath>
                                        </defs>
                                        <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                            <path d="M0 0h160" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(176 20.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v-72" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 92.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0c0-88.223-71.777-160-160-160S-320-88.223-320 0" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(416 252.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0c-44.183 0-80 35.817-80 80v160c0 44.183 35.817 80 80 80s80-35.817 80-80V80C80 35.817 44.183 0 0 0Z" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 172.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v40" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(96 332.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v120" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(20 292.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v40" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(416 332.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v120" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(492 292.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <p class="text-sm text-center text-gray-600 mt-2">Please speak clearly into the microphone.</p>
                        </div>
                    </div>
                    <!-- speech recognition search 1 -->
                    <script>
                        // Check for browser support
                        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                        if (!SpeechRecognition) {
                            alert("Your browser does not support speech recognition.");
                        } else {
                            const recognition = new SpeechRecognition();
                            recognition.continuous = true; // Continuous listening until stopped
                            recognition.interimResults = false; // Don't return interim results

                            const micPopup = document.getElementById('mic-popup');
                            const startButton = document.getElementById('start-btn');

                            recognition.onstart = () => {
                                micPopup.classList.remove('hidden');
                            };

                            // Event handler for result
                            recognition.onresult = (event) => {
                                const transcript = event.results[event.resultIndex][0].transcript;
                                document.getElementById('search-input').value = transcript;
                                document.getElementById('searchBtns').click();
                            };

                            // Error handling
                            recognition.onerror = (event) => {
                                console.error('Error occurred in recognition: ' + event.error);
                                micPopup.classList.add('hidden'); // Hide popup on error
                            };

                            // Start recognition when button is clicked
                            document.getElementById('start-btn').addEventListener('click', () => {
                                recognition.start();
                            });

                            // Stop recognition function
                            function stopRecognition() {
                                recognition.stop();
                                micPopup.classList.add('hidden');
                            }

                            // Stop recognition when the popup is closed
                            document.getElementById('mic-close-btn').addEventListener('click', () => {
                                stopRecognition();
                            });
                        }
                    </script>

                </form>
                <?php
                if (isset($_POST["searchBtn"])) {
                    $searchName = $_POST['searchInputItems'];
                    $filterName = str_replace(' ', '+', $searchName); // Replace spaces with "+" for URL compatibility
                    ?>
                    <script>
                        let filterName = "<?php echo htmlspecialchars($filterName, ENT_QUOTES, 'UTF-8'); ?>";

                        if (filterName != "") {
                            window.location.href = "../search/search_items.php?searchName=" + filterName;
                        }
                    </script>
                <?php
                }
                ?>
            </div>
            <!-- user & cart -->
            <div class="flex items-center gap-4 md:gap-10 pr-4">
                <?php
                if (isset($_COOKIE['user_id'])) {
                ?>
                    <!-- popup is show when user is login -->
                    <div x-data="{loginUser:false}" class="">
                        <div>
                            <button class="flex items-center gap-2 text-white rounded-full px-0.5 py-0.5 hover:ring-1 hover:ring-gray-400 hover:bg-gray-800 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:bg-gray-800" x-on:click="loginUser = !loginUser" @click.outside="loginUser=false">
                                <div class="w-6 h-6 md:w-9 md:h-9 m-auto">
                                    <img class="w-full h-full rounded-full flex justify-center object-cover" src="<?php echo isset($_COOKIE['user_id']) ? '../src/user_dp/' . $row['profile_image'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' ?>" alt="" class="bg-white">
                                </div>
                                <svg class="w-3 mr-0.5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 451.847 451.847" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    </g>
                                </svg>

                            </button>
                        </div>
                        <div x-show="loginUser" x-transition x-cloak class="w-40 bg-white border text-black overflow-hidden absolute right-4 top-[5rem] md:right-40 rounded-md z-10">
                            <div class="py-2 px-3">
                                <a href="../index.php" class="w-full">Hi,<?php echo isset($_COOKIE['fname']) ? $_COOKIE['fname'] : 'User Name' ?></a>
                            </div>
                            <hr class="border">
                            <ul class="text-sm lg:text-base">
                                <li class="hover:bg-gray-500 hover:text-white px-3">
                                    <a class="flex items-center gap-x-2 py-2" href="../user/profile.php">
                                        <svg class="h-4 w-4 lg:h-5 lg:w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path d="M256 0c-74.439 0-135 60.561-135 135s60.561 135 135 135 135-60.561 135-135S330.439 0 256 0zm0 240c-57.897 0-105-47.103-105-105S198.103 30 256 30s105 47.103 105 105-47.103 105-105 105zM423.966 358.195C387.006 320.667 338.009 300 286 300h-60c-52.008 0-101.006 20.667-137.966 58.195C51.255 395.539 31 444.833 31 497c0 8.284 6.716 15 15 15h420c8.284 0 15-6.716 15-15 0-52.167-20.255-101.461-57.034-138.805zM61.66 482c7.515-85.086 78.351-152 164.34-152h60c85.989 0 156.825 66.914 164.34 152H61.66z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                            </g>
                                        </svg>
                                        Account
                                    </a>
                                </li>
                                <li class="hover:bg-gray-500 hover:text-white px-3">
                                    <a class="flex items-center gap-x-2 py-2" href="../user/show_orders.php">
                                        <svg class="h-4 w-4 lg:h-5 lg:w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path d="m458.737 422.218-22.865-288.116c-1.425-18.562-17.123-33.103-35.739-33.103H354.97v-2.03C354.97 44.397 310.573 0 256.001 0s-98.969 44.397-98.969 98.969v2.03H111.87c-18.617 0-34.316 14.54-35.736 33.064L53.262 422.257c-1.77 23.075 6.235 46.048 21.961 63.026C90.949 502.261 113.242 512 136.385 512h239.231c23.142 0 45.436-9.738 61.163-26.717 15.726-16.979 23.73-39.951 21.958-63.065zM187.022 98.969c0-38.035 30.945-68.979 68.979-68.979s68.979 30.945 68.979 68.979v2.03H187.022v-2.03zm227.754 365.936c-10.218 11.03-24.124 17.105-39.16 17.105h-239.23c-15.036 0-28.942-6.075-39.16-17.105-10.217-11.031-15.211-25.363-14.063-40.315l22.87-288.195c.232-3.032 2.796-5.406 5.837-5.406h45.162v36.935c0 8.281 6.714 14.995 14.995 14.995 8.281 0 14.995-6.714 14.995-14.995v-36.935H324.98v36.935c0 8.281 6.714 14.995 14.995 14.995s14.995-6.714 14.995-14.995v-36.935h45.163c3.04 0 5.604 2.375 5.84 5.446l22.865 288.115c1.15 14.992-3.845 29.323-14.062 40.355z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                <path d="M323.556 254.285c-5.854-5.856-15.349-5.856-21.204 0l-66.956 66.956-25.746-25.746c-5.855-5.856-15.35-5.856-21.206 0s-5.856 15.35 0 21.206l36.349 36.349c2.928 2.928 6.766 4.393 10.602 4.393s7.675-1.464 10.602-4.393l77.558-77.558c5.857-5.857 5.857-15.351.001-21.207z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                            </g>
                                        </svg>
                                        Order
                                    </a>
                                </li>
                                <hr class="border">
                                <li class="hover:bg-gray-500 hover:text-white px-3">
                                    <a class="flex items-center gap-x-2 py-2" href="../user/user_logout.php">
                                        <svg class="h-4 w-4 lg:h-5 lg:w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <g fill="#000">
                                                    <path d="M14.945 1.25c-1.367 0-2.47 0-3.337.117-.9.12-1.658.38-2.26.981-.524.525-.79 1.17-.929 1.928-.135.737-.161 1.638-.167 2.72a.75.75 0 0 0 1.5.008c.006-1.093.034-1.868.142-2.457.105-.566.272-.895.515-1.138.277-.277.666-.457 1.4-.556.755-.101 1.756-.103 3.191-.103h1c1.436 0 2.437.002 3.192.103.734.099 1.122.28 1.4.556s.456.665.555 1.4c.102.754.103 1.756.103 3.191v8c0 1.435-.001 2.437-.103 3.192-.099.734-.279 1.122-.556 1.399s-.665.457-1.399.556c-.755.101-1.756.103-3.192.103h-1c-1.435 0-2.436-.002-3.192-.103-.733-.099-1.122-.28-1.399-.556-.243-.243-.41-.572-.515-1.138-.108-.589-.136-1.364-.142-2.457a.75.75 0 1 0-1.5.008c.006 1.082.032 1.983.167 2.72.14.758.405 1.403.93 1.928.601.602 1.36.86 2.26.982.866.116 1.969.116 3.336.116h1.11c1.368 0 2.47 0 3.337-.117.9-.12 1.658-.38 2.26-.981.602-.602.86-1.36.982-2.26.116-.867.116-1.97.116-3.337v-8.11c0-1.367 0-2.47-.116-3.337-.121-.9-.38-1.658-.982-2.26-.602-.602-1.36-.86-2.26-.981-.867-.117-1.97-.117-3.337-.117z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                    <path d="M15 11.25a.75.75 0 0 1 0 1.5H4.027l1.961 1.68a.75.75 0 1 1-.976 1.14l-3.5-3a.75.75 0 0 1 0-1.14l3.5-3a.75.75 0 1 1 .976 1.14l-1.96 1.68z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div>
                        <div class="hidden md:flex items-center gap-3 text-white">
                            <svg class="w-9" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0" fill="#ffffff" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>
                            <div class="text-xs hidden md:block">
                                <h1>Username</h1>
                                <a class="underline focus:outline-none" href="../authentication/user_auth/user_login.php">Login</a> / <a class="underline focus:outline-none" href="../authentication/user_auth/user_register.php">Register</a>
                            </div>
                        </div>
                        <div class="md:hidden" x-data="{withOutLogin:false}">
                            <button x-on:click="withOutLogin = !withOutLogin" @click.outside="withOutLogin=false" class="focus:outline-none text-white flex items-center gap-2 rounded-full px-1 py-0.5 hover:ring-1 hover:ring-gray-400 hover:bg-gray-800">
                                <svg class="w-5 md:w-9" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0" fill="#ffffff" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                                <svg class="w-2.5 md:w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 451.847 451.847" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    </g>
                                </svg>
                            </button>
                            <!-- popup for without login -->
                            <div x-show="withOutLogin" x-transition x-cloak class="text-sm border rounded-md flex flex-col space-y-1 absolute top-14  bg-white text-black overflow-hidden z-10">
                                <a class="px-2 py-1 flex items-center gap-x-2 hover:bg-gray-500 hover:text-white" href="../authentication/user_auth/user_login.php">
                                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                        <g>
                                            <g fill="#000">
                                                <path d="M14.945 1.25c-1.367 0-2.47 0-3.337.117-.9.12-1.658.38-2.26.981-.524.525-.79 1.17-.929 1.928-.135.737-.161 1.638-.167 2.72a.75.75 0 0 0 1.5.008c.006-1.093.034-1.868.142-2.457.105-.566.272-.895.515-1.138.277-.277.666-.457 1.4-.556.755-.101 1.756-.103 3.191-.103h1c1.436 0 2.437.002 3.192.103.734.099 1.122.28 1.4.556s.456.665.555 1.4c.102.754.103 1.756.103 3.191v8c0 1.435-.001 2.437-.103 3.192-.099.734-.279 1.122-.556 1.399s-.665.457-1.399.556c-.755.101-1.756.103-3.192.103h-1c-1.435 0-2.436-.002-3.192-.103-.733-.099-1.122-.28-1.399-.556-.243-.243-.41-.572-.515-1.138-.108-.589-.136-1.364-.142-2.457a.75.75 0 1 0-1.5.008c.006 1.082.032 1.983.167 2.72.14.758.405 1.403.93 1.928.601.602 1.36.86 2.26.982.866.116 1.969.116 3.336.116h1.11c1.368 0 2.47 0 3.337-.117.9-.12 1.658-.38 2.26-.981.602-.602.86-1.36.982-2.26.116-.867.116-1.97.116-3.337v-8.11c0-1.367 0-2.47-.116-3.337-.121-.9-.38-1.658-.982-2.26-.602-.602-1.36-.86-2.26-.981-.867-.117-1.97-.117-3.337-.117z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                <path d="M2.001 11.249a.75.75 0 0 0 0 1.5h11.973l-1.961 1.68a.75.75 0 1 0 .976 1.14l3.5-3a.75.75 0 0 0 0-1.14l-3.5-3a.75.75 0 0 0-.976 1.14l1.96 1.68z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                            </g>
                                        </g>
                                    </svg>Login</a>
                                <a class="px-2 py-1 flex items-center gap-x-2 hover:bg-gray-500 hover:text-white" href="../authentication/user_auth/user_register.php">
                                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 1.27 1.27" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd">
                                        <g>
                                            <g fill="currentColor">
                                                <path fill-rule="nonzero" d="M.565.042a.257.257 0 0 1 .183.44.257.257 0 0 1-.365 0 .257.257 0 0 1 .182-.44zm.123.136A.173.173 0 0 0 .445.176L.443.178a.173.173 0 0 0 0 .245.173.173 0 0 0 .245-.245zM.579 1.228H.127a.086.086 0 0 1-.064-.029.086.086 0 0 1-.022-.066.54.54 0 0 1 .792-.425c.01.005.016.014.018.024.003.01.002.02-.004.03L.842.77a.038.038 0 0 1-.05.014.454.454 0 0 0-.667.358v.001h.001l.001.001h.686c.021 0 .038.017.038.038v.009a.038.038 0 0 1-.038.038zm-.492-.01a.042.042 0 0 1-.018-.024" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                <path d="M.846.93h.341c.024 0 .043.018.043.042a.042.042 0 0 1-.043.042H.846a.042.042 0 0 1 0-.085z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                <path d="M.974 1.142V.801c0-.023.02-.042.043-.042.023 0 .042.019.042.042v.341a.042.042 0 0 1-.085 0z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                            </g>
                                        </g>
                                    </svg>Register</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div>
                    <a href="../shopping/cart.php" class="relative focus:outline-none">
                        <svg class="w-5 sm:w-7" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zM362 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0" fill="#ffffff" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <p class="text-white text-center rounded-full text-xs px-1 absolute -top-2 -right-2 bg-[#ff0000]">
                            <?php
                            if (isset($_COOKIE['Cart_products'])) {
                                $cookie_value = $_COOKIE['Cart_products'];

                                $cart_products = json_decode($cookie_value, true);
                                if (!empty($cart_products) && is_array($cart_products)) {
                                    $totalCartItems = count($cart_products);
                                    echo $totalCartItems;
                                }
                            }
                            ?>
                        </p>
                    </a>
                </div>
                <div>
                    <a class="flex items-center gap-2 text-white text-xs focus:outline-none" href="../authentication/vendor_auth/vendor_register.php">
                        <svg class="w-5 h-5 xl:w-7 xl:h-7" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path d="M143.5 326.255a7.5 7.5 0 0 0-7.5 7.5v13.5a7.5 7.5 0 0 0 15 0v-13.5a7.5 7.5 0 0 0-7.5-7.5z" fill="#ffffff" opacity="1" data-original="#ffffff"></path>
                                <path d="M488.312 425.849h-12.143V217.76c20.115-3.56 35.445-21.155 35.445-42.276v-28.876c0-.147-.014-.291-.022-.436-.005-.081-.005-.162-.012-.243a7.517 7.517 0 0 0-.128-.871c-.003-.017-.009-.033-.013-.049a7.389 7.389 0 0 0-.224-.8c-.022-.066-.048-.132-.072-.197a7.436 7.436 0 0 0-.278-.655c-.019-.039-.031-.08-.05-.118L477.653 77.29V42.796c0-8.902-7.243-16.145-16.145-16.145H120.456a7.5 7.5 0 0 0 0 15h341.052c.631 0 1.145.514 1.145 1.145V71.64H49.347V42.796c0-.631.514-1.145 1.145-1.145H85.56a7.5 7.5 0 0 0 0-15H50.492c-8.902 0-16.145 7.243-16.145 16.145V77.29L1.186 143.239c-.019.039-.032.08-.05.118a7.436 7.436 0 0 0-.278.655c-.024.066-.05.131-.072.197a7.389 7.389 0 0 0-.224.8l-.013.049c-.06.285-.102.575-.128.871-.007.081-.007.162-.012.243-.008.145-.022.289-.022.436v28.876c0 21.12 15.33 38.716 35.445 42.276v208.089H23.688C10.626 425.849 0 436.476 0 449.538v23.722c0 6.666 5.423 12.089 12.089 12.089h487.822c6.666 0 12.089-5.423 12.089-12.089v-23.722c0-13.062-10.626-23.689-23.688-23.689zm8.301-250.364c0 15.409-12.536 27.945-27.945 27.945s-27.945-12.536-27.945-27.945v-21.376h55.89v21.376zM465.565 86.64l26.382 52.468h-53.448L419.655 86.64h45.91zm-61.849 0 18.844 52.468h-54.17L357.083 86.64h46.633zm22.008 67.468v21.376c0 15.409-12.536 27.945-27.945 27.945s-27.945-12.536-27.945-27.945v-21.376h55.89zM341.739 86.64l11.307 52.468h-54.62l-3.769-52.468h47.082zm13.095 67.468v21.376c0 15.409-12.536 27.945-27.944 27.945s-27.945-12.536-27.945-27.945v-21.376h55.889zM232.382 86.64h47.235l3.769 52.468h-54.773l3.769-52.468zm-4.327 67.468h55.89v21.376c0 15.409-12.536 27.945-27.945 27.945s-27.945-12.536-27.945-27.945v-21.376zM256 218.429c14.704 0 27.701-7.431 35.445-18.732 7.744 11.301 20.741 18.732 35.445 18.732s27.701-7.431 35.444-18.732c7.744 11.301 20.741 18.732 35.445 18.732s27.701-7.431 35.445-18.732c6.396 9.334 16.379 16.016 27.945 18.063v208.089H178.836V259.185c0-7.692-6.258-13.95-13.95-13.95H78.177c-7.692 0-13.95 6.258-13.95 13.95v166.664H50.832V217.76c11.566-2.047 21.549-8.729 27.945-18.063 7.744 11.301 20.741 18.732 35.445 18.732s27.701-7.431 35.445-18.732c7.744 11.301 20.741 18.732 35.444 18.732s27.701-7.431 35.445-18.732c7.743 11.301 20.74 18.732 35.444 18.732zm-92.164 41.806v165.614H79.227V260.235h84.609zm-77.56-84.75v-21.376h55.89v21.376c0 15.409-12.536 27.945-27.945 27.945s-27.945-12.537-27.945-27.945zm83.985-88.845h47.082l-3.769 52.468h-54.62l11.307-52.468zm-13.095 67.468h55.889v21.376c0 15.409-12.536 27.945-27.945 27.945s-27.944-12.536-27.944-27.945v-21.376zm-2.25-67.468-11.307 52.468h-54.17l18.844-52.468h46.633zm-108.481 0h45.91l-18.844 52.468H20.053L46.435 86.64zm-31.048 88.845v-21.376h55.89v21.376c0 15.409-12.536 27.945-27.945 27.945s-27.945-12.537-27.945-27.945zM15 470.349v-20.812c0-4.791 3.897-8.688 8.688-8.688h464.623c4.791 0 8.688 3.897 8.688 8.688v20.812H15z" fill="#ffffff" opacity="1" data-original="#ffffff"></path>
                                <path d="M426.773 245.235H335.06a7.5 7.5 0 0 0 0 15h90.664V378.27H209.5V260.235h90.25a7.5 7.5 0 0 0 0-15h-91.3c-7.692 0-13.95 6.257-13.95 13.95v120.136c0 7.692 6.258 13.95 13.95 13.95h218.323c7.692 0 13.95-6.258 13.95-13.95V259.185c0-7.692-6.258-13.95-13.95-13.95z" fill="#ffffff" opacity="1" data-original="#ffffff"></path>
                            </g>
                        </svg>
                        <span class="hidden md:block">Become a vendor</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="lg:hidden px-5 my-4">
            <form action="" method="post">
                <div class="flex justify-center items-center" x-data="{showMic2:false}">
                    <div class="relative w-full">
                        <!-- search input -->
                        <input id="search-input2" value="<?php echo isset($_SESSION['searchWord']) ? $_SESSION['searchWord'] : ''; ?>" name="searchInputItems2" class="w-full h-12 pr-10 focus:ring-[#08091b] border-0 text-black focus:ring-0 focus:outline-none rounded-s-md text-lg" type="text" placeholder="search for anything..." autocomplete="off">
                        <!-- suggetion -->
                        <input type="submit" id="searchBtn2" name="searchBtn2" class="hidden">
                        <ul id="suggestions-list2" class="w-full h-60 bg-white absolute top-11 left-0 rounded-b-md z-[100] list-none hidden custom-scrollbar"></ul>
                        <!-- microphone button -->
                        <div class="absolute right-3 top-2.5 p-1 cursor-pointer" id="start-btn2" @click="showMic2=true">
                            <svg class="text-gray-400 h-5 w-5" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 435.2 435.2" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M356.864 224.768c0-8.704-6.656-15.36-15.36-15.36s-15.36 6.656-15.36 15.36c0 59.904-48.64 108.544-108.544 108.544-59.904 0-108.544-48.64-108.544-108.544 0-8.704-6.656-15.36-15.36-15.36s-15.36 6.656-15.36 15.36c0 71.168 53.248 131.072 123.904 138.752v40.96h-55.808c-8.704 0-15.36 6.656-15.36 15.36s6.656 15.36 15.36 15.36h142.336c8.704 0 15.36-6.656 15.36-15.36s-6.656-15.36-15.36-15.36H232.96v-40.96c70.656-7.68 123.904-67.584 123.904-138.752z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                    <path d="M217.6 0c-47.104 0-85.504 38.4-85.504 85.504v138.752c0 47.616 38.4 85.504 85.504 86.016 47.104 0 85.504-38.4 85.504-85.504V85.504C303.104 38.4 264.704 0 217.6 0z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <!-- js for suggetion search 2 -->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const searchInput = document.getElementById('search-input2');
                            const suggestionsList = document.getElementById('suggestions-list2');
                            let currentIndex = -1;

                            // Fetch search suggestions
                            const fetchSuggestions = (query) => {
                                if (query.length === 0) {
                                    suggestionsList.classList.add('hidden');
                                    return;
                                }

                                fetch('../search/suggestion.php', {
                                        method: 'POST',
                                        body: new URLSearchParams({
                                            query
                                        }),
                                    })
                                    .then((response) => {
                                        if (!response.ok) {
                                            throw new Error(`HTTP error! status: ${response.status}`);
                                        }
                                        return response.text();
                                    })
                                    .then((data) => {
                                        suggestionsList.innerHTML = data;
                                        suggestionsList.classList.toggle('hidden', data.trim() === '');
                                        currentIndex = -1; // Reset index
                                    })
                                    .catch((error) => console.error('Error fetching suggestions:', error));
                            };

                            // Update suggestions on input
                            searchInput.addEventListener('input', (e) => {
                                const query = e.target.value.trim();
                                fetchSuggestions(query);
                                currentIndex = -1;
                            });

                            // Handle key navigation and Enter
                            searchInput.addEventListener('keydown', (e) => {
                                const items = suggestionsList.querySelectorAll('li');
                                const query = searchInput.value.trim();

                                if (e.key === 'ArrowDown') {
                                    // Move to the next suggestion
                                    if (currentIndex < items.length - 1) {
                                        currentIndex++;
                                    }
                                    highlightSuggestion();
                                    scrollToSuggestion();
                                } else if (e.key === 'ArrowUp') {
                                    // Move to the previous suggestion
                                    if (currentIndex > 0) {
                                        currentIndex--;
                                    }
                                    highlightSuggestion();
                                    scrollToSuggestion();
                                } else if (e.key === 'Enter') {
                                    if (query === '') {
                                        // If search input is empty, redirect to the index page
                                        e.preventDefault();
                                        window.location.href = '../index.php'; // Redirect to index page
                                    } else if (currentIndex >= 0 && currentIndex < items.length) {
                                        const selectedSuggestion = items[currentIndex];
                                        const link = selectedSuggestion.querySelector('a');
                                        if (link) {
                                            e.preventDefault();
                                            window.location.href = link.href;
                                        }
                                    } else if (query) {
                                        window.location.assign(`../search/search_items.php?query=${encodeURIComponent(query)}`);
                                    }
                                }
                            });

                            // Highlight suggestions and update the input value
                            const highlightSuggestion = () => {
                                const items = suggestionsList.querySelectorAll('li');
                                items.forEach((item) => item.classList.remove('bg-gray-300'));
                                if (currentIndex >= 0 && currentIndex < items.length) {
                                    const selectedItem = items[currentIndex];
                                    selectedItem.classList.add('bg-gray-300');
                                    // Update the input field with the current selected suggestion
                                    searchInput.value = selectedItem.textContent.trim();
                                }
                            };

                            // Scroll to the selected suggestion
                            const scrollToSuggestion = () => {
                                const items = suggestionsList.querySelectorAll('li');
                                const selectedItem = items[currentIndex];
                                if (selectedItem) {
                                    const container = suggestionsList;
                                    const itemRect = selectedItem.getBoundingClientRect();
                                    const containerRect = container.getBoundingClientRect();

                                    // Scroll the container to ensure the selected item is visible
                                    if (itemRect.top < containerRect.top) {
                                        container.scrollTop -= (containerRect.top - itemRect.top);
                                    } else if (itemRect.bottom > containerRect.bottom) {
                                        container.scrollTop += (itemRect.bottom - containerRect.bottom);
                                    }
                                }
                            };

                            // Click suggestion to update input and search
                            suggestionsList.addEventListener('click', (e) => {
                                if (e.target.tagName === 'LI') {
                                    searchInput.value = e.target.textContent;
                                    suggestionsList.classList.add('hidden');
                                }
                            });

                            // Close suggestions if clicking outside
                            document.addEventListener('click', (e) => {
                                if (!e.target.closest('.relative')) {
                                    suggestionsList.classList.add('hidden');
                                }
                            });
                        });
                    </script>
                    <label for="searchBtn2" id="searchBtns2">
                        <div class="search-btn bg-[#b7ff1d] px-3 h-12 flex items-center justify-center rounded-e-md transition duration-300 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 118.783 118.783" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                <g>
                                    <path d="M115.97 101.597 88.661 74.286a47.75 47.75 0 0 0 7.333-25.488c0-26.509-21.49-47.996-47.998-47.996S0 22.289 0 48.798c0 26.51 21.487 47.995 47.996 47.995a47.776 47.776 0 0 0 27.414-8.605l26.984 26.986a9.574 9.574 0 0 0 6.788 2.806 9.58 9.58 0 0 0 6.791-2.806 9.602 9.602 0 0 0-.003-13.577zM47.996 81.243c-17.917 0-32.443-14.525-32.443-32.443s14.526-32.444 32.443-32.444c17.918 0 32.443 14.526 32.443 32.444S65.914 81.243 47.996 81.243z" fill="#000000" opacity="1" data-original="#000000"></path>
                                </g>
                            </svg>
                        </div>
                    </label>
                    <div id="mic-popup2" class="w-full h-full z-[100] fixed top-0 left-0 flex items-center justify-center bg-black bg-opacity-40 px-5 hidden" x-show="showMic2">
                        <div class="w-max h-max z-[100] flex flex-col items-center justify-center p-8 bg-white border-2 border-blue-600 rounded-lg shadow-2xl relative">
                            <span class="absolute top-2 right-2">
                                <svg id="mic-close-btn2" @click="showMic2=false" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 511.76 511.76" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="M436.896 74.869c-99.84-99.819-262.208-99.819-362.048 0-99.797 99.819-99.797 262.229 0 362.048 49.92 49.899 115.477 74.837 181.035 74.837s131.093-24.939 181.013-74.837c99.819-99.818 99.819-262.229 0-362.048zm-75.435 256.448c8.341 8.341 8.341 21.824 0 30.165a21.275 21.275 0 0 1-15.083 6.251 21.277 21.277 0 0 1-15.083-6.251l-75.413-75.435-75.392 75.413a21.348 21.348 0 0 1-15.083 6.251 21.277 21.277 0 0 1-15.083-6.251c-8.341-8.341-8.341-21.845 0-30.165l75.392-75.413-75.413-75.413c-8.341-8.341-8.341-21.845 0-30.165 8.32-8.341 21.824-8.341 30.165 0l75.413 75.413 75.413-75.413c8.341-8.341 21.824-8.341 30.165 0 8.341 8.32 8.341 21.824 0 30.165l-75.413 75.413 75.415 75.435z" fill="#ff0000" opacity="1" data-original="#ff0000" class=""></path>
                                    </g>
                                </svg>
                            </span>
                            <h2 class="text-xl font-semibold text-center text-gray-800">Listening...</h2>
                            <div class="wave my-6 mx-auto"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="15" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <defs>
                                            <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                                <path d="M0 512h512V0H0Z" fill="#ffffff" opacity="1" data-original="#ffffff"></path>
                                            </clipPath>
                                        </defs>
                                        <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                            <path d="M0 0h160" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(176 20.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v-72" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 92.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0c0-88.223-71.777-160-160-160S-320-88.223-320 0" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(416 252.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0c-44.183 0-80 35.817-80 80v160c0 44.183 35.817 80 80 80s80-35.817 80-80V80C80 35.817 44.183 0 0 0Z" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 172.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v40" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(96 332.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v120" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(20 292.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v40" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(416 332.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                            <path d="M0 0v120" style="stroke-width:40;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(492 292.036)" fill="none" stroke="#ffffff" stroke-width="40" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#ffffff" class=""></path>
                                        </g>
                                    </g>
                                </svg></div>
                            <p class="text-sm text-center text-gray-600 mt-2">Please speak clearly into the microphone.</p>
                        </div>
                    </div>
                    <!-- speech recognisation for search 2 -->
                    <script>
                        // Check for browser support
                        const SpeechRecognition2 = window.SpeechRecognition || window.webkitSpeechRecognition;
                        if (!SpeechRecognition2) {
                            alert("Your browser does not support speech recognition.");
                        } else {
                            const recognition = new SpeechRecognition();
                            recognition.continuous = true; // Continuous listening until stopped
                            recognition.interimResults = false; // Don't return interim results

                            const micPopup = document.getElementById('mic-popup2');
                            const startButton = document.getElementById('start-btn2');

                            recognition.onstart = () => {
                                micPopup.classList.remove('hidden');
                            };

                            // Event handler for result
                            recognition.onresult = (event) => {
                                const transcript = event.results[event.resultIndex][0].transcript;

                                const searchInput = document.getElementById('search-input2');
                                if (searchInput) {
                                    searchInput.value = transcript;
                                    document.getElementById('searchBtns2').click();
                                } else {
                                    console.error("Search input element not found.");
                                }
                            };

                            // Error handling
                            recognition.onerror = (event) => {
                                console.error('Error occurred in recognition: ' + event.error);
                                micPopup.classList.add('hidden'); // Hide popup on error
                            };

                            // Start recognition when button is clicked
                            document.getElementById('start-btn2').addEventListener('click', () => {
                                recognition.start();
                            });

                            // Stop recognition function
                            function stopRecognition() {
                                recognition.stop();
                                micPopup.classList.add('hidden');
                            }

                            // Stop recognition when the popup is closed
                            document.getElementById('mic-close-btn2').addEventListener('click', () => {
                                stopRecognition();
                            });
                        }
                    </script>
                </div>
            </form>
            <?php
                if (isset($_POST["searchBtn2"])) {
                    $searchName = $_POST['searchInputItems2'];
                    $filterName = str_replace(' ', '+', $searchName); // Replace spaces with "+" for URL compatibility
                    ?>
                    <script>
                        let filterName = "<?php echo htmlspecialchars($filterName, ENT_QUOTES, 'UTF-8'); ?>";

                        if (filterName != "") {
                            window.location.href = "../search/search_items.php?searchName=" + filterName;
                        }
                    </script>
                <?php
                }
            ?>
        </div>
        </div>
    </header>
    <!-- sidebar -->
    <div id="sidebarContainer" class="hidden bg-gray-50 pb-3 font-medium fixed top-0 w-72 lg:w-80 h-[100vh] overflow-y-auto z-50 scrollBar">
        <div id="sidebarHeader" class="p-2 bg-gray-200 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <?php
                if (isset($_COOKIE['user_id'])) {
                ?>
                    <div class="w-7 h-7 md:w-8 md:h-8 border m-auto">
                        <img class="w-full h-full rounded-full flex justify-center object-cover" src="<?php echo isset($_COOKIE['user_id']) ? '../src/user_dp/' . $row['profile_image'] : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' ?>" alt="" class="bg-white">
                    </div>
                <?php
                } else {
                ?>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>
                <?php
                }
                ?>
                <h1 class="text-black"><a href="">Hello,<?php echo isset($_COOKIE['fname']) ? $_COOKIE['fname'] : 'User' ?></a></h1>
            </div>
            <div>
                <button onclick="closeSidebar()" class="focus:outline-none"><svg class="relative top-0.5 right-0.5 text-[#ff0000] transition rounded-md" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" style="fill: currentColor;">
                        <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
                    </svg></button>
            </div>
        </div>
        <div id="sidebarBody">
            <div class="w-full py-3">
                <a class="flex items-center gap-3 px-9 h-12 hover:bg-gray-200 transition" href="../pages/track_order.php"><svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M492.522 118.3 266.433 3.743l-.094-.047c-10.067-5.012-22.029-4.9-32.002.3L137.368 55.46c-.788.334-1.545.739-2.27 1.205L18.896 118.337C7.24 124.44 0 136.398 0 149.559V362.44c0 13.161 7.24 25.118 18.896 31.221l215.345 114.292.097.051a35.255 35.255 0 0 0 16.297 3.981 35.232 35.232 0 0 0 15.704-3.682l226.183-114.604C504.538 387.69 512 375.618 512 362.18V149.82c0-13.439-7.462-25.512-19.478-31.52zM248.237 30.569a5.26 5.26 0 0 1 4.705-.042l211.629 107.23-82.364 41.005L175.308 69.275l72.929-38.706zM235.424 474.63 32.91 367.147l-.097-.051a5.237 5.237 0 0 1-2.824-4.656V163.091l205.435 107.124V474.63zm15.153-230.335L46.272 137.76l97.024-51.493L349.171 195.21l-98.594 49.085zm231.432 117.883a5.22 5.22 0 0 1-2.911 4.703L265.414 475.152V270.408l98.386-48.982v51.355c0 8.281 6.714 14.995 14.995 14.995s14.995-6.714 14.995-14.995v-66.286l88.219-43.92v199.603z" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>Track order</a>

                <a class="flex items-center gap-3 px-9 h-12 hover:bg-gray-200 transition" href="../pages/help_center.php"><svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M256 0C114.509 0 0 114.496 0 256c0 141.489 114.496 256 256 256 141.491 0 256-114.496 256-256C512 114.509 397.504 0 256 0zm0 476.279c-121.462 0-220.279-98.816-220.279-220.279S134.538 35.721 256 35.721c121.463 0 220.279 98.816 220.279 220.279S377.463 476.279 256 476.279z" fill="#000000" opacity="1" data-original="#000000"></path>
                            <path d="M248.425 323.924c-14.153 0-25.61 11.794-25.61 25.946 0 13.817 11.12 25.948 25.61 25.948s25.946-12.131 25.946-25.948c0-14.152-11.794-25.946-25.946-25.946zM252.805 127.469c-45.492 0-66.384 26.959-66.384 45.155 0 13.142 11.12 19.208 20.218 19.208 18.197 0 10.784-25.948 45.155-25.948 16.848 0 30.328 7.414 30.328 22.915 0 18.196-18.871 28.642-29.991 38.077-9.773 8.423-22.577 22.24-22.577 51.22 0 17.522 4.718 22.577 18.533 22.577 16.511 0 19.881-7.413 19.881-13.817 0-17.522.337-27.631 18.871-42.121 9.098-7.076 37.74-29.991 37.74-61.666s-28.642-55.6-71.774-55.6z" fill="#000000" opacity="1" data-original="#000000"></path>
                        </g>
                    </svg>Help center</a>
            </div>
            <hr class="border border-gray-300">
            <!-- shoping category -->
            <div class="py-3">
                <h1 class="px-5 text-xl">Shop by category</h1>
                <div class=" py-3">
                    <ul class="lg:text-lg">
                        <!-- tv -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=TV">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 30 30" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M26.315 3.687H3.685a3.432 3.432 0 0 0-3.427 3.43v12.742a3.43 3.43 0 0 0 3.427 3.429h8.307L9 24.875c-.887.412-.27 1.769.626 1.363.051-.039 5.312-2.809 5.374-2.85l5.293 2.813a.74.74 0 0 0 .351.088c.765.031 1.045-1.079.356-1.414l-2.992-1.587h8.307a3.431 3.431 0 0 0 3.427-3.428V7.117a3.432 3.432 0 0 0-3.427-3.43zm1.927 16.171a1.928 1.928 0 0 1-1.927 1.929H3.685a1.93 1.93 0 0 1-1.927-1.928V7.117c0-1.065.862-1.928 1.927-1.929h22.63a1.93 1.93 0 0 1 1.927 1.928z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M13.678 10.024H8.032a.75.75 0 0 0 0 1.5h2.073V16.2a.75.75 0 0 0 1.5 0v-4.676h2.073c.981-.004.981-1.495 0-1.5zM22.297 10.1a.75.75 0 0 0-1.003.345l-1.972 4.042-1.971-4.044c-.435-.88-1.779-.226-1.351.66l2.648 5.426c.258.545 1.089.549 1.348 0l2.646-5.426a.75.75 0 0 0-.345-1.003z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                                TVs
                            </a>
                        </li>
                        <!-- laptop -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Laptops/MacBook">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512.021 512.021" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M304.947 385.93v8.714h-97.382v-8.714H0v3.584c0 5.642 2.048 11.274 6.154 15.38 4.096 4.096 9.738 6.154 15.38 6.154h468.951c5.642 0 11.274-2.048 15.38-6.154 4.096-4.096 6.154-9.738 6.154-15.38v-3.584H304.947zM68.68 400.276H47.155v-2.56H68.68v2.56zM60.989 377.728H451.01c3.584 0 7.178-1.536 9.738-4.096s4.096-6.154 4.096-9.738V114.806c0-3.584-1.536-7.178-4.096-9.738s-6.154-4.096-9.738-4.096H60.989c-3.584 0-7.178 1.536-9.738 4.096s-4.096 6.154-4.096 9.738v249.078c0 3.584 1.536 7.178 4.096 9.738 3.072 3.082 6.154 4.106 9.738 4.106zm195.267-270.602c2.56 0 4.608 2.048 4.608 4.608s-2.048 4.608-4.608 4.608-4.608-2.048-4.608-4.608 2.048-4.608 4.608-4.608zm-187.064 15.37h374.139v233.707H69.192V122.496z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                                Laptops & Computers
                            </a>
                        </li>
                        <!-- ipad/tab -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Tabs/Ipad">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <g fill="#222020">
                                            <ellipse cx="32" cy="4.872" rx="1.221" ry="1.204" fill="#222020" opacity="1" data-original="#222020"></ellipse>
                                            <path d="M51.7 2a1.965 1.965 0 0 1 1.959 1.959v56.082A1.965 1.965 0 0 1 51.7 62H12.3a1.965 1.965 0 0 1-1.959-1.959V3.959A1.965 1.965 0 0 1 12.3 2zm0-2H12.3a3.963 3.963 0 0 0-3.959 3.959v56.082A3.963 3.963 0 0 0 12.3 64h39.4a3.963 3.963 0 0 0 3.959-3.959V3.959A3.963 3.963 0 0 0 51.7 0z" fill="#222020" opacity="1" data-original="#222020"></path>
                                            <path d="M50.32 9.753V52.66H13.68V9.753zm2-2H11.68V54.66h40.64z" fill="#222020" opacity="1" data-original="#222020"></path>
                                            <ellipse cx="32" cy="58.236" rx="2.009" ry="1.982" fill="#222020" opacity="1" data-original="#222020"></ellipse>
                                        </g>
                                    </g>
                                </svg>
                                iPads & Tablets
                            </a>
                        </li>
                        <!-- mobille -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Phones">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M381.333 124.87c-.089 0-.162.048-.249.05V77.366c0-26.234-21.347-47.581-47.581-47.581H178.478c-26.234 0-47.581 21.347-47.581 47.581v47.551c-.081-.002-.149-.047-.23-.047a9.805 9.805 0 0 0-9.811 9.811v29.166a9.805 9.805 0 0 0 9.811 9.811c.081 0 .148-.044.23-.047v10.173c-.081-.002-.149-.047-.23-.047a9.805 9.805 0 0 0-9.811 9.811v29.166a9.805 9.805 0 0 0 9.811 9.811c.081 0 .148-.044.23-.047v202.155c0 26.234 21.347 47.581 47.581 47.581h155.026c26.234 0 47.581-21.347 47.581-47.581V173.608c.087.002.16.05.249.05a9.805 9.805 0 0 0 9.811-9.811v-29.166a9.807 9.807 0 0 0-9.812-9.811zm-19.872 309.764c0 15.407-12.532 27.958-27.958 27.958H178.478c-15.426 0-27.958-12.552-27.958-27.958V77.366c0-15.407 12.532-27.958 27.958-27.958h22.153V62.23a8.673 8.673 0 0 0 8.672 8.672h93.382a8.673 8.673 0 0 0 8.672-8.672V49.408h22.146c15.426 0 27.958 12.552 27.958 27.958z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                                Cell phone
                            </a>
                        </li>
                        <!-- headphone -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Headphone">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <g data-name="STATIONERY AND OFFICE">
                                            <path d="M87.37 393.24c18.81 47.81 34.24 78.54 37 82.51 4.55 6.53 13.93 10.5 21.42 8.9a89.71 89.71 0 0 0 18.15-6.31 92.11 92.11 0 0 0 16.53-9.8c6.06-4.67 9.22-14.14 7.45-21.56-1-4.57-13.93-34.85-31.94-80.65s-29.06-76.82-31.44-80.84c-3.76-6.64-12.5-11.43-20.12-10.74a92.74 92.74 0 0 0-18.79 4.06A89.74 89.74 0 0 0 68 286.53c-6.58 3.92-10.75 13.21-9.65 21.09.7 4.77 10.29 37.78 29.02 85.62zM453.66 307.62c1.1-7.88-3.07-17.17-9.65-21.09a89.74 89.74 0 0 0-17.6-7.72 92.74 92.74 0 0 0-18.79-4.06c-7.62-.69-16.36 4.1-20.12 10.74-2.38 4-13.49 35-31.44 80.84s-30.95 76.08-31.94 80.67c-1.76 7.42 1.39 16.89 7.45 21.56a92.11 92.11 0 0 0 16.53 9.8 89.71 89.71 0 0 0 18.15 6.31c7.49 1.6 16.87-2.37 21.42-8.9 2.72-4 18.15-34.7 37-82.51s28.33-80.87 28.99-85.64z" fill="#000000" opacity="1" data-original="#000000"></path>
                                            <path d="M502 303.3v-30.55A19 19 0 0 0 512 256 256 256 0 0 0 75 75 254.37 254.37 0 0 0 0 256a19 19 0 0 0 10 16.73v30.57a24 24 0 0 0-9 26.12 975.06 975.06 0 0 0 66.49 169.4 24 24 0 1 0 42.84-21.65 926.57 926.57 0 0 1-63.2-161 24 24 0 0 0-19.08-17v-26.42A19 19 0 0 0 38 256a218 218 0 0 1 372.17-154.15A216.63 216.63 0 0 1 474 256a19 19 0 0 0 10 16.73v26.37a24 24 0 0 0-19.08 17 926.57 926.57 0 0 1-63.2 161 24 24 0 1 0 42.85 21.65 975.82 975.82 0 0 0 66.48-169.4A24 24 0 0 0 502 303.3z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        </g>
                                    </g>
                                </svg>
                                Headphones
                            </a>
                        </li>
                        <!-- cloths -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Clothes">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M26.516 5.65A4.383 4.383 0 0 0 23.4 4.36h-.005l-2.934.002c-.191 0-.37.074-.537.158-2.693 1.717-5.313 1.72-8.007 0-.167-.084-.346-.159-.537-.158L8.44 4.36h-.004a4.38 4.38 0 0 0-3.115 1.29L3.538 7.435a5.261 5.261 0 0 0-.003 7.425l2.496 2.5v5.028a5.258 5.258 0 0 0 5.252 5.252h9.277a5.258 5.258 0 0 0 5.252-5.252v-4.714l2.65-2.65a5.259 5.259 0 0 0 0-7.427zm-7.602 1.587a3.533 3.533 0 0 1-2.992 1.667 3.534 3.534 0 0 1-2.993-1.666c1.992.743 3.993.743 5.985 0zm8.134 6.373-1.236 1.236v-2.632a1 1 0 1 0-2 0v10.174a3.256 3.256 0 0 1-3.252 3.252h-9.277a3.256 3.256 0 0 1-3.252-3.252V12.373a1 1 0 1 0-2 0v2.156l-1.08-1.082a3.258 3.258 0 0 1 .001-4.598l1.784-1.784a2.389 2.389 0 0 1 1.701-.705h.002l2.036.002c.473 2.58 2.733 4.542 5.447 4.542s4.973-1.963 5.446-4.542l2.03-.002h.003c.642 0 1.245.25 1.7.704l1.947 1.947a3.257 3.257 0 0 1 0 4.6z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                    </g>
                                </svg>
                                Cloths
                            </a>
                        </li>
                        <!-- watch -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Watch">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M10.5 6.5h.41a2.34 2.34 0 0 0 .377-.884l.562-3.203A.497.497 0 0 1 12.34 2h6.32c.243 0 .45.174.492.414l.564 3.213c.064.321.193.616.373.873h.411c.743 0 1.415.28 1.938.728A.48.48 0 0 0 22.5 7a.5.5 0 0 0-.5-.5c-.632 0-1.18-.449-1.301-1.057l-.562-3.201A1.496 1.496 0 0 0 18.66 1h-6.32c-.731 0-1.352.522-1.477 1.241l-.559 3.19A1.333 1.333 0 0 1 9 6.5a.5.5 0 0 0-.5.5.48.48 0 0 0 .062.228A2.968 2.968 0 0 1 10.5 6.5zM20.5 25.5h-.41a2.34 2.34 0 0 0-.377.884l-.562 3.203a.497.497 0 0 1-.491.413h-6.32a.499.499 0 0 1-.492-.414l-.564-3.213a2.304 2.304 0 0 0-.373-.873H10a1.988 1.988 0 0 1-1.469-.652A.478.478 0 0 0 8.5 25a.5.5 0 0 0 .5.5c.632 0 1.18.449 1.301 1.057l.562 3.201c.125.72.746 1.242 1.477 1.242h6.32c.731 0 1.352-.522 1.477-1.241l.559-3.19A1.333 1.333 0 0 1 22 25.5a.5.5 0 0 0 .5-.5.48.48 0 0 0-.062-.228 2.968 2.968 0 0 1-1.938.728zM24 10h-.5v1h.5v2h-.5v1h.5c.551 0 1-.449 1-1v-2c0-.551-.449-1-1-1zm0 3.5V13z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M20.5 26h-10C8.57 26 7 24.43 7 22.5v-13C7 7.57 8.57 6 10.5 6h10C22.43 6 24 7.57 24 9.5v13c0 1.93-1.57 3.5-3.5 3.5zm-10-19A2.503 2.503 0 0 0 8 9.5v13c0 1.378 1.122 2.5 2.5 2.5h10c1.378 0 2.5-1.122 2.5-2.5v-13C23 8.122 21.878 7 20.5 7z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                                Watch
                            </a>
                        </li>
                        <!-- Stationary -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Stationary">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M359.167 231.568a7.498 7.498 0 0 1-3.24-10.099L436.323 65.1 398.72 45.832l-93.788 182.495a7.5 7.5 0 0 1-13.342-6.857l97.213-189.157a7.502 7.502 0 0 1 10.091-3.247l50.953 26.11a7.502 7.502 0 0 1 3.25 10.104l-83.831 163.047a7.499 7.499 0 0 1-10.099 3.241z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M404.194 225.931a7.498 7.498 0 0 1-3.235-10.101l47.367-92.001-77.918-39.93a7.5 7.5 0 1 1 6.842-13.349l84.604 43.357a7.503 7.503 0 0 1 3.247 10.108l-50.807 98.682a7.499 7.499 0 0 1-10.1 3.234zM180.704 228.525l-62.368-110.7-55.14-37.905 8.939 68.027 42.232 73.146a7.5 7.5 0 0 1-12.99 7.5l-42.979-74.439a7.493 7.493 0 0 1-.941-2.773L46.13 65.176a7.5 7.5 0 0 1 11.685-7.158l70.452 48.43a7.5 7.5 0 0 1 2.286 2.5l63.221 112.215a7.5 7.5 0 0 1-2.853 10.215 7.5 7.5 0 0 1-10.217-2.853z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M62.161 160.649a7.5 7.5 0 0 1 2.219-10.372l54.598-35.354a7.5 7.5 0 0 1 8.153 12.591l-54.598 35.354c-3.454 2.237-8.106 1.28-10.372-2.219z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="m141.07 228.68-46.296-77.786a7.5 7.5 0 0 1 2.609-10.281 7.499 7.499 0 0 1 10.281 2.609l46.296 77.786a7.5 7.5 0 0 1-2.609 10.281c-3.547 2.111-8.156.962-10.281-2.609zM279.498 232.344a7.5 7.5 0 0 1-7.421-7.579l1.243-117.596-24.78-51.955-22.627 54.595v115.034a7.5 7.5 0 0 1-15 0V108.317c0-.985.194-1.961.571-2.872l29.647-71.532a7.5 7.5 0 0 1 6.733-4.626c2.949-.06 5.69 1.596 6.965 4.269l32.778 68.725a7.506 7.506 0 0 1 .73 3.308l-1.261 119.334c-.044 4.191-3.516 7.493-7.578 7.421z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M210.919 115.046a7.5 7.5 0 0 1 7.107-7.874l57.855-2.961a7.5 7.5 0 0 1 .768 14.981l-57.856 2.961c-4.104.215-7.661-2.943-7.874-7.107z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="m241.781 224.944-1.364-102.934a7.5 7.5 0 0 1 7.4-7.599c4.164-.1 7.543 3.258 7.599 7.4l1.364 102.934a7.5 7.5 0 0 1-7.399 7.599 7.502 7.502 0 0 1-7.6-7.4z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M356.44 432.336a7.5 7.5 0 0 1-6.891-8.063l14.835-189.204H104.72l14.823 189.204a7.5 7.5 0 0 1-6.891 8.063c-4.131.328-7.739-2.762-8.063-6.892l-15.456-197.29c-.341-4.356 3.104-8.086 7.477-8.086h275.886c4.369 0 7.82 3.727 7.477 8.086l-15.469 197.289a7.502 7.502 0 0 1-8.064 6.893z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M370.402 483.76H98.689a7.5 7.5 0 0 1-7.5-7.5v-47.977a7.5 7.5 0 0 1 7.5-7.5h271.713c4.143 0 7.5 3.357 7.5 7.5v47.977c0 4.143-3.357 7.5-7.5 7.5zm-264.213-15h256.713v-32.977H106.189zM368.364 287.76H101.219c-4.142 0-7.5-3.357-7.5-7.5s3.358-7.5 7.5-7.5h267.145c4.143 0 7.5 3.357 7.5 7.5s-3.358 7.5-7.5 7.5z" fill="#000000" opacity="1" data-original="#000000"></path>
                                    </g>
                                </svg>
                                Stationary
                            </a>
                        </li>
                        <!-- camera -->
                        <li>
                            <a class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200" href="../pages/product_category.php?Category=Cameras">
                                <svg class="w-6" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                    <g>
                                        <path d="M27.348 7h-4.294l-.5-1.5A3.645 3.645 0 0 0 19.089 3h-6.178a3.646 3.646 0 0 0-3.464 2.5L8.946 7H4.652A3.656 3.656 0 0 0 1 10.652v14.7A3.656 3.656 0 0 0 4.652 29h22.7A3.656 3.656 0 0 0 31 25.348v-14.7A3.656 3.656 0 0 0 27.348 7ZM29 25.348A1.654 1.654 0 0 1 27.348 27H4.652A1.654 1.654 0 0 1 3 25.348v-14.7A1.654 1.654 0 0 1 4.652 9h5.015a1 1 0 0 0 .948-.684l.729-2.187A1.65 1.65 0 0 1 12.911 5h6.178a1.649 1.649 0 0 1 1.567 1.13l.729 2.186a1 1 0 0 0 .948.684h5.015A1.654 1.654 0 0 1 29 10.652Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <path d="M16 10a7.5 7.5 0 1 0 7.5 7.5A7.508 7.508 0 0 0 16 10Zm0 13a5.5 5.5 0 1 1 5.5-5.5A5.506 5.506 0 0 1 16 23Z" fill="#000000" opacity="1" data-original="#000000"></path>
                                        <circle cx="26" cy="12" r="1" fill="#000000" opacity="1" data-original="#000000"></circle>
                                    </g>
                                </svg>
                                Cameras
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border border-gray-300">
            <div class="py-3">
                <h1 class="px-5 text-xl">Preferences</h1>
                <ul class="lg:text-lg mt-2">
                    <li class="px-9 h-12 flex items-center gap-3 hover:bg-gray-200"><svg class="w-7" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 68 68" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path d="M60.8 15.19H7.21C3.79 15.19 1 17.98 1 21.4v25.21c0 3.42 2.79 6.2 6.21 6.2H60.8c3.42 0 6.2-2.78 6.2-6.2V21.4c0-3.42-2.78-6.21-6.2-6.21zM65 46.61a4.2 4.2 0 0 1-4.2 4.2H7.21c-2.32 0-4.21-1.88-4.21-4.2V21.4c0-2.32 1.89-4.21 4.21-4.21H60.8c2.32 0 4.2 1.89 4.2 4.21z" fill="#000000" opacity="1" data-original="#000000"></path>
                                <path d="M61 25.27a4.08 4.08 0 0 1-4.07-4.07c0-.55-.45-1-1-1H12.07c-.55 0-1 .45-1 1A4.08 4.08 0 0 1 7 25.27c-.55 0-1 .45-1 1v15.47c0 .55.45 1 1 1 2.24 0 4.07 1.82 4.07 4.07 0 .55.45 1 1 1h43.86c.55 0 1-.45 1-1 0-2.25 1.83-4.07 4.07-4.07.55 0 1-.45 1-1V26.27c0-.55-.45-1-1-1zm-1 15.55c-2.55.42-4.56 2.44-4.99 4.99H12.99A6.099 6.099 0 0 0 8 40.82V27.19a6.099 6.099 0 0 0 4.99-4.99h42.02A6.099 6.099 0 0 0 60 27.19z" fill="#000000" opacity="1" data-original="#000000"></path>
                                <path d="M17.963 30.066A3.938 3.938 0 0 0 14.03 34a3.941 3.941 0 0 0 3.933 3.94 3.945 3.945 0 0 0 3.94-3.94 3.941 3.941 0 0 0-3.94-3.934zm0 5.874A1.939 1.939 0 0 1 16.03 34c0-1.067.867-1.934 1.933-1.934 1.07 0 1.94.867 1.94 1.934 0 1.07-.87 1.94-1.94 1.94zM49.917 30.066A3.938 3.938 0 0 0 45.984 34a3.941 3.941 0 0 0 3.933 3.94 3.945 3.945 0 0 0 3.94-3.94 3.941 3.941 0 0 0-3.94-3.934zm0 5.874A1.939 1.939 0 0 1 47.984 34c0-1.067.867-1.934 1.933-1.934 1.07 0 1.94.867 1.94 1.934 0 1.07-.87 1.94-1.94 1.94zM40.26 30.53c0 .55-.44 1-1 1h-1.89a5.257 5.257 0 0 1-5.15 4.24h-1.45l4.14 5.35c.33.43.25 1.06-.18 1.4a1.002 1.002 0 0 1-1.41-.18l-5.38-6.95c-.33-.44-.25-1.07.18-1.41.18-.14.39-.21.6-.21h3.5c1.44 0 2.65-.94 3.08-2.24h-6.56c-.56 0-1-.45-1-1 0-.56.44-1 1-1h6.56c-.43-1.31-1.64-2.25-3.08-2.25h-3.48a.96.96 0 0 1-.68-.28.952.952 0 0 1-.32-.72c0-.55.44-1 1-1h10.52c.56 0 1 .45 1 1s-.44 1-1 1h-2.95c.52.64.89 1.4 1.06 2.25h1.89c.56 0 1 .44 1 1z" fill="#000000" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <div class="flex">
                            <p>&#8377;-</p>
                            <p>INR</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>