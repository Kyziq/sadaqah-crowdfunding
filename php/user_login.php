<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <form action="user_login_progress.php" method="post" class="login-form">
        <div class="input-login">
            Login Page
            <div class="input-field">
                <label>Username<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your username" name="user_username" required />
            </div>
            <div class="input-field">
                <label>Password<span style="color: red;"> *</span></label>
                <input type="password" placeholder="Enter your password" name="user_password" required />
            </div>

            <?php
            // Check for wrong password
            if (isset($_GET["msg"]) && $_GET["msg"] == 'failed')
                echo '<span style="color: #ed2146; font-size: 15px;"><b>Wrong username or password!</b></span>';
            ?>

            <div class="button">
                <button type="Reset">Reset</button>
                <button type="Submit" name="login-button" value="Submit">Login</button>
            </div>
        </div>

        <span class="text">Don't have an account?
            <a href="user_register.php">Register Now</a>
        </span>
    </form>
</body>

</html>