
<?php
$menu="order";
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
    $func='order';
}
if (isset($_GET['card'])) {
    $card=$_GET['card'];
}else{
    $card='no';
}
if (isset($_GET['card_no'])) {
    $card_no=$_GET['card_no'];
}else{
    $card_no='';
}
if (isset($_GET['address'])) {
    $address=$_GET['address'];
}else{
    $address='';
}
//-------------------PLACE ORDER-------------------------
$member_id = $_SESSION['member_id'];
if ($func=='order'){

    if (isset($_GET['message'])) {
        $message=$_GET['message'];
        echo "<div class ='hb15' style='color:red;text-align:center;padding-top:20px;'>";
        echo $message;
        echo "</div>";
    }
    //-------------ADD PAYMENT-------------------------------
    if($card=='add'){
        $card_holder_name = $_POST['card_holder_name'];
        $card_no = $_POST['card_no'];
        $card_exp_month = $_POST['card_exp_month'];
        $card_exp_year = $_POST['card_exp_year'];
        $card_cvv = $_POST['card_cvv'];
        
        $sql="select card_no from payments where card_no = '".$card_no."'";
        $result=mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);

        if($num>0){
            echo "Card exists!";
        }else{
        // insert to table payments
            $sql= " insert into payments(member_id, card_holder_name, card_no, card_exp_month, card_exp_year, card_cvv,card_default) 
                    values('".$member_id."','".$card_holder_name. "','".$card_no."',".$card_exp_month.",".$card_exp_year.",'".$card_cvv."',1)";
            $result = mysqli_query($conn,$sql);
        }
    }
    //-------------REMOVE CARD-------------------------------
    if($card=='remove'){
        $card_no = $_GET['card_no'];
        $sql="delete from payments where card_no = '".$card_no."'";
        $result=mysqli_query($conn,$sql);
    }
    //---------------END REMOVE CARD----------------------------

    //---------------GET SHIPPING INFO---------------
    //----- get number of checkout items---------
    $sql=" select sum(product_quantity) as items from carts where place_order = 1 and member_id = '".$_SESSION['member_id']."' group by member_id";
    $result=mysqli_query($conn,$sql);
    $items_num = mysqli_fetch_array($result, MYSQLI_BOTH);
    $items= $items_num[0];
    
    $card_selected="";
    if($address=='other'){
        $name=$_POST["oname"];
        $street=$_POST["ostreet"];
        $city=$_POST["ocity"];
        $state=$_POST["ostate"];
        $zipcode=$_POST["ozipcode"];
    }else{
        //----- get shipping information-------------
        $sql=" select concat(firstname,' ', lastname) as name, street_no, city, state, zipcode from members where member_id = '".$_SESSION['member_id']."'";
        $result=mysqli_query($conn,$sql);
        $shipping = mysqli_fetch_array($result, MYSQLI_BOTH);
        $name=$shipping["name"];
        $street=$shipping["street_no"];
        $city=$shipping["city"];
        $state=$shipping["state"];
        $zipcode=$shipping["zipcode"];
    }
    
