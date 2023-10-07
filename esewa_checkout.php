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
    $payment_type=get_safe_value($con,$_POST['payment_type']);
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
    $payment_status='success';
    echo$payment_type; //undefine ?
    if($payment_type==' Esewa'){
        $payment_status='success';
    }
    $order_status='1';
    $added_on=date('Y-m-d h:i:s');
    $ref_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

    mysqli_query($con,"insert into
     `order`(user_id,payment_type,payment_status,order_status,added_on,total_price)  VALUES('$user_id',
    '$payment_type','$payment_status','$order_status','$added_on','$total_price')");


$order_id=mysqli_insert_id($con);
foreach($_SESSION['cart'] as $key=>$val){
    $productArr=get_product($con,'','',$key); 
     
    $price=$productArr[0]['price'];
    $qty=$val['qty'];

    mysqli_query($con,"insert into
    order_detail(order_id,product_id,qty,price)  VALUES('$order_id',
   '$key','$qty','$price')");
  }
  
 
  
?>

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
                                    
                                 
                                   
                                    

                 
                                               
                                               
                                            
             
                                            <div class="single-method">
                                               
                                            </div>
                                        
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
                                  </div>  
                                </div> 
                                
                            

                                <div class="accordion__body">
                                        <div class="paymentinfo">
                                            <h3>Delivery Charge- Rs.100<h3> <br>
                                            <div class="single-method">

                                            <h3>Pay With</h3>
							<ul class="list-group">
								<li class="list-group-item">
									<form action="https://uat.esewa.com.np/epay/main" method="post">
										<input value="<?php echo$overall_charge?>" name="tAmt" type="hidden">
										<input value="<?php echo $overall_charge?>" name="amt" type="hidden">
										<input value="0" name="txAmt" type="hidden">
										<input value="0" name="psc" type="hidden">
										<input value="0" name="pdc" type="hidden">
										<input value="epay_payment" name="scd" type="hidden">
										<input value="<?php echo $pid;?>" name="pid" type="hidden">
										<input value="esewa" name="payment_type" type="hidden">
										<input value="http://localhost/project/ecommerce/esewa_payment_success.php?q=su" type="hidden" name="su">
										<input value="http://localhost/project/ecommerce/esewa_payment_failed.php?q=fu" type="hidden" name="fu">
										<br>
                                        <input type="radio" name="payment_type" value="Esewa"required/> Cash On Delivery
                                            </div>
                                             <br>
                                             <div class="buttons-cart checkout--btn">
                                            <input type="submit" name="submit" style="background:hsl(19deg 90% 49%);,color:#f5f5f5;"/>
                                               <br>
                                    </div>
										</li>
										
								</div>

                                </form>
                                             <!-- <input type="radio" name="payment_type" value="ESEWA"required/> Cash On Delivery
                                            </div>
                                             <br>
                                             <div class="buttons-cart checkout--btn">
                                            <input type="submit" name="submit" style="background:hsl(19deg 90% 49%);,color:#f5f5f5;"/>
                                               <br>
                                    </div> -->

                                   
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
