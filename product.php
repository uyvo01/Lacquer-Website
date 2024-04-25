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
    $sql="select policy_code, policy_code,policy_description from sale_policy where policy_type = 'shipping'";
    $shipping=mysqli_query($conn,$sql);
    $sql="select policy_code, policy_code,policy_description from sale_policy where policy_type = 'return'";
    $return=mysqli_query($conn,$sql);

?>
    <br />
    <form action='product.php?func=add_product' method = 'post' enctype="multipart/form-data">
    <h1>ADD PAINTINGS</h1>
    <table style='width:100%'>
        <tr>
            <td style='text-align:right'><label>Name*</label></td>
            <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='name' name='name' value=''></td>
            <td style='text-align:right'><label>Artist*</label></td>
            <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='artist' name='artist' value=''></td>
        </tr>    
        <tr>
            <td style='text-align:right'><label>Size(H*W)*</label></td>
            <td style='text-align:left'>
                <input type='text' class='textbox' style = "width: 60px" id='size_height' name='size_height' value=''> <label>cm</label>
                <input type='text' class='textbox' style = "width: 60px"  id='size_width' name='size_width' value=''><label>cm</label>
            </td>
            <td style='text-align:right'><label>Material*</label></td>
            <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='material' name='material' value=''></td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Ship code*</label></td>
            <td><select name='ship_code' id='ship_code' style='height:30px; width:100%;'" required>
                <option value=''>Select</option>
                <?php
                while($row = mysqli_fetch_array($shipping, MYSQLI_BOTH)) { 
                    echo"<option value=$row[policy_code]>$row[policy_code]</option>";
                }
                ?>
                </select> 
            </td>
            <td style='text-align:right'><label>Return code*</label></td>
            <td><select name='return_code' id='return_code' style='height:30px; width:100%;'" required>
                <option value=''>Select</option>
                <?php
                while($row = mysqli_fetch_array($return, MYSQLI_BOTH)) { 
                    echo"<option value=$row[policy_code]>$row[policy_code]</option>";
                }
                ?>
                </select> 
            </td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Status*</label></td>
            <td>
            <select name='product_status' id='product_status' style='height:30px; width:100%;'>
                <option value='Active'>Active</option>
                <option value='Inactive'>Inactive</option>
            </select>
            <td style='text-align:right'><label>Delivery*</label></td>
            <td colspan='3' style='text-align:left'><input type='text' style = "width: 100%; text-align:right" required='required' class='textbox' id='product_delivery' name='product_delivery' value=''></td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Price($)*</label></td>
            <td style='text-align:right'><input type='text' style = "width: 100%; text-align:right" required='required' class='textbox' id='product_price' name='product_price' value=''></td>
            <td style='text-align:right'><label>Description</label></td>
            <td style='text-align:left'><textarea rows="4" style = "width: 100%" class='textbox' id='product_description' name='product_description' value=''></textarea></td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Image*</label></td>
            <td colspan='3'><input type='file' class='textbox' id='product_img' name='product_img' value=''></td>
        </tr>
        <tr>
            <td></td>
            <td colspan='3'style='text-align:left'><label>(*): mandatory<label></td>
        </tr>
        <tr>
            <td></td><td colspan='3'><button type='submit' class='button' value='submit' name='submit'>Submit
            <button type='reset' class='button' value='Reset'>Reset</td>         
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
    $ship_code = validate($_POST['ship_code']);
    $return_code = validate($_POST['return_code']);
    $product_status = validate($_POST['product_status']);
    $product_delivery = validate($_POST['product_delivery']);
    $product_price = validate($_POST['product_price']);
    $product_description = validate($_POST['product_description']);

    $sql="select product_name from products where product_name = '".$product_name."'";
    $result=mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);

    if($num>0){
        header("Location: product.php?error=The painting exists!");
        exit();
    }
    // insert to table products
    $sql= " insert into products(product_name, product_artist, product_size_height, product_size_width, product_material, product_img, member_id, 
                    ship_code, return_code, product_status, product_delivery, product_price, product_description) 
            values('".$product_name."','".$product_artist. "',".$product_size_height. ",".$product_size_width. ",
                    '".$product_material. "', '".$product_img. "', '".$member_id. "', '".$ship_code. "', '".$return_code. "',
                    '".$product_status."', '".$product_delivery."', ".$product_price. ",'".$product_description."')";

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
            <td>Day Delivery</td>
            <td>Description</td>
            <td>Price</td>
            <td>Image</td>
            </thead>";
    if ($_SESSION["usertype"]=="A"){ //Admin view
        $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
                , p.product_material, p.product_img, p.product_status, p.product_delivery, p.product_description, p.product_price, p.member_id
                from products p
                where 1=1 order by 1";
    }else{ // Seller view
        $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,1) as size_height_inches
                , p.product_size_width, round(p.product_size_width/2.54,1) as size_width_inches 
                , p.product_material, p.product_img, p.product_status, p.product_delivery, p.product_description, p.product_price, p.member_id
                from products p 
                where p.member_id = '".$_SESSION['member_id']."'";
    }
    $result=mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
        echo "<tr>";
        echo "<td style='text-align: right'><a href='product.php?func=edit_product&product_no=$row[product_no]' class='icon'><img src='images/edit.png' width='30px' height='30px'></a></td>";
        echo "<td>$row[product_status]</td>";
        echo "<td>$row[product_name]</td>";
        echo "<td>$row[product_artist]</td>";
        echo "<td>$row[product_size_height]cm*$row[product_size_width]cm | $row[size_height_inches] inches*$row[size_width_inches] inches</td>";
        echo "<td>$row[product_material]</td>";
        echo "<td style='text-align:right'>$row[product_delivery]</td>";
        echo "<td>$row[product_description]</td>";
        echo "<td style='text-align: right'>$row[product_price]</td>";
        echo "<td width='100px'><img src='images/$row[product_img]' width='100%' height='100%'></td>";
        echo "</tr>";
    }
    echo "</table>";

