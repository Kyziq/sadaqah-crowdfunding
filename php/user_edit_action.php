<?php
/* Start session and validate user */
session_start();
if (isset($_SESSION['user_id']) && ($_SESSION['user_level'] == 3 || $_SESSION['user_level'] == 2 || $_SESSION['user_level'] == 1)) {
    include_once 'dbcon.php'; // Connect to database 
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
        echo "Your information has been saved!";
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
                if (isset($result) && is_resource($result)) {
                    mysqli_free_result($result);  // Release returned data
                }
                mysqli_close($con); // Close connection
                echo "Your password has been changed!";
            } else {
                echo "Your current password is incorrect!";
            }
        }
    } else {
        header("Location: user_edit_detail.php");
    }
} else {
    header("Location: user_login.php");
}
