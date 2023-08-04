<?php
  require 'top.php';


//for cart total
$cart_total=0;
if( $_SERVER['REQUEST_METHOD'] == 'POST')
{
	$product_id = $_POST['product_id'];
	$sql = "SELECT * FROM product WHERE id='$product_id'";
	$result = mysqli_query($con, $sql);
	if($result)
	{
		if ( mysqli_num_rows($result) == 1)
		{
			$product = mysqli_fetch_assoc($result);
			$id= $productArr[0]['id'];
        	$price=$productArr[0]['price'];
        	$mrp=$productArr[0]['mrp'];
        	$qty=$val['qty'];
        	$cart_total=$cart_total+($price*$qty);
			$total_price=($cart_total);
    		$payment_status='pending';
    		if($payment_type=='Esewa'){
       		 $payment_status='success';
    }
    $order_status='1';
    $added_on=date('Y-m-d h:i:s');
			$query = "insert into
			`order`(user_id,payment_type,payment_status,order_status,total_price,added_on)  VALUES('$user_id','$payment_type','$payment_status','$order_status','$total_price','$added_on')";
	   

			$order_id=mysqli_insert_id($con);
foreach($_SESSION['cart'] as $key=>$val){
    $productArr=get_product($con,'','',$key); 
     
    $price=$productArr[0]['price'];
    $qty=$val['qty'];

    mysqli_query($con,"insert into
    order_detail(order_id,product_id,qty,price)  VALUES('$order_id',
   '$key','$qty','$price')");
  }
			if( !mysqli_query($con, $query))
			{
				die('Error!');
			}
		}
	}
}


						
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Checkout Page</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</head>
	<body>
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

                                   
                                         
            </div>
                                         </div> 
						<div class="col-md-6">
							<h3>Pay With</h3>
							<ul class="list-group">
								<li class="list-group-item">

								<!--  <form class="card-body" action="https://uat.esewa.com.np/epay/main" method="POST">
              <input value="<?php echo $overall_charge?>" name="tAmt" type="hidden">
              <input value="<?php echo $overall_charge?>" name="amt" type="hidden">
              <input value="0" name="txAmt" type="hidden">
              <input value="0" name="psc" type="hidden">
              <input value="0" name="pdc" type="hidden">
              <input value="<?php echo $pid?>" name="pid" type="hidden">
              <input value="NP-ES-COLLEGE-TEST" name="scd" type="hidden">
              <input value="http://localhost/project/ecommerce/esewa_payment_success.php?q=su" type="hidden" name="su">
              <input value="http://localhost/project/ecommerce/esewa_payment_failed.php?q=fu" type="hidden" name="fu">
              <br>
            <br><input type="radio" name="payment_type"value="esewa"required/>ESEWA
            <input type="image" src="image/esewa.png"> 
              <input class="btn btn-success btn-lg" name="submit" value="Pay with e-Sewa" type="submit" >
              <div class="single-method">
                                               
                                               </div>
            </form>     -->
		

				<form action="https://uat.esewa.com.np/epay/main" method="POST">
				<input value="<?php echo $overall_charge?>" name="tAmt" type="hidden">
              <input value="<?php echo $overall_charge?>" name="amt" type="hidden">
              <input value="0" name="txAmt" type="hidden">
              <input value="0" name="psc" type="hidden">
              <input value="0" name="pdc" type="hidden">
              <input value="<?php echo $pid?>" name="pid" type="hidden">
              <input value="NP-ES-COLLEGE-TEST" name="scd" type="hidden">
              <input value="http://localhost/project/ecommerce/esewa_payment_success.php?q=su" type="hidden" name="su">
              <input value="http://localhost/project/ecommerce/esewa_payment_failed.php?q=fu" type="hidden" name="fu">
              <br>
			  <input type="image" src="image/esewa.png">
										</li>
										</ul>
								</div>


								</form>
								
							</div>

						</div>
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
                                    
                                </div>
                                <?php } ?>
                            </div>
                            
			</body>
		</html>