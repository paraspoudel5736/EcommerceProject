<?php

 

    if (isset($_POST["verify_email"]))
    {
        $email = $_POST["email"];
        $verification_code = $_POST["verification_code"];
 
        // connect with database
        $conn = mysqli_connect("localhost", "root", "", "ecommerce");
 
        // mark email as verified
        $sql = "UPDATE users SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);
 
        if (mysqli_affected_rows($conn) == 0)
        {
            die("Verification code failed.");
        }

      
        echo "<p>Verification done! You can login now.</p>";
        header("Location: http://localhost/project/ecommerce/login.php");
        
        exit();
        
    }
 
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ecom Website</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>
</head>
<body>


<form method="POST" >

<div class="single-contact-form">
    
<div class="contact-box name">
<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required >
<input type="text" name="verification_code" placeholder="Enter verification code" style="width:30%;margin-top:150px; margin-left:460px;"required/>
</div>
<input type="submit" class="fv-btn" name="verify_email" value="Verify Email"style="width:25%;;margin-top:10px; margin-left:480px;"required/>


</div>

 </form>
</body>
</html>