?>
    <br />
    
    <div class = "container" style="width: 95%; min-width:700px;padding-bottom:50px ">
        
        <div class="container" style="background-color: white; width: 60%; animation: fadeInAnimation ease 2s; padding-left:20px;margin-right:0px;margin-top:0px;">
            <div class = 'h25' style="width: 100%; text-align: center; padding:10px; margin-left:auto;margin-right:auto; ">Checkout (<?php echo $items; ?> items)
            </div>
            <div class="line-1" style="width:100%; padding-right:20px;padding-top:0px"></div>
            <div class="container" style="width: 100%; background-color: white; margin-left:auto;margin-right:auto;">
                    <div class="hb20" style="width: 20%;  margin-top:0px;padding:10px;">1. Shipping address</div>
                    <div class="container_vertical" style="width: 75%; margin-top:0px;padding:10px; margin-left:0;">
                        <div class="h15" style = "margin-bottom:10px;" ><?php echo $name; ?></div>
                        <div class="h15" style = "margin-bottom:10px;"><?php echo $street; ?></div>
                        <div class="h15" ><?php echo $city.', '.$state.' '.$zipcode; ?></div>
                        <button><a style='padding:0px;background:inherit' href='order.php?func=order&address=new' >Other</a></button>
                        <?php if($address=='new'){ ?>                            
                        <form class='normal' action='order.php?func=order&address=other' method = 'post' enctype="multipart/form-data" style="width: 100%; background:white;">
                            <div class="container" style="margin-top:0px;margin-bottom:0px;padding:0px">
                                <table style="width:100%">
                                    <tr><td colspan="2" style="text-align: right;"><button><a style='padding:0px;background:inherit' href='order.php?func=order&address=no'>X</a></button></td></tr>
                                    <tr><td width="200px">Name<font color='red'>* </td><td><input style="width:300px" type="textbox" required='required' class='textbox' name='oname' /></td></tr>
                                    <tr><td width="200px">Street #<font color='red'>* </td><td><input style="width:300px" type="textbox" required='required' class='textbox' name='ostreet' /></td></tr>
                                    <tr><td width="200px">City<font color='red'>*</td><td><input style="width:300px" type='text' class='textbox' name='ocity' /></td></tr>
                                    <tr><td width="200px">State<font color='red'>*</td><td><input style="width:300px" type='text' minlength='2' maxlength='2' class='textbox' name='ostate'/></td></tr>
                                    <tr><td width="200px">Zip code<font color='red'>*</td><td><input style="width:300px" type='text' minlength='5' maxlength='5' class='textbox' name='ozipcode'/></td></tr>
                                    <tr><td></td><td><button type="submit" value ="submit">Submit</button></td></tr>
                                </table>
                            </div>
                        </form>
                        <?php } ?>

                    </div>
            </div>

            <div class="line-1" style="width:100%; padding-right:20px"></div>
            <div class="container" style="width: 100%; background-color: white; margin-left:auto;margin-right:auto;">
                    <div class="hb20" style="width: 20%;  margin-top:0px;padding:10px;">2. Payment method</div>
                    <div class="container_vertical" style="width: 75%; margin-top:0px;padding:10px; margin-left:0;">
                        <div class="h15" style = "margin-bottom:10px;">Billing address: Same as shipping address.</div>
                        <table style="width:100%; border:none;">
                            <tr>
                                <td colspan="2" style="border:none;"><div class="h15">Choose a payment method</div></td>
                                <td style="border:none;"><div class='h15'>Name on card</div></td>
                                <td style="border:none;"><div class='h15'>Expires on</div></td>
                                <td style="border:none;"></td>
                            </tr>
                        <?php 
                            //----- get cards information-------------
                        $sql="  select card_holder_name, card_no, card_exp_month, card_exp_year, card_cvv, card_default from payments where member_id = '".$_SESSION['member_id']."' 
                                order by card_default desc";
                        $result=mysqli_query($conn,$sql);
                        
                        while($cards = mysqli_fetch_array($result, MYSQLI_BOTH)){
                            
                            $card_no_4=substr($cards['card_no'],12,16);
                            if($cards['card_default']){
                                $card_selected = $cards['card_no'];
                                echo "<tr><td style='border:none;'><input type='radio' id='' name='card_no' value='$cards[card_no]' onchange='handleChange(this);' checked></td>";
                            }else{
                                echo "<tr><td style='border:none;'><input type='radio' id='' name='card_no' value='$cards[card_no]' onchange='handleChange(this);'></td>";
                            }
                            
                            echo "<td style='border:none;'><div class='h15'>Visa ending in $card_no_4</div></td>";
                            echo "<td style='border:none;'><div class='h15'>$cards[card_holder_name]</div></td>";
                            echo "<td style='border:none;'><div class='h15'>$cards[card_exp_month]/$cards[card_exp_year]</div></td>";
                            echo "<td style='border:none;'><a href='order.php?func=order&card=remove&card_no=$cards[card_no]' class='icon' style='color:darkblue'>remove</a></td></tr>";
                        };

                        ?>
                        </table>
                        
                        <button><a style='padding:0px;background:inherit' href='order.php?func=order&card=new' >Add card</a></button>
                        <?php if($card=='new'){ ?>                            
                        <div class="container" style="margin-top:0px;margin-bottom:0px;padding:0px">
                            <form class='normal' action='order.php?func=order&card=add' method = 'post' enctype="multipart/form-data" style="width: 100%; background:white;">
                                <table style="width:100%">
                                    <tr><td colspan="2" style="text-align: right;"><button><a style='padding:0px;background:inherit' href='order.php?func=order&card=no'>X</a></button></td></tr>
                                    <tr><td width="200px">Name on card<font color='red'>* </td><td><input style="width:200px" type="textbox" required='required' class='textbox' name='card_holder_name' style='text-transform:uppercase' /></td></tr>
                                    <tr><td width="200px">Card number (16 digits)<font color='red'>*</td><td><input style="width:200px" type='text' minlength='16' maxlength='16' class='textbox' name='card_no' onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/></td></tr>
                                    <tr><td width="200px">Expiration date<font color='red'>*</td>
                                    <td>
                                        
                                        <select name="card_exp_month" id="card_exp_month" style="width: 50px;height:30px; border-radius: 8px;">
                                            <option value="1" <?php if (date('m')==1) {echo "selected";}?>>1</option>
                                            <option value="2" <?php if (date('m')==2) {echo "selected";}?>>2</option>
                                            <option value="3" <?php if (date('m')==3) {echo "selected";}?>>3</option>
                                            <option value="4" <?php if (date('m')==4) {echo "selected";}?>>4</option>
                                            <option value="5" <?php if (date('m')==5) {echo "selected";}?>>5</option>
                                            <option value="6" <?php if (date('m')==6) {echo "selected";}?>>6</option>
                                            <option value="7" <?php if (date('m')==7) {echo "selected";}?>>7</option>
                                            <option value="8" <?php if (date('m')==8) {echo "selected";}?>>8</option>
                                            <option value="9" <?php if (date('m')==9) {echo "selected";}?>>9</option>
                                            <option value="10" <?php if (date('m')==10) {echo "selected";}?>>10</option>
                                            <option value="11" <?php if (date('m')==11) {echo "selected";}?>>11</option>
                                            <option value="12" <?php if (date('m')==12) {echo "selected";}?>>12</option>
                                        </select>
                                        <select name="card_exp_year" id="card_exp_year" style="width: 70px;height:30px; border-radius: 8px;">
                                            <option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
                                            <option value="<?php echo date('Y')+1;?>"><?php echo date('Y')+1;?></option>
                                            <option value="<?php echo date('Y')+2;?>"><?php echo date('Y')+2;?></option>
                                            <option value="<?php echo date('Y')+3;?>"><?php echo date('Y')+3;?></option>
                                            <option value="<?php echo date('Y')+4;?>"><?php echo date('Y')+4;?></option>
                                            <option value="<?php echo date('Y')+5;?>"><?php echo date('Y')+5;?></option>
                                            <option value="<?php echo date('Y')+6;?>"><?php echo date('Y')+6;?></option>
                                            <option value="<?php echo date('Y')+7;?>"><?php echo date('Y')+7;?></option>
                                            <option value="<?php echo date('Y')+8;?>"><?php echo date('Y')+8;?></option>
                                            <option value="<?php echo date('Y')+9;?>"><?php echo date('Y')+9;?></option>
                                            <option value="<?php echo date('Y')+10;?>"><?php echo date('Y')+10;?></option>
                                            <option value="<?php echo date('Y')+11;?>"><?php echo date('Y')+11;?></option>
                                            <option value="<?php echo date('Y')+12;?>"><?php echo date('Y')+12;?></option>
                                            <option value="<?php echo date('Y')+13;?>"><?php echo date('Y')+13;?></option>
                                            <option value="<?php echo date('Y')+14;?>"><?php echo date('Y')+14;?></option>
                                            <option value="<?php echo date('Y')+15;?>"><?php echo date('Y')+15;?></option>
                                            <option value="<?php echo date('Y')+16;?>"><?php echo date('Y')+16;?></option>
                                            <option value="<?php echo date('Y')+17;?>"><?php echo date('Y')+17;?></option>
                                            <option value="<?php echo date('Y')+18;?>"><?php echo date('Y')+18;?></option>
                                            <option value="<?php echo date('Y')+19;?>"><?php echo date('Y')+19;?></option>
                                            <option value="<?php echo date('Y')+20;?>"><?php echo date('Y')+20;?></option>
                                        </select>
                                    </td></tr>
                                    <tr><td width="200px">CVV (3 digits)<font color='red'>*</td><td><input style="width:200px" type='text' required='required' class='textbox' name='card_cvv' minlength='3' maxlength='3' onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/></td></tr>
                                    <tr><td></td><td><button type="submit" value ="submit">Submit</button></td></tr>
                                </table>
                            </form>
                        </div>
                        <?php }?>
                    </div>
            </div>
            <div class="line-1" style="width:100%; padding-right:20px"></div>
            <div class="container" style="width: 100%; background-color: white; margin-left:auto;margin-right:auto;">
                <div class="hb20" style="width: 100%;  margin-top:0px;padding:10px;">3. Review items and shipping</div>
                <form class='normal' action='order.php?func=order' method = 'post' enctype="multipart/form-data" style="width: 100%; background:white;">
                <?php     
                $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                        , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches, p.product_material
                        , DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL p.product_delivery DAY),'%a, %M %D, %Y') as delivery 
                        , p.product_price, p.product_img, p.product_status, p.product_delivery, p.product_description, p.member_id, c.product_quantity 
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
                $tax = 0;
                $total = 0;
                $ship_fee=0;
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    $count=$count + $row["product_quantity"];
                    $itemtotal = $row["product_quantity"]*$row["product_price"];
                    $subtotal= $subtotal + $itemtotal
                        
                ?>   
                    <div class="container_horizon" style="width: 100%; background:white; margin-left:auto;margin-right:auto;">    
                        <img src='images/<?php echo $row['product_img']?>' style="width:40%; height:auto;margin-left:0px;margin-right:auto;">
                        <div class="container_vertical" style = 'width:55%;'>
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
                                <a href = "javascript:;" onclick = "this.href='order.php?func=update_order&product_no=<?php echo $row['product_no'];?>&quantity=' + document.getElementById('quantity<?php echo $count; ?>').value"><label>Update</label></a>
                            </div>
                            <div class="line-1"></div>
                            <br />
                        </div>
                    </div>
                    
                    <?php
                    }
                    $tax = $subtotal*0.085;
                    $total = $subtotal*1.085;
            ?>
                <br />
                <br />
                <br />
                <br />
                </form>
            </div>
            <br />
        </div>

        <div class='container' style = 'width: 20%;margin-top:0px; margin-left:20px;padding-bottom:20px;border:1pt;'>       
            <div class='container' style = 'background:white; width: 100%; margin-top:0px; padding:10px; padding-bottom:20px; flex-direction: column;'>
                <form class='normal' action='order.php?func=place' method = 'post' enctype="multipart/form-data" style=" background:white;">
                    
                    <input type="hidden" id = "subtotal" name ="subtotal" value="<?php echo $subtotal ?>" >
                    <input type="hidden" id = "tax" name ="tax" value="<?php echo $tax ?>" >
                    <input type="hidden" id = "total" name ="total" value="<?php echo $total ?>" >
                    <input type="hidden" id = "card_selected" name ="card_selected" value="<?php echo $card_selected ?>" >
                    
                    <input type="hidden" id = "order_ship_name" name ="order_ship_name" value="<?php echo $name ?>" >
                    <input type="hidden" id = "order_ship_street" name ="order_ship_street" value="<?php echo $street ?>" >
                    <input type="hidden" id = "order_ship_city" name ="order_ship_city" value="<?php echo $city ?>" >
                    <input type="hidden" id = "order_ship_state" name ="order_ship_state" value="<?php echo $state ?>" >
                    <input type="hidden" id = "order_ship_zipcode" name ="order_ship_zipcode" value="<?php echo $zipcode ?>" >
                    <input type="hidden" id = "ship_fee" name ="ship_fee" value="<?php echo $ship_fee ?>" >
                    <input type="hidden" id = "order_status" name ="order_status" value="In process" >

                    <div class='container' style = 'background:white; width: 100%;'>
                        <button type='submit' class='button' value='submit' name='submit' style = 'margin-left:auto; margin-right:auto; padding-bottom:10px'>Place your order</button>
                    </div>
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
                        echo "<span style='float:right;margin-right:5px;'>$"; echo number_format($tax,2); echo "</span>";?>
                    </div>
                    <div class="line-1" style="width:100%;margin-left:2px;margin-bottom:10px;"></div>
                    <div class="hb20" style = 'margin-left:2px;padding-bottom:10px;text-align:left;color:red'>
                        <?php  echo "Order total:"; 
                        echo "<span style='float:right;margin-right:5px;'>$"; echo number_format($total,2); echo "</span>";?>
                    </div>
                </form>
            </div>
            <br />
        </div>
    </div>
