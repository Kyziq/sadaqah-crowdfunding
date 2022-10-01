<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_POST['registerButton'])) {
        // Connect to database 
        include_once 'dbcon.php';
        // Get all the posted items
        $user_username = $_POST['user_username'];
        $user_password = $_POST['user_password'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_phone = $_POST['user_phone'];
        $user_address = $_POST['user_address'];
        $user_level = 3;

        // Construct and run query to check if username is taken
        $q = "SELECT * FROM user WHERE user_username='$user_username'";
        $result = mysqli_query($con, $q);

        // If nothing matches (unique username)
        if (mysqli_num_rows($result) == 0) {
            // Construct and run query to store new user using prepared statements
            $q =    "INSERT INTO user(user_username, user_password, user_name, user_email, user_phone, user_address, user_level)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $q))
                echo "SQL statement failed";
            else {
                mysqli_stmt_bind_param($stmt, "ssssssi", $user_username, $user_password, $user_name, $user_email, $user_phone, $user_address, $user_level);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
            }
            mysqli_close($con);
            echo "Registration success!";
        }
    } else {
        header("Location: register.php");
    }
    ?>
</body>

</html>