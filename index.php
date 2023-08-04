<?php
require('top.php');

?>

<div class="body__overlay"></div>
    
        <div class="slider__container slider--one bg__cat--3">
            <div class="slide__container slider__activation__wrap owl-carousel">
                <div class="single__slide animation__style01 slider__fixed--height" style="background-color: antiquewhite;">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>collection 2022</h2>
                                        <h1>IPHONE 13</h1>
                                        <div class="cr__btn">
                                            <a href="cart.php">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="images/slider/fornt-img/1.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single__slide animation__style01 slider__fixed--height"style="height: 604px;">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>collection 2023</h2>
                                        <h1>MI mobile</h1>
                                        <div class="cr__btn">
                                            <a href="cart.php">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="images/slider/fornt-img/2.webp" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="htc__category__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <h2 class="title__line">New Arrivals</h2>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30">
                            <?php
                            $get_product=get_product($con,18);
                            foreach($get_product as $list){
                            ?>
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']?>">
                                           
                                            <img src="media/product/<?php echo $list['image']?>"/>
                                        </a>
                                    </div>
                                   
                                  
                                    <div class="fr__product__inner">
                                        <h4><a href="product-details.html"><?php echo $list['name']?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize"><s>Rs. <?php echo $list['mrp']?></s></li>
                                            <li>Rs. <?php echo $list['price']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
        
                        </div>
                    </div>
                </div>
            </div>
        </section>
       
 <?php
require('footer.php');

?>