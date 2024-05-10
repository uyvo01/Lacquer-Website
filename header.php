
<link rel="stylesheet" href="style.css">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<header>
<?php
    session_start();
    include 'ConnectionData.txt';
    include "language.php";
    include "title.php";
    if (empty($menu)){
        $menu="home";
    }
    if(!empty( $_SESSION["usertype"]) && $_SESSION["usertype"]=="B"){
        include "menu_b.php";
    }else if(!empty( $_SESSION["usertype"]) && $_SESSION["usertype"]=="S"){
        include "menu_s.php";
    }else if(!empty( $_SESSION["usertype"]) && $_SESSION["usertype"]=="A"){
        include "menu_a.php";
    }else {
        include "menu.php"; //menu in index page
    }
?>
</header>