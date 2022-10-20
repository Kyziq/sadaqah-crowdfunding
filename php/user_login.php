<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    Login Page
    <form action="user_login_action.php" method="post">
        <table>
            <tr>
                <td>
                    <label>Username:</label>
                </td>
                <td>
                    <input type="text" placeholder="Enter your username" name="user_username" required />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Password:</label>
                </td>
                <td>
                    <input type="password" placeholder="Enter your password" name="user_password" required />
                </td>
                <td>
                    <?php
                    // Check for wrong password
                    if (isset($_GET["msg"]) && $_GET["msg"] == 'failed')
                        echo '<span style="color: #ed2146; font-size: 15px;"><b>Wrong username or password!</b></span>';
                    ?>
                </td>
            </tr>
        </table>
        <button type="Reset">Reset</button>
        <button type="Submit" name="login-button" value="Submit">Login</button>
    </form>

    <div>
        Don't have an account?
        <a href="user_register.php">Register Now</a>
        <a href="../index.php">Home</a>
    </div>
</body>

</html>