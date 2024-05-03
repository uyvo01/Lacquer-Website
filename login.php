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
    if(isset($_POST['username']) && isset($_POST['password'])){
        function validate($data) {
            $data = trim($data);
            $data=stripslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }
    }
    $username =  validate($_POST['username']);
    $pass = validate($_POST['password']);
    $pass = hash('ripemd128', $pass);

    if(empty($username)){
        header("Location: signin.php?error=User Name is required");
        exit();
    }
    else if(empty($pass)){
        header("Location: signin.php?error=Password is required");
        exit();
    }
    $sql="select u.email, u.usertype, m.member_id, concat(m.firstname,' ',m.lastname) as member_name from users u, members m where u.email = m.email and u.email='".$username."' and password = '".$pass."' ";

    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $_SESSION['email']=$row['email'];
        $_SESSION['member_name']=$row['member_name'];
        $_SESSION['member_id']=$row['member_id'];
        $_SESSION['usertype']=$row['usertype'];
        header("Location: home.php");
    }else{
        header("Location: signin.php?error=Incorrect User Name or Password!");
        exit();
    }
?>
