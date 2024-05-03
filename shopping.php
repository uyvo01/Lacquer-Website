
<?php
$menu="home";
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
    $func='';
}
if ($func=='add_cart'){
    
    //------------------ADD CART--------------------------
    $product_no = validate($_POST['product_no']);
    $product_quantity = validate($_POST['product_quantity']);
    $member_id = $_SESSION['member_id'];

    if(empty($_SESSION['member_id'])){
        header("Location: signin.php?error=Please sign in first!");
    }else{
        $sql="select product_no from carts where product_no = '".$product_no."' and member_id ='".$member_id."'";
        $result=mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);

        if($num>0){
            $sql = "update carts set product_quantity = product_quantity + ".$product_quantity. " 
                where product_no = '".$product_no."' and member_id ='".$member_id."'";
        }else{
        // insert to table carts
            $sql= " insert into carts(member_id, product_no, product_quantity) 
                    values('".$member_id."','".$product_no. "',$product_quantity)";
        }
        $result = mysqli_query($conn,$sql);
        header("Location: shopping.php?func=update_cart&message=Add to cart successfully!");
    }
    //------------------END ADD CART----------------------
    
//-----------------------BEGIN THE FEATURE LIST PAINTINGS---------------------
}else if ($func=='update_cart'){

    echo "<div class = 'hb'>$_GET[message]</div>";
    echo "<br />";
    echo "<div class='container' style = 'width: 300px; margin-left:auto; margin-right:auto'>";
    echo "<a class = 'icon' style='padding:0px' href='home.php'><button>Continue shopping</button></a>";
    echo "<a class = 'icon' style='padding:0px' href='cart.php?func=checkout'><button>Checkout</button></a>";
    echo "</div>";

//-------------------Begin function edit product------------------------
}else if ($func=='view'){
    $product_no = $_GET['product_no'];
    $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,2) as size_height_inches
            , p.product_size_width, round(p.product_size_width/2.54,2) as size_width_inches 
            , p.product_material, p.product_img, p.product_status, p.product_description 
            , DATE_FORMAT(DATE_ADD(CURDATE(),INTERVAL p.product_delivery DAY),'%a, %M %D, %Y') as delivery
            , s.policy_description as ship_description, r.policy_description as return_description, p.product_price
            from products p, sale_policy s, sale_policy r 
            where p.ship_code = s.policy_code and p.return_code = r.policy_code and p.product_no = '".$product_no."'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
    $artist = $row['product_artist'];
    ?>    
    <form class='normal' action='shopping.php?func=add_cart' method = 'post' enctype="multipart/form-data">
    <input type="hidden" id="product_no" name="product_no" value='<?php echo $row['product_no']?>' />
        <div class="container_detail" >
            <img src='images/<?php echo $row['product_img']?>' class="img" onclick="zoom(this)" style=" width:60%; cursor:zoom-in; min-width:400px; height:auto;margin-left:auto;margin-right:auto;">
            <div class="container_vertical" style = 'width:38%; min-width:400px; margin-top: 0px;'>
            
                <div class = 'hb' style="font-weight:bold;text-align:left;padding-bottom:10px"><?php echo $row['product_name']; ?></div>
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
                    <?php if ($_SESSION['member_id']!=""){ ?>
                        <tr>
                        <td style='border:0px;'><div class='hb15'>PRICE:</div></td>
                        <td style='border:0px;'><h5>$<?php echo number_format($row["product_price"],2) ?></h5></td>
                        </tr>
                    <?php } else{ ?>
                        <tr>
                        <td style='border:0px;'><div class='hb15'>PRICE:</div></td>
                        <td style='border:0px;'><h5>Shown after signing in.</h5></td>
                        </tr>
                    <?php } ?>
                </table>
                <br />
                <div class="line-1"></div>
                <br />
                
                <div class="container" style="align-items:flex-end; margin-left: 0px;">
                    <span class="minus" onclick="updateQuantity(-1)">-</span>
                    <input type="text" id = "product_quantity" name = "product_quantity" style = "width: 40px; height:36px; border:none; text-align:center;" value="1"/>
                    <span class="plus" onclick="updateQuantity(+1)">+</span>
                    <button type='submit' class='button' value='submit' name='submit'>ADD TO CART</button>
                </div>
                <br />
                <div class="line-1"></div>
                <br />
                <h5>- <?php echo $row['ship_description']?></h5>
                <h5>- <?php echo $row['return_description']?></h5>
                <h5>- Estimate delivery on <?php echo $row['delivery'] ?></h5>

            </div>
        </div>
    </form>
    <br />
    <div class="container_vertical" style = 'width:70%; min-width:450px; margin-top: 0px;'>
        <div class="line-1"></div>
        <div class="line-2" style="max-width: 10%;"></div>
        <div class = "hb15">DESCRIPTION</div>
        <h5><?php echo $row['product_description']?></h5>
        <br />
        
        <div class="container_detail" style='background-color:bisque;width:100%'>
            <div class="hb30" style="text-align:center">OTHER ARTWORKS BY ARTIST <?php echo $row['product_artist']?></div>
            <?php
                $sql="  select p.product_no, p.product_name, p.product_artist,  p.product_size_height
                , round(p.product_size_height/2.54,1) as size_height_inches
                , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
                , p.product_material, p.product_img
                from products p where product_status='Active' and p.product_artist='".$artist."' and p.product_no!='".$product_no."'";
                $result=mysqli_query($conn,$sql);
                while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
                    echo "<div class='box-image'>";
                    echo "<a class='icon' href='shopping.php?func=view&product_no=$row[product_no]'><img class='list' src='images/$row[product_img]'></a>";
                    echo "<h5>$row[product_artist]</h5>";
                    echo "<h5>Size: $row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches</h5>";
                    echo "<h5>Material: $row[product_material]</h5>";
                    echo "<h5>$row[product_name]</h5>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>

            
    
<?php
 
}else if ($func=='message'){
    echo "<div class = 'hb'>$_GET[content]</div>";
    echo "<br />";
    echo "<center><a href='shopping.php?func=list_product' style ='background-color:orange;'>Back to the list...</a></center>";

}
    include "footer.php";
?>

<script>
    function updateQuantity(n) {
        var input = document.getElementById("product_quantity").value;
        var count = parseInt(input) + n;
        if (count<1) {
            count=1;
        }
        document.getElementById("product_quantity").value=count;
    }
    function zoom(element){
        element.classList.toggle("zoom");
    }
</script>
</body>