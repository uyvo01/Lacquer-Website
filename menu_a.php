
<div class="container" style="width:100%;background:darkred;margin-top:2px;">
    <div class="container" style="width:34%"></div>
    <div class="menu" style="width:35%; text-align:left;">
        <?php 
            if ($menu== 'home'){
                echo "<a style='background:#F39C12;' href='home.php'>$Home</a>";
            }else{
                echo "<a  href='home.php'>$Home</a>";
            }
            echo "<div class='dropdown'>";
            if ($menu=='artists'){
                echo "<a style='background:#F39C12;'>$Artists <i class='arrow down'></i></a>";
            }else{
                echo "<a>$Artists <i class='arrow down'></i></a>";
            }
            echo "<div class='dropdown-content'>";
            // Get list of artist
            $sql="select product_artist as artist from products
            group by product_artist ";
            $result=mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
                echo "<a href='artists.php?search=$row[artist]'>$row[artist]</a>";
            }
            echo "</div>";
            echo "</div>";
            
            echo "<div class='dropdown'>";
            if ($menu=='paintings'){
                echo "<a style='background:#F39C12;'>$Paintings <i class='arrow down'></i></a>";
            }else{
                echo "<a>$Paintings <i class='arrow down'></i></a>";
            }
            echo "<div class='dropdown-content'>";
            // Get list of material
            $sql="select product_material as material from products
            group by product_material ";
            $result=mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
                echo "<a href='paintings.php?search=$row[material]'>$row[material]</a>";
            }
            echo "</div>";
            echo "</div>";
            if ($menu== 'introduction'){
                echo "<a style='background:#F39C12;' href='introduction.php'>$Introduction</a>";
            }else{
                echo "<a  href='introduction.php'>$Introduction</a>";
            }
            if ($menu== 'aboutus'){
                echo "<a style='background:#F39C12;' href='aboutus.php'>$Aboutus</a>";
            }else{
                echo "<a  href='aboutus.php'>$Aboutus</a>";
            }
            // Get shopping cart number
            $sql="select sum(product_quantity) as quantity from carts where member_id ='".$_SESSION["member_id"]."' group by member_id";
            $result=mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result, MYSQLI_BOTH);
            $num = mysqli_num_rows($result);
            if ($num>0){
                $quantity = $row["quantity"];
            }else{
                $quantity=0;
            }

        // Account features: profile, sign out, orders, cart
        ?>
    </div>
    <div class="menu" style="width:30%; text-align:right;">
     
        <div class="dropdown">
            <a><?php echo $Hello.', '. $_SESSION["member_name"];?> <i class="arrow down"></i></a>
            <div class="dropdown-content">
                <?php
                if ($menu== 'product'){
                    echo "<a style='background:#F39C12;' href='product.php?func=list_product'>Product Management</a>";
                }else{
                    echo "<a  href='product.php?func=list_product'>Product Management</a>";
                }
                if ($menu== 'order_management'){
                    echo "<a style='background:#F39C12;' href='order_management.php?func=list_order_management'>Order Management</a>";
                }else{
                    echo "<a  href='order_management.php?func=list_order_management'>Order Management</a>";
                }
                if ($menu== 'policy'){
                    echo "<a style='background:#F39C12;' href='policy.php?func=list_policy'>Sale Policy</a>";
                }else{
                    echo "<a  href='policy.php?func=list_policy'>Sale Policy</a>";
                }
                if ($menu== 'members'){
                    echo "<a style='background:#F39C12;' href='members.php'>Members Management</a>";
                }else{
                    echo "<a  href='members.php'>Members Management</a>";
                }
               
                if ($menu== 'profile'){
                    echo "<a style='background:#F39C12;' href='profile.php'>$Profile</a>";
                }else{
                    echo "<a  href='$Profile.php'>$Profile</a>";
                }
                echo "<a href='index.php'>$Signout</a>";
                ?>
            </div>
        </div>
    <?php
        if ($menu== 'order'){
            echo "<a style='background:#F39C12;' href='order_history.php'>$Orders</a>";
        }else{
            echo "<a  href='order_history.php'>$Orders</a>";
        }
        if ($menu== 'cart'){
            echo "<a style='background:#F39C12;' href='cart.php'>$Cart($quantity)</a>";
        }else{
            echo "<a  href='cart.php'>$Cart($quantity)</a>";
        }
    ?>

    </div>
</div>


