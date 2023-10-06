<?php 
require('top.php');
$metaTagVar ="";
if(isset($_GET['id'])){
	$product_id=mysqli_real_escape_string($con,$_GET['id']);
	if($product_id>0){
		$get_product=get_product($con,'','',$product_id);
        $get_related_product=get_related_products($con,$product_id);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
?>
<?php
    $metaTagVar = $get_product['0']['meta_tag'];
?>
 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home<?="hh".$metaTagVar?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <a class="breadcrumb-item" href="categories.php?id=<?php echo $get_product['0']['categories_id']?>"><?php echo $get_product['0']['categories']?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active"><?php echo $get_product['0']['name']?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                        <img src="media/product/<?php echo $get_product['0']['image']?>" alt="full-image"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name']?></h2>
                                <ul  class="pro__prize">
                                    <li class="old__prize"><?php echo $get_product['0']['mrp']?></li>
                                    <li><?php echo $get_product['0']['price']?></li>
                                </ul>
                                <p class="pro__info"><?php echo $get_product['0']['short_desc']?></p>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
										<?php
										$productSoldQtyByProductId=productSoldQtyByProductId($con,$get_product['0']['id']);
										
										$pending_qty=$get_product['0']['qty']-$productSoldQtyByProductId;
										
										$cart_show='yes';
										if($get_product['0']['qty']>$productSoldQtyByProductId){
											$stock='In Stock';			
										}else{
											$stock='<i style="color:red;font-size:22px;font-family:calibri ;"> Not In Stock </i> ';
											$cart_show='';
										}
										?>
                                        <p><span>Availability:</span> <?php echo $stock?></p>
                                    </div>
									<div class="sin__desc">
										<?php
										if($cart_show!=''){
										?>
                                        <p><span>Qty:</span> 
										<select id="qty">
											<?php
											for($i=1;$i<=$pending_qty;$i++){
												echo "<option>$i</option>";
											}
											?>
										</select>
										</p>
										<?php } ?>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['categories']?></a></li>
                                        </ul>
                                    </div>
                                    
                                    </div>
									
                                </div>
								<?php
								if($cart_show!=''){
								?>
								<a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add')">Add to cart</a>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
       
		<!-- Start Product Description -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <?php echo $get_product['0']['description']?>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Description -->
        <!-- content based recomended algorithm -->
        <div class="container"> 
            <div class="row">
                <div class="row">
                <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <div class="mt-5" style="
                    text-align: center;
                    text: 25px;
                    font-size: 30px;
                    font-weight: bold;">
                        Related Products
                    </div>
                </div>
                <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        <?php
        $preferredTag = $metaTagVar;

        // Fetch Products that match the user's preferred tag
        $sql = "SELECT * FROM product WHERE  meta_tag = '$preferredTag'";
        $result = $con->query($sql);
        // Array to store recommended Products
        $recommendedProducts = array();

        // Check if there are any Products that match the preferred tag
        if ($result->num_rows > 0) {
            // Loop through each Products and calculate similarity scores
            while ($row = $result->fetch_assoc()) {
                $productId = $row["id"];
                $productTitle = $row["name"];
                $productDesc = $row["description"];
                $prodTag = $row["meta_tag"];
                $productImg = $row["image"];
                $prodPrice = $row["price"];

                // Calculate similarity score based on Products attributes (you can define your own similarity metric)
                $similarityScore = calculateSimilarity($productTitle, $productDesc, $preferredTag);

                // Store Products details along with similarity score in the recommendedProducts array
                $recommendedProducts[] = array(
                    "productId" => $productId,
                    "prodTitle" => $productTitle,
                    "prodDesc" => $productDesc,
                    "tag" => $prodTag,
                    "productImg" => $productImg,
                    "similarityScore" => $similarityScore,
                    "prodPrice" => $prodPrice
                );
            }

            // Sort recommended Products based on similarity score in descending order
            usort($recommendedProducts, function ($a, $b) {
                return $b["similarityScore"] <=> $a["similarityScore"];
            });

            // Display the recommended Products
            foreach ($recommendedProducts as $prod) {
                ?>
                <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                        <div class="category">
                            <div class="ht__cat__thumb">
                                <a href="product.php?id=<?php echo $prod['productId']?>">
                                <img src="media/product/<?php echo $prod['productImg']?>" alt="full-image"/>
                                </a>
                            </div>
                            
                            <div class="fr__product__inner">
                                <h4><a href="product-details.html"><?php echo $prod['prodTitle']?></a></h4>
                                <ul class="fr__pro__prize">
                                    <li>Rs. <?php echo $prod['prodPrice']?></li>
                                </ul>
                                <li><?php echo $prod['tag']?></li>
                            </div>
                        </div>
                    </div>
                <?php
            }
        } else {
            echo "No Product found matching your preferred tag.";
        }
        // $con->close();

        // Function to calculate similarity score (you can implement your own similarity metric)
        function calculateSimilarity($productTitle, $productDesc, $preferredTag) {
           
            return rand(1, 10);
        }
        ?>
        </div>
        </div>
        <!-- content based recomended algorithm -->
										
<?php require('footer.php')?>        