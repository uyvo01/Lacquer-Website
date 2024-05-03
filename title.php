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

?>
<div class="title">Vietnamese Lacquer Art</div>
<div class = "container" style = "background-color:darkred;">   
    <div class="container" style = "width:58%; margin-left:5px;" >
    <form action ="home.php" method="post" style = "margin-left:0px;padding:0px">
            <input type="text" style="width:250px; height:40px; font-style:italic; font-size:12pt; margin-bottom:0px;" name = "txtsearch" placeholder = "name, material, artirst, size">
            <button class="go" type="submit" style="margin-left:5px;" > Go </button>
    </form>  
    </div>
    
    <div class="container" style = "flex-direction:row-reverse; width:40%; ">
            <img src ="images/gbr.svg" width="40px" height="40px" style = "background-color: darkred; padding-left:10px; padding-right:10px;margin-right: 0;" /> 
            <img src ="images/vnm.svg" width="40px" height="40px" style = "background-color: darkred; padding-left:10px; padding-right:10px;margin-right: 0"/>
    </div>
</div>


