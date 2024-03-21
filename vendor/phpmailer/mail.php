<?php
include "classes/class.phpmailer.php";
$mail = new PHPMailer; 
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "smtp.mail.yahoo.com"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "jafar_sidik4@yahoo.co.id"; //user email
$mail->Password = "blackknight"; //password email 
$mail->SetFrom("jafar_sidik4@yahoo.co.id","jafar"); //set email pengirim
$mail->Subject = "Testing"; //subyek email
$mail->AddAddress("jafarsidikS1@gmail.com","aha");  //tujuan email
$mail->MsgHTML("Testing...");
if($mail->Send()) echo "Message has been sent";
else echo "Failed to sending message";
?>