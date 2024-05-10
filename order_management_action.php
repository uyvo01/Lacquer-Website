
<?php

$menu="order_management";
include "header.php"; 
if($_SESSION["usertype"]<>"A" && $_SESSION["usertype"]<>"S"){
    header('location: home.php');
}
if (isset($_GET['action'])) {
    $action =$_GET['action'];
    //-------------Update cancelling item status------------------
    if($action=='cancelitem'){
        $order_no = $_GET['order_no'];
        $product_no = $_GET['product_no'];
        $sql="  update orders_detail set product_status='Cancelleds', status_date = NOW() 
                where order_no= '".$order_no."' and product_no='".$product_no."'";
        echo $sql;
        $update=mysqli_query($conn,$sql);
    }
    //-------------Update shipping status-------------------------
    if($action=='shiporder'){
        $order_no= $_GET['order_no'];
        $delivery_date = $_GET['group_date'];
        $sql="  update orders_detail set product_status='Shipped', status_date = NOW() 
                    where order_no= '".$order_no."' and product_status = 'In process' and delivery_date = '".$delivery_date."'";
        $update=mysqli_query($conn,$sql);

        $sql = " select order_no from orders_detail where order_no= '".$order_no."' and product_status = 'In process'";
        echo $sql;
        $result=mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) === 0){
            $sql="  update orders set order_status='Shipped'
            where order_no= '".$order_no."'";
            $update=mysqli_query($conn,$sql);
        }
    }
        //-------------Update delivering status-------------------------
    if($action=='deliverorder'){
        $order_no= $_GET['order_no'];
        $delivery_date = $_GET['group_date'];
        $sql="  update orders_detail set product_status='Delivered', status_date = NOW()
                    where order_no= '".$order_no."' and product_status='Shipped' and delivery_date = '".$delivery_date."'";
        $update=mysqli_query($conn,$sql);
        
        $sql = " select order_no from orders_detail where order_no= '".$order_no."' and product_status = 'Shipped'";
        echo $sql;
        $result=mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) === 0){
            $sql="  update orders set order_status='Completed'
            where order_no= '".$order_no."'";
            $update=mysqli_query($conn,$sql);
        }
    }
    if($action=='returnitem'){
        $order_no= $_GET['order_no'];
        $product_no = $_GET['product_no'];
        $sql="  update orders_detail set product_status='Returned', status_date = NOW()
                    where order_no= '".$order_no."' and product_no='".$product_no."'";
        $update=mysqli_query($conn,$sql);
        header("Location:order_history.php?func=view");
       
    }
    header("Location:order_management.php?func=list_order_management");
}
?>