<div class = "menu">
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
        <span style='float:right; margin-left:10px;'>
        <div class="dropdown">
            <a><?php echo $Hello.', '.$_SESSION["member_name"];?> <i class="arrow down"></i></a>
            <div class="dropdown-content">
                <a  href='profile.php'><?php echo $Profile; ?></a>
                <a href='index.php'><?php echo $Signout; ?></a>
            </div>
        </div>
        <?php
            if ($menu== 'order'){
                echo "<a style='background:#F39C12;' href='history_order.php'>$Orders</a>";
            }else{
                echo "<a  href='history_order.php'>$Orders</a>";
            }
            if ($menu== 'cart'){
                echo "<a style='background:#F39C12;' href='cart.php'>$Cart($quantity)</a>";
            }else{
                echo "<a  href='cart.php'>$Cart($quantity)</a>";
            }
        ?>
        </span>
</div>