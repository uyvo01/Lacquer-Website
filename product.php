<?php
$menu="product";
include "header.php"; 
if (isset($_GET['func'])) {
    $func=$_GET['func'];
    function validate($data) {
        $data = trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
}else{
    $func='';
}
if ($func=='new_product'){
?>
    <br />
    <form action='product.php?func=add_product' method = 'post' enctype="multipart/form-data">
    <h1>ADD PAINTINGS</h1>
    <table style='width:600px'>
        <tr>
            <td style='text-align:right'><label>Name*</label></td>
            <td style='text-align:left'><input type='text' style = "width: 250px" required='required' class='textbox' id='name' name='name' value=''></td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Artist*</label></td>
            <td style='text-align:left'><input type='text' style = "width: 250px" required='required' class='textbox' id='artist' name='artist' value=''></td>
        </tr>    
        <tr>
            <td style='text-align:right'><label>Size (height * width)*</label></td>
            <td style='text-align:left'>
                <input type='text' class='textbox' style = "width: 90px" id='size_height' name='size_height' value=''> cm * 
                <input type='text' class='textbox' style = "width: 90px"  id='size_width' name='size_width' value=''> cm
            </td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Material</label></td>
            <td style='text-align:left'><input type='text' style = "width: 250px" class='textbox' id='material' name='material' value=''></td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Image*</label></td>
            <td><input type='file' class='textbox' id='product_img' name='product_img' value=''></td>
        </tr>
        <tr>
            <td></td>
            <td td colspan='3'style='text-align:left'><label>(*): mandatory<label></td>
        </tr>
        <tr>
            <td></td><td td colspan='3'><input type='submit' class='button' value='submit' name='submit'>
            <input type='reset' class='button' value='Reset'></td>         
        </tr>
    </table>
    </form>
    <br />
    <?php
}else if ($func=='add_product'){
    
    //------------------ UPLOAD FILE IMAGE -------------------------------
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["product_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {

        $check = getimagesize($_FILES["product_img"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["product_img"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["product_img"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            echo $_FILES["product_img"]["name"];
            exit();
        }
    }
    //--------------END UPLOAD THE FILE-------------------------------
    //------------------ADD PAINTING INFORMATION--------------------------
    $product_name = validate($_POST['name']);
    $product_artist = validate($_POST['artist']);
    $product_size_height = validate($_POST['size_height']);
    $product_size_width = validate($_POST['size_width']);
    $product_material = validate($_POST['material']);
    $product_img = $_FILES["product_img"]["name"];
    $member_id = $_SESSION['member_id'];


    $sql="select product_name from products where product_name = '".$product_name."'";
    $result=mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);

    if($num>0){
        header("Location: product.php?error=The painting exist!");
        exit();
    }
    // insert to table products
    $sql= " insert into products(product_name, product_artist, product_size_height, product_size_width, product_material, product_img, member_id) 
            values('".$product_name."','".$product_artist. "',".$product_size_height. ",".$product_size_width. ",
                    '".$product_material. "', '".$product_img. "', '".$member_id. "')";

    $result = mysqli_query($conn,$sql);
    header("Location: product.php?func=list_product&error=Add successfully!");
    //------------------END ADD PAINTING INFORMATION----------------------
    
//-----------------------BEGIN THE FEATURE LIST PAINTINGS---------------------
}else if ($func=='list_product'){
    echo "<div class = 'hb'>PRODUCT MANAGEMENT</div>";
    echo "<hr />";
    echo "<center><a style='padding:0px' href='product.php?func=new_product'><button>Add new</button></a></center><br/>";
    
    echo "<table>";
    echo "<thead>
            <td>#</td>
            <td>Status</td>
            <td>Painting Name</td>
            <td>Artist</td>
            <td>Size</td>
            <td>Material</td>
            <td>Image</td>
            </thead>";
    $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
            , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
            , p.product_material, p.product_img, p.product_status
            from products p 
            where p.member_id = '".$_SESSION['member_id']."'";

    $result=mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
        echo "<tr>";
        echo "<td style='text-align: right'><a href='product.php?func=edit_product&product_no=$row[product_no]' class='icon'><img src='images/edit.png' width='30px' height='30px'></a></td>";
        echo "<td>$row[product_status]</td>";
        echo "<td>$row[product_name]</td>";
        echo "<td>$row[product_artist]</td>";
        echo "<td>$row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches</td>";
        echo "<td>$row[product_material]</td>";
        echo "<td width='100px'><img src='images/$row[product_img]' width='100%' height='100%'></td>";
        echo "</tr>";
    }
    echo "</table>";

//-------------------Begin function edit product------------------------
}else if ($func=='edit_product'){
    $product_no = $_GET['product_no'];
    $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,2) as size_height_inches
            , p.product_size_width, round(p.product_size_width/2.54,2) as size_width_inches 
            , p.product_material, p.product_img, p.product_status
            from products p 
            where p.product_no = '".$product_no."'";
        
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH)
    ?>
    <div class = 'hb'>UPDATE PAINTING</div>
    <hr />
    <form class='normal' action='product.php?func=update_product' method = 'post' enctype="multipart/form-data">
    <input type="hidden" id="product_no" name="product_no" value='<?php echo $row['product_no']?>' />
    <div class="container" style='background-color: bisque;'>
        <img src='images/<?php echo $row['product_img']?>' width='50%' height='50%'>
        <table style='width:45%;height:300px'>
            <tr>   
                <td style='text-align:right'><label>Name*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 250px" required='required' class='textbox' id='name' name='name' value='<?php echo $row['product_name']?>'></td>
            </tr>
            <tr>
                <td style='text-align:right'><label>Artist*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 250px" required='required' class='textbox' id='artist' name='artist' value='<?php echo $row['product_artist']?>'></td>
            </tr>    
            <tr>
                <td style='text-align:right'><label>Size (height * width)*</label></td>
                <td style='text-align:left'>
                    <input type='text' class='textbox' style = "width: 90px" id='size_height' name='size_height' value='<?php echo $row['product_size_height']?>'> cm * 
                    <input type='text' class='textbox' style = "width: 90px"  id='size_width' name='size_width' value='<?php echo $row['product_size_width']?>'> cm
                </td>
            </tr>
            <tr>
                <td style='text-align:right'><label>Material*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 250px" required='required' class='textbox' id='material' name='material' value='<?php echo $row['product_material']?>'></td>
            </tr>
            <tr>
                <td style='text-align:right'><label>Status*</label></td>
                <td>
                <select name='product_status' id='product_status' style='height:30px; width:250px;'>
                    <option value='Active' <?php if ($row['product_status']=='Active'){ echo 'selected'; } ?>>Active</option>
                    <option value='Inactive' <?php if ($row['product_status']=='Inactive'){ echo 'selected'; } ?>>Inactive</option>
                </select>
            </tr>
            <tr>
                <td></td>
                <td td colspan='3'style='text-align:left'><label>(*): mandatory<label></td>
            </tr>
            <tr>
                <td></td><td td colspan='3' style="align-content:center"><button type='submit' class='button' value='submit' name='submit'>Submit</button>
                <button type='reset' class='button' value='Reset'>Reset</button></td>
            </tr>
        </table>
    </div>
    </form>
    <br />
<?php
 //------------------UPDATE PAINTING INFORMATION--------------------------
}else if ($func=='update_product'){
   
    $product_no = validate($_POST['product_no']);
    $product_name = validate($_POST['name']);
    $product_artist = validate($_POST['artist']);
    $product_size_height = validate($_POST['size_height']);
    $product_size_width = validate($_POST['size_width']);
    $product_material = validate($_POST['material']);
    $product_status = validate($_POST['product_status']);
    
    $sql= " update products set product_name = '".$product_name."', product_artist = '".$product_artist."', 
            product_size_height = ".$product_size_height.", product_size_width = ".$product_size_width.", 
            product_material = '".$product_material."', product_status = '".$product_status."'
            where product_no = '".$product_no. "'";
    $result = mysqli_query($conn,$sql);
    header("Location: product.php?func=message&content=Update successfully!");
    //------------------END UPDATE PAINTING INFORMATION----------------------
}else if ($func=='message'){
    echo "<div class = 'hb'>$_GET[content]</div>";
    echo "<br />";
    echo "<center><a href='product.php?func=list_product' style ='background-color:orange;'>Back to the list...</a></center>";

}
    include "footer.php";
?>