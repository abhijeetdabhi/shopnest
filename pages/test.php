<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>
    
    <form action="" method="post">
        <input type="submit" name="mail" value="Send mail">
    </form>

    <?php

        if(isset($_POST['mail'])){   
            include '../pages/mail.php';

            $mail->addAddress('abhijeetdabhi9304@gmail.com');
            $mail->isHTML(true);
            
            $mail->Subject = "My selft";
            $mail->Body = "Hello My name is authers";
            if($mail->send()){
                echo "mail Send";
            }else{
                echo "error";
            }
        }
    ?>

</body>
</html>