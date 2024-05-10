
<?php
$menu="order";
include "header.php"; 
if(empty($_SESSION['member_id'])){
    header('location: home.php');
}
if (isset($_GET['func'])) {
    $func=$_GET['func'];
    function validate($data) {
        $data = trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
}else{
    $func='view';
}
if ($func=='view'){
    if (isset($_GET['message'])) {
        $message=$_GET['message'];
        echo "<div class ='hb15' style='color:red;text-align:center;padding-top:20px;'>";
        echo $message;
        echo "</div>";
    }
    $view_status="<>'Completed'";
    if (isset($_GET['status'])) {
        $status =$_GET['status'];
        if($status=='completed'){
           $view_status=" = 'completed'";
        }
        if($status=='notcompleted'){
            $view_status=" <> 'completed'";
        }
    
    }

?>
    <br />
        
    <div class = "container" style="width: 80%;">
        <div class="container" style="width: 60%;  animation: fadeInAnimation ease 2s; background-color: white; padding-left:20px;margin-left:auto;margin-right:auto;margin-top:0px">
            
            <div class='container' style='width:100%; margin-left:0px'>
                <div class = 'hb25' style='width: 70%; background-color: white; margin-left:auto;margin-right:auto; text-align:left; padding:10px; '>Your History Orders</div>
                <div class = 'h15' style='width: 26%; background-color: white; margin-left:auto;margin-right:0; margin-top:auto; margin-bottom:auto; '>
                    <a class='icon' href='order_history.php?func=view&status=notcompleted'><button class='button' style='font-size:12px; color: black; background:orange; width:100px; '>Not completed</button></a>
                    <a class='icon' href='order_history.php?func=view&status=completed'><button class='button' style='font-size:12px; color: black; background:orange; width:100px; '>Completed</button></a>
                </div>
                
            </div>
            <div class="line-1" style="width:100%; padding-right:20px"></div>
                <?php
                $sql="  select order_no, DATE_FORMAT(order_date,' %M %D, %Y') as order_date, subtotal, tax, total, card_no, order_ship_name
                        , CONCAT(order_ship_street,', ', order_ship_city, ', ', order_ship_state, ', ', order_ship_zipcode) as address, ship_fee
                        , tracking_no, order_status      
                    from orders 
                    where member_id = '".$_SESSION['member_id']."' and order_status $view_status order by order_no desc";
                $order=mysqli_query($conn,$sql);
                
                while($row = mysqli_fetch_array($order, MYSQLI_BOTH)) {
                    $order_no = $row['order_no'];
                    $order_status = $row['order_status'];
                    echo "<div class='container' style='width:100%;background-color: lightgrey; padding:0px; margin-left:0;'>";
                        
                        echo "<div class = 'container' style='width:18%; margin-left:0px; margin-top:0px;padding:10px;'>";
                            echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left; padding-bottom:10px;'>ORDER PLACED</div>";
                            echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left;'>$row[order_date]</div>";
                        echo "</div>";
                        echo "<div class = 'container' style='width:18%; margin-left:0px; margin-top:0px; padding:10px;'>";
                            echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left; padding-bottom:10px;'>TOTAL</div>";
                            echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left;'>$"; echo number_format($row['total'],2); echo "</div>";
                        echo "</div>";
                        echo "<div class = 'container' style='width:30%; margin-left:0px; margin-top:0px; padding:10px;'>";
                            echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left; padding-bottom:10px;'>SHIP TO: $row[order_ship_name]</div>";
                            echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left;'>$row[address]</div>";
                        echo "</div>";
                        echo "<div class = 'container' style='width:18%;  margin-right:0px; margin-top:0px; padding:10px;'>";
                            echo "<div class = 'hb15' style='width: 100%; margin-right:0px; text-align:right; padding-bottom:10px;'>ORDER #$row[order_no]</div>";
                            
                        echo "</div>";
                        
                    echo "</div>";    
                    echo "<div class = 'line-1' style= 'padding:0px'></div>";
                    echo "<div class='container' style='width:100%; padding:0px;'>";
                        echo "<div class = 'hb15' style='font-weight:bold;text-align:left;margin-top:10px;'>Status: $order_status</div><br />";
                    echo "</div>";
                    $sql="  select o.order_no, p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                            , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material, p.product_price
                            , p.product_img, d.product_status, d.delivery_date, DATE_FORMAT(d.delivery_date,' %M %D, %Y') as delivery_day, p.product_description, d.product_quantity          
                            from products p, orders o, orders_detail d 
                            where o.order_no = d.order_no and p.product_no = d.product_no 
                                and o.order_no = '".$order_no."' and o.member_id = '".$_SESSION['member_id']."' order by d.delivery_date";
                    $result=mysqli_query($conn,$sql);
                    $group_date_delivery ='';
                    $show_date='';
                    $new_group=1;
                    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                        $product_no = $row['product_no'];
                        $product_status=$row['product_status'];
                        if ($group_date_delivery == $row['delivery_day']){
                            $show_date = '';
                            $new_group=0;
                        }else{
                            
                            if ($row['delivery_date']>date("Y-m-d")){
                                $show_date = 'Estimate: '.$row['delivery_day'];
                            }else{
                                $show_date = 'Delivery: '.$row['delivery_day'];
                            }
                            $group_date_delivery= $row['delivery_day'];
                            $new_group = 1;
                        }
                    ?>
                        <div class = 'hb15' style="font-weight:bold;text-align:left;margin-top:10px;"><?php echo $show_date; ?></div>
                        <div class="container_horizon" style="width: 100%; padding-left:20px;margin-left:auto;margin-right:auto;margin-top:10px;padding-top:0px;">
                            <div class="container" style="width: 15%;margin-left:0px;margin-right:auto;margin-top:0px;padding-top:0px;">
                                
                                <img src='images/<?php echo $row['product_img']?>' style="width:100px; height:auto;margin-left:5px; ,magin-top:0px;">
                            </div>
                            <div class="container_vertical" style = 'width:60%; height:auto;margin-left:20px;margin-right:auto; margin-top:0px;padding-top:0px;'>
                                <div class = 'hb15' style="font-weight:bold;text-align:left;margin-top:0px;"><?php echo $row['product_name']; ?></div>
                                <div class="line-2" style='margin-bottom:0px;padding:0px;'></div>
                                <table style="width:100%; border:0px; margin-top:0px; margin-left: 0px; align-self: flex-start;">
                                    <tr>
                                        <td style="border:0px;">
                                            <div class="hb12">ARTIRST: <?php echo $row['product_artist']?></div>
                                            <div class="hb12">MATERIAL: <?php echo $row['product_material']?></div>
                                            <div class="hb12">SIZE: <?php echo "$row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches" ?></div>
                                        </td> 
                                    </tr>
                                </table>
                                <div class="line-1"></div>
                            </div>
                            <div class="container_vertical" style = 'width:20%; height:auto;margin-right:auto; margin-top:0px;padding-top:0px;'>
                            <?php
                                if ($product_status =='In process'){
                                    echo "<a class='icon' href='order_return.php?func=view&action=cancelitem&order_no=$order_no&product_no=$product_no'><button class='button' style='font-size:12px; color: black; background:bisque; width:120px; '>Cancel item</a>";
                                }else if ($product_status =='Shipped'){
                                    echo "<div class='hb15' class='hb15' style='padding:20px'>Shipped</div>";
                                }else if ($product_status =='Delivered'){
                                    echo "<div class='hb15' style='padding-left:20px'>Delivered</div>";
                                    echo "<a class='icon' href='order_return.php?func=view&action=returnitem&order_no=$order_no&product_no=$product_no'><button class='button' style='font-size:12px; color: black; background:bisque; width:120px; '>Return</a>";
                                }else if ($product_status =='Cancelled'){
                                    echo "<div class='hb15' style='padding:20px'> Cancelled</div>";
                                }else if ($product_status =='Cancelleds'){
                                    echo "<div class='hb15' style='padding:20px'> Cancelled by the Seller</div>";
                                }else if ($product_status =='Returned'){
                                    echo "<div class='hb15' style='padding-left:20px'>Returned</div>";
                                }
                            ?>
                            </div>
                        </div>
                        <?php
                        }
                }
            ?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            </div>
        
        <div class='container' style = 'width: 35%; margin-top:0px; padding-bottom:20px;background:white'>
            <div class="hb20" style = "width: 100%; margin-top:0px; padding:10px; background:white" >Explore frequently repurchased items</div>
            <?php     
                $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                        , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material
                        , p.product_price, p.product_img, p.product_status, p.product_delivery, p.product_description, p.member_id
                from products p
                where p.product_no in (select product_no from orders_detail group by product_no) limit 3";

                $result=mysqli_query($conn,$sql);
                $count=0;
                $subtotal=0;
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                ?>
                    <div class="container_horizon" style="width: 50%; padding-bottom:5px;margin-left:auto;margin-right:auto;">
                        <a class='icon' href='shopping.php?func=view&product_no=<?php echo $row['product_no']; ?>'>
                            <img src='images/<?php echo $row['product_img']?>' style="width:100%; height:auto;margin-left:5px;margin-right:auto;">
                        </a>
                    </div>
                    <div class="container_vertical" style = 'width:45%;background:white' >
                        <div class = 'hb15' style="font-weight:bold;text-align:left; margin-bottom:0px"><?php echo $row['product_name']; ?></div>
                        <br />
                        <table style="width:100%;border:0px; margin-top: 0px; margin-left: auto; margin-right: auto; align-self: flex-start;">
                            <tr>
                                <td style="border:0px; margin-bottom: 0px;"><div class="hb12">ARTIRST:</div></td>
                                <td style="border:0px;"><div class="hb12"><?php echo $row['product_artist']?></div></td>
                            </tr>
                            <tr>
                                <td style="border:0px;"><div class="hb12">MATERIAL:</div></td>
                                <td style="border:0px;"><div class="hb12"><?php echo $row['product_material']?></div></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border:0px;"><div class="hb12">$<?php echo number_format($row["product_price"]);?></div></td>
                            </tr>
                        </table>
                        <div class="line-1"></div>
                    </div>
                    <?php
                }
            ?>
        </div>
        
    </div>
<?php

}else if ($func=='message'){
?>
    <div class = 'hb'>$_GET[content]</div>";
    <br />";
    <center><a href='shopping.php?func=list_product' style ='background-color:orange;'>Back to the list...</a></center>";
<?php
}
    include "footer.php";
?>

</body>