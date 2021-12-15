<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
            rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/login.style.css"/>
    <title>Login - Futurama</title>
    <!-- jQuery JS 3.1.0 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script defer src="js/login-validation.js"></script>
</head>

<body>
<div class="container">
    <h2 class="name">
        Futurama
    </h2>

    <ul id="error">
        <?php if (isset($error_message)) {
            echo "<li>" . $error_message . "</li>";
        } ?>
        <?php if (isset($success_message)) {
            echo "<li style='color:green'>" . $success_message . "</li>";
        } ?>
    </ul>

    <form id="registerform" method="POST" style="display: none;" action="login">
        <div class="login-item">
            <div class="form-field">
                <input id="register_fullname" class="input-form" placeholder="Full name" name="register_full_name"
                       type="text">
            </div>
            <div class="form-field">
                <input id="register_email" class="input-form" placeholder="Email" name="register_email" type="text">
            </div>
            <div class="form-field">
                <input id="register_username" class="input-form" placeholder="Username" name="register_username"
                       type="text">
            </div>
            <div class="form-field">
                <input id="register_password" class="input-form" placeholder="Password" name="register_password"
                       type="password">
            </div>
            <div class="form-field">
                <input id="register_confirm_password" class="input-form" placeholder="Confirm password"
                       name="register_password_confirm" type="password">
            </div>
            <div class="form-field align-right">
                <input class="input-form buttonLogin" type="submit" name="register_submit" value="Register">
            </div>
        </div>
        <div class="center">
            <a class="color-black" id="toogleLogin">You are already registred?</a>
        </div>

    </form>

    <form id="loginform" method="POST" action="login">
        <div class="login-item">
            <div class="form-field">
                <input id="loginusername" class="input-form" placeholder="Username" name="login_username" type="text">
            </div>
            <div class="form-field">
                <input id="loginpassword" class="input-form" placeholder="Password" name="login_password"
                       type="password">
            </div>
            <div class="form-field align-right">
                <input class="input-form buttonLogin" type="submit" name="login_submit" value="Log in">
            </div>
            <div class="center">
                <a class="color-black" id="toogleRegister">Need account ?</a>
            </div>

        </div>

    </form>
</div>
<div class="links">
<?PHP

?>
    <a class="link" href="<?php echo $this->url_login_page_redirect("home"); ?>">Home</a>
    <a class="link" href="<?php echo $this->url_login_page_redirect("about"); ?>">About us</a>
    <a class="link" href="<?php echo $this->url_login_page_redirect("contact"); ?>">Contact us</a>
    <a class="link" href="<?php echo $this->url_login_page_redirect("product"); ?>">Products</a>
    <a class="link" href="<?php echo $this->url_login_page_redirect("news"); ?>">News</a>
</div>

</body>

</html>
