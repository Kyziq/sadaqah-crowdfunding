<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /** Start session and validate user **/
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 2) {
        include_once '../dbcon.php'; // Connect to database
        $user_id = $_SESSION['user_id'];

        /** Edit my detail button is clicked **/
        if (isset($_POST['edit-action-button'])) {
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
                // Release returned data
                mysqli_free_result($result);
            }
            // Close connection
            mysqli_close($con);
    ?>

            <!-- Success Popup -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '<?php echo $user_name; ?>',
                    text: 'Your new account details has been saved.',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#1E976B`,
                    timer: 5000,
                    willClose: () => {
                        window.location.href = 'auditor_edit_profile.php';
                    }
                })
            </script>
            <?php
        }


        /** Edit password button is clicked **/
        else if (isset($_POST['edit-password-button'])) {
            /* Get all the posted items */
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];

            include_once '../dbcon.php'; // Connect to database
            /* Query */
            $query = "SELECT * FROM user WHERE user_id=?"; // SQL with parameters
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result(); // Get the MySQLI result
            $r = $result->fetch_assoc(); // Fetch data

            /* Check current password is correct */
            if (password_verify($currentPassword, $r['user_password'])) {
                /* Check current password same as new password */
                if ($currentPassword == $newPassword) {
            ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Your new password cannot be the same as your current password.',
                            footer: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#1E976B`,
                            timer: 5000,
                            willClose: () => {
                                window.location.href = 'auditor_edit_profile.php';
                            }
                        })
                    </script>
                <?php
                } elseif ($newPassword != $confirmNewPassword) {
                ?>
                    <!-- Fail Popup (new password and confirm new password do not match)-->
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Your new password and confirm new password do not match.',
                            footer: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#1E976B`,
                            timer: 5000,
                            willClose: () => {
                                window.location.href = 'auditor_edit_profile.php';
                            }
                        })
                    </script>
                <?php
                } else {
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
                            title: 'Success!',
                            text: 'Your password has been changed.',
                            footer: '(Auto close in 5 seconds)',
                            showConfirmButton: true,
                            confirmButtonText: 'Confirm',
                            backdrop: `#1E976B`,
                            timer: 5000,
                            willClose: () => {
                                window.location.href = 'auditor_edit_profile.php';
                            }
                        })
                    </script>
                <?php
                }
            } else {
                ?>
                <!-- Fail Popup (new password cannot be the same as current password)-->
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your current password is incorrect.',
                        footer: '(Auto close in 5 seconds)',
                        showConfirmButton: true,
                        confirmButtonText: 'Confirm',
                        backdrop: `#1E976B`,
                        timer: 5000,
                        willClose: () => {
                            window.location.href = 'auditor_edit_profile.php';
                        }
                    })
                </script>
    <?php
            }
        } else {
            header("Location: auditor_edit_profile.php");
        }
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>