<?php

//---------PLACE THE ORDER-----------------------------------
}else if ($func=='place'){
    $member_id = $_SESSION['member_id'];
    if (isset($_POST['card_selected'])){
        $card_selected = $_POST['card_selected'];
    }else{
        $card_selected ="";
    }
    $subtotal = $_POST['subtotal'];
    $tax = $_POST['tax'];
    $total = $_POST['total'];

    $order_ship_name = $_POST['order_ship_name'];
    $order_ship_street = $_POST['order_ship_street'];
    $order_ship_city = $_POST['order_ship_city'];
    $order_ship_state = $_POST['order_ship_state'];
    $order_ship_zipcode = $_POST['order_ship_zipcode'];
    
    $ship_fee = $_POST['ship_fee'];
    $order_status = $_POST['order_status'];
    echo "<br >";
    echo "<br >";
    //--------UPDATE CARD DEFAULT-----------------
    if ($card_selected!=""){
        $card_no = $card_selected;
        $sql = "update payments set card_default = 0  
            where member_id ='".$member_id."'";
        $result = mysqli_query($conn,$sql);
        $sql = "update payments set card_default = 1  
            where card_no = '".$card_selected."' and member_id ='".$member_id."'";
        $result = mysqli_query($conn,$sql);
    }
    
    // INPUT TO ORDER TABLE -------------------------------------
    $sql = "insert into orders(member_id, order_date, subtotal, tax, total, card_no, order_ship_name, order_ship_street
            , order_ship_city, order_ship_state, order_ship_zipcode, ship_fee, order_status)   
            values('".$member_id."', NOW(),".$subtotal.",".$tax.",".$total.",'".$card_selected."'
            ,'".$order_ship_name."','".$order_ship_street."','".$order_ship_city."','".$order_ship_state."','".$order_ship_zipcode."'
            ,$ship_fee, 'In process')";
    $result = mysqli_query($conn,$sql);

    
    //--- INPUT INTO ORDER_DETAIL TABLE FROM CARTS WHERE place_order = 1
    //-------Get order number to input to the order-detail table
    $sql = "select max(order_no) as maxno from orders";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
    $order_no = $row['maxno'];
    
    //-------Get product detail in the card information to input to the order-detail table
    $sql = "select c.member_id, c.product_no, c.product_des, c.product_quantity, p.product_price
            , DATE_ADD(CURDATE(),INTERVAL p.product_delivery DAY) as delivery_date 
            , s.policy_value as delivery_day
            , DATE_ADD(CURDATE(),INTERVAL r.policy_value DAY) as return_date  
            from carts c, products p, sale_policy s, sale_policy r
            where c.product_no = p.product_no and c.member_id ='".$member_id."' and c.place_order = 1
            and p.ship_code = s.policy_code and s.policy_type='shipping' 
            and p.return_code = r.policy_code and r.policy_type='return'";
    $cart = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($cart, MYSQLI_BOTH)) {
        $product_no = $row['product_no'];
        $product_quantity=$row['product_quantity'];
        $product_price = $row['product_price'];
        $delivery_date = $row['delivery_date'];
        $return_date = $row['return_date'];
        $return_fee = 0;
        $sql = "insert into orders_detail(order_no, product_no, product_quantity, product_price, delivery_date, return_date, return_fee, product_status)   
        values('".$order_no."',$product_no,$product_quantity,$product_price,'".$delivery_date."','".$return_date."',$return_fee, 'In process')";
        $order = mysqli_query($conn,$sql);
    }

    //-----Delete from carts after place the order-------------------
    $sql= " delete from carts where place_order = 1 and member_id ='".$member_id."'";
    $result = mysqli_query($conn,$sql);
    header("Location: order.php?func=successfully&order_no=$order_no");

