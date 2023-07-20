<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($con,$str){
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}

function get_product($con,$limit='',$cat_id='',$product_id='',$search_str='',$sort_order=''){	
	$sql="select product.*,categories.categories from product,categories where product.status=1 ";
	if($cat_id!=''){
		$sql.=" and product.categories_id=$cat_id ";
	}
	if($product_id!=''){
		$sql.=" and product.id=$product_id ";
	}
	$sql.=" and product.categories_id=categories.id ";

	if($search_str!=''){
		$sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%')";
	}
	if($sort_order!=''){
		$sql.=$sort_order;
	}
	else{
		$sql.=" order by product.id desc";
	}
	
	if($limit!=''){
		$sql.=" limit $limit";
	}
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function productSoldQtyByProductId($con,$pid){
	$sql="select sum(order_detail.qty) as qty from order_detail,`order` where 
	`order`.id=order_detail.order_id and order_detail.product_id=$pid and 
	`order`.order_status!=4 and ((`order`.payment_type='esewa' and `order`.payment_status='Success') or (`order`.payment_type='COD' and `order`.payment_status!=''))";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function  get_related_products($con, $pid) {
    $query = "SELECT description FROM product WHERE id = ?";
	$productDescription="";
	$relatedProductId="";
	$relatedProductName="";
	$relatedImage="";
	$relatedPrice="";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->bind_result($productDescription);
    $stmt->fetch();
    $stmt->close();
    
    $query = "SELECT id, image, name, price FROM product WHERE MATCH (description) AGAINST (?) AND id != ? LIMIT 5";
    $stmt = $con->prepare($query);
    $stmt->bind_param("si", $productDescription, $pid);
    $stmt->execute();
    $stmt->bind_result($relatedProductId,$relatedImage, $relatedProductName,  $relatedPrice);
    
    $relatedProducts = array();
    while ($stmt->fetch()) {
        $relatedProducts[] = array('id' => $relatedProductId, 'image' => $relatedImage,'name' => $relatedProductName, 'price' => $relatedPrice );
    }
    $stmt->close();
    
    return $relatedProducts;
}


function productQty($con,$pid){
	$sql="select qty from product where id='$pid'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

?>