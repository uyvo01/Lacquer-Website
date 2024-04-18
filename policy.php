<?php
    $menu="policy";
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
    if ($func=='new_policy'){
    ?>
    <br />
    <form class = 'normal' style="background-color: darkred;width:100%;max-width:500px" action='policy.php?func=add_policy' method = 'post' enctype="multipart/form-data">
    <h1>ADD POLICY</h1>
    <table style='width:100%'>
        <tr>
            <td style='text-align:right'><label>Policy Type*</label></td>
            <td>
                <select name='policy_type' id='policy_type' style='height:30px; width:100%;' required>
                    <option value=''>Select</option>
                    <option value='shipping'>Free Shipping - X USD</option>
                    <option value='return'>Free Return - Y days</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Code*</label></td>
            <td style='text-align:left;'><input type='text' oninput="this.value = this.value.toUpperCase()" style = "width: 100%" required='required' class='textbox' id='policy_code' name='policy_code' value=''></td>
        </tr>
        <tr>
            <td style='text-align:right'><label>Value*</label></td>
            <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='policy_value' name='policy_value' value=''></td>
        </tr>    
        <tr>
            <td style='text-align:right'><label>Description*</label></td>
            <td style='text-align:left'>
                <input type='text' class='textbox' style = "width: 100%" id='policy_description' name='policy_description' value=''>
            </td>
        </tr>
        <tr>
            <td></td>
            <td td colspan='3'style='text-align:left'><label>(*): mandatory<label></td>
        </tr>
        <tr>
            <td></td><td td colspan='3'><button type='submit' class='button' value='submit' name='submit'>Submit
            <button type='reset' class='button' value='Reset'>Reset</td>         
        </tr>
    </table>
    </form>
    <br />
    <?php
    }else if ($func=='add_policy'){
        
        //------------------ADD POLICY INFORMATION--------------------------
        $policy_type = validate($_POST['policy_type']);
        $policy_code = validate($_POST['policy_code']);
        $policy_value = validate($_POST['policy_value']);
        $policy_description = validate($_POST['policy_description']);
    
    
        $sql="select policy_code from sale_policy where policy_code = '".$policy_code."'";
        $result=mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);
    
        if($num>0){
            header("Location: policy.php?error=The policy exists!");
            exit();
        }
        // insert to table products
        $sql= " insert into sale_policy(policy_type, policy_code, policy_value, policy_description) 
                values('".$policy_type."','".$policy_code. "',".$policy_value. ",'".$policy_description. "')";
        $result = mysqli_query($conn,$sql);
        header("Location: policy.php?func=list_policy&error=Add successfully!");
        //------------------END ADD POLICY INFORMATION----------------------
        
    //-----------------------BEGIN THE FEATURE LIST POLICY---------------------
    }else if ($func=='list_policy'){
        echo "<div class = 'hb'>SALE POLICY MANAGEMENT</div>";
        echo "<hr />";
        echo "<center><a style='padding:0px' href='policy.php?func=new_policy'><button>Add new</button></a></center><br/>";
        
        echo "<table>";
        echo "<thead>
                <td>#</td>
                <td>Type</td>
                <td>Code</td>
                <td>Value</td>
                <td>Description</td>
                </thead>";
        $sql="  select p.policy_no, p.policy_type, p.policy_code, p.policy_value, p.policy_description
                from sale_policy p 
                where 1=1 order by policy_type desc";
    
        $result=mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
            echo "<tr>";
            echo "<td style='text-align: right'><a href='policy.php?func=edit_policy&policy_no=$row[policy_no]' class='icon'><img src='images/edit.png' width='30px' height='30px'></a></td>";
            echo "<td>$row[policy_type]</td>";
            echo "<td>$row[policy_code]</td>";
            echo "<td style = 'text-align:right'>$row[policy_value]</td>";
            echo "<td>$row[policy_description]</td>";
            echo "</tr>";
        }
        echo "</table>";
    
    //-------------------Begin function edit policy------------------------
    }else if ($func=='edit_policy'){
        $policy_no = $_GET['policy_no'];
        $sql="  select p.policy_no, p.policy_type, p.policy_code, p.policy_value
                , p.policy_description
                from sale_policy p 
                where p.policy_no = '".$policy_no."'";
            
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result, MYSQLI_BOTH)
        ?>
        <br />
        <form class='normal' style="background-color: darkred;width:100%;max-width:500px" action='policy.php?func=update_policy' method = 'post' enctype="multipart/form-data">
        <h1>UPDATE POLICY</h1>
        <input type="hidden" id="policy_no" name="policy_no" value='<?php echo $row['policy_no']?>' />
        <div class="container" style='background-color: bisque;'>
            <table style='width:100%;'>
                <tr>   
                    <td style='text-align:right'><label>Policy Type*</label></td>
                    <td ><input type='text' style = "width: 100%" required='required' class='textbox' readonly id='policy_code' name='policy_type' value='<?php echo $row['policy_type']?>'></td>
                </tr>
                <tr>
                    <td style='text-align:right'><label>Code*</label></td>
                    <td style='text-align:left'><input style='text-transform:uppercase;' type='text'  readonly style = "width: 100%" required='required' class='textbox' id='policy_code' name='policy_code' value='<?php echo $row['policy_code']?>'></td>
                </tr>    
                <tr>
                    <td style='text-align:right'><label>Value</label></td>
                    <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='policy_value' name='policy_value' value='<?php echo $row['policy_value']?>'></td>
                </tr>
                <tr>
                    <td style='text-align:right'><label>Description </label></td>
                    <td style='text-align:left'><input type='text' style = "width: 100%" required='required' class='textbox' id='policy_description' name='policy_description' value='<?php echo $row['policy_description']?>'></td>
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
     //------------------UPDATE POLICY INFORMATION--------------------------
    }else if ($func=='update_policy'){
       
        $policy_no = validate($_POST['policy_no']);
        $policy_type = validate($_POST['policy_type']);
        $policy_code = validate($_POST['policy_code']);
        $policy_value = validate($_POST['policy_value']);
        $policy_description = validate($_POST['policy_description']);
        
        $sql= " update sale_policy set policy_type = '".$policy_type."', policy_code = '".$policy_code."', 
                policy_value = ".$policy_value.", policy_description = '".$policy_description."'
                where policy_no = ".$policy_no."";
        $result = mysqli_query($conn,$sql);
        header("Location: policy.php?func=message&content=Update successfully!");
        //------------------END UPDATE PAINTING INFORMATION----------------------
    }else if ($func=='message'){
        echo "<div class = 'hb'>$_GET[content]</div>";
        echo "<br />";
        echo "<center><a href='policy.php?func=list_policy' style ='background-color:orange;'>Back to the list...</a></center>";
    
    }
        include "footer.php";
    ?>