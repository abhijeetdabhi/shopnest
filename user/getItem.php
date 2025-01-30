<?php
    include "../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['search'];
        $vendorId = $_POST['vendorId'];

        $sql = "SELECT * FROM orders WHERE order_title LIKE '%$search%' AND vendor_id = $vendorId";
        $query = mysqli_query($con, $sql);

        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                ?>
                    <a href="?vendorId=<?php echo $vendorId ?>&productId=<?php echo $row['product_id'] ?>" class="flex flex-col min-[530px]:flex-row items-center gap-4 p-3 my-3 cursor-pointer hover:bg-gray-100 rounded-md bg-white transition">
                        <div class="w-full sm:w-32 flex justify-center">
                            <img class="w-52 h-auto object-contain mix-blend-multiply" src="../src/product_image/product_profile/<?php echo $row['order_image'] ?>" alt="Product Image">
                        </div>
                        <div class="flex flex-col gap-2 w-full">
                            <div>
                                <span class="text-base font-normal text-gray-800 line-clamp-2">
                                    <?php echo $row['order_title'] ?>
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 md:w-56">
                                <span class="text-gray-600 font-medium">Colour: <h3 class="text-black"><?php echo $row['order_color'] ?></h3></span>
                                <span class="text-gray-600 font-medium">Size: <h3 class="text-black"><?php echo $row['total_price'] ?></h3></span>
                            </div>
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