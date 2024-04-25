<div class = "menu">
    <?php 
        if ($menu== 'home'){
            echo "<a style='background:#F39C12;' href='home.php'>Home</a>";
        }else{
            echo "<a  href='home.php'>Home</a>";
        }
        if ($menu== 'aboutus'){
            echo "<a style='background:#F39C12;' href='aboutus.php'>About Us</a>";
        }else{
            echo "<a  href='aboutus.php'>About Us</a>";
        }
        if ($menu== 'introduction'){
            echo "<a style='background:#F39C12;' href='introduction.php'>Introduction</a>";
        }else{
            echo "<a  href='introduction.php'>Introduction</a>";
        }
        if ($menu== 'product'){
            echo "<a style='background:#F39C12;' href='product.php?func=list_product'>Product</a>";
        }else{
            echo "<a  href='product.php?func=list_product'>Product</a>";
        }
        if ($menu== 'policy'){
            echo "<a style='background:#F39C12;' href='policy.php?func=list_policy'>Sale Policy</a>";
        }else{
            echo "<a  href='policy.php?func=list_policy'>Sale Policy</a>";
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
            <a><?php echo "Hello, "; echo $_SESSION["member_name"];?> <i class="arrow down"></i></a>
            <div class="dropdown-content">
                <a  href='profile.php'>Profile</a>
                <a href='index.php'>Sign out</a>
            </div>
        </div>
        <?php
            if ($menu== 'order'){
                echo "<a style='background:#F39C12;' href='history_order.php'>Orders</a>";
            }else{
                echo "<a  href='history_order.php'>Orders</a>";
            }
            if ($menu== 'cart'){
                echo "<a style='background:#F39C12;' href='cart.php'>Cart($quantity)</a>";
            }else{
                echo "<a  href='cart.php'>Cart($quantity)</a>";
            }
        ?>
        </span>
</div>