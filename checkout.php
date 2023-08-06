<?php
require('top.php');
date_default_timezone_set('Asia/Kathmandu');
//check if there is item in cart or not if cart is 0 then redirect to index page.
if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
    ?>
    <script>
        window.location.href='index.php';
    </script>
    <?php
}
//for cart total
$cart_total=0;



//form method post submit in database
if(isset($_POST['submit'])){
    $address=get_safe_value($con,$_POST['address']);
    $city=get_safe_value($con,$_POST['city']);
    $pincode=get_safe_value($con,$_POST['pincode']);
    $payment_type=get_safe_value($con,$_POST['payment_type']);
    //echo $payment_type;
 
    $user_id=$_SESSION['USER_ID'];

    foreach($_SESSION['cart'] as $key=>$val){
        $productArr=get_product($con,'','',$key);  
        $id= $productArr[0]['id'];
        $price=$productArr[0]['price'];
        $mrp=$productArr[0]['mrp'];
        $qty=$val['qty'];
        $cart_total=$cart_total+($price*$qty);
        }
    $total_price=($cart_total);
    $payment_status='pending';
    if($payment_type=='cod'){
        $payment_status='success';
    }
    $order_status='1';
    $added_on=date('Y-m-d h:i:s');

    mysqli_query($con,"insert into
     `order`(user_id,address,city,pincode,payment_type,payment_status,order_status,added_on,total_price)  VALUES('$user_id',
    '$address','$city','$pincode','$payment_type','$payment_status','$order_status','$added_on','$total_price')");


$order_id=mysqli_insert_id($con);
foreach($_SESSION['cart'] as $key=>$val){
    $productArr=get_product($con,'','',$key); 
     
    $price=$productArr[0]['price'];
    $qty=$val['qty'];

    mysqli_query($con,"insert into
    order_detail(order_id,product_id,qty,price)  VALUES('$order_id',
   '$key','$qty','$price')");
  }
  
  unset($_SESSION['cart']);
  if($payment_type=='esewa'){
    $hash_string = '';
		
		$URL = "https://uat.esewa.com.np/epay/main";
		$action = '';
		$posted = array();
		if(!empty($_POST)) {
		  foreach($_POST as $key => $value) {    
			$posted[$key] = $value; 
            $order_status = "0";        
            
  }}
}
  
?>
<script>
     window.location.href='thank_you.php';
 </script>
 <?php

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
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    
                                    <?php 
                                    $accordion_class='accordion__title';
                                    if(!isset($_SESSION['USER_LOGIN'])){
                                    $accordion_class='accordion__hide';
                                        ?>
                                        <div class="accordion__title">
                                        Checkout Method
                                    </div>
                                    <!-- <div class="accordion__body">
                                        <div class="accordion__body__form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                    <form id="login-form"  method="post">
                                                            <h5 class="checkout-method__title">Login</h5>
                                                            <div class="single-input">
                                                                <label for="user-email">Email Address</label>
                                                                <input type="text" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
                                                                <span class="field_error" id="login_email_error"></span>  
                                                            </div>
                                                            
                                                            <div class="single-input">
                                                                <label for="user-pass">Password</label>
                                                                <input type="text" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
                                                                <span class="field_error" id="login_password_error"></span>
                                                            </div>
                                                            
                                                            <p class="require">* Required fields</p>
                                                            <div class="dark-btn">
                                                            <button type="button" class="fv-btn" onclick="user_login()">Login</button>
                                                            <div class="form-output login_msg">
									                          <p class="form-messege field_error"></p>
								                            </div>
                                                        </div>
                                                            
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                    <form id="register-form" method="post">
                                                            <h5 class="checkout-method__title">Register</h5>
                                                            <div class="single-input">
                                                                
                                                                <input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
                                                                <span class="field_error" id="name_error"></span>
                                                            </div>
															<div class="single-input">
                                                                
                                                                <input type="text" name="email" id="email" placeholder="Your Email*" style="width:100%">
                                                                <span class="field_error" id="email_error"></span>
                                                            </div>

                                                            <div class="single-input">
                                                            <input type="text" name="mobile" id="mobile"placeholder="Your Mobile*" style="width:100%">
                                                            <span class="field_error" id="mobile_error"></span>
                                                            </div>
															
                                                            <div class="single-input">
                                                            <input type="text" name="password" id="password" placeholder="Your Password*" style="width:100%">   
                                                            <span class="field_error" id="password_error"></span>  
                                                            </div>
                                                            <div class="dark-btn">
                                                            <button type="button" class="fv-btn" onclick="user_register() ">Register</button>
                                                            <div class="form-output register_msg">
                                                              <p class="form-messege field_error"></p>
								                            </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php } ?>
                                    <div class="<?php echo $accordion_class?>">
                                        Address Information
                                    </div>
                                    <div class="accordion__body">
                                        <div class="bilinfo">
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="single-input">
                                                            <input type="text" name="address" placeholder="Street Address"required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name="city" placeholder="City/State"required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="single-input">
                                                            <input type="text" name="pincode" placeholder="Post code/ zip"required>
                                                        </div>
                                                    </div>
                                                   
                                                    
                                                </div>
                                            
                                        </div>
                                    </div>
                                    <div class="<?php echo $accordion_class?>">
                                        payment information
                                    </div>
                                    <div class="accordion__body">
                                        <div class="paymentinfo">
                                            <h3>Delivery Charge- Rs.100<h3> <br>
                                            <div class="single-method">

                                             <input type="radio" name="payment_type" value="COD"required/> Cash On Delivery

                                             <br>
                                            <!-- <input type="radio" name="payment_type" value="ESEWA"required/> ESEWA -->
                                            </div>
                                             <br>
                                             <div class="buttons-cart checkout--btn">
                                            <input type="submit" name="submit" style="background:hsl(19deg 90% 49%);,color:#f5f5f5;"/>
                                               <br>
                                    </div>

                 
                                               
                                               
                                            
             
                                            <div class="single-method">
                                               
                                            </div>
                                        </div>
                                    
                                     
                                         </form>
                                         <?php
							$cart_total=0;
							foreach($_SESSION['cart'] as $key=>$val){
							$productArr=get_product($con,'','',$key);
                            $pid=$productArr[0]['id'];
							$pname=$productArr[0]['name'];
                           
							$mrp=$productArr[0]['mrp'];
							$price=$productArr[0]['price'];
							$image=$productArr[0]['image'];
							$qty=$val['qty'];
                            $delivery=100;
                            $cart_total=$cart_total+($price*$qty);
                            $overall_charge=$cart_total+$delivery;

							?> 
                                    <div class="accordion__body ">

                                    <a href="http://localhost/project/ecommerce/esewa_checkout.php">
                                    <button>Pay with esewa</button>
                                    </a>
                                         
            </div>
                                         </div>  
                                </div> 
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                     
                            
                                <div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="media/product/<?php echo $image?>"/>
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $pname?></a>
                                        <span class="price">Rs. <?php echo $price*$qty?></span>
                                    </div>
                                    <div class="single-item__remove">
                                    <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')"><i class="icon-trash icons"></i></a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            
                            <div class="ordre-details__total">
                                <h5>Order Total</h5>
                                <span class="price">Rs.<?php echo  $cart_total ?></span>
                            
                            </div>
                            <div class="ordre-details__total">
                                <h5>Delivery Price</h5>
                                <span class="price">Rs.<?php echo  $delivery ?></span>
                            
                            </div>
                            <div class="ordre-details__total">
                                <h5>Total Price</h5>
                                <span class="price">Rs.<?php echo $overall_charge ?></span>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->

        <?php
        require('footer.php');
        ?>
