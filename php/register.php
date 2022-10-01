<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <form action="register_save.php" class="registerForm">
        <div class="input-registration">
            Registration Page
            <div class="input-field">
                <label>Username<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your username" name="userUname" id="userUname" required />
            </div>
            <div class="input-field">
                <label>Password<span style="color: red;"> *</span></label>
                <input type="password" placeholder="Enter your password" name="userPassw" required />
            </div>
            <div class="input-field">
                <label>Email<span style="color: red;"> *</span></label>
                <input type="text" placeholder="name@domainname" name="userEmail" required />
            </div>

            <div class="input-field">
                <label>Full Name:<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your full name" name="userEmail" required />
            </div>
            <div class="input-field">
                <label>Phone Number: <span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your phone number" name="userEmail" required />
            </div>
            <div class="input-field">
                <label>Address<span style="color: red;"> *</span></label>
                <input type="text" placeholder="Enter your address" name="userEmail" required />
            </div>
        </div>
    </form>

</body>

</html>