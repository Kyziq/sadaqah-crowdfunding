<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <title>Login Page</title>
</head>

<body>
    Registration Page
    <form name="registerForm" action="user_register_save.php" method="post">
        <div class="form-group">
            <label>Username:</label>
            <div class="col-2">
                <input type="text" class="form-control" name="user_username" required />
            </div>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <div class="col-2">
                <input type="password" class="form-control" name="user_password" required />
            </div>
        </div>
        <div class="form-group">
            <label>Full Name:</label>
            <div class="col-2">
                <input type="text" class="form-control" name="user_name" required />
            </div>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <div class="col-2">
                <input type="email" class="form-control" name="user_email" required />
            </div>
        </div>
        <div class="form-group">
            <label>Phone Number:</label>
            <div class="col-2">
                <input type="number" step=1 class="form-control" name="user_phone" required />
            </div>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <div class="col-2">
                <textarea type="text" class="form-control" name="user_address" rows="3" required></textarea>
            </div>
        </div>

        <!-- <div class="g-recaptcha" data-sitekey="6LeHHUIgAAAAAEgwTJnckkfkbZ-0JlarQeLKsmg-"></div> -->
        <br>
        <button type="submit" class="btn btn-primary" id="register-button" name="register-button">Register</button>
    </form>

    <span class="text">
        Already a member?
        <a href="user_login.php">Login Now</a>
    </span>

    <!-- Import JS File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>