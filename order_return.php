
<?php

$menu="orders";
include "header.php"; 

if (isset($_GET['action'])) {
    $action =$_GET['action'];
    //-------------Update cancelling item status------------------
    if($action=='cancelitem'){
        $order_no = $_GET['order_no'];
        $product_no = $_GET['product_no'];
        $sql="  update orders_detail set product_status='Cancelled', status_date = NOW() 
                where order_no= '".$order_no."' and product_no='".$product_no."'";
        $update=mysqli_query($conn,$sql);
    }
    //-------------Update shipping status-------------------------
    if($action=='returnitem'){
        $order_no= $_GET['order_no'];
        $product_no = $_GET['product_no'];
        $sql="  update orders_detail set product_status='Returned', status_date = NOW()
                    where order_no= '".$order_no."' and product_no='".$product_no."'";
        $update=mysqli_query($conn,$sql);
    }
    header("Location:order_history.php?func=view");
}
?>