<?php
session_start();
if (isset($_SESSION['user_id']) && ($_SESSION['user_level'] == 3 || $_SESSION['user_level'] == 2 || $_SESSION['user_level'] == 1)) {
    if (isset($_POST['edit-action-button'])) { // Submit login button
        include_once 'dbcon.php'; // Connect to database 

        // Get all the posted items
        $user_id = $_SESSION['user_id'];
        $user_username = $_POST['username'];
        $user_name = $_POST['name'];
        $user_email = $_POST['email'];
        $user_phone = $_POST['phone'];
        $user_address = $_POST['address'];

        $query = "UPDATE user SET user_username=?, user_name=?, user_email=?, user_phone=?, user_address=? WHERE user_id=?"; // SQL with parameters
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssi", $user_username, $user_name, $user_email, $user_phone, $user_address, $user_id);
        $stmt->execute();

        mysqli_close($con);
        echo "Your information has been saved!";
    } else
        header("Location: user_edit_detail.php");
} else
    header("Location: user_login.php");
