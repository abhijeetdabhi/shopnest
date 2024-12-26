<?php
    include "../../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $mobileno = $_POST['mobileno'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $user_reg_date = date('d-m-Y');

        $pass = password_hash($password, PASSWORD_BCRYPT);

        // find email
        $email_check = "SELECT * FROM user_registration WHERE email = '$email'";
        $check_query = mysqli_query($con, $email_check);
        $emailCount = mysqli_num_rows($check_query);


        $phone_check = "SELECT * FROM user_registration WHERE phone = '$mobileno'";
        $number_query = mysqli_query($con, $phone_check);
        $mobileCount = mysqli_num_rows($number_query);

        // get first letter from the first Name

        $first_letter = strtoupper(substr($fname, 0, 1));
        $firstNameImage = $first_letter . '.png';

        if($emailCount > 0){   
            echo 'email_exists';
        }else if($mobileCount > 0){
            echo 'phone_exists';
        }else{
            $userFirstName = $fname; 
            $userLastName = $lname; 
            $userPhoneNumber = $mobileno; 
            $userEmailAddress = $email ; 
            $userProfileImage = $firstNameImage; 
            $userAddress = $address; 
            $userState = $state; 
            $userCity = $city; 
            $userPincode = $pincode ; 
            $userPassword = $pass; 
            $userLoginDate = $user_reg_date; 
        
            $insert_reg_data = "INSERT INTO user_registration(first_name, last_name, phone, email, profile_image, Address, state, city, pin, password, date) VALUES ('$userFirstName', '$userLastName', '$userPhoneNumber', '$userEmailAddress', '$userProfileImage', '$userAddress', '$userState', '$userCity', '$userPincode', '$userPassword' ,'$userLoginDate')";
            $iquery = mysqli_query($con, $insert_reg_data);

            if ($iquery) {
                echo 'success';
            }
        }

    }