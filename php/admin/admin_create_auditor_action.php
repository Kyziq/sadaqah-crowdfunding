<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Auditor</title>
    <link rel="icon" href="../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate admin */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        /* Check if create auditor button clicked */
        if (isset($_POST['createAuditorButton'])) {
            /* DB Connect and Setting */
            include_once '../dbcon.php';

            $level = 2; // Auditor level
            /* Get all the posted items */
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address  = $_POST['address'];

            /* SweetAlert2 Popup */
            function resultPopup($type)
            {
                if ($type == "success") {
    ?>
                    <!-- Success Popup -->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'A new auditor has been successfully created.',
                            footer: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#2871f9`,
                            confirmButtonColor: '#0d6efd',
                            timer: 5000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = 'admin.php';
                            }
                        })
                    </script>
                <?php
                } else if ($type == "error") {
                ?>
                    <!-- Error Popup -->
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'The username has been taken! Get a new username.',
                            footer: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#2871f9`,
                            confirmButtonColor: '#0d6efd',
                            timer: 5000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href = 'admin_create_auditor.php';
                            }
                        })
                    </script>
    <?php
                }
            }
            /* End SweetAlert2 Popup */

            /* SELECT Query (Check if username is taken) */
            $q = "SELECT * FROM user WHERE user_username='$username'";
            $result = mysqli_query($con, $q);

            /* If nothing matches (unique username) */
            if (mysqli_num_rows($result) == 0) {
                $password = password_hash($password, PASSWORD_DEFAULT);

                /* INSERT Query */
                $query = "INSERT INTO user(user_username, user_password, user_name, user_email, user_phone, user_address, user_level) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("ssssssi", $username, $password, $name, $email, $phone, $address, $level);
                $stmt->execute();

                resultPopup("success");

                /* Close connection */
                $stmt->close();
                $con->close();
            } else {
                resultPopup("error");
            }
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>