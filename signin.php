<head>
 <link rel="stylesheet" href="style.css">
 <title>Vietnamese Lacquer Art</title>
 <style>
 </style>
</head>
<body>
    <?php
    include "title.php";
    include "menu1.php";
    ?>
    <hr>
    <form action="login.php" method = "post">
        <h1>SIGN IN</h1>
        <?php if (isset($_GET['error'])) { ?>
            <p class = "error"><h3><font color='Red'> <?php echo $_GET['error']; ?></font></h3> </p>
        <?php } ?>
        <table style="width:400px">
        <tr>
        <td><label> User Name </label></td>
        <td><input type = "text" class="textbox" name = "username" placeholder="User Name"></td>
        </tr>
        <tr><td><label>Password</label></td><td><input type = "password" class="textbox"  name = "password" placeholder="Password"></td></tr>
        <tr><td></td><td><button type="submit" class="button" >Sign in</button> </td></tr>
        <tr><td></td><td>&nbsp;</td></tr>
        <tr><td colspan="2" align="center"><label>Not register? <a href="signup.php">Create an account</a></label></td></tr>
        </table>
    </form>
    
    <table style="height:400px">
    <tr style="border: none;">
    <td style="border: none;"></td>
    </tr>
    </table>
<?php
    include "footer.php";
?>