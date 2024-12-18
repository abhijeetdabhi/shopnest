<?php

    include "../../include/connect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['userEmail'];
        $password = $_POST['userPass'];

        // for the user
        $email_search = "SELECT * FROM user_registration WHERE email = '$email'";
        $search_query = mysqli_query($con, $email_search);

        if(mysqli_num_rows($search_query) > 0){
            $emailPass = mysqli_fetch_assoc($search_query);

            $userPass = $emailPass['password'];
            $userId = $emailPass['user_id'];
            $userFirstName = $emailPass['first_name'];

            if(password_verify($password, $userPass)){
                setcookie('user_id', $userId, time() + (365 * 24 * 60 * 60), "/");
                setcookie('fname', $userFirstName, time() + (365 * 24 * 60 * 60), "/");

                echo 'success';
            }else{
                echo "pass_not_matching";
            }
        }else {
            // for the admin
            $admin_email = $_POST['userEmail'];
            $admin_pass = $_POST['userPass'];

            $search_admin = "SELECT * FROM admin WHERE email = '$admin_email'";
            $admin_query = mysqli_query($con, $search_admin);

            if(mysqli_num_rows($admin_query) > 0){
                $findAdmin = mysqli_fetch_assoc($admin_query);

                $myEmail = $findAdmin['email'];
                $myPass = $findAdmin['password'];
                if(password_verify($admin_pass, $myPass)){
                    echo "admin_success";
                    
                    setcookie('adminEmail', $admin_email, time() + (365 * 24 * 60 * 60), "/");
                    setcookie('adminPass', $admin_pass, time() + (365 * 24 * 60 * 60), "/");
                }
            }else{
                echo "pass_not_matching";
            }
        }
    }