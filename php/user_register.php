<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <form action="user_register_save.php" method="post" class="registerForm">
        <div class="input-registration">
            Registration Page
            <div class="input-field">
                <label>Username<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your username" name="user_username" required />
            </div>
            <div class="input-field">
                <label>Password<span style="color: red;"> *</span></label>
                <input type="password" placeholder="Enter your password" name="user_password" required />
            </div>
            <div class="input-field">
                <label>Full Name:<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your full name" name="user_name" required />
            </div>
            <div class="input-field">
                <label>Email<span style="color: red;"> *</span></label>
                <input type="text" placeholder="name@domainname" name="user_email" required />
            </div>
            <div class="input-field">
                <label>Phone Number: <span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your phone number" name="user_phone" required />
            </div>
            <div class="input-field">
                <label>Address<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your address" name="user_address" required />
            </div>

            <div class="button">
                <button type="Reset">Reset</button>
                <button type="Submit" name="registerButton" value="Submit">Register</button>
            </div>

        </div>
    </form>

</body>

</html>