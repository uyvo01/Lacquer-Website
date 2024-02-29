
<?php
    if( empty(session_id()) && !headers_sent()){
        session_start();
    }
    $_SESSION['email']="";
    $_SESSION['member_name']="";
    $_SESSION['member_id']="";
    $_SESSION['usertype']="";
    $menu="home";
    header("Location: home.php");
?>