//---------SHOW ORDER INFOMATION--------------------------------
}else if ($func=='successfully'){
    if(!empty($_GET['order_no'])){
        $order_no = $_GET['order_no'];
    }else{
        $order_no="";
    }

    ?>
    <div class="container" style="width: 60%;  animation: fadeInAnimation ease 2s; background-color: white; padding-left:20px;margin-left:auto;margin-right:auto;margin-top:0px">
        <div class = 'hb25' style="width: 100%; background-color: white; margin-left:auto;margin-right:auto; text-align:left; padding:10px; ">Your Orders Successful!</div>
        <div class="line-1" style="width:100%; padding-right:20px"></div>
        
            <?php
            $sql="  select order_no, DATE_FORMAT(order_date,' %M %D, %Y') as order_date, subtotal, tax, total, card_no, order_ship_name
                    , CONCAT(order_ship_street,', ', order_ship_city, ', ', order_ship_state, ', ', order_ship_zipcode) as address, ship_fee
                    , tracking_no, order_status      
                from orders 
                where order_no = $order_no and member_id = '".$_SESSION['member_id']."'";
            $order=mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($order, MYSQLI_BOTH);
            
            $order_no = $row['order_no'];
            $order_status=$row['order_status'];
            
            echo "<div class='container' style='width:100%;background-color: lightgrey; padding:0px;'>";
                
                echo "<div class = 'container' style='width:18%; background-color: lightgrey; margin-left:0px; margin-top:0px;padding:10px;'>";
                    echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left; padding-bottom:10px;'>ORDER PLACED</div>";
                    echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left;'>$row[order_date]</div>";
                echo "</div>";
                echo "<div class = 'container' style='width:18%; background-color: lightgrey; margin-left:0px; margin-top:0px; padding:10px;'>";
                    echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left; padding-bottom:10px;'>TOTAL</div>";
                    echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left;'>$"; echo number_format($row['total'],2); echo "</div>";
                echo "</div>";
                echo "<div class = 'container' style='width:30%; background-color: lightgrey; margin-left:0px; margin-top:0px; padding:10px;'>";
                    echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left; padding-bottom:10px;'>SHIP TO: $row[order_ship_name]</div>";
                    echo "<div class = 'h15' style='width: 100%; margin-left:0px; text-align:left;'>$row[address]</div>";
                echo "</div>";
                echo "<div class = 'container' style='width:18%; background-color: lightgrey; margin-right:0px; margin-top:0px; padding:10px;'>";
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
                if ($group_date_delivery == $row['delivery_day']){
                    $show_date = '';
                    $new_group=0;
                }else{
                    
                    if ($row['delivery_date']>date("Y-m-d")){
                        $show_date = 'Estimate Arriving: '.$row['delivery_day'];
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
                </div>
                <?php
            }
            echo "<br />";
        echo "</div>";
    echo "</div>";
//--------------UPDATE QUANTITY IN THE CART---------------------
}else if ($func=='update_order'){
    $product_no=$_GET['product_no'];
    $product_quantity=$_GET['quantity'];
    $member_id = $_SESSION['member_id'];
    
//--------UPDATE CART-----------------
    if($product_quantity>0){
        $sql = "update carts set product_quantity = ".$product_quantity. " 
            where product_no = '".$product_no."' and member_id ='".$member_id."'";
    }else{
    // delete from carts
        $sql= " delete from carts where product_no = '".$product_no."' and member_id ='".$member_id."'";
    }
    $result = mysqli_query($conn,$sql);
    header("Location: order.php?func=order");
//--------END UPDATE CART-------------------------------------

}else if ($func=='message'){
?>
    <div class = 'hb'>$_GET[content]</div>";
    <br />";
    <center><a href='shopping.php?func=list_product' style ='background-color:orange;'>Back to the list...</a></center>";
<?php
}
    include "footer.php";
?>

<script>
function handleChange(src) {
  document.getElementById("card_selected").value=src.value;
}
</script>
