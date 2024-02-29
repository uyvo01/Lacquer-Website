<?php
    include "title.php"; 
    if( empty(session_id()) && !headers_sent()){
        session_start();
    } 
    if (empty($menu)){
        $menu="home";
    }
    if($_SESSION["usertype"]=="B"){
        include "menu_b.php";
    }else if($_SESSION["usertype"]=="S"){
        include "menu_s.php";
    }else if($_SESSION["usertype"]=="A"){
        include "menu_a.php";
    }else {
        include "menu.php"; //menu in index page
    }
?>
