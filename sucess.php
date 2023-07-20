<?php
require('top.php');
include('checkout.php');

if(isset($_GET['oid'])){
    $pid = $_GET['oid'];
    var_dump($pid);
    $orderstatus = "UPDATE order SET order_status = '1' WHERE id = '$pid'";
    var_dump($orderstatus);
    $orderstatusQuery = mysqli_query($con, $orderstatus);
}
?>

<div class="container" xmlns="http://www.w3.org/1999/html">
    <strong></strong> <p class="text-center text-info after-book-info">
        Thank you for investing your precious time and money on our GadgetNepal. You can view your package details from dashboard
    </p></strong>
    <a href="index.php" class="btn btn-primary bookDashboard">Go to dashboard</a>
</div>

<?php include "footer.php"?>