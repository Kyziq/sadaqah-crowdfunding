<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link rel="icon" href="../../images/logo-LZNK.ico">

    <!-- Imports -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    /* Start session and validate donator */
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3) {
        /* DB Connect and Setting */
        include_once '../dbcon.php';

        $user_id = $_SESSION['user_id'];
        /* SweetAlert2 */
        // Success
        function successPopup($condition)
        {
            if ($condition == 'profile') {
                $text = 'Your new account details has been saved.';
            } else if ($condition == 'password') {
                $text = 'Your new password has been saved.';
            }
    ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?php echo $text ?>',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'donator_edit_profile.php';
                    }
                })
            </script>
        <?php
        }

        // Error
        function errorPopup($condition)
        {
            if ($condition == 'pw-same') {
                $text = "Your new password cannot be the same as your current password.";
            } else if ($condition == 'pw-not-match') {
                $text = "Your new password and confirm new password do not match.";
            } else if ($condition == 'pw-current-incorrect') {
                $text = "Your current password is incorrect.";
            }
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo $text; ?>',
                    footer: '(Auto close in 5 seconds)',
                    showConfirmButton: true,
                    confirmButtonText: 'Confirm',
                    backdrop: `#2871f9`,
                    confirmButtonColor: '#0d6efd',
                    timer: 5000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = 'donator_edit_profile.php';
                    }
                })
            </script>
    <?php
        }
        /* End SweetAlert2 */

        /***** Edit profile detail button is clicked *****/
        if (isset($_POST['editProfileButton'])) {
            /* Get all the posted items */
            $user_username = $_POST['username'];
            $user_name = $_POST['name'];
            $user_email = $_POST['email'];
            $user_phone = $_POST['phone'];
            $user_address = $_POST['address'];

            /* UPDATE Query */
            $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssi", $user_username, $user_name, $user_email, $user_phone, $user_address, $user_id);
            $stmt->execute();

            successPopup('profile');
        }

        /***** Edit password button is clicked *****/
        else if (isset($_POST['editPasswordButton'])) {
            /* Get all the posted items */
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];

            /* SELECT Query */
            $query = "SELECT * FROM user WHERE user_id=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $r = $result->fetch_assoc();

            /* Check current password is correct */
            if (password_verify($currentPassword, $r['user_password'])) {
                /* Check current password same as new password */
                if ($currentPassword == $newPassword) {
                    errorPopup('pw-same');
                } else if ($newPassword != $confirmNewPassword) {
                    errorPopup('pw-not-match');
                } else {
                    /* UPDATE Query */
                    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $query = "UPDATE user SET user_password=? WHERE user_id=?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("si", $newPassword, $user_id);
                    $stmt->execute();

                    successPopup("password");
                }
            } else {
                errorPopup('pw-current-incorrect');
            }
        }
        /* Close connection */
        $stmt->close();
        $con->close();
    } else {
        header("Location: ../user_logout.php");
    }
    ?>
</body>

</html>