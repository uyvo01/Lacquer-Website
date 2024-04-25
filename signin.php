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
    <form action="login.php" method = "post">
        <h1>SIGN IN</h1>
        <?php if (isset($_GET['error'])) { ?>
            <p class = "error"><h3> <?php echo $_GET['error']; ?>!</h3> </p>
        <?php } ?>
        <table style="width:400px">
        <tr>
        <td><label> User Name </label></td>
        <td><input type = "text" class="textbox" name = "username" placeholder="User Name"></td>
        </tr>
        <tr><td><label>Password</label></td><td><input type = "password" class="textbox"  name = "password" placeholder="Password"></td></tr>
        <tr><td></td><td><button type="submit" class="button" >Sign in</button> </td></tr>
        
        </table>
        <br />
        <div class="container">   
            <h4 style='margin:0px;'> Not registered? <a style='border-radius:8px; background:orange;' href="signup.php" >Create an account</a></h4>
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