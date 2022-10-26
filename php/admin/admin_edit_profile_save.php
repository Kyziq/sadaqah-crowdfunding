<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details Saved</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <!-- Sweet Alert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate user */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1) {
        include_once '../dbcon.php'; // Connect to database 
        $user_id = $_SESSION['user_id'];

        if (isset($_POST['edit-action-button'])) { /* Edit my detail button is clicked */
            /* Get all the posted items */
            $user_username = $_POST['username'];
            $user_name = $_POST['name'];
            $user_email = $_POST['email'];
            $user_phone = $_POST['phone'];
            $user_address = $_POST['address'];

            /* Query */
            $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?"; // SQL with parameters
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssi", $user_username, $user_name, $user_email, $user_phone, $user_address, $user_id);
            $stmt->execute();

            if (isset($result) && is_resource($result)) {
                mysqli_free_result($result);  // Release returned data
            }
            mysqli_close($con); // Close connection

    ?>
            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Your new account details has been saved.',
                    text: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#192e59`,
                    timer: 5000,
                    willClose: () => {
                        window.location.href = 'admin_edit_profile.php';
                    }
                })
            </script>
            <?php

        } else if (isset($_POST['edit-password-button'])) { /* Edit password button is clicked */
            /* Get all the posted items */
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];

            if ($currentPassword == $newPassword) {
                echo "Your new password cannot be the same as your current password!";
            } else if ($newPassword != $confirmNewPassword) {
                echo "Your new password and confirm new password do not match!";
            } else {
                include_once 'dbcon.php'; // Connect to database 
                /* Query */
                $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameters
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result(); // Get the MySQLI result
                $r = $result->fetch_assoc(); // Fetch data

                /* Check if current password is correct */
                if (password_verify($currentPassword, $r['user_password'])) {
                    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $query = "UPDATE user SET user_password=? WHERE user_id=?"; // SQL with parameters
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("si", $newPassword, $user_id);
                    $stmt->execute();

                    // Close connection
                    $stmt->close();
                    $con->close();
            ?>
                    <!-- Success Popup -->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Your password has been changed.',
                            text: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#192e59`,
                            timer: 5000,
                            willClose: () => {
                                window.location.href = 'admin_edit_profile.php';
                            }
                        })
                    </script>
    <?php
                } else {
                    echo "Your current password is incorrect!";
                }
            }
        } else {
            header("Location: admin_edit_profile.php");
        }
    } else {
        header("Location: user_login.php");
    }
    ?>
</body>

</html>