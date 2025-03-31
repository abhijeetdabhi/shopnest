<?php
if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>

<?php
include "../include/connect.php";

if (isset($_COOKIE['adminEmail'])) {
    $product_id = $_GET['product_id'];
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
    <title>Products Reviews</title>
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

<body style="font-family: 'Outfit', sans-serif;" class="bg-gray-200">
    <div class="px-1 md:px-6 py-8 mx-auto w-full">
        <h3 class="text-3xl font-medium">Product Reviews</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 min-[1258px]:grid-cols-3 gap-6 w-full mt-6 py-4 lg:overflow-y-scroll p-3 rounded-md">

            <?php
            if (isset($_COOKIE['adminEmail'])) {

                $retrive_reivew = "SELECT * FROM user_review WHERE product_id = '$product_id'";
                $retrive_reivew_query = mysqli_query($con, $retrive_reivew);

                while ($rev = mysqli_fetch_assoc($retrive_reivew_query)) {
                    $product_id = $rev['product_id'];
                    $retrive_product = "SELECT * FROM products WHERE product_id = '$product_id'";
                    $retrive_product_query = mysqli_query($con, $retrive_product);

                    $pr = mysqli_fetch_assoc($retrive_product_query);
            ?>
                    <div class="bg-white shadow-lg h-max rounded-tl-xl rounded-br-xl overflow-hidden w-full">
                        <div class="w-full">
                            <div>
                                <div class="flex gap-y-4 items-start justify-between flex-row md:items-center px-3 pt-3 w-full">
                                    <div class="flex items-center justify-center gap-x-3">
                                        <img class="w-8 h-8 rounded-full object-cover" src="<?php echo '../src/user_dp/' . $rev['profile_image'] ?>" alt="">
                                        <div class="flex flex-col gap-0">
                                            <h2 class="font-medium text-base text-neutral-800"><?php echo isset($_COOKIE['adminEmail']) ? $rev['public_name'] : 'public_name' ?></span></h2>
                                            <p class="font-medium text-sm text-gray-500"><?php echo isset($_COOKIE['adminEmail']) ? $rev['date'] : 'date' ?></p>
                                        </div>
                                    </div>
                                    <div class="flex item-center gap-1">
                                        <span class="bg-gray-900 rounded-tl-lg rounded-br-lg px-2 py-0.5 flex items-center gap-1">
                                            <h1 class="font-semibold text-base text-white"><?php echo isset($_COOKIE['adminEmail']) ? $rev['Rating'] : 'Rating' ?></h1>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.991 511" class="w-3 h-3 m-auto fill-current text-white">
                                                <path d="M510.652 185.883a27.177 27.177 0 0 0-23.402-18.688l-147.797-13.418-58.41-136.75C276.73 6.98 266.918.497 255.996.497s-20.738 6.483-25.023 16.53l-58.41 136.75-147.82 13.418c-10.837 1-20.013 8.34-23.403 18.688a27.25 27.25 0 0 0 7.937 28.926L121 312.773 88.059 457.86c-2.41 10.668 1.73 21.7 10.582 28.098a27.087 27.087 0 0 0 15.957 5.184 27.14 27.14 0 0 0 13.953-3.86l127.445-76.203 127.422 76.203a27.197 27.197 0 0 0 29.934-1.324c8.851-6.398 12.992-17.43 10.582-28.098l-32.942-145.086 111.723-97.964a27.246 27.246 0 0 0 7.937-28.926zM258.45 409.605"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex my-2">
                                    <div>
                                        <img class="w-full h-full max-w-44 max-h-44" src="<?php echo '../src/product_image/product_profile/' . $pr['profile_image_1'] ?>" alt="">
                                    </div>
                                    <div class="mt-3 px-3 space-y-1 w-full">
                                        <h1 class="font-medium line-clamp-1 pr-2" title="<?php echo isset($_COOKIE['adminEmail']) ? $rev['Headline'] : 'Headline' ?>">Title: <?php echo isset($_COOKIE['adminEmail']) ? $rev['Headline'] : 'Headline' ?></h1>
                                        <p class="text-sm line-clamp-4" title="<?php echo isset($_COOKIE['adminEmail']) ? $rev['description'] : 'description' ?>">
                                            <span class="font-semibold">Description :</span>
                                            <?php echo isset($_COOKIE['adminEmail']) ? $rev['description'] : 'description' ?>
                                        </p>
                                    </div>
                                </div>
                            </d>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="relative font-bold text-2xl w-max text-center mt-12 flex items-center justify-center m-auto">No data available for this period.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>