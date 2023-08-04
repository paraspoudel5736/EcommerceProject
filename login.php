<?php 

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
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
		$conn = mysqli_connect("localhost", "root", "", "ecommerce");

		// insert in users table
		$sql = "INSERT INTO users(name, mobile, email, password, verification_code, email_verified_at) VALUES ('" . $name . "','" . $mobile . "', '" . $email . "', '" . $password . "', '" . $verification_code . "', NULL)";
		mysqli_query($conn, $sql);
		header("Location: email-verification.php?email=" . $email);
		exit();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

require('top.php');
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
	//header('location:checkout.php');
	die();
}
?>
<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Login/register</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        
		<!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
            <div class="container">
                <div class="row">
					<div class="col-md-6">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Login</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="login-form"  method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
											
										</div>
										<span class="field_error" id="login_email_error"></span>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											
											<input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
										</div>
										<span class="field_error" id="login_password_error"></span>
									</div>
									
									<div class="contact-btn">
										<button type="button" class="fv-btn" onclick="user_login()">Login</button>
										</div>
								</form>
								<div class="form-output login_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>
						</div> 
                
				</div>
				

					<div class="col-md-6">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Register</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="register-form" method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="text" name="name" id="name" placeholder="Username*" style="width:100%">
										</div>
										<span class="field_error" id="name_error"></span>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" id="email" placeholder="Your Email*" style="width:100%">
											
										</div>
										<span class="field_error" id="email_error"></span>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="text" max="9999999999" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%" required>
											
										</div>
										<span class="field_error" id="mobile_error"></span>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
											
										</div>
										<span class="field_error" id="password_error"></span>
									</div>
									
									<div class="contact-btn">
									<input type="submit" class="fv-btn" name="register" value="Register">
									<!-- <button type="button" class="fv-btn" onclick="user_register() ">Register</button> -->
									</div>
								</form> 
								<div class="form-output register_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>
						</div> 
                
				</div>
					
            </div>
        </section>
<?php require('footer.php')?>        