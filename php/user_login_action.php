<?php
session_start();
if (isset($_POST['login-button'])) { // Submit login button
    include_once 'dbcon.php'; // Connect to database 

    // Get all the posted items
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    // Construct and run query to check for correct credentials (prepared statements)
    $query = "SELECT * FROM user WHERE user_username=?"; // SQL with parameters
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $result = $stmt->get_result(); // Get the MySQLI result
    $r = $result->fetch_assoc();

    if (password_verify($user_password, $r['user_password'])) {
        $_SESSION['user_id'] = $r['user_id'];
        $_SESSION['user_level'] = $r['user_level'];

        if ($r['user_level'] == 1)
            header("Location: admin/admin.php");
        else if ($r['user_level'] == 2)
            header("Location: auditor/auditor.php");
        else if ($r['user_level'] == 3)
            header("Location: donator/donator.php");
    } else {
        header("Location:user_login.php?msg=failed");
    }

    if (isset($result) && is_resource($result))
        mysqli_free_result($result);  // Release returned data
    mysqli_close($con); // Close connection
} else {
    header("Location: user_login.php");
}
