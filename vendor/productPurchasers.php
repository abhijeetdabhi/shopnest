<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: /index.php");
    exit;
}

if (isset($_COOKIE['vendor_id'])) {
    header("Location: /vendor/vendor_dashboard.php");
    exit;
}
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

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- link to css -->
    <link rel="stylesheet" href="">

    <!-- favicon -->
    <link rel="shortcut icon" href="../src/logo/favIcon.svg">

    <!-- title -->
    <title>Product Purchasers</title>
    <style>
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

        #logoutPopUp {
            display: none;
        }

        [x-cloak] {
            display: none;
        }
    </style>
</head>

<body style="font-family: 'Outfit', sans-serif;">

    <div>
        <?php
        include "vendor_logout.php";
        ?>
    </div>

    <div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0" x-cloak>
                <div class="flex items-center justify-center mt-8 mr-2">
                    <a class="flex w-fit" href="">
                        <!-- icon logo div -->
                        <div>
                            <img class="w-12 sm:w-14 mt-0.5" src="../src/logo/white_cart_logo.svg" alt="">
                        </div>
                        <!-- text logo -->
                        <div>
                            <img class="w-28 sm:w-36" src="../src/logo/white_text_logo.svg" alt="">
                        </div>
                    </a>
                </div>
                <nav class="mt-10">
                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="dashboard.php">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <span class="mx-3">Dashboard</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="tables.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M21.5 23h-19A2.503 2.503 0 0 1 0 20.5v-17C0 2.122 1.122 1 2.5 1h19C22.878 1 24 2.122 24 3.5v17c0 1.378-1.122 2.5-2.5 2.5zM2.5 2C1.673 2 1 2.673 1 3.5v17c0 .827.673 1.5 1.5 1.5h19c.827 0 1.5-.673 1.5-1.5v-17c0-.827-.673-1.5-1.5-1.5z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M23.5 8H.5a.5.5 0 0 1 0-1h23a.5.5 0 0 1 0 1zM23.5 13H.5a.5.5 0 0 1 0-1h23a.5.5 0 0 1 0 1zM23.5 18H.5a.5.5 0 0 1 0-1h23a.5.5 0 0 1 0 1z" fill="" opacity="1" data-original="#000000" class=""></path>
                                <path d="M6.5 23a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 1 0v15a.5.5 0 0 1-.5.5zM12 23a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 1 0v15a.5.5 0 0 1-.5.5zM17.5 23a.5.5 0 0 1-.5-.5v-15a.5.5 0 0 1 1 0v15a.5.5 0 0 1-.5.5z" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Tables</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_users.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M210.352 246.633c33.882 0 63.218-12.153 87.195-36.13 23.969-23.972 36.125-53.304 36.125-87.19 0-33.876-12.152-63.211-36.129-87.192C273.566 12.152 244.23 0 210.352 0c-33.887 0-63.22 12.152-87.192 36.125s-36.129 53.309-36.129 87.188c0 33.886 12.156 63.222 36.13 87.195 23.98 23.969 53.316 36.125 87.19 36.125zM144.379 57.34c18.394-18.395 39.973-27.336 65.973-27.336 25.996 0 47.578 8.941 65.976 27.336 18.395 18.398 27.34 39.98 27.34 65.972 0 26-8.945 47.579-27.34 65.977-18.398 18.399-39.98 27.34-65.976 27.34-25.993 0-47.57-8.945-65.973-27.34-18.399-18.394-27.344-39.976-27.344-65.976 0-25.993 8.945-47.575 27.344-65.973zM426.129 393.703c-.692-9.976-2.09-20.86-4.149-32.351-2.078-11.579-4.753-22.524-7.957-32.528-3.312-10.34-7.808-20.55-13.375-30.336-5.77-10.156-12.55-19-20.16-26.277-7.957-7.613-17.699-13.734-28.965-18.2-11.226-4.44-23.668-6.69-36.976-6.69-5.227 0-10.281 2.144-20.043 8.5a2711.03 2711.03 0 0 1-20.879 13.46c-6.707 4.274-15.793 8.278-27.016 11.903-10.949 3.543-22.066 5.34-33.043 5.34-10.968 0-22.086-1.797-33.043-5.34-11.21-3.622-20.3-7.625-26.996-11.899-7.77-4.965-14.8-9.496-20.898-13.469-9.754-6.355-14.809-8.5-20.035-8.5-13.313 0-25.75 2.254-36.973 6.7-11.258 4.457-21.004 10.578-28.969 18.199-7.609 7.281-14.39 16.12-20.156 26.273-5.558 9.785-10.058 19.992-13.371 30.34-3.2 10.004-5.875 20.945-7.953 32.524-2.063 11.476-3.457 22.363-4.149 32.363C.343 403.492 0 413.668 0 423.949c0 26.727 8.496 48.363 25.25 64.32C41.797 504.017 63.688 512 90.316 512h246.532c26.62 0 48.511-7.984 65.062-23.73 16.758-15.946 25.254-37.59 25.254-64.325-.004-10.316-.351-20.492-1.035-30.242zm-44.906 72.828c-10.934 10.406-25.45 15.465-44.38 15.465H90.317c-18.933 0-33.449-5.059-44.379-15.46-10.722-10.208-15.933-24.141-15.933-42.587 0-9.594.316-19.066.95-28.16.616-8.922 1.878-18.723 3.75-29.137 1.847-10.285 4.198-19.937 6.995-28.675 2.684-8.38 6.344-16.676 10.883-24.668 4.332-7.618 9.316-14.153 14.816-19.418 5.145-4.926 11.63-8.957 19.27-11.98 7.066-2.798 15.008-4.329 23.629-4.56 1.05.56 2.922 1.626 5.953 3.602 6.168 4.02 13.277 8.606 21.137 13.625 8.86 5.649 20.273 10.75 33.91 15.152 13.941 4.508 28.16 6.797 42.273 6.797 14.114 0 28.336-2.289 42.27-6.793 13.648-4.41 25.058-9.507 33.93-15.164 8.043-5.14 14.953-9.593 21.12-13.617 3.032-1.973 4.903-3.043 5.954-3.601 8.625.23 16.566 1.761 23.636 4.558 7.637 3.024 14.122 7.059 19.266 11.98 5.5 5.262 10.484 11.798 14.816 19.423 4.543 7.988 8.208 16.289 10.887 24.66 2.801 8.75 5.156 18.398 7 28.675 1.867 10.434 3.133 20.239 3.75 29.145v.008c.637 9.058.957 18.527.961 28.148-.004 18.45-5.215 32.38-15.937 42.582zm0 0" fill="" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <span class="mx-3">Users</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_vendors.php">
                        <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class="">
                            <g>
                                <path d="M17.898 27.921a2.951 2.951 0 0 1-.648.071C14.171 28 8.087 28 5.007 28a3.001 3.001 0 0 1-2.998-2.855l-.001-.028a39.881 39.881 0 0 1 .5-7.195c.255-1.546 1.578-3.49 2.926-4.311l.163-.098a.998.998 0 0 1 1.1.05C7.941 14.467 9.472 15 11.126 15s3.185-.533 4.429-1.437a1 1 0 0 1 1.094-.053l.169.101c.684.417 1.37 1.115 1.905 1.909A7.504 7.504 0 0 1 30 22a7.495 7.495 0 0 1-3.718 6.477A7.465 7.465 0 0 1 22.5 29.5a7.463 7.463 0 0 1-4.602-1.579zm-.757-11.167a5.187 5.187 0 0 0-1.004-1.175A9.497 9.497 0 0 1 11.126 17a9.499 9.499 0 0 1-5.012-1.422c-.782.643-1.482 1.757-1.632 2.669a37.847 37.847 0 0 0-.474 6.824c.038.522.472.929.998.929 2.747 0 7.885 0 11.147-.005a7.47 7.47 0 0 1-1.035-5.324 7.493 7.493 0 0 1 2.023-3.917zm1.648 9.303A5.476 5.476 0 0 0 22.5 27.5a5.473 5.473 0 0 0 3.045-.92 5.5 5.5 0 1 0-6.518-8.843 5.501 5.501 0 0 0-1.786 5.879 5.51 5.51 0 0 0 1.548 2.441zm2.713-.384a4.267 4.267 0 0 1-1.367-.581 1 1 0 0 1 1.119-1.658 2.415 2.415 0 0 0 1.564.368c.251-.034.488-.14.488-.442 0-.041-.041-.051-.072-.069a1.784 1.784 0 0 0-.313-.132c-.388-.13-.832-.216-1.235-.334-1.163-.339-1.992-.962-1.992-2.173 0-.611.18-1.091.458-1.464.323-.435.795-.734 1.352-.887a1 1 0 0 1 1.994.021c.508.126.992.336 1.38.607a1 1 0 0 1-1.145 1.64 2.322 2.322 0 0 0-1.546-.37c-.254.035-.493.148-.493.453 0 .041.041.051.072.069.093.054.2.094.313.132.388.13.832.216 1.235.334 1.163.339 1.992.962 1.992 2.173 0 1.237-.668 1.948-1.592 2.275-.07.025-.143.047-.218.066a1.001 1.001 0 0 1-1.994-.028zM11.126 2a5.455 5.455 0 0 1 5.453 5.452c0 3.01-2.444 5.453-5.453 5.453s-5.452-2.443-5.452-5.453A5.455 5.455 0 0 1 11.126 2zm0 2a3.454 3.454 0 0 0-3.452 3.452 3.454 3.454 0 0 0 3.452 3.453 3.454 3.454 0 0 0 3.453-3.453A3.454 3.454 0 0 0 11.126 4z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Vendors</span>
                    </a>
                    <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="productPurchasers.php">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-6">
                                <g>
                                    <path d="M155.166 233.471h106.395c4.056 44.754 41.779 79.939 87.573 79.939 48.49 0 87.939-39.45 87.939-87.939 0-45.793-35.185-83.517-79.939-87.572V31.503a8 8 0 0 0-8-8H155.166a8 8 0 0 0-8 8v193.968a8 8 0 0 0 8 8zm265.907-8c0 39.667-32.271 71.939-71.939 71.939s-71.94-32.272-71.94-71.939c0-39.668 32.272-71.94 71.94-71.94s71.939 32.272 71.939 71.94zM234.531 39.503h35.236v56.585h-35.236zm-71.365 0h55.365v64.585a8 8 0 0 0 8 8h51.236a8 8 0 0 0 8-8V39.503h55.366v98.396c-42.119 3.817-75.756 37.453-79.573 79.572h-98.395V39.503zm185.968 126.322a8 8 0 0 1 8 8v10.135h17.82a8 8 0 0 1 0 16h-38.393c-4.827 0-8.755 3.928-8.755 8.755s3.928 8.755 8.755 8.755h25.144c13.65 0 24.756 11.105 24.756 24.755s-11.105 24.755-24.756 24.755h-4.571v10.135a8 8 0 0 1-16 0V266.98h-17.821a8 8 0 0 1 0-16h38.393c4.828 0 8.756-3.928 8.756-8.755s-3.928-8.755-8.756-8.755h-25.144c-13.649 0-24.755-11.105-24.755-24.755s11.105-24.755 24.755-24.755h4.572v-10.135a8 8 0 0 1 8-8zm134.594 154.153c-5.257-9.106-13.777-15.628-23.992-18.365-10.217-2.736-20.854-1.349-29.959 3.908l-88.799 51.268c-2.345-14.974-13.249-27.928-28.806-32.096l-133.841-35.862c-15.805-4.235-31.003-2.234-45.173 5.947l-31.452 18.159-2.547-4.411a8.006 8.006 0 0 0-4.857-3.728 8.008 8.008 0 0 0-6.07.799l-61.237 35.355a8 8 0 0 0-2.928 10.928l76.565 132.615a8.006 8.006 0 0 0 6.927 4 8 8 0 0 0 4-1.072l61.237-35.355a8 8 0 0 0 2.928-10.928l-3.709-6.425 14.628-8.446 124.218 25.92a39.936 39.936 0 0 0 10.111 1.311c6.833 0 13.565-1.786 19.619-5.28l128.68-74.293c9.105-5.257 15.627-13.777 18.364-23.991 2.738-10.213 1.349-20.853-3.907-29.958zM110.487 469.569 41.922 350.81l47.382-27.355 68.565 118.759zm361.694-123.773c-1.63 6.086-5.505 11.156-10.909 14.276l-128.68 74.293c-5.406 3.12-11.735 3.941-17.819 2.311a8.159 8.159 0 0 0-.437-.104l-127.414-26.587a7.997 7.997 0 0 0-5.634.903l-17.273 9.973-54.309-94.066 31.452-18.159c10.508-6.067 21.312-7.488 33.032-4.349l133.841 35.862c12.51 3.352 19.962 16.254 16.617 28.764l-.004.012c-1.615 6.028-5.509 11.083-10.965 14.233-5.458 3.149-11.782 3.995-17.811 2.38l-69.847-18.715a8 8 0 0 0-4.141 15.455l69.847 18.715a39.468 39.468 0 0 0 10.222 1.353c6.847 0 13.617-1.803 19.729-5.332 8.141-4.7 14.208-11.948 17.367-20.635l98.729-57.002c5.405-3.12 11.731-3.94 17.818-2.31 6.086 1.631 11.156 5.505 14.276 10.91 3.123 5.405 3.944 11.733 2.313 17.819z" fill="currentColor" opacity="1" data-original="currentColor" class=""></path>
                                </g>
                            </svg>
                        </span>
                        <span class="mx-3">Product Purchasers</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="view_product.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 96 96" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="m90.895 25.211-42-21a2.004 2.004 0 0 0-1.789 0l-42 21A2 2 0 0 0 4 27v42a2 2 0 0 0 1.105 1.789l42 21a1.998 1.998 0 0 0 1.79 0l42-21A2 2 0 0 0 92 69V27a2 2 0 0 0-1.105-1.789zM48 8.236 85.528 27 77.5 31.014 39.973 12.25zm13.5 30.778L23.972 20.25 35.5 14.486 73.028 33.25zm1.5 3.722 12-6v14.877l-3.838-2.741a2.006 2.006 0 0 0-1.506-.343 2.007 2.007 0 0 0-1.301.832L63 57.098zm-43.5-20.25L57.027 41.25 48 45.764 10.472 27zM8 30.236l38 19v37.527l-38-19zm42 56.528V49.236l9-4.5V63.5a2 2 0 0 0 3.645 1.139l7.845-11.331 5.349 3.82A1.997 1.997 0 0 0 79 55.5V34.736l9-4.5v37.527z" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Products</span>
                    </a>

                    <a class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="contact_page.php">
                        <svg class="w-6 h-6 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <path d="M255.986 368.994c69.385 0 125.834-56.437 125.834-125.807a125.977 125.977 0 0 0-125.834-125.834c-69.37 0-125.806 56.449-125.806 125.834a126.3 126.3 0 0 0 33.62 85.588l-13.013 48.547a15 15 0 0 0 21.993 16.872l50.895-29.408a125.582 125.582 0 0 0 32.311 4.208zm-41.747-33.4-25.091 14.5 5.868-21.89a15 15 0 0 0-4.268-14.863 94.89 94.89 0 0 1-30.568-70.149 95.775 95.775 0 1 1 66.2 91.128 15 15 0 0 0-12.141 1.271zM503.8 253.9c.163-6.138.332-12.485.039-19.093a71.337 71.337 0 0 0-71.782-68.279C402.4 98.677 334.645 51.136 255.986 51.136S109.6 98.676 79.942 166.527a71.339 71.339 0 0 0-71.779 68.257c-.294 6.632-.125 12.98.038 19.119.173 6.486.351 13.193.018 20.73a71.432 71.432 0 0 0 68.18 74.36q1.678.078 3.349.078a70.393 70.393 0 0 0 27.415-5.54 14.973 14.973 0 0 0 8.114-19.377 8.044 8.044 0 0 0-.824-2.021 162.3 162.3 0 0 1-20.491-78.946c0-89.355 72.684-162.051 162.024-162.051s162.052 72.7 162.052 162.051a161.532 161.532 0 0 1-132.157 159.287 41.584 41.584 0 1 0 1.328 30.209 192.361 192.361 0 0 0 130.075-85.231 70.237 70.237 0 0 0 14.951 1.62q1.653 0 3.315-.076a71.366 71.366 0 0 0 68.23-74.383c-.332-7.513-.153-14.226.02-20.713zM77.733 319.023a41.405 41.405 0 0 1-39.543-43.085c.379-8.579.178-16.151 0-22.833-.156-5.875-.3-11.423-.055-17.014a41.394 41.394 0 0 1 31.274-38.35 192.359 192.359 0 0 0 8.3 116.877l-.018.007q.876 2.232 1.809 4.443-.877-.004-1.767-.045zm170.118 111.841a11.589 11.589 0 1 1 11.588-11.593v.022a11.6 11.6 0 0 1-11.588 11.571zm225.958-154.947a41.366 41.366 0 0 1-39.591 43.108q-.864.041-1.724.044a.255.255 0 0 0 .011-.177 192.27 192.27 0 0 0 10.086-121.15 41.391 41.391 0 0 1 31.275 38.371c.247 5.568.1 11.116-.056 16.99-.178 6.682-.38 14.255-.001 22.814zm-252.869-34.2a14.464 14.464 0 0 1 .07 1.47 14.661 14.661 0 0 1-.07 1.48c-.05.48-.13.97-.22 1.45s-.22.96-.36 1.43-.31.93-.5 1.38-.4.9-.63 1.33-.48.85-.75 1.26a12.819 12.819 0 0 1-.87 1.18c-.31.39-.65.75-.99 1.1a14.668 14.668 0 0 1-1.1.99c-.38.31-.78.6-1.18.88-.41.26-.83.52-1.27.75a13.2 13.2 0 0 1-1.32.62 14.253 14.253 0 0 1-1.38.5c-.47.14-.95.26-1.43.36a14.512 14.512 0 0 1-1.45.22 15.681 15.681 0 0 1-2.96 0 14.512 14.512 0 0 1-1.45-.22c-.48-.1-.96-.22-1.43-.36a14.253 14.253 0 0 1-1.38-.5 13.2 13.2 0 0 1-1.32-.62c-.44-.23-.86-.49-1.27-.75-.4-.28-.8-.57-1.18-.88a14.668 14.668 0 0 1-1.1-.99c-.34-.35-.68-.71-.99-1.1a12.819 12.819 0 0 1-.87-1.18q-.4-.615-.75-1.26c-.23-.43-.44-.88-.63-1.33s-.35-.91-.5-1.38-.26-.95-.36-1.43a14.086 14.086 0 0 1-.29-2.93c0-.49.03-.98.07-1.47s.13-.98.22-1.46.22-.95.36-1.42.31-.93.5-1.38.4-.9.63-1.33a15.584 15.584 0 0 1 1.62-2.45c.31-.38.65-.75.99-1.09a14.668 14.668 0 0 1 1.1-.99c.38-.31.78-.61 1.18-.88a14.6 14.6 0 0 1 1.27-.75q.645-.345 1.32-.63c.45-.18.92-.35 1.38-.49a14.242 14.242 0 0 1 1.43-.36 14.718 14.718 0 0 1 5.86 0 14.242 14.242 0 0 1 1.43.36c.46.14.93.31 1.38.49s.89.4 1.32.63a14.6 14.6 0 0 1 1.27.75c.4.27.8.57 1.18.88a14.668 14.668 0 0 1 1.1.99c.34.34.68.71.99 1.09a15.584 15.584 0 0 1 1.62 2.45c.23.43.44.88.63 1.33s.35.91.5 1.38.26.95.36 1.42.17.966.22 1.456zm20.06 1.47a14.988 14.988 0 0 1 14.986-15h.028a15 15 0 1 1-15.014 15zm50.06 1.476a14.661 14.661 0 0 1-.07-1.48 14.464 14.464 0 0 1 .07-1.47c.05-.49.13-.98.22-1.46s.22-.95.36-1.42a13.353 13.353 0 0 1 .5-1.38c.18-.45.4-.9.62-1.33a16.64 16.64 0 0 1 1.63-2.45c.31-.38.65-.75.99-1.09a14.668 14.668 0 0 1 1.1-.99 12.913 12.913 0 0 1 1.18-.88q.615-.4 1.26-.75c.43-.23.88-.44 1.33-.63s.92-.35 1.38-.49a14.242 14.242 0 0 1 1.43-.36 14.684 14.684 0 0 1 4.4-.22 14.277 14.277 0 0 1 1.46.22 13.41 13.41 0 0 1 1.42.36c.47.14.94.31 1.39.49s.89.4 1.32.63a14.6 14.6 0 0 1 1.27.75c.4.27.8.57 1.18.88a12.8 12.8 0 0 1 1.09.99c.35.34.68.71 1 1.09.3.38.6.78.87 1.19a14.425 14.425 0 0 1 .75 1.26c.23.43.44.88.63 1.33a13.294 13.294 0 0 1 .49 1.38 11.812 11.812 0 0 1 .36 1.42 11.959 11.959 0 0 1 .22 1.46 14.479 14.479 0 0 1 .08 1.47 14.676 14.676 0 0 1-.08 1.48 12.1 12.1 0 0 1-.22 1.45 11.967 11.967 0 0 1-.36 1.43 14.174 14.174 0 0 1-.49 1.38c-.19.45-.4.9-.63 1.33s-.48.85-.75 1.26-.57.81-.87 1.18c-.32.39-.65.75-1 1.1a12.8 12.8 0 0 1-1.09.99c-.38.31-.78.6-1.18.87a14.692 14.692 0 0 1-1.27.76 13.2 13.2 0 0 1-1.32.62 13.525 13.525 0 0 1-1.39.5c-.46.14-.94.26-1.42.36a14.461 14.461 0 0 1-2.93.29 14.661 14.661 0 0 1-1.48-.07 14.512 14.512 0 0 1-1.45-.22c-.48-.1-.96-.22-1.43-.36a14.253 14.253 0 0 1-1.38-.5 13.359 13.359 0 0 1-1.33-.62c-.43-.23-.85-.49-1.26-.76a12.819 12.819 0 0 1-1.18-.87 14.668 14.668 0 0 1-1.1-.99c-.34-.35-.68-.71-.99-1.1a12.819 12.819 0 0 1-.87-1.18c-.27-.41-.53-.83-.76-1.26s-.44-.88-.62-1.33a14.253 14.253 0 0 1-.5-1.38c-.14-.47-.26-.95-.36-1.43s-.17-.97-.22-1.45z" fill="" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <span class="mx-3">Contacts</span>
                    </a>

                    <a id="logoutButton1" class="group flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="#">
                        <svg class="w-5 h-5 fill-gray-500 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g>
                                <g data-name="ARROW 48">
                                    <path d="M307.69 347.47a24 24 0 0 0-24 24v58.47a33.93 33.93 0 0 1-33.89 33.9H82.06a33.93 33.93 0 0 1-33.89-33.9V82.06a33.93 33.93 0 0 1 33.89-33.9H249.8a33.93 33.93 0 0 1 33.89 33.9v50.54a24 24 0 0 0 48 0V82.06A82 82 0 0 0 249.8.16H82.06A82 82 0 0 0 .17 82.06v347.88a82 82 0 0 0 81.89 81.9H249.8a82 82 0 0 0 81.89-81.9v-58.47a24 24 0 0 0-24-24z" fill="" opacity="1" data-original="#000000" class=""></path>
                                    <path d="m504.77 238.53-85.41-85.35a24 24 0 0 0-33.6-.33c-9.7 9.33-9.47 25.13.05 34.65l44.47 44.5h-208a24 24 0 0 0-24 24 24 24 0 0 0 24 24h208l-44.9 44.9a24 24 0 0 0 33.94 33.95l85.45-85.41a24.66 24.66 0 0 0 0-34.91z" fill="" opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </g>
                        </svg>
                        <span class="mx-3">Log Out</span>
                    </a>
                </nav>
            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-600">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <div class="relative mx-4 lg:mx-0">
                            <h1 class="text-2xl font-semibold">Hello Admin !</h1>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                <img class="object-cover w-full h-full" src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=296&amp;q=80" alt="Your avatar">
                            </button>
                            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>
                            <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl divide-y-2 divide-gray-300 ring-2 ring-gray-400" style="display: none;">
                                <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Dashboard</a>
                                <a href="view_product.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Products</a>
                                <a id="logoutButton2" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-600 hover:text-white">Logout</a>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- script for logout popup -->
                <script>
                    // Select elements
                    const logoutPopUp = document.getElementById('logoutPopUp');
                    const logoutButton1 = document.getElementById('logoutButton1');
                    const logoutButton2 = document.getElementById('logoutButton2');

                    // Function to show the logout popup
                    function showLogoutPopup() {
                        logoutPopUp.style.display = 'flex'; // Show the popup
                    }

                    // Function to hide the logout popup
                    function closePopup() {
                        logoutPopUp.style.display = 'none'; // Hide the popup
                    }

                    // Add click event listeners to logout buttons
                    logoutButton1.addEventListener('click', (event) => {
                        event.preventDefault();
                        showLogoutPopup();
                    });

                    logoutButton2.addEventListener('click', (event) => {
                        event.preventDefault();
                        showLogoutPopup();
                    });

                    // Add a global event listener to the Cancel button
                    document.addEventListener('click', (event) => {
                        if (event.target.matches('.cancel-button')) {
                            closePopup();
                        }
                    });
                </script>
                <main class="flex-1 overflow-x-hidden overflow-y-auto scrollBar bg-gray-200 px-5 mt-5">
                    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 gap-5 xl:gap-8">
                        <!-- user 1 -->
                        <div class="bg-white rounded-tl-2xl rounded-br-2xl shadow-lg text-center grid place-items-center overflow-hidden">
                            <div class="flex justify-center mt-4">
                                <img class="w-24 h-24 rounded-full object-cover" src="../src/user_dp/null-20241130-WA0054.jpg" alt="Profile Picture">
                            </div>
                            <div class="py-4">
                                <h2 class=" text-xl font-semibold">vishvjitchauhan</h2>
                                <a href="mailto:vishvjitchauhan2284@gmail.com" class="text-sm text-gray-500">vishvjitchauhan2284@gmail.com</a>
                            </div>
                            <div class="border-t-2 w-full">
                                <div class="flex justify-between divide-x-2">
                                    <a href="tel:8141391797" class="flex items-center justify-center space-x-1 w-full py-2 text-green-600">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 480.56 480.56" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path d="M365.354 317.9c-15.7-15.5-35.3-15.5-50.9 0-11.9 11.8-23.8 23.6-35.5 35.6-3.2 3.3-5.9 4-9.8 1.8-7.7-4.2-15.9-7.6-23.3-12.2-34.5-21.7-63.4-49.6-89-81-12.7-15.6-24-32.3-31.9-51.1-1.6-3.8-1.3-6.3 1.8-9.4 11.9-11.5 23.5-23.3 35.2-35.1 16.3-16.4 16.3-35.6-.1-52.1-9.3-9.4-18.6-18.6-27.9-28-9.6-9.6-19.1-19.3-28.8-28.8-15.7-15.3-35.3-15.3-50.9.1-12 11.8-23.5 23.9-35.7 35.5-11.3 10.7-17 23.8-18.2 39.1-1.9 24.9 4.2 48.4 12.8 71.3 17.6 47.4 44.4 89.5 76.9 128.1 43.9 52.2 96.3 93.5 157.6 123.3 27.6 13.4 56.2 23.7 87.3 25.4 21.4 1.2 40-4.2 54.9-20.9 10.2-11.4 21.7-21.8 32.5-32.7 16-16.2 16.1-35.8.2-51.8-19-19.1-38.1-38.1-57.2-57.1zM346.254 238.2l36.9-6.3c-5.8-33.9-21.8-64.6-46.1-89-25.7-25.7-58.2-41.9-94-46.9l-5.2 37.1c27.7 3.9 52.9 16.4 72.8 36.3 18.8 18.8 31.1 42.6 35.6 68.8zM403.954 77.8c-42.6-42.6-96.5-69.5-156-77.8l-5.2 37.1c51.4 7.2 98 30.5 134.8 67.2 34.9 34.9 57.8 79 66.1 127.5l36.9-6.3c-9.7-56.2-36.2-107.2-76.6-147.7z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                            </g>
                                        </svg>
                                        <h1>8141391797</h1>
                                    </a>
                                    <a href="remove_user.php?id=26" class="w-full py-2 space-x-1 text-red-600">
                                        <i class="fa-solid fa-trash text-base"></i>
                                        <span>Remove</span>
                                    </a>
                                </div>
                                <div class="border-t-2 py-2">
                                    <a href="userPurchaseProduct.php" class="flex justify-center items-center gap-2 text-blue-600">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="w-5">
                                                <g>
                                                    <path d="m458.737 422.218-22.865-288.116c-1.425-18.562-17.123-33.103-35.739-33.103H354.97v-2.03C354.97 44.397 310.573 0 256.001 0s-98.969 44.397-98.969 98.969v2.03H111.87c-18.617 0-34.316 14.54-35.736 33.064L53.262 422.257c-1.77 23.075 6.235 46.048 21.961 63.026C90.949 502.261 113.242 512 136.385 512h239.231c23.142 0 45.436-9.738 61.163-26.717 15.726-16.979 23.73-39.951 21.958-63.065zM187.022 98.969c0-38.035 30.945-68.979 68.979-68.979s68.979 30.945 68.979 68.979v2.03H187.022v-2.03zm227.754 365.936c-10.218 11.03-24.124 17.105-39.16 17.105h-239.23c-15.036 0-28.942-6.075-39.16-17.105-10.217-11.031-15.211-25.363-14.063-40.315l22.87-288.195c.232-3.032 2.796-5.406 5.837-5.406h45.162v36.935c0 8.281 6.714 14.995 14.995 14.995 8.281 0 14.995-6.714 14.995-14.995v-36.935H324.98v36.935c0 8.281 6.714 14.995 14.995 14.995s14.995-6.714 14.995-14.995v-36.935h45.163c3.04 0 5.604 2.375 5.84 5.446l22.865 288.115c1.15 14.992-3.845 29.323-14.062 40.355z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                    <path d="M323.556 254.285c-5.854-5.856-15.349-5.856-21.204 0l-66.956 66.956-25.746-25.746c-5.855-5.856-15.35-5.856-21.206 0s-5.856 15.35 0 21.206l36.349 36.349c2.928 2.928 6.766 4.393 10.602 4.393s7.675-1.464 10.602-4.393l77.558-77.558c5.857-5.857 5.857-15.351.001-21.207z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                                                </g>
                                            </svg>
                                        </span>
                                        <span>View Orders</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </section>
                </main>
            </div>
        </div>
    </div>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>