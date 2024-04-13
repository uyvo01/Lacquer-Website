
<div class="menu">
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
        if ($menu== 'members'){
            echo "<a style='background:#F39C12;' href='members.php'>Members</a>";
        }else{
            echo "<a  href='members.php'>Members</a>";
        }
        if ($menu== 'return_management'){
            echo "<a style='background:#F39C12;' href='return_management.php'>Return Management</a>";
        }else{
            echo "<a  href='return_management.php'>Return Management</a>";
        }
        echo "<span style='float:right;'>";
        echo $_SESSION["member_name"];
        echo ", <a href='index.php'>Sign out</a></span>";
    ?>
    
</div>



