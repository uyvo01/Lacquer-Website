
<div class="container" style="width:100%; background:darkred; margin-top:2px;">
    <div class="container" style="width:30%"></div>
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
            if ($menu== 'signin'){
                echo "<a style='background:#F39C12;  padding: 10px; padding-left: 10px; padding-right: 10px;' href='signin.php'>$Signin</a>";
            }else{
                echo "<a  href='signin.php'>$Signin</a>";
            }
        ?>
    </div>
    <div class="container" style="width:30%;"></div>
</div>