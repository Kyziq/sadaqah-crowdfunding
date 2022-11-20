<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="icon" href="../images/logo-LZNK.ico">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        $phone = $_POST['phone'];
        $address  = $_POST['address'];
        $level = 3;

        /* Construct and run query to check if username is taken */
        $q = "SELECT * FROM user WHERE user_username='$username'";
        $result = mysqli_query($con, $q);

        /* If nothing matches (unique username) */
        if (mysqli_num_rows($result) == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            /* Query */
            $query = "INSERT INTO user(user_username, user_password, user_name, user_email, user_phone, user_address , user_level) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssssssi", $username, $password, $name, $email, $phone, $address, $level);
            $stmt->execute();
    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your account has been successfully created.',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = '../index.php';
                    }
                })
            </script>
    <?php
            // Close connection
            $stmt->close();
            $con->close();
        } else {
            header("Location: ../index.php?error=usernametaken");
        }
    } else {
        header("Location: ../index.php");
    }
    ?>
</body>

</html>