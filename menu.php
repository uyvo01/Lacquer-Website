<div class = "menu">
    <?php 
        if ($menu== 'home'){
            echo "<a style='background:#F39C12;  padding: 10px; padding-left: 10px; padding-right: 10px;' href='home.php'>Home</a>";
        }else{
            echo "<a  href='home.php'>Home</a>";
        }
        if ($menu== 'aboutus'){
            echo "<a style='background:#F39C12;  padding: 10px; padding-left: 10px; padding-right: 10px;' href='aboutus.php'>About Us</a>";
        }else{
            echo "<a  href='aboutus.php'>About Us</a>";
        }
        if ($menu== 'introduction'){
            echo "<a style='background:#F39C12;  padding: 10px; padding-left: 10px; padding-right: 10px;' href='introduction.php'>Introduction</a>";
        }else{
            echo "<a  href='introduction.php'>Introduction</a>";
        }
        if ($menu== 'signin'){
            echo "<a style='background:#F39C12;  padding: 10px; padding-left: 10px; padding-right: 10px;' href='signin.php'>Sign in</a>";
        }else{
            echo "<a  href='signin.php'>Sign in</a>";
        }
    ?>
</div>