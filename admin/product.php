<?php

session_start();
require('top.inc.php');
require('function.inc.php');
require('connection.inc.php');

if(isset($_GET['type']) && $_GET['type']!='') {
    $type=get_safe_value($con,$_GET['type']);
    //update product
    if($type=='status') {
        $operation=get_safe_value($con,$_GET['operation']);
        $id=get_safe_value($con,$_GET['id']);
        if($operation=='active') {
            $status='1';
        }else{
            $status='0';
        }
        $update_status_sql="update product set status='$status' where id='$id'";
        mysqli_query($con,$update_status_sql);
    }
//delete product
    if($type=='delete') {
        $id=get_safe_value($con,$_GET['id']); 
        $delete_sql="delete from product where id='$id'";
        mysqli_query($con,$delete_sql);
    }
}

$sql="select product.* , categories.categories from product,categories where product.categories_id=categories.id  order by product.id desc";

$res=mysqli_query(mysqli_connect("localhost","root","","ecommerce"),$sql);

?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12" style="background: #fd7e14;">
                <div class="card">
                <div class="card-body">
                   <h4 class="box-title">Products</h4>
                   <h4 class="box-link"><a href="manage_product.php">Add Product</a></h4>
                </div>
                    <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th>ID</th>
                                       <th>Categories</th>
                                       <th>Name</th>
                                       <th>MRP</th>
                                       <th>Image</th>
                                       <th>Price</th>
                                       <th>Qty</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                     <?php 
                                     $i=1;
                                     while($row=mysqli_fetch_assoc($res)) {?>
                                     <tr>
                                         <td class="serial"><?php echo $i++?></td>
                                         <td><?php echo $row['id']?></td>
                                         <td><?php echo $row['categories']?></td>
                                         <td><?php echo $row['name']?></td>
                                         <td><?php echo $row['mrp']?></td>
                                         <td><img src="../media/product/<?php echo $row['image']?>"/></td>  
                                         <td><?php echo $row['price']?></td>
                                         <td><?php echo $row['qty']?>
                                         <br>
                                         <?php $productSoldQtyByProductId=productSoldQtyByProductId($con,$row['id']);
                                         $pending_qty=$row['qty']-$productSoldQtyByProductId;
                                         ?>
                                       <i style="color:red;font-size:15px;font-family:calibri;">Pending Qty </i> 
                                          <?php echo $pending_qty?>
                                         </td>
                                         <td>
                                             <?php
                                             if ($row['status']==1){
                                                 echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></span>&nbsp;";
                                             }else{
                                                echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></span>&nbsp;";
                                             }
                                             echo "<span class='badge badge-edit'><a href='manage_product.php?id=".$row['id']."'>Edit</a></span>&nbsp;";
                                             echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";
                                           
                                             
                                            ?>
                                            </td>
                                    <?php } ?>
                                 </tbody>
                              </table>
                        </div>
                     </div>
                 </div>
                </div>
            </div>
         </div>
    </div>
    
<?php
require('footer.inc.php');
?>