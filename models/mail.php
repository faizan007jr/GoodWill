 <?php

 require_once ('./PHPMailer/PHPMailerAutoload.php');

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '465';
$mail->isHTML();
$mail->Username = 'goodwillelectronics2@gmail.com';
$mail->Password = 'xyz@1234';
$mail->setFrom('noreply@goodwill.com');
/*$mail->Subject = 'Sign Up';
$mail->Body = 'Hello World';
$mail->AddAddress('email@gmail.com');

$mail->Send();*/
?>