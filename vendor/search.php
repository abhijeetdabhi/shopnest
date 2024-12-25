<?php 
    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $searchWord = $_POST['searchWord'];


        $sql = "SELECT * FROM products WHERE title LIKE '%$searchWord%' OR keywords LIKE '%$searchWord%' LIMIT 10";
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) > 0){
            while($res = mysqli_fetch_array($result)){
                $size = $res['size'];
                $sizeExplode = explode(',', $size);
                $firstSize = $sizeExplode[0];

                $MRP = number_format($res['vendor_mrp']);

                echo '<a href="?name=' . $res['Category'] . '&productId=' . $res['product_id'] . '" class="flex flex-col min-[530px]:flex-row items-center gap-4 p-3 border cursor-pointer hover:bg-gray-100 rounded-md bg-white transition">
                        <div class="w-full sm:w-32 flex justify-center">
                            <img class="w-52 h-auto object-contain mix-blend-multiply" src="../src/product_image/product_profile/' . $res['profile_image_1'] . '" alt="Product Image">
                        </div>
                        <div class="flex flex-col gap-2 w-full">
                            <div>
                                <span class="text-xl font-semibold text-gray-800 line-clamp-2">
                                    ' . $res['title'] . '
                                </span>
                                
                            </div>
                            <div class="grid grid-cols-2 gap-2 md:w-56">
                                <span class="text-gray-600 font-medium">Colour: <h3 class="text-black">' . $res['color'] . '</h3></span>
                                <span class="text-gray-600 font-medium">Size: <h3 class="text-black">' . $firstSize . '</h3></span>
                                <span class="text-gray-600 font-medium">Price: <h3 class="text-black">₹' . $MRP . '</h3></span>
                            </div>
                        </div>
                    </a>';
            }
        }else{
            echo "<div>No suggestions found</div>";
        }
    }else{
        echo "<div>No suggestions found</div>";
    }
?>
