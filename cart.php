
<?php
$menu="cart";
include "header.php"; 
if (isset($_GET['func'])) {
    $func=$_GET['func'];
    function validate($data) {
        $data = trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
}else{
    $func='checkout';
}
if ($func=='checkout'){
    if (isset($_GET['message'])) {
        $message=$_GET['message'];
        echo "<div class ='hb15' style='color:red;text-align:center;padding-top:20px;'>";
        echo $message;
        echo "</div>";
    }
    
    if (isset($_POST['products'])){
        $member_id = $_SESSION['member_id'];
        $products = $_POST['products'];
        $select="";
        foreach ($products as $product){ 
            $select=$select.$product.", ";
        }
        // remove ", " at the end
        if(substr($select,-2)==", "){
            $select=substr($select,0,-2);
        }
    //--------UPDATE CART-----------------
        $sql = "update carts set place_order = 0 
                where product_no not in (".$select.") and member_id ='".$member_id."'";
        $result = mysqli_query($conn,$sql);

        $sql = "update carts set place_order = 1 
        where product_no in (".$select.") and member_id ='".$member_id."'";
        $result = mysqli_query($conn,$sql);
    }

?>
    <br />
    
        <form class='normal' action='cart.php?func=checkout' method = 'post' name = 'frmCart' id ='frmCart'  enctype="multipart/form-data">
            <div class = "container" style="width: 95%;">
                <div class="container" style="width: 75%;  animation: fadeInAnimation ease 2s; background-color: white; padding-left:20px;margin-left:auto;margin-right:auto;">
                    <div class = 'hb25' style="width: 100%; background-color: white; margin-left:auto;margin-right:auto; text-align:left; padding:10px; ">Shopping Cart
                        <span style='float:right; margin-right:20px; margin-bottom:5px;font-size:20px'>Price</span>
                    </div>
                    <div class="line-1" style="width:100%; padding-right:20px"></div>
                    
                        <?php     
                        $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                                , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material, p.product_price
                                , p.product_img, p.product_status, p.product_delivery, p.product_description, p.member_id, c.product_quantity, c.place_order
                                , DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL p.product_delivery DAY),'%a, %M %D, %Y') as delivery
                                , s1.policy_value as s_shipping, s2.policy_description as s_return                                
                                from products p, carts c, sale_policy s1, sale_policy s2 
                                where p.product_no = c.product_no 
                                    and p.ship_code = s1.policy_code and s1.policy_type='shipping' 
                                    and p.return_code = s2.policy_code and s2.policy_type='return'
                                    and c.member_id = '".$_SESSION['member_id']."'";
                        $result=mysqli_query($conn,$sql);
                        $count=0;
                        $subtotal=0;
                        $itemtotal=0;
                        while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                            if ($row["place_order"] ==1){
                                $count=$count + $row["product_quantity"];
                                $itemtotal = $row["product_quantity"]*$row["product_price"];
                                $subtotal= $subtotal + $itemtotal;
                            }
                            
                        ?>
                            <div class="container_cart" style="width: 100%; padding-left:20px;margin-left:auto;margin-right:auto;margin-top:20px;">
                                
                                <input type='checkbox' id='<?php echo $itemtotal;?>' value='<?php echo $row["product_no"]?>' name=products[] <?php if($row["place_order"]==1){ echo 'checked';} ?> onclick='return update_cart(this.id);'>
                                <img src='images/<?php echo $row['product_img']?>' style="width:30%; height:auto;margin-left:20px;margin-right:auto;">
                                <div class="container_vertical" style = 'width:60%;'>
                                    <div class = 'hb20' style="font-weight:bold;text-align:left;"><?php echo $row['product_name']; ?></div>
                                    <span style='float:right; margin-left:10px; font-weight:bold;'>$<?php echo number_format($row["product_price"]);?></span>
                                    <div class="line-2"></div>
                                    <br />
                                    <table style="width:100%;border:0px; margin-left: auto; margin-right: auto; align-self: flex-start;">
                                        <tr>
                                            <td style="border:0px;"><div class="hb15">ARTIRST:</div></td>
                                            <td style="border:0px;"><h5><?php echo $row['product_artist']?></h5></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><div class="hb15">MATERIAL:</div></td>
                                            <td style="border:0px;"><h5><?php echo $row['product_material']?></h5></td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="border:0px;"><div class="hb15">SIZE:</div></td>
                                            <td style="border:0px;"><h5><?php echo "$row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches" ?></h5></td>  
                                        </tr>
                                    </table>
                                    <h5 style='color:darkblue'><?php echo "Free Delivery "."<strong>".$row['delivery']."</strong>"?></h5>
                                    <h5 style='color:darkblue'><?php echo $row['s_return'] ?></h5>
                                    <br />
                                    <div class="container_horizon">
                                        <input type = "number" id = "quantity<?php echo $count; ?>" min="0" oninput="this.value = Math.abs(this.value)" style="width:50px;text-align:center;background-color:bisque;border-color:dodgerblue;border-radius:5px" value ="<?php echo $row['product_quantity'];?>">
                                        <a href = "javascript:;" onclick = "this.href='cart.php?func=update&product_no=<?php echo $row['product_no'];?>&quantity=' + document.getElementById('quantity<?php echo $count; ?>').value"><label>Update</label></a>
                                    </div>
                                    <div class="line-1"></div>
                                    <br />
                                </div>
                            </div>
                            <?php
                            }
                    ?>
                    <br />
                    </div>
                
                <div class='container' style = 'width: 20%; margin-top:0px; padding-bottom:20px'>
                    <div class='container' style = 'background:white; width: 100%; margin-top:0px; padding:10px; padding-bottom:20px'>
                        <div class="h15" style = 'margin-left:2px;padding-bottom:10px;text-align:left;'>Subtotal (<?php echo $count; echo " items): $"; echo number_format($subtotal,2);?></div>
                        <button class='button' style = 'margin-left:auto; margin-right:auto; padding-bottom:10px;border-radius:8px;'><a href='cart.php?func=order' style=' background:inherit; padding: 5px;'>Proceed to checkout</a></button>
                        <br />
                    </div>
                    <br />
                    <br />
                    <div class="hb20" style = "width: 100%; margin-top:0px; padding:10px; background:white" >Explore frequently repurchased items</div>
                    
                    <?php     
                        $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                                , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material
                                , p.product_price, p.product_img, p.product_status, p.product_delivery, p.product_description, p.member_id, c.product_quantity
                                from products p, carts c 
                                where p.product_no = c.product_no and c.member_id = '".$_SESSION['member_id']."' order by c.product_no limit 4";
                        $result=mysqli_query($conn,$sql);
                        $count=0;
                        $subtotal=0;
                        while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                        ?>
                            <div class="container_cart" style="width: 100%; padding-left:5px;margin-left:auto;margin-right:auto;">
                                
                                <img src='images/<?php echo $row['product_img']?>' style="width:45%; height:auto;margin-left:5px;margin-right:auto;">

                                <div class="container_vertical" style = 'width:50%;'>
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
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        
    </form>
<?php
//--------------UPDATE QUANTITY IN CART---------------------
}else if ($func=='update'){
    $product_no=$_GET['product_no'];
    $product_quantity=$_GET['quantity'];
    $member_id = $_SESSION['member_id'];
    

//--------UPDATE CART-----------------

    if($product_quantity>0){
        $sql = "update carts set product_quantity = ".$product_quantity. " 
            where product_no = '".$product_no."' and member_id ='".$member_id."'";
    }else{
    // delete to table carts
        $sql= " delete from carts where product_no = '".$product_no."' and member_id ='".$member_id."'";
    }
    $result = mysqli_query($conn,$sql);
    header("Location: cart.php?func=checkout");
//--------END UPDATE CART-------------------------------------

}else if ($func=='update_order'){
    $product_no=$_GET['product_no'];
    $product_quantity=$_GET['quantity'];
    $member_id = $_SESSION['member_id'];
    

//--------UPDATE CART-----------------

    if($product_quantity>0){
        $sql = "update carts set product_quantity = ".$product_quantity. " 
            where product_no = '".$product_no."' and member_id ='".$member_id."'";
    }else{
    // delete to table carts
        $sql= " delete from carts where product_no = '".$product_no."' and member_id ='".$member_id."'";
    }
    $result = mysqli_query($conn,$sql);
    header("Location: cart.php?func=order");
//-------------------PROCEED TO ORDER-------------------------
}else if ($func=='order'){

    if (isset($_GET['message'])) {
        $message=$_GET['message'];
        echo "<div class ='hb15' style='color:red;text-align:center;padding-top:20px;'>";
        echo $message;
        echo "</div>";
    }
    $sql=" select sum(product_quantity) as items from carts where place_order = 1 and member_id = '".$_SESSION['member_id']."' group by member_id";
    $result=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
    $items= $row[0];

?>
    <br />
    <form class='normal' action='order.php?func=order' method = 'post' enctype="multipart/form-data">
        <div class = "container" style="width: 95%; ">
            <div class="container" style="width: 75%;  animation: fadeInAnimation ease 2s; background-color: white; padding-left:20px;margin-left:auto;margin-right:auto;margin-top:0px;">
                <div class = 'h25' style="width: 100%; text-align: center; padding:10px; margin-left:auto;margin-right:auto; ">Checkout (<?php echo $items; ?> items)
                </div>
                <div class="line-1" style="width:100%; padding-right:20px"></div>
                
                    <?php     
                    $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                            , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material
                            , p.product_price, p.product_img, p.product_status, p.product_delivery, p.product_description, p.member_id, c.product_quantity
                            , DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL p.product_delivery DAY),'%a, %M %D, %Y') as delivery
                            , s1.policy_value as s_shipping, s2.policy_description as s_return
                            from products p, carts c, sale_policy s1, sale_policy s2 
                            where p.product_no = c.product_no and c.place_order = 1
                                    and p.ship_code = s1.policy_code and s1.policy_type='shipping' 
                                    and p.return_code = s2.policy_code and s2.policy_type='return'
                                    and c.member_id = '".$_SESSION['member_id']."'";

                    $result=mysqli_query($conn,$sql);
                    $count=0;
                    $subtotal=0;
                    $itemtotal=0;
                    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                        $count=$count + $row["product_quantity"];
                        $itemtotal = $row["product_quantity"]*$row["product_price"];
                        $subtotal= $subtotal + $itemtotal
                         
                    ?>
                        <div class="container_cart" style="width: 100%; padding-left:20px;margin-left:auto;margin-right:auto;margin-top:20px;">
                            
                            <img src='images/<?php echo $row['product_img']?>' style="width:30%; height:auto;margin-left:20px;margin-right:auto;">
                            <div class="container_vertical" style = 'width:60%;'>
                                <div class = 'hb20' style="font-weight:bold;text-align:left;"><?php echo $row['product_name']; ?></div>
                                <span style='float:right; margin-left:10px; font-weight:bold;'>$<?php echo number_format($row["product_price"]);?></span>
                                <div class="line-2"></div>
                                <br />
                                <table style="width:100%;border:0px; margin-left: auto; margin-right: auto; align-self: flex-start;">
                                    <tr>
                                        <td style="border:0px;"><div class="hb15">ARTIRST:</div></td>
                                        <td style="border:0px;"><h5><?php echo $row['product_artist']?></h5></td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;"><div class="hb15">MATERIAL:</div></td>
                                        <td style="border:0px;"><h5><?php echo $row['product_material']?></h5></td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="border:0px;"><div class="hb15">SIZE:</div></td>
                                        <td style="border:0px;"><h5><?php echo "$row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches" ?></h5></td>  
                                    </tr>
                                </table>
                                <h5 style='color:darkblue'><?php echo "Free Delivery "."<strong>".$row['delivery']."</strong>"?></h5>
                                <h5 style='color:darkblue'><?php echo $row['s_return'] ?></h5>
                                <br />
                                <div class="container_horizon">
                                    <input type = "number" id = "quantity<?php echo $count; ?>" min="0" oninput="this.value = Math.abs(this.value)" style="width:50px;text-align:center;background-color:bisque;border-color:dodgerblue;border-radius:5px" value ="<?php echo $row['product_quantity'];?>">
                                    <a href = "javascript:;" onclick = "this.href='cart.php?func=update_order&product_no=<?php echo $row['product_no'];?>&quantity=' + document.getElementById('quantity<?php echo $count; ?>').value"><label>Update</label></a>
                                </div>
                                <div class="line-1"></div>
                                <br />
                            </div>
                        </div>
                        <?php
                        }
                ?>
                <br />
                </div>
            
            <div class='container' style = 'width: 20%; margin-top:0px; padding-bottom:20px'>
                <div class='container' style = 'background:white; width: 100%; margin-top:0px; padding:10px; padding-bottom:20px; flex-direction: column;'>
                    <button type='submit' class='button' value='submit' name='submit' style = 'margin-left:auto; margin-right:auto; padding-bottom:10px'>Place your order</button>
                    <div class="hb12" style = 'margin-left:2px;padding-top:10px;padding-bottom:10px;text-align:left;'>By placing your order, you agree to the website's privacy notice and conditions of use.</div>
                    <div class="line-1" style="width:100%;margin-left:2px"></div>
                        <div class="hb20" style = 'margin-left:2px;padding-top:10px;padding-bottom:10px;text-align:left;'>Order summary</div>
                    <div class="h15" style = 'margin-left:2px;padding-bottom:10px;text-align:left;'>
                        <?php  echo "Items ("; echo $count; echo "):"; 
                        echo "<span style='float:right; margin-right:5px;'>$"; echo number_format($subtotal,2); echo "</span>";?>
                    </div>
                    <div class="h15" style = 'margin-left:2px;padding-bottom:10px;text-align:left;'>
                        <?php  echo "Shipping & handling:"; 
                        echo "<span style='float:right;margin-right:5px;'>$0.00</span>";?>
                    </div>
                    <div class="line-1" style="width:30%;margin-right:5px;margin-bottom:10px;"></div>
                    <div class="h15" style = 'margin-left:2px;padding-bottom:10px;text-align:left;'>
                        <?php  echo "Total before tax:"; 
                        echo "<span style='float:right;margin-right:5px;'>$"; echo number_format($subtotal,2); echo "</span>";?>
                    </div>
                    <div class="h15" style = 'margin-left:2px;padding-bottom:10px;text-align:left;'>
                        <?php  echo "Estimate tax to be collected:"; 
                        echo "<span style='float:right;margin-right:5px;'>$"; echo number_format($subtotal*0.085,2); echo "</span>";?>
                    </div>
                    <div class="line-1" style="width:100%;margin-left:2px;margin-bottom:10px;"></div>
                    <div class="hb20" style = 'margin-left:2px;padding-bottom:10px;text-align:left;color:red'>
                        <?php  echo "Order total:"; 
                        echo "<span style='float:right;margin-right:5px;'>$"; echo number_format($subtotal*1.085,2); echo "</span>";?>
                    </div>
                </div>
                <br />
                <br />
                <div class="hb20" style = "width: 100%; margin-top:0px; padding:10px; background:white" >Explore frequently repurchased items</div>
                <?php     
                    $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                            , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material
                            , p.product_price, p.product_img, p.product_status, p.product_delivery, p.product_description, p.member_id, c.product_quantity
                            from products p, carts c 
                            where p.product_no = c.product_no and c.member_id = '".$_SESSION['member_id']."' order by c.product_no limit 4";
                    $result=mysqli_query($conn,$sql);
                    $count=0;
                    $subtotal=0;
                    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    ?>
                        <div class="container_cart" style="width: 100%; padding-left:5px;margin-left:auto;margin-right:auto;">
                            
                            <img src='images/<?php echo $row['product_img']?>' style="width:45%; height:auto;margin-left:5px;margin-right:auto;">

                            <div class="container_vertical" style = 'width:50%;'>
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
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </form>
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
<script type="text/javascript">
    function update_cart(id) {
        form = document.getElementById('frmCart');
        HTMLFormElement.prototype.submit.call(form);
    }
</script>
</body>