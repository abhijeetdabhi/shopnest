<?php
if (isset($_COOKIE['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['adminEmail'])) {
    header("Location: ../admin/dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    include "../include/connect.php";

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        foreach ($data as $form) {
            $vendor_id = $form['vendorId'];

            // Fetch vendor details
            $getVendor = "SELECT * FROM vendor_registration WHERE vendor_id = '$vendor_id'";
            $getVendorQuery = mysqli_query($con, $getVendor);
            $res = mysqli_fetch_array($getVendorQuery);

            if($res){
                $newPassword = $form['password'];
                $pass = password_hash($newPassword, PASSWORD_BCRYPT);
    
                $vendorName = mysqli_real_escape_string($con, $res['name']);
                $vendorEmail = mysqli_real_escape_string($con, $form['email']);
                $vendorPassword = $pass;
                $vendorUsername = mysqli_real_escape_string($con, $form['shopname']);
                $vendorPhone = mysqli_real_escape_string($con, $form['phone']);
                $vendorBio = mysqli_real_escape_string($con, $res['Bio']);
                $vendorGST = mysqli_real_escape_string($con, $res['GST']);
                $vendorCover_image = mysqli_real_escape_string($con, $res['cover_image']);
                $vendorDp_image = mysqli_real_escape_string($con, $res['dp_image']);
                $vendorLatitude = mysqli_real_escape_string($con, $form['lat']);
                $vendorLongitude = mysqli_real_escape_string($con, $form['lng']);
                $Vendor_reg_date = date('Y-m-d');
    
                $insert_new_vendor = "INSERT INTO vendor_registration(name, email, password, username, phone, Bio, GST, cover_image, dp_image, latitude, longitude, date) VALUES ('$vendorName', '$vendorEmail', '$vendorPassword', '$vendorUsername', '$vendorPhone', '$vendorBio', '$vendorGST', '$vendorCover_image', '$vendorDp_image', '$vendorLatitude', '$vendorLongitude', '$Vendor_reg_date')";
    
                if (mysqli_query($con, $insert_new_vendor)) {
                    $LstVendor_id = mysqli_insert_id($con);
    
                    $get_products = "SELECT * FROM products WHERE vendor_id = '$vendor_id'";
                    $product_query = mysqli_query($con, $get_products);
    
                    while ($ven = mysqli_fetch_assoc($product_query)) {
                        $same_id = mysqli_real_escape_string($con, $ven['same_id']);
                        $title = mysqli_real_escape_string($con, $ven['title']);
                        $profileImage1 = mysqli_real_escape_string($con, $ven['profile_image_1']);
                        $profileImage2 = mysqli_real_escape_string($con, $ven['profile_image_2']);
                        $profileImage3 = mysqli_real_escape_string($con, $ven['profile_image_3']);
                        $profileImage4 = mysqli_real_escape_string($con, $ven['profile_image_4']);
                        $coverImage1 = mysqli_real_escape_string($con, $ven['cover_image_1']);
                        $coverImage2 = mysqli_real_escape_string($con, $ven['cover_image_2']);
                        $coverImage3 = mysqli_real_escape_string($con, $ven['cover_image_3']);
                        $coverImage4 = mysqli_real_escape_string($con, $ven['cover_image_4']);
                        $Company_name = mysqli_real_escape_string($con, $ven['company_name']);
                        $Category = mysqli_real_escape_string($con, $ven['Category']);
                        $type = mysqli_real_escape_string($con, $ven['Type']);
                        $MRP = mysqli_real_escape_string($con, $ven['MRP']);
                        $vendor_mrp = mysqli_real_escape_string($con, $ven['vendor_mrp']);
                        $your_price = mysqli_real_escape_string($con, $ven['vendor_price']);
                        $quantity = mysqli_real_escape_string($con, $ven['Quantity']);
                        $condition = mysqli_real_escape_string($con, $ven['Item_Condition']);
                        $description = mysqli_real_escape_string($con, $ven['Description']);
                        $pcolor = mysqli_real_escape_string($con, $ven['color']);
                        $size_filter = mysqli_real_escape_string($con, $ven['size']);
                        $keywords = mysqli_real_escape_string($con, $ven['keywords']);
                        $avg_rating = mysqli_real_escape_string($con, $ven['avg_rating']);
                        $total_reviews = mysqli_real_escape_string($con, $ven['total_reviews']);
                        $Product_insert_Date = date('Y-m-d');
    
                        $insert_vendor_products = "INSERT INTO products(same_id, vendor_id, title, profile_image_1, profile_image_2, profile_image_3, profile_image_4, cover_image_1, cover_image_2, cover_image_3, cover_image_4, company_name, Category, Type, MRP, vendor_mrp, vendor_price, Quantity, Item_Condition, Description, color, size, keywords, avg_rating, total_reviews, date) VALUES ('$same_id', '$LstVendor_id', '$title', '$profileImage1', '$profileImage2', '$profileImage3', '$profileImage4', '$coverImage1', '$coverImage2', '$coverImage3', '$coverImage4', '$Company_name', '$Category', '$type', '$MRP', '$vendor_mrp', '$your_price', '$quantity', '$condition', '$description', '$pcolor', '$size_filter', '$keywords', '$avg_rating', '$total_reviews', '$Product_insert_Date')";
    
                        if (!mysqli_query($con, $insert_vendor_products)) {
                            echo json_encode(['status' => 'error', 'message' => 'Failed to insert product']);
                            exit;
                        }
                    }
    
                    // Successful insert
                    echo json_encode(['status' => 'success', 'message' => 'Account and products added successfully']);
                    exit;
    
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to register vendor']);
                    exit;
                }
            }
        }
    }
}
?>
