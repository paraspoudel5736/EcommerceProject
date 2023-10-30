<?php
session_start();
require('top.inc.php');
require('function.inc.php');
require('connection.inc.php');


$categories_id='';
$name='';
$mrp='';
$price='';
$qty='';
$image='';
$short_desc='';
$description='';
$meta_tag='';


$msg='';
$image_required='required';

if(isset($_GET['id']) && $_GET['id']!=''){
   $image_required='';
    $id=get_safe_value($con,$_GET['id']);
    $res=mysqli_query($con,"select * from product where id='$id'");
   
    $check=mysqli_num_rows($res);
     if($check>0){
      mysqli_query($con,"update product set categories_id='$categories_id',name='$name', 
      mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',
      meta_tag='$meta_tag' where id='$id'");

    $row=mysqli_fetch_assoc($res);
    $categories_id=$row['categories_id'];
    $name=$row['name'];
    $mrp=$row['mrp'];
    $price=$row['price'];
    $qty=$row['qty'];
    $short_desc=$row['short_desc'];
    $description=$row['description'];
    $meta_tag=$row['meta_tag'];
   
    
     }else{
        header('location:product.php');
        die();
     }
}
$nameError='';



if(isset($_POST['submit'])) {
 
 

    $categories_id=get_safe_value($con,$_POST['categories_id']);
    $name=get_safe_value($con,$_POST['name']);
    $mrp=get_safe_value($con,$_POST['mrp']);
    $price=get_safe_value($con,$_POST['price']);
    $qty=get_safe_value($con,$_POST['qty']);
    $short_desc=get_safe_value($con,$_POST['short_desc']);
    $description=get_safe_value($con,$_POST['description']);
    $meta_tag=get_safe_value($con,$_POST['meta_tag']);
   

    $res=mysqli_query(mysqli_connect("localhost","root","","ecommerce"),"select * from product where name='$name'");
    //check if the categories is already in database or not
    $check=mysqli_num_rows($res);
    if($check>0){
        if(isset($_GET['id']) && $_GET['id']!=''){
         $getData=mysqli_fetch_assoc($res);
         if($id==$getData['id']){

         }else{
            $msg="Product already exist";
         }

        }else{

        $msg="Product already exist";
        }
    }


    if($msg==''){
        if(isset($_GET['id']) && $_GET['id']!=''){
            mysqli_query($con,"update product set categories_id='$categories_id',name='$name', 
            mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',
            meta_tag='$meta_tag' where id='$id'");

        }else{
           $image=rand(1111,9999).'_'.$_FILES['image']['name'];
           move_uploaded_file($_FILES['image']['tmp_name'],'../media/product/'.$image);
        mysqli_query($con,"insert into product(categories_id,name,mrp,price,qty,short_desc,
        description,meta_tag,status,image)
        values('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_tag',
        1,'$image')");
    
        }
        header('location:product.php');
        die();
    }
}

?>


<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12" style="background: #fd7e14;">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <div class="card-body card-block">
                           <div class="form-group">
                               <label for="categories" class=" form-control-label">Categories</label>
                              <select class="form-control" name="categories_id">
                                 <option>Select Category</option>
                                 <?php
                                 $res=mysqli_query(mysqli_connect("localhost","root","","ecommerce"),"select
                                 id,categories from categories order by categories asc");
                                 while($row=mysqli_fetch_assoc($res)){
                                    if($row['id']==$categories_id){
                                       echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                    }else{
                                       echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                    }
                                    }
                                 ?>
                              </select>
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Product Name</label>
                               <input type="text" name="name" placeholder="Enter your product name"
                                class="form-control"  value="<?php echo $name?>">
                                
                                
                            </div>


                            <div class="form-group">
                               <label for="categories" class=" form-control-label">MRP</label>
                               <input type="text" name="mrp" placeholder="Enter your product mrp"
                                class="form-control"  value="<?php echo $mrp?>">
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Price</label>
                               <input type="text" name="price" placeholder="Enter your product price"
                                class="form-control"  value="<?php echo $price?>">
                            </div>
                            
                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Qty</label>
                               <input type="text" name="qty" placeholder="Enter qty"
                                class="form-control"  value="<?php echo $qty?>">
                            </div>
                           
                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Image</label>
                               <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/jpg"/>
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Short Description</label>
                               <input type="text" name="short_desc" placeholder="Enter product short description"
                                class="form-control" ><?php echo $short_desc?>
                              </textarea>
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Description</label>
                               <input type="text" name="description" rows="4" cols="50" placeholder="Enter  product  description"
                                class="form-control"  ><?php echo $description?>
                              </textarea>
                            </div>

                            <div class="form-group">
                               <label for="categories" class=" form-control-label">Meta Tag</label>
                               <input type="text" name="meta_tag" placeholder="Enter product meta tag"
                                class="form-control"><?php echo $meta_tag?>
                              </textarea>
                            </div>

                            

                           <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                           <div class="field_error"><?php echo $msg?></div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <script>
    function validateForm() {
      
        var priceInput = document.getElementsByName("price")[0];
        var mrpInput = document.getElementsByName("mrp")[0];
        var qtyInput = document.getElementsByName("qty")[0];

        var categoriesId = document.getElementsByName("categories_id")[0].value;
       var productName = document.getElementsByName("name")[0].value;
       var image = document.getElementsByName("image")[0].value;
       var shortDesc = document.getElementsByName("short_desc")[0].value;
       var description = document.getElementsByName("description")[0].value;
       var metaTag = document.getElementsByName("meta_tag")[0].value;
      
        var errorMessage = document.getElementsByClassName("field_error")[0];
        var priceValue = parseFloat(priceInput.value);
        var mrpValue = parseFloat(mrpInput.value);
        var qtyValue = parseFloat(qtyInput.value);
        if (isNaN(priceValue) || priceValue <= 0) {
            errorMessage.textContent = "Price must be a positive number.";
            return false;
        }

        if (isNaN(mrpValue) || mrpValue <= 0) {
            errorMessage.textContent = "Mrp must be a positive number.";
            return false;
        }

        if (isNaN(qtyValue) || qtyValue <= 0) {
            errorMessage.textContent = "qty must be a positive number.";
            return false;
        }
       
        if (
           categoriesId === "" ||
           productName === "" ||
           image === "" ||
           shortDesc === "" ||
           description === "" ||
           metaTag === "" 
       ) {
           errorMessage.textContent = "All fields are required.";
           return false;
       } else {
           errorMessage.textContent = "";
           return true;
       }
    

        errorMessage.textContent = ""; // Clear any previous error message
        return true;
    }
</script>

<?php
require('top.inc.php');
?>