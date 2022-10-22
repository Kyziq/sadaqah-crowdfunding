<?php
/* Start session and validate admin */
session_start();
if (isset($_SESSION['user_id']) &&  $_SESSION['user_level'] == 1) {
    /* Check if edit user button clicked */
    if (isset($_POST["edit-user-button"])) {
        include_once '../dbcon.php'; // Connect to database 
        $id = $_POST["edit-user-button"];
        $username = $_POST["username"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];

        $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?"; // SQL with parameters
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssi", $username, $name, $email, $phone, $address, $id);
        $stmt->execute();

        if (isset($result) && is_resource($result)) {
            mysqli_free_result($result);  // Release returned data
        }
        mysqli_close($con); // Close connection
        echo "Information for ID $id has been saved!";
    } else {
        header("Location: admin_edit_user.php");
    }
} else {
    header("Location: user_login.php");
}
