<?php
if (isset($_COOKIE['vendor_id'])) {
    header("Location: ../vendor/vendor_dashboard.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>

<?php
include "../include/connect.php";

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $review_id = $_GET['review_id'];

    $product_find = "SELECT * FROM products WHERE product_id = '$product_id'";
    $product_query = mysqli_query($con, $product_find);

    $row = mysqli_fetch_assoc($product_query);

    // for the review
    $get_reviews = "SELECT * FROM user_review WHERE review_id = '$review_id'";
    $review_query = mysqli_query($con, $get_reviews);

    $rev = mysqli_fetch_assoc($review_query);
}

if (isset($_COOKIE['user_id'])) {
    $userId = $_COOKIE['user_id'];

    $userData = "SELECT * FROM user_registration WHERE user_id  = '$userId'";
    $userQuery = mysqli_query($con, $userData);
    $fetchUser = mysqli_fetch_assoc($userQuery);

    $userFirstName = $fetchUser['first_name'];
    $userLastName = $fetchUser['last_name'];
    $userprofileImage = $fetchUser['profile_image'];
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
    <title>Edit Reviews</title>

    <style>
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


    <div class="w-[100%] mx-auto px-4 py-12 md:m-auto md:w-[70%]">
        <div class="grid grid-col-1 gap-y-4">
            <h2 class="font-bold text-2xl text-black">Edit review</h2>
            <div class="flex flex-col item-center justify-start gap-2 md:flex-row">
                <img class="w-20 h-auto" src="<?php echo isset($product_id) ? '../src/product_image/product_profile/' . $rev['product_img'] : '../src/sample_images/product_1.jpg' ?>" alt="">
                <span class="text-xl font-medium line-clamp-1 my-auto h-7 cursor-default" title="<?php echo isset($product_id) ? $rev['product_title'] : 'product_title' ?>"><?php echo isset($product_id) ? $rev['product_title'] : 'product_title' ?></span>
            </div>
        </div>
        <hr class="my-5">
        <form action="" method="post">
            <div>
                <h2 class="font-bold text-2xl mb-5">Rating</h2>
                <input type="radio" class="hidden" id="Star_1" name="stars[]" value="1">
                <input type="radio" class="hidden" id="Star_2" name="stars[]" value="2">
                <input type="radio" class="hidden" id="Star_3" name="stars[]" value="3">
                <input type="radio" class="hidden" id="Star_4" name="stars[]" value="4">
                <input type="radio" class="hidden" id="Star_5" name="stars[]" value="5">


                <label for="Star_1"><i id="star_1" class="far fa-star text-2xl text-yellow-400" onclick="changeIconClass('1')"></i></label>
                <label for="Star_2"><i id="star_2" class="far fa-star text-2xl text-yellow-400" onclick="changeIconClass('2')"></i></label>
                <label for="Star_3"><i id="star_3" class="far fa-star text-2xl text-yellow-400" onclick="changeIconClass('3')"></i></label>
                <label for="Star_4"><i id="star_4" class="far fa-star text-2xl text-yellow-400" onclick="changeIconClass('4')"></i></label>
                <label for="Star_5"><i id="star_5" class="far fa-star text-2xl text-yellow-400" onclick="changeIconClass('5')"></i></label>
            </div>
            <hr class="my-5">
            <div>
                <div class="headline">
                    <p class="cursor-default font-semibold text-2xl">Add a headline</p>
                    <input class="w-full h-12 border-2 border-[#cccccc] rounded-md focus:border-black focus:ring-0 mt-2" type="text" id="headline" name="headline" value="<?php echo isset($product_id) ? $rev['Headline'] : 'Headline' ?>" required>
                </div>
                <hr class="my-6">
                <div class="review">
                    <p class="cursor-default font-semibold text-2xl">Add a written review</p>
                    <textarea class="w-full h-28 border-2 border-[#cccccc] rounded-md focus:border-black focus:ring-0 mt-2" name="description" id="description"><?php echo isset($product_id) ? $rev['description'] : 'description' ?></textarea>
                </div>
                <hr class="my-6">
                <div class="public_Name">
                    <p class="cursor-default font-semibold text-2xl">Choose your public name</p>
                    <div class="flex item-center justify-center m-auto gap-2">
                        <img class="w-12 h-12 mt-2 rounded-full object-cover" src="<?php echo '../src/user_dp/' . $userprofileImage ?>" alt="">
                        <input class="w-full h-12 border-2 border-[#cccccc] rounded-md focus:border-black focus:ring-0 mt-2" type="text" id="public_Name" name="public_Name" value="<?php echo isset($product_id) ? $rev['public_name'] : 'public_name' ?>" required>
                    </div>
                </div>
                <div class="submit mt-6">
                    <input name="updateReview" class="rounded-tl-xl rounded-br-xl text-center font-medium bg-gray-600 py-3 px-6 text-white hover:bg-gray-700 cursor-pointer transition duration-300 group-invalid:pointer-events-none group-invalid:opacity-30" type="submit" value="Update">
                </div>
            </div>
        </form>
    </div>

    <!-- footer -->
    <?php
    include "../pages/_footer.php";
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
                window.location.href = 'show_reviews.php';
            }, 2000);
        }
    </script>

    <script>
        function changeIconClass(clickedStar) {
            for (var i = 1; i <= 5; i++) {
                var icon = document.getElementById('star_' + i);
                if (i <= clickedStar) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.classList.add('selected');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.remove('selected');
                    icon.classList.add('far');
                }
            }
        }
    </script>

    <!-- chatboat script -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js-na1.hs-scripts.com/47227404.js"></script>

</body>

</html>

<?php
if (isset($_POST['updateReview'])) {
    $headline = mysqli_real_escape_string($con, $_POST['headline']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $public_Name = mysqli_real_escape_string($con, $_POST['public_Name']);
    $review_update_Date = date('d-m-Y');

    if (isset($_POST['stars']) && is_array($_POST['stars'])) {
        $selectedStars = $_POST['stars'];
        $starString = implode(", ", $selectedStars);

        $updateReviewDate = date('d-m-Y');

        $updateReview = "UPDATE user_review SET Rating='$starString',Headline='$headline',description='$description',public_name='$public_Name', date='$updateReviewDate' WHERE review_id = '$review_id'";
        $review_query = mysqli_query($con, $updateReview);

        if ($review_query) {
            $get_reviews = "SELECT * FROM user_review WHERE product_id = '$product_id'";
            $review_query = mysqli_query($con, $get_reviews);

            $totalReviews = mysqli_num_rows($review_query);

            $sum = 0;
            $count = 0;
            if ($totalReviews > 0) {
                while ($data = mysqli_fetch_assoc($review_query)) {
                    $rating = str_replace(",", "", $data['Rating']);
                    $sum += (float)$rating;
                    $count++;
                }

                $average = $sum / $count;
                $formatted_average = number_format($average, 1);
            } else {
                $formatted_average = "0.0";
            }

            $update_review = "UPDATE products SET avg_rating='$formatted_average',total_reviews='$totalReviews' WHERE product_id = '$product_id'";
            $update_review_query = mysqli_query($con, $update_review);

            echo '<script>loader()</script>';
            echo '<script>displaySuccessMessage("Review Updated Successfully.");</script>';
        } else {
            echo '<script>displayErrorMessage("Update failed try again.");</script>';
        }
    } else {
        echo '<script>displayErrorMessage("Please select a rating.");</script>';
    }
}
?>