//-------------------Begin function edit product------------------------
}else if ($func=='edit_product'){
    $product_no = $_GET['product_no'];
    $sql="  select p.product_no, p.product_name, p.product_artist, p.product_size_height, round(p.product_size_height/2.54,2) as size_height_inches
            , p.product_size_width, round(p.product_size_width/2.54,2) as size_width_inches 
            , p.product_material, p.product_img, p.product_status, p.product_delivery, p.product_price, p.product_description, p.ship_code, p.return_code
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
        <img src='images/<?php echo $row['product_img']?>' style = 'width:50%; height=50%; margin-left:auto; margin-right:auto' >
        <table style='width:45%;'>
            <tr>   
                <td style='text-align:right'><label>Name*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='name' name='name' value='<?php echo $row['product_name']?>'></td>
                <td style='text-align:right'><label>Artist*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='artist' name='artist' value='<?php echo $row['product_artist']?>'></td>
            </tr>    
            <tr>
                <td style='text-align:right'><label>Size(H*W)*</label></td>
                <td style='text-align:left'>
                    <input type='text' class='textbox' style = "width: 60px; text-align:right" id='size_height' name='size_height' value='<?php echo $row['product_size_height']?>'> cm * 
                    <input type='text' class='textbox' style = "width: 60px; text-align:right"  id='size_width' name='size_width' value='<?php echo $row['product_size_width']?>'> cm
                </td>
                <td style='text-align:right'><label>Material*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='material' name='material' value='<?php echo $row['product_material']?>'></td>
            </tr>
            <tr>
            <td style='text-align:right'><label>Ship code*</label></td>
            <td><select name='ship_code' id='ship_code' style='height:30px; width:100%;'" required>

                <?php
                $sql="Select policy_code, policy_description from sale_policy where policy_type = 'shipping' order by 1";
                $result2 = mysqli_query($conn,$sql);
                while($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) { 
                    if ($row['ship_code']==$row2['policy_code']){
                        echo"<option value=$row2[policy_code] selected>$row2[policy_code]</option>";
                    }else{
                        echo"<option value=$row2[policy_code]>$row2[policy_code]</option>";
                    }
                }
                ?>
                </select> 
            </td>
            <td style='text-align:right'><label>Return code*</label></td>
            <td><select name='return_code' id='return_code' style='height:30px; width:100%;'" required>
                <?php
                $sql="Select policy_code, policy_description from sale_policy where policy_type='return' order by 1";
                $result2 = mysqli_query($conn,$sql);
                while($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) { 
                    if ($row['return_code']==$row2['policy_code']){
                        echo"<option value=$row2[policy_code] selected>$row2[policy_code]</option>";
                    }else{
                        echo"<option value=$row2[policy_code]>$row2[policy_code]</option>";
                    }
                }
                ?>
                </select> 
            </td>
        </tr>
            <tr>
                <td style='text-align:right'><label>Status*</label></td>
                <td>
                <select name='product_status' id='product_status' style='height:30px; width:100%;'>
                    <option value='Active' <?php if ($row['product_status']=='Active'){ echo 'selected'; } ?>>Active</option>
                    <option value='Inactive' <?php if ($row['product_status']=='Inactive'){ echo 'selected'; } ?>>Inactive</option>
                </select>
                <td style='text-align:right'><label>Day delivery*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 100%; text-align:right" required='required' class='textbox' id='product_delivery' name='product_delivery' value='<?php echo $row['product_delivery']; ?>'></td>
            </tr>
            <tr>
                <td style='text-align:right'><label>Price($)*</label></td>
                <td style='text-align:left'><input type='text' style = "width: 100%; text-align:right" required='required' class='textbox' id='product_price' name='product_price' value='<?php echo $row['product_price']; ?>'></td>
                <td style='text-align:right'><label>Description</label></td>
                <td style='text-align:left'><textarea rows="4" style = "width: 100%" class='textbox' id='product_description' name='product_description' value='<?php echo $row['product_description']; ?>'><?php echo $row['product_description']; ?></textarea></td>
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
    $product_description = validate($_POST['product_description']);
    $product_delivery = validate($_POST['product_delivery']);
    $ship_code = validate($_POST['ship_code']);
    $return_code = validate($_POST['return_code']);
    $product_price = validate($_POST['product_price']);
    
    $sql= " update products set product_name = '".$product_name."', product_artist = '".$product_artist."', 
            product_size_height = ".$product_size_height.", product_size_width = ".$product_size_width.", 
            product_material = '".$product_material."', product_status = '".$product_status."',  
            product_description = '".$product_description."', product_delivery = ".$product_delivery.",
            ship_code = '".$ship_code."', return_code = '".$return_code."',  product_price = ".$product_price." 
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