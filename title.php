<?php
if( empty(session_id()) && !headers_sent()){
        session_start();
    }
    include "ConnectionData.txt";
    $conn=mysqli_connect($servername,$username,$password);
    if (!$conn)
    {
        die('Could not connect: '.$mysqli_error());
    }
    mysqli_select_db($conn,$dbname) or die("Unable to select database $dbname");
    if (isset($_POST['search'])) {
        $search=$_POST['search'];
        $search=strtolower($search);
        
    }
?>
<div class="title">Vietnamese Lacquer Art</div>
    <div class="container" style = "background-color: darkred; flex-direction:row-reverse">
            <img src ="images/gbr.svg" width="40px" height="40px" style = "background-color: darkred; padding-left:10px; padding-right:10px;margin-right: 0;" /> 
            <img src ="images/vnm.svg" width="40px" height="40px" style = "background-color: darkred; padding-left:10px; padding-right:10px;margin-right: 0"/>

    </div>
</div>

