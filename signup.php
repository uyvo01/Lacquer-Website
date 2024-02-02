<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Vietnamese Lacquer Art</title>
</head>
<?php
    include 'ConnectionData.txt';
    $conn=mysqli_connect($servername,$username,$password);
    if (!$conn)
    {
        die('Could not connect: '.$mysqli_error());
    }
    mysqli_select_db($conn,$dbname) or die("Unable to select database $dbname");
    include "title.php";
    include "menu1.php";
?>

<body>
<script>  
function verifyPassword() {  
    var password = document.getElementById("password").value;
    var confirm = document.getElementById("confirm_pass").value;
    if (confirm != password) {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Not matching';
        return false;
    } else {
        document.getElementById('message').innerHTML = '';
    }
}
// change specialty
function change_type(value) {
  if(value=='Saler'){
    document.getElementById("ssn").value = '';
    document.getElementById("ssn").style.visibility = 'visible';
  }else{
    document.getElementById("ssn").style.visibility = 'hidden';
    //document.getElementById("ssn").value = 'abc';
    document.getElementById("ssn").placeholder="Tax code";
  }
}
</script> 
<hr>

<form action='signup.php' method = 'post' onsubmit='return verifyPassword()'>
<h1>SIGN UP</h1>
<?php if (isset($_GET['error'])) { ?>
    <p class = "error"> <?php echo $_GET['error']; ?> </p>
<?php } ?>
<table style='width:900px'>
    <tr>
        <td style='text-align:right'><label>First Name*</label></td>
        <td style='text-align:left'><input type='text' required='required' class='textbox' id='first_name' name='first_name' value=''></td>
        <td style='text-align:right'><label>Last Name*</label></td>
        <td style='text-align:left'><input type='text' required='required' class='textbox' id='last_name' name='last_name' value=''></td>
    </tr>
    <tr>
       <td style='text-align:right'><label>Birthday</label></td>
        <td style='text-align:left'><input type='date' style='height:25px;" required='required' class='textbox' max='2023-01-01' id='birth_day' name='birth_day' value=''></td>
        <td style='text-align:right'><label>Primary Phone*</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='phone_no' name='phone_no' value=''></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Member Type*</label></td>
        <td colspan=3 ><select name='type' id='type' style='height:25px; width:150px;' onchange="change_type(this.value);" required>
            <option value=''>Select</option>
                <?php
                $sql="Select type, description from member_type where type<>'A' order by 1";
                $result2 = mysqli_query($conn,$sql);
                while($row2 = mysqli_fetch_array($result2, MYSQLI_BOTH)) { 
                    if ($row['description']==$row2['description']){
                        echo"<option value=$row2[description] selected>$row2[description]</option>";
                    }else{
                        echo"<option value=$row2[description]>$row2[description]</option>";
                    }
                }
                ?>
        </select> 
        <input type='text' class='textbox' id='ssn' name='ssn' required='required' style='visibility: hidden' placeholder="Tax code"></td>
        </tr>
    <tr>
        <td style='text-align:right'><label>Street #</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='street_no' name='street_no' value=''></td>
        <td style='text-align:right'><label>Street Name</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='street_name' name='street_name' value=''></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>City</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='city' name='city' value=''></td>
        <td style='text-align:right'><label>State</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='state' name='state' value=''></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Zip Code</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='zip_code' name='zip_code' value=''></td>
        <td style='text-align:right'><label>ID Number</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='id_number' name='id_number' value=''></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Email*</label></font></td>
        <td style='text-align:left'><input type='email' required='required' class='textbox' id='username' name='username' value=''></td>
        <td></td><td></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Password*</label></td>
        <td style='text-align:left'><input type='password' required='required' minlength='6' class='textbox' id='password' name='password' value=''></td>
        <td></td><td></td>
    </tr>
    <tr>    
        <td style='text-align:right'><label>Confirm Password*</label></td>
        <td style='text-align:left'><input type='password' required='required' minlength='6' class='textbox' id='confirm_pass' name='confirm_pass' value=''></td>
        <td colspan='2'><span id='message'></span></td>
    </tr>
    <tr>
        <td></td>
        <td style='text-align:left'><label>(*): mandatory<label></td>
        <td></td><td></td>
    </tr>
    <tr>
    <td></td><td><input type='submit' class='button' value='Sign up' onclick='verifyPassword()'>
    <input type='reset' class='button' value='Reset'></td> <td></td><td></td>
    </tr>
</table>
</form>

<?php
    include "footer.php";
?>