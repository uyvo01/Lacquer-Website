<html>
<?php
    $menu="profile";
    include "header.php";
?>

<body>
<script>  
function verifyPassword() {  
    var password = document.getElementById("password").value;
    var confirm = document.getElementById("confirm_pass").value;
    if (confirm != password) {
        document.getElementById('message').style.color = 'white';
        document.getElementById('message').innerHTML = 'Confirm not matching';
        return false;
    } else {
        document.getElementById('message').innerHTML = '';
    }
}
// change type
</script> 
<hr>

<form action='profile.php' method = 'post'>

<?php if (isset($_GET['message'])) { ?>
    <div class = "hb20"> <?php echo $_GET['message']; ?> </div>
<?php }
    if (isset($_POST['firstname'])){
        $birthday = $_POST['birthday'];
        $phone_no = $_POST['phone_no'];
        $street_no = $_POST['street_no'];
        $suite = $_POST['suite'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zipcode = $_POST['zipcode'];
        //----UPDATE USER INFORMATION---------------------------
        $sql = "update members set birthday = '".$birthday."', phone_no = '".$phone_no."' , street_no = '".$street_no."', suite = '".$suite."'
                , city = '".$city."', state = '".$state."', zipcode = '".$zipcode."'
                where member_id ='".$_SESSION['member_id']."'";

        $result = mysqli_query($conn,$sql);
        header('location: profile.php?message=Update information successfully!');
    }
    $sql = "Select firstname, lastname, birthday, phone_no, street_no, suite, city, state, zipcode, member_type, email
        from members where member_id = '".$_SESSION['member_id']."'";
    $result=mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
    if($row['member_type']=='A'){
        $membertype = 'Admin';
    }else if($row['member_type']=='S'){
        $membertype = 'Seller/Buyer';
    }else{
        $membertype = 'Buyer';
    }
?>
<h1>Update Account Information</h1>
<table style='width:600px'>
    <tr>
        <td style='text-align:right'><label>First Name*</label></td>
        <td style='text-align:left'><input type='text' readonly required='required' id='firstname' name='firstname' value='<?php echo $row['firstname']; ?>'></td>
        <td style='text-align:right'><label>Last Name*</label></td>
        <td style='text-align:left'><input type='text' readonly required='required' class='textbox' id='lastname' name='lastname' value='<?php echo $row['lastname']; ?>'></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Birthday</label></td>
        <td style='text-align:left'><input type='date' style='height:25px;width:146px;' required='required' class='textbox' max='2023-01-01' id='birthday' name='birthday' value='<?php echo $row['birthday']; ?>'></td>
        <td style='text-align:right'><label>Primary Phone*</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='phone_no' name='phone_no' value='<?php echo $row['phone_no']; ?>'></td>
    </tr>
    
    <tr>
        <td style='text-align:right'><label>Street #</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='street_no' name='street_no' value='<?php echo $row['street_no']; ?>'></td>
        <td style='text-align:right'><label>Suite/Apt.</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='suite' name='suite' value='<?php echo $row['suite']; ?>'></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>City</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='city' name='city' value='<?php echo $row['city']; ?>'></td>
        <td style='text-align:right'><label>State</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='state' name='state' value='<?php echo $row['state']; ?>'></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Zip Code</label></td>
        <td style='text-align:left'><input type='text' class='textbox' id='zipcode' name='zipcode' value='<?php echo $row['zipcode']; ?>'></td>
        <td></td><td></td>
    </tr>
    <tr>
        <td style='text-align:right'><label>Member Type*</label></td>
        <td style='text-align:left'><input type='text' id='member_type' name='member_type' readonly value='<?php echo $membertype; ?>'></td>
        <td style='text-align:right'><label>Email*</label></font></td>
        <td style='text-align:left'><input type='text' required='required' id='username' name='username' readonly value='<?php echo $row['email']; ?>'></td>
    </tr>
    <tr>
        <td></td>
        <td style='text-align:left'><label>(*): mandatory<label></td>
        <td></td><td></td>
    </tr>
    <tr>
    <td></td><td><button type='submit' class='button' value='Submit'>Submit</button>
    <button type='reset' class='button' value='Reset'>Reset</button></td> <td></td><td></td>
    </tr>
</table>
</form>

<?php
    include "footer.php";
?>