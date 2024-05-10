
<?php
    session_start();
    $_SESSION['language']=$_GET['lang'];
   
    /* Do work */
    if(isset($_SERVER["HTTP_REFERER"])){
        header("Location: {$_SERVER["HTTP_REFERER"]}");
    }else{
        header("Location: home.php");
    }
?>