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
        if ($menu== 'product'){
            echo "<a style='background:#F39C12;' href='product.php?func=list_product'>Product</a>";
        }else{
            echo "<a  href='product.php?func=list_product'>Product</a>";
        }
        if ($menu== 'policy'){
            echo "<a style='background:#F39C12;' href='policy.php'>Sale Policy</a>";
        }else{
            echo "<a  href='policy.php'>Sale Policy</a>";
        }
        echo "<span style='float:right;'>";
        echo $_SESSION["member_name"];
        echo ", <a href='index.php'>Sign out</a></span>";
    ?>
</div>