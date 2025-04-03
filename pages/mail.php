<?php
    include "../include/connect.php";

    use phpmailer\PHPMailer\PHPMailer;
    use phpmailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    $mail->Username = "shopnest2603@gmail.com";
    $mail->Password = "setn bzcp ynps jygc";
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('shopnest2603@gmail.com');
?>