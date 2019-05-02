<?php
include('SMTP.php');
include("PHPMailer.php");

use PHPMailer\PHPMailer\PHPMailer;

function sendMail($to)
{
    $nFrom = "Phone Shop PTIT";
    $mFrom = 'phoneshopptit@gmail.com';
    $mPass = 'abc@@123';

    $mail = new PHPMailer();
    $body = "Your order has been confirmed";
    $title = "Successful order";
    $mail->IsSMTP();
    $mail->CharSet = "utf-8";
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;

    $mail->Username = $mFrom;
    $mail->Password = $mPass;
    $mail->SetFrom($mFrom, $nFrom);
    $mail->AddReplyTo('phoneshopptit@gmail.com', 'phoneshop');
    $mail->Subject = $title;
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $to);

    if (!$mail->Send()) {
        return 1;
    } else {
        return 0;
    }
}

?>


