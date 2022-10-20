<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <title>Login Page</title>
</head>

<body>
    Registration Page
    <form action="user_register_save.php" method="post" class="register-form">
        <table>
            <tr>
                <td>
                    <label><span style="color: red;">*</span>Username:</label>
                </td>
                <td><input type="text" placeholder="Enter your username" name="user_username" required /></td>
            </tr>
            <tr>
                <td>
                    <label><span style="color: red;">*</span>Password:</label>
                </td>
                <td> <input type="password" placeholder="Enter your password" name="user_password" required /></td>
            </tr>
            <tr>
                <td>
                    <label><span style="color: red;">*</span>Full Name:</label>
                </td>
                <td> <input type="text" placeholder="Enter your full name" name="user_name" required /></td>
            </tr>
            <tr>
                <td>
                    <label><span style="color: red;">*</span>Email:</label>
                </td>
                <td> <input type="text" placeholder="name@domainname" name="user_email" required /></td>
            </tr>
            <tr>
                <td>
                    <label><span style="color: red;">*</span>Phone Number:</label>
                </td>
                <td> <input id="user_phone" type="tel" name="user_phone" required /></td>
            </tr>
            <tr>
                <td>
                    <label><span style="color: red;">*</span>Address:</label>
                </td>
                <td> <input type="text" placeholder="Enter your address" name="user_address" required /></td>
            </tr>
        </table>
        <button type="Reset">Reset</button>
        <button type="Submit" id="register-button" name="register-button" value="Submit">Register</button>
    </form>

    <span class="text">
        Already a member?
        <a href="user_login.php">Login Now</a>
    </span>

    <script>
        const phoneInputField = document.querySelector("#user_phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            preferredCountries: ["my"],
        });

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        document.getElementById("register-button").addEventListener("click", function() {
            setCookie("user_phone", phoneInput.getNumber(), "10");
        });
    </script>
</body>

</html>