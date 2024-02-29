<div class = "menu">
    <?php 
        if ($menu== 'home'){
            echo "<a style='background:#F39C12;  padding: 5px; padding-left: 10px; padding-right: 10px;' href='home.php'>Home</a>";
        }else{
            echo "<a  href='home.php'>Home</a>";
        }
        if ($menu== 'aboutus'){
            echo "<a style='background:#F39C12;  padding: 5px; padding-left: 10px; padding-right: 10px;' href='aboutus.php'>About Us</a>";
        }else{
            echo "<a  href='aboutus.php'>About Us</a>";
        }
        if ($menu== 'introduction'){
            echo "<a style='background:#F39C12;  padding: 5px; padding-left: 10px; padding-right: 10px;' href='introduction.php'>Introduction</a>";
        }else{
            echo "<a  href='introduction.php'>Introduction</a>";
        }
        if ($menu== 'profile'){
            echo "<a style='background:#F39C12;  padding: 5px; padding-left: 10px; padding-right: 10px;' href='profile.php'>Profile</a>";
        }else{
            echo "<a  href='profile.php'>Profile</a>";
        }
        if ($menu== 'product'){
            echo "<a style='background:#F39C12;  padding: 5px; padding-left: 10px; padding-right: 10px;' href='product.php'>Product</a>";
        }else{
            echo "<a  href='product.php'>Product</a>";
        }
        if ($menu== 'policy'){
            echo "<a style='background:#F39C12;  padding: 5px; padding-left: 10px; padding-right: 10px;' href='policy.php'>Sale Policy</a>";
        }else{
            echo "<a  href='policy.php'>Sale Policy</a>";
        }
        echo "<span style='float:right;'>";
        echo $_SESSION["member_name"];
        echo ", <a href='index.php'>Sign out</a></span>";
    ?>
</div>