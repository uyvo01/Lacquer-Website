<?php
$menu="order";
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
    $func='new_card';
}
if ($func=='new_card'){
?>
  <div class="container" style="margin-top:20px;">
    
    <form action="payment.php?func=add_card" method="post" style="width:30%; min-width:500px;">
      <div class="hw" style="text-align:center;">Add bank card</div>
      <br>
      <table style="width:100%">
        <tr><td width="200px">Card Holder Name<font color='red'>* </td><td><input style="width:100%" type="textbox" required='required' class='textbox' name='bank_holder_name' style='text-transform:uppercase' /></td></tr>
        <tr><td width="200px">Card Number (16 digits)<font color='red'>*</td><td><input style="width:100%" type='text' minlength='16' maxlength='16' class='textbox' name='bank_no' onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/></td></tr>
        <tr><td width="200px">Expiry Date<font color='red'>*</td><td><input style="width:100%" type='date' required='required' min='<?php echo $date?>' class='textbox' name='bank_exp'/></td></tr>
        <tr><td width="200px">CVV (3 digits)<font color='red'>*</td><td><input style="width:100%" type='text' required='required' class='textbox' name='bank_cvv' minlength='3' maxlength='3' onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/></td></tr>
        <tr><td></td><td><button type='submit' class='button' value ='submit'>Add card</button></td></tr>
      </table>
    </form>
  </div>
  <?php
}else if ($func=='add_card'){

}
?>