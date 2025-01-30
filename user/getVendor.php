<?php

    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $searchWord = $_POST['searchWord'];

        $sql = "SELECT * FROM vendor_registration WHERE username LIKE '%$searchWord%'";
        $query = mysqli_query($con, $sql);

        if(mysqli_num_rows($query) > 0){
            while($res = mysqli_fetch_assoc($query)){
                ?>
                    <a href="?vendorId=<?php echo $res['vendor_id'] ?>" class="flex flex-col min-[530px]:flex-row items-center gap-4 w-full p-2 my-2 border cursor-pointer hover:bg-gray-100 rounded-md bg-white transition">
                        <div class="w-full flex items-center gap-2">
                            <img class="w-8 h-8 rounded-full object-cover" src="../src/vendor_images/vendor_profile_image/<?php echo $res['dp_image'] ?>" alt="Product Image">
                            <h1 class="whitespace-nowrap"><?php echo $res['username'] ?></h1>
                        </div>
                    </a>
                <?php
            }
        }else{
            echo "<div>No suggestions found</div>";
        }
    }else{
        echo "<div>No suggestions found</div>";
    }

?>