<!-- /* Copyright (C) Uy Vo, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Uy Vo <uyvo01@gmail.com>, May 2024
 */
-->
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

    $first_name = validate($_POST['first_name']);
    $last_name = validate($_POST['last_name']);
    $birth_day = validate($_POST['birth_day']);
    $phone_no = validate($_POST['phone_no']);
    $type = validate($_POST['type']);
    $tax = validate($_POST['tax']);
    $street_no = validate($_POST['street_no']);
    $suite = validate($_POST['suite']);
    $city = validate($_POST['city']);
    $state = validate($_POST['state']);
    $zip_code = validate($_POST['zip_code']);
    $username =  validate($_POST['username']);
    $pass = validate($_POST['password']);
    $pass = hash('ripemd128', $pass);

    if(empty($username)){
        header("Location: signup.php?error=User Name is required!");
        exit();
    }
    else if(empty($pass)){
        header("Location: signup.php?error=Password is required!");
        exit();
    } else if(empty($type)){
        header("Location: signup.php?error=Member type is required!");
        exit();
    } else if(empty($first_name)){
        header("Location: signup.php?error=First name is required!");
        exit();
    } else if(empty($last_name)){
        header("Location: signup.php?error=Last name is required!");
        exit();
    } else if(empty($birth_day)){
        header("Location: signup.php?error=Birth day is required!");
        exit();
    } else if(empty($phone_no)){
        header("Location: signup.php?error=Phone number is required!");
        exit();
    }

    $sql="select email from users where email = '".$username."'";
    $result=mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);

    if($num>0){
        header("Location: signup.php?error=The email exist!");
        exit();
    }
    // insert to table members
    $sql= " insert into members(lastname, firstname, birthday, phone_no, street_no, 
                suite, city, state, zipcode, email, member_type, tax) 
            values('".$last_name. "','". $first_name. "','". $birth_day. "',
                '". $phone_no. "', '". $street_no. "','". $suite. "',
                '". $city. "','". $state. "','". $zip_code. "','". $username."',
                '". $type."','". $tax."')";
    $result = mysqli_query($conn,$sql);
    // insert to table users
    $sql="insert into users values('".$username."', '".$pass."','".$type."','A')";
    $result=mysqli_query($conn,$sql);
    
    // redirect to home page
    $sql="select u.email, u.usertype, m.member_id, concat(m.firstname,' ',m.lastname) as member_name from users u, members m where u.email = m.email and u.email='".$username."' and password = '".$pass."' ";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $_SESSION['email']=$row['email'];
        $_SESSION['member_name']=$row['member_name'];
        $_SESSION['member_id']=$row['member_id'];
        $_SESSION['usertype']=$row['usertype'];
        header("Location: home.php?error=Register Successfully!");
    }
?>
