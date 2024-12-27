<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../include/connect.php";
    $data = json_decode(file_get_contents("php://input"), true);

    
    
    if ($data) {
        foreach ($data as $form) {
            $vendor_id = $form['vendorId'];

            $getVendor = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
            $getVendorQuery = mysqli_query($con, $getVendor);

            $res = mysqli_fetch_array($getVendorQuery);

            $name = $res['name'];
            $bio = $res['Bio'];
            $gst = $res['GST'];
            $CoverImage = $res['cover_image'];
            $ProfileImage = $res['dp_image'];
            
            $newEmail = $form['email'];
            $newPassword = $form['password'];
            $newShopname = $form['shopname'];
            $newPhone = $form['phone'];
            $newLat = $form['lat'];
            $newLng = $form['lng'];

            $Vendor_reg_date = date('d-m-Y');
            $pass = password_hash($newPassword, PASSWORD_BCRYPT);

            $vendorName = $name;
            $vendorEmail = $newEmail;
            $vendorPassword = $pass;
            $vendorUsername = $newShopname;
            $vendorPhone = $newPhone;
            $vendorBio = $bio;
            $vendorGST = $gst;
            $vendorCover_image = $CoverImage;
            $vendorDp_image = $ProfileImage;
            $vendorLatitude = $newLat;
            $vendorLongitude = $newLng;
            $vendorRegiDate = $Vendor_reg_date;
            
            $insert_data = "INSERT INTO vendor_registration(name, email, password, username, phone, Bio, GST, cover_image, dp_image, latitude, longitude, date) VALUES ('$vendorName','$vendorEmail','$vendorPassword','$vendorUsername','$vendorPhone','$vendorBio','$vendorGST','$vendorCover_image','$vendorDp_image','$vendorLatitude','$vendorLongitude','$vendorRegiDate')";
            $insert_sql = mysqli_query($con, $insert_data);

            $LstVendor_id = mysqli_insert_id($con);

            $product_find = "SELECT * FROM products WHERE vendor_id = '$vendor_id'";
            $product_query = mysqli_query($con, $product_find);

            while($ven = mysqli_fetch_assoc($product_query)){
                $same_id = $ven['same_id'];
                $vendor_id = $LstVendor_id;
                $full_name = $ven['title'];
                $profileImage1 = $ven['profile_image_1'];
                $profileImage2 = $ven['profile_image_2'];
                $profileImage3 = $ven['profile_image_3'];
                $profileImage4 = $ven['profile_image_4'];
                $coverImage1 = $ven['cover_image_1'];
                $coverImage2 = $ven['cover_image_2'];
                $coverImage3 = $ven['cover_image_3'];
                $coverImage4 = $ven['cover_image_4'];
                $Company_name = $ven['company_name'];
                $Category = $ven['Category'];
                $type = $ven['Type'];
                $json_size_encode = $ven['MRP'];
                $MRP = $ven['vendor_mrp'];
                $your_price = $ven['vendor_price'];
                $quantity = $ven['Quantity'];
                $condition = $ven['Item_Condition'];
                $description = $ven['Description'];
                $pcolor = $ven['color'];
                $size_filter = $ven['size'];
                $keywords_value = $ven['keywords'];
                $avg_rating = $ven['avg_rating'];
                $total_reviews = $ven['total_reviews'];
                $Product_insert_Date = $vendorRegiDate;
            }
            

            $product_insert = "INSERT INTO products(same_id, vendor_id, title, profile_image_1, profile_image_2, profile_image_3, profile_image_4, cover_image_1, cover_image_2, cover_image_3, cover_image_4, company_name, Category, Type, MRP, vendor_mrp, vendor_price, Quantity, Item_Condition, Description, color, size, keywords, avg_rating, total_reviews, date) VALUES ('$same_id','$vendor_id','$full_name','$profileImage1','$profileImage2','$profileImage3','$profileImage4','$coverImage1','$coverImage2','$coverImage3','$coverImage4','$Company_name','$Category','$type','$json_size_encode','$MRP','$your_price','$quantity','$condition','$description','$pcolor','$size_filter','$keywords_value','$avg_rating','$total_reviews','$Product_insert_Date')";
            $product_query = mysqli_query($con, $product_insert);

            if ($insert_sql && $product_query) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data received or data is invalid']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}

?>
