<?php
    $menu="signin";
    include "header.php";
?>
<head>
    <meta name="google-signin-client_id" content="158007705898-ajs0q2l5uk5pfmen6jlbr7v2kke0s4lp.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js?onload=renderButton_hidden" async defer></script>

</head>
<body>

    <hr>
    <?php if (isset($_GET['error'])) { ?>
        <div class="hb20" style="text-align: center; margin-bottom:25px;"> <?php echo $_GET['error']; ?></div>
    <?php } ?>
    <form action="login.php" method = "post">
        <h1><?php echo $SIGNIN; ?></h1>
        
        <table style="width:400px">
        <tr>
        <td><label> <?php echo $UserName;?></label></td>
        <td><input type = "text" class="textbox" name = "username" placeholder="example@gmail.com"></td>
        </tr>
        <tr><td><label><?php echo $Password; ?></label></td><td><input type = "password" class="textbox"  name = "password" placeholder="Password"></td></tr>
        <tr><td></td><td><button type="submit" class="button" ><?php echo $Signin;?></button> </td></tr>
        
        </table>
        <br />
        <div class="container">   
            <h4 style='margin:0px;'> <?php echo $Notregistered;?>? <a style='border-radius:8px; background:orange;' href="signup.php" ><?php echo $Createaccount;?></a></h4>
        </div>
    </form>
</body>
<script>
    function onSuccess(googleUser) {
      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    }
    function onFailure(error) {
      console.log(error);
    }
    function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
    }

</script>
<?php
    include "footer.php";
?>