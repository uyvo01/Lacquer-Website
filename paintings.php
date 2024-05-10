<?php
    $menu="paintings";
    include "header.php"; 
    if (isset($_GET['search'])) {
        $material=$_GET['search'];
        
    }else{
        $material="";
    }

    if (!empty($_GET['search'])){
        $sql="  select p.product_no, p.product_name, p.product_artist,  p.product_size_height
        , round(p.product_size_height/2.54,1) as size_height_inches
        , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
        , p.product_material, p.product_img
        from products p 
        where product_status='Active' and (lower(p.product_material) like '%".$material."%')";
        $result=mysqli_query($conn,$sql);
        echo "<div class='hb'>$Material: $material </div>";
        
    }else{
        $sql="  select p.product_no, p.product_name, p.product_artist,  p.product_size_height
        , round(p.product_size_height/2.54,1) as size_height_inches
        , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
        , p.product_material, p.product_img
        from products p where product_status='Active'";
        $result=mysqli_query($conn,$sql);
        echo "<div class='hb'>$PaintingOfTheMonth </div>";
    
    }
    echo "<hr />";   
    echo "<div class='container' style='width:100%;'>";
    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
        echo "<div class='box-image'>";
            echo "<a class='icon' href='shopping.php?func=view&product_no=$row[product_no]'><img class='list' src='images/$row[product_img]'></a>";
            echo "<h5>$row[product_artist]</h5>";
            echo "<h5>$Size: $row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches</h5>";
            echo "<h5>$Material: $row[product_material]</h5>";
            echo "<h5>$row[product_name]</h5>";
        echo "</div>";
    }
    echo "</div>";
    echo "<div class='container'>";
        echo "<div class='hb30' style='width:100%;text-align:center;'>$PaintingOfTheMonth</div>";
        echo "<div class='container'>";
        $sql="  select p.product_no, p.product_name, p.product_artist,  p.product_size_height
        , round(p.product_size_height/2.54,1) as size_height_inches
        , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
        , p.product_material, p.product_img
        from products p where p.product_status='Active' and product_no in (select product_no from orders_detail group by product_no)";
        $result=mysqli_query($conn,$sql);


        while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
            echo "<div class='box-image'>";
            echo "<a class='icon' href='shopping.php?func=view&product_no=$row[product_no]'><img class='list' src='images/$row[product_img]'></a>";
            echo "<h5>$row[product_artist]</h5>";
            echo "<h5>$size: $row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches</h5>";
            echo "<h5>$material: $row[product_material]</h5>";
            echo "<h5>$row[product_name]</h5>";
            echo "</div>";
        }
        echo "</div>";
    echo "</div>";
    echo "<br />";
    echo "<br />";
    include "footer.php";
?>

