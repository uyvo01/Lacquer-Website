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
        if ($menu== 'profile'){
            echo "<a style='background:#F39C12;' href='profile.php'>Profile</a>";
        }else{
            echo "<a  href='profile.php'>Profile</a>";
        }
        if ($menu== 'cart'){
            echo "<a style='background:#F39C12;' href='cart.php'>View Cart</a>";
        }else{
            echo "<a  href='cart.php'>View Cart</a>";
        }
        if ($menu== 'order'){
            echo "<a style='background:#F39C12;' href='order.php'>History Orders</a>";
        }else{
            echo "<a  href='order.php'>History Order</a>";
        }
        echo "<span style='float:right;'>";
        echo $_SESSION["member_name"];
        echo ", <a href='index.php'>Sign out</a></span>";
    ?>
</div>