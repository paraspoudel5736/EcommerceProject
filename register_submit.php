<?php
require('connection.inc.php');
require('function.inc.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST["register"]))
{
    
	$name = $_POST["name"];
	$mobile = $_POST["mobile"];
	$email = $_POST["email"];
	$password = $_POST["password"];

	//Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		//Enable verbose debug output
		$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

		//Send using SMTP
		$mail->isSMTP();
		$mail->SMTPAuth=true;
		$mail -> SMTPSecure='tls';


		//Set the SMTP server to send through
		$mail->Host = 'smtp.gmail.com';

		//Enable SMTP authentication
		$mail->SMTPAuth = true;

		//SMTP username
		$mail->Username = 'paraspoudel5736@gmail.com';

		//SMTP password
		$mail->Password = 'xocqwkxlchsklruq';

		//Enable TLS encryption;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

		//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		$mail->Port = 587;

		//Recipients
		$mail->setFrom('paraspoudel5736@gmail.com', 'GadgetNepal');


		//Add a recipient
		$mail->addAddress($email, $name);

		//Set email format to HTML
		$mail->isHTML(true);

		$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

		$mail->Subject = 'Email verification';
		$mail->Body    = '<p> Your One-Time Password (OTP) for verifying your account with Gadgets Nepal is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

		$mail->send();
		// echo 'Message has been sent';

		// $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

		// connect with database
		$check_user=mysqli_num_rows(mysqli_query($con,"select * from users where
        email='$email'"));
        if($check_user>0){
         echo "email_present";
        }else{

		// insert in users table
        mysqli_query($con,"insert into users(name,email,mobile,password,added_on) 
        values('$name','$email','$mobile','$password','$added_on')");

		// $sql = "INSERT INTO users(name, mobile, email, password, verification_code, email_verified_at) 
        // VALUES ('" . $name . "','" . $mobile . "', '" . $email . "', '" . $password . "', '" . $verification_code . "'
        // , NULL)";
		// mysqli_query($conn, $sql);

		header("Location: email-verification.php?email=" . $email);
		exit();
            }
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}


//      $added_on=date('Y-m-d h:i:S');
//      mysqli_query($con,"insert into users(name,email,mobile,password,added_on) 
//      values('$name','$email','$mobile','$password','$added_on')");
//      echo "insert";
//  }


?>