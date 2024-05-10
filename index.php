
<?php
    if( empty(session_id())){
        session_start();

        $_SESSION['email']="";
        $_SESSION['member_name']="";
        $_SESSION['member_id']="";
        $_SESSION['usertype']="";
        $_SESSION['language']="en";
    }
    echo session_id();

    header("Location: home.php");
?>

