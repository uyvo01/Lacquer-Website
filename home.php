<?php
    $menu="home";
    include "header.php"; 
?>
<body>
    <div class="hb">PAINTINGS OF THE MONTH </div>
    <hr />
    <div class="container">
        <?php
        $sql="  select p.product_no, p.product_name, p.product_artist,  p.product_size_height
        , round(p.product_size_height/2.54,1) as size_height_inches
        , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
        , p.product_material, p.product_img
        from products p where product_status='Active'";
        $result=mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
            echo "<div class='box-image'>";
            echo "<img class='list' src='images/$row[product_img]' width='80%' height='75%'>";
            echo "<h5>$row[product_artist]</h5>";
            echo "<h5>Size: $row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches</h5>";
            echo "<h5>Material: $row[product_material]</h5>";
            echo "<h5>$row[product_name]</h5>";
            echo "</div>";
        }
        ?>
    </div>

</body>

<?php
    include "footer.php";
?>

