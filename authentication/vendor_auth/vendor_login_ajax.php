<?php

    include "../../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['vendorEmail'];
        $password = $_POST['vendorPassword'];

        // check if email is rejected or not
        $checkEmail = "SELECT * FROM vendor_cancel_request WHERE email = '$email'";
        $checkEmailQuery = mysqli_query($con, $checkEmail);
        if(mysqli_num_rows($checkEmailQuery) > 0){
            echo "request_cancel";
            exit();
        }

        // check if email request is Pending or not
        $requestEmail = "SELECT * FROM vendor_request WHERE email = '$email'";
        $requestEmailQuery = mysqli_query($con, $requestEmail);
        if(mysqli_num_rows($requestEmailQuery) > 0){
            echo "not_accept";
            exit();
        }

        // for the user
        $email_search = "SELECT * FROM vendor_registration WHERE email = '$email'";
        $search_query = mysqli_query($con, $email_search);

        if(mysqli_num_rows($search_query) > 0){
            if(mysqli_num_rows($search_query) > 0){
                $emailPass = mysqli_fetch_assoc($search_query);
    
                $vendorPassword = $emailPass['password'];
                $vendorId = $emailPass['vendor_id'];
    
                if(password_verify($password, $vendorPassword)){
                    setcookie('vendor_id', $vendorId, time() + (365 * 24 * 60 * 60), "/");
                    echo 'success';
                }else{
                    echo "pass_not_matching";
                }
            }else{
                echo "email_not_found";
            }
        }else{
            // for the admin
            $search_admin = "SELECT * FROM admin WHERE email = '$email'";
            $admin_query = mysqli_query($con, $search_admin);
            if(mysqli_num_rows($admin_query) > 0){
                $admin_email = $_POST['vendorEmail'];
                $admin_pass = $_POST['vendorPassword'];
                
                $findAdmin = mysqli_fetch_assoc($admin_query);
    
                $myEmail = $findAdmin['email'];
                $myPass = $findAdmin['password'];
                if(password_verify($admin_pass, $myPass)){
                    echo "admin_success";
                    
                    setcookie('adminEmail', $admin_email, time() + (365 * 24 * 60 * 60), "/");
                    setcookie('adminPass', $admin_pass, time() + (365 * 24 * 60 * 60), "/");
                }else{
                    echo "pass_not_matching";
                }
            }else{
                echo "email_not_found";
            }
        }

    }