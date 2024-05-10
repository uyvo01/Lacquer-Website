<?php
    include "ConnectionData.txt";
    $conn=mysqli_connect($servername,$username,$password);
    if (!$conn)
    {
        die('Could not connect: '.$mysqli_error());
    }
    mysqli_select_db($conn,$dbname) or die("Unable to select database $dbname");

?>
<div class="title"><?php echo $VietnameseLacquerArt ?></div>
<div class = "container" style = "background-color:darkred;">   
    <div class="container" style = "max-width:90%; min-width:300px;margin-left:5px;" >
    <form action ="home.php" method="post" style = "margin-left:0px;padding:0px">
            <input type="text" style="width:250px; height:40px; font-style:italic; font-size:12pt; margin-bottom:0px;" name = "txtsearch" placeholder = '<?php echo $name.', '.$material.', '.$artist .', '. $size; ?>'>
            <button class="go" type="submit" style="margin-left:5px;" > <?php echo $Go; ?></button>
    </form>  
    </div>
    
    <div class="container" style = "flex-direction:row; width:120px; margin-right:1px; ">
        <a class='icon' href='switchlang.php?lang=vn'>
            <img src ="images/vnm.svg" width="40px" height="40px" style = "background-color: darkred; padding-left:10px; padding-right:10px;margin-right: 0"/>
        </a>
        <a class='icon' href='switchlang.php?lang=en'>
            <img src ="images/gbr.svg" width="40px" height="40px" style = "background-color: darkred; padding-left:10px; padding-right:10px;margin-right: 0;" />
        </a>

    </div>
</div>


