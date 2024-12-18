<?php

    if(!isset($_GET['product_id'])){
        header("Location: ../index.php");
        exit;
    }

    if(isset($_COOKIE['vendor_id'])){
        header("Location: ../vendor/vendor_dashboard.php");
        exit;
    }

    if(isset($_COOKIE['adminEmail'])){
        header("Location: ../admin/dashboard.php");
        exit;
    }
?>


<?php
    include "../include/connect.php";

    if(isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        
        $product_find = "SELECT * FROM products WHERE product_id = '$product_id'";
        $product_query = mysqli_query($con,$product_find);
        
        $row = mysqli_fetch_assoc($product_query);
        $productImage = $row['profile_image_1'];

        $title = $row['title'];
    }

    if(isset($_COOKIE['user_id'])){
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
    <title>Add Your Reviews</title>
</head>
<body style="font-family: 'Outfit', sans-serif;">
    

    <div class="w-[100%] mx-auto px-4 py-12 md:m-auto md:w-[70%]">
        <div class="grid grid-col-1 gap-y-4">
            <h2 class="font-bold text-2xl text-black">Write review</h2>
            <div class="flex flex-col item-center justify-start gap-2 md:flex-row">
                <img class="w-20 h-auto" src="<?php echo isset($product_id) ? '../src/product_image/product_profile/' . $row['profile_image_1'] : '../src/sample_images/product_1.jpg'?>" alt="">
                <span class="text-xl font-medium line-clamp-1 my-auto h-7 cursor-default" title="<?php echo isset($product_id) ? $title : 'product_title'?>"><?php echo isset($product_id) ? $title : 'product_title'?></span>
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
                    <input class="w-full h-12 border-2 border-[#cccccc] rounded-md focus:border-gray-500 focus:ring-gray-500 mt-2" type="text" id="headline" name="headline" placeholder="What's most important to know?" required>
                </div>
                <hr class="my-6">
                <div class="review">
                    <p class="cursor-default font-semibold text-2xl">Add a written review</p>
                    <input class="w-full h-12 border-2 border-[#cccccc] rounded-md focus:border-gray-500 focus:ring-gray-500 mt-2" type="text" id="description" name="description" placeholder="What did you like or dislike? What did you use this product for?" required>
                </div>
                <hr class="my-6">
                <div class="public_Name">
                    <p class="cursor-default font-semibold text-2xl">Choose your public name</p>
                    <div class="flex item-center justify-center m-auto gap-2">
                        <img class="w-12 h-12 mt-2 rounded-full object-cover" src="<?php echo '../src/user_dp/' . $userprofileImage?>" alt="">
                        <input class="w-full h-12 border-2 border-[#cccccc] rounded-md focus:border-gray-500 focus:ring-gray-500 mt-2" type="text" id="public_Name" name="public_Name" value="<?php echo isset($_COOKIE['user_id']) ? $userFirstName . ' ' . $userLastName : 'user Name'?>" required>
                    </div>
                </div>
                <div class="submit mt-6">
                    <input name="submitReview" class="rounded-tl-xl rounded-br-xl text-center bg-gray-700 h-10 w-32 text-white hover:bg-gray-800 cursor-pointer transition duration-300 group-invalid:pointer-events-none group-invalid:opacity-30" type="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>

    <!-- footer -->
    <?php
        include "../pages/_footer.php";
    ?>

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
    if(isset($_POST['submitReview'])){
        $headline = mysqli_real_escape_string($con, $_POST['headline']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $public_Name = mysqli_real_escape_string($con, $_POST['public_Name']);
        $review_insert_Date = date('d-m-Y');

        if(isset($_POST['stars']) && is_array($_POST['stars'])){
            $selectedStars = $_POST['stars'];
            $starString = implode(", ", $selectedStars);

            $insertReview = "INSERT INTO user_review(product_id, user_id, product_img, product_title, Rating, Headline, description, public_name, profile_image, date) VALUES ('$product_id','$userId','$productImage','$title','$starString','$headline','$description','$public_Name','$userprofileImage','$review_insert_Date')";
            $review_query = mysqli_query($con, $insertReview);

            if($review_query){
                $product_id = $_GET['product_id'];
        
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
                }else {
                    $formatted_average = "0.0";
                }

                $update_review = "UPDATE products SET avg_rating='$formatted_average',total_reviews='$totalReviews' WHERE product_id = '$product_id'";
                $update_review_query = mysqli_query($con, $update_review);

                ?>
                <!-- Successfully -->
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="SpopUp" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Inserted Successfully.</span>
                        </div>
                    </div>
                </div>

                <script>
                
                    let SpopUp = document.getElementById('SpopUp');

                    SpopUp.style.display = 'flex';
                    SpopUp.style.opacity = '100';

                    setTimeout(() => {
                        SpopUp.style.display = 'none';
                        SpopUp.style.opacity = '0';
                        window.location.href = 'product_detail.php?product_id=<?php echo $product_id?>';
                    }, 1500);
                </script>
                <?php
            }else {
                ?>
                    <!-- Error -->
                    <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="EpopUp" style="display: none;">
                        <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Insertion Failed.</span>
                            </div>
                        </div>
                    </div>
    
                    <script>
                    
                        let EpopUp = document.getElementById('EpopUp');
    
                        EpopUp.style.display = 'flex';
                        EpopUp.style.opacity = '100';
    
                        setTimeout(() => {
                            EpopUp.style.display = 'none';
                            EpopUp.style.opacity = '0';
                        }, 1500);
                    </script>
                <?php
            }
        }else {
            ?>
                <!-- Error -->
                <div class="validInfo fixed top-0 mt-2 w-full transition duration-300 z-50" id="ErpopUp" style="display: none;">
                    <div class="flex items-center m-auto justify-center px-6 py-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Please Select a Rating.</span>
                        </div>
                    </div>
                </div>
    
                <script>
                
                    let ErpopUp = document.getElementById('ErpopUp');
    
                    ErpopUp.style.display = 'flex';
                    ErpopUp.style.opacity = '100';
    
                    setTimeout(() => {
                        ErpopUp.style.display = 'none';
                        ErpopUp.style.opacity = '0';
                    }, 1500);
                </script>
            <?php
        }
    }
?>