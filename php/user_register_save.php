<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Save</title>
</head>

<body>
    <?php
    /* Check if register button clicked */
    if (isset($_POST['register-button'])) {
        include_once 'dbcon.php'; // Connect to database 
        /* Get all the posted items */
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['user_phone'];
        $address  = $_POST['address '];
        $level = 3;

        /* Construct and run query to check if username is taken */
        $q = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($con, $q);

        /* If nothing matches (unique username) */
        if (mysqli_num_rows($result) == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            /* Query */
            $query = "INSERT INTO user(username, password, name, email, user_phone, address , level) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssssssi", $username, $password, $name, $email, $user_phone, $address, $level);
            $stmt->execute();

            if (isset($result) && is_resource($result)) {
                mysqli_free_result($result);  // Release returned data
            }
            mysqli_close($con); // Close connection
            echo "Registration success!";
        } else {
            header("Location: register.php");
        }
    } else {
        header("Location: register.php");
    }
    ?>
</body>

</